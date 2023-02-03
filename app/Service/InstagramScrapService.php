<?php

namespace App\Service;

use App\Exceptions\BannedFromInstagramApiException;
use App\Exceptions\InstagramApiException;
use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Utils\FileScrapper;
use App\Utils\Formatter\InstagramUserApiFormatter;
use App\Utils\Mapper\InstagramPostArrayMapper;
use App\Utils\Mapper\InstagramProfileObjectMapper;
use DateTimeImmutable;
use DB;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use InstagramScraper\Exception\InstagramAuthException;
use InstagramScraper\Exception\InstagramChallengeRecaptchaException;
use InstagramScraper\Exception\InstagramChallengeSubmitPhoneNumberException;
use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Instagram;
use InstagramScraper\Model\Account;
use InstagramScraper\Model\Media;
use Phpfastcache\Helper\Psr16Adapter;
use Psr\SimpleCache\InvalidArgumentException;

class InstagramScrapService
{

    /**
     * @param string $username
     * @return Model|InstagramProfile
     * @throws InstagramAuthException
     * @throws InstagramChallengeRecaptchaException
     * @throws InstagramChallengeSubmitPhoneNumberException
     * @throws InstagramException
     * @throws InstagramNotFoundException
     * @throws InvalidArgumentException
     */
    public function retrieveInstagramPostFromUsername(string $username): InstagramProfile|Model
    {
        $profile = InstagramProfile::where('username', $username)->first();

       // Check if user exist in DB and if it's retrieved less than one hour ago
        if (
            $profile &&
            $profile->updated_at > (new DateTimeImmutable('now'))->modify('-1 hour') &&
            ($profile->posts() && $profile->mediaCount)
        ) {
            $profile->load('posts');
            return $profile;
        }

        // If not, scrap it
        $scrapper = Instagram::withCredentials(new Client(), env('INSTAGRAM_ACCOUNT'), env('INSTAGRAM_PASSWORD'), new Psr16Adapter('Files'));

        // Don't force login here, it's faster if we already got a valid session
        $scrapper->login();

        $scrappedProfile = $scrapper->getAccountInfo($username);

        if (!$profile) {
            $profile = new InstagramProfile();
        }

        $this->createOrUpdateProfile($scrappedProfile, $profile, $username);

        $this->updatePosts($scrappedProfile->getMedias(), $profile);

        $profile->load('posts');
        return $profile;

    }

    /**
     * @param Account $scrappedProfile
     * @param InstagramProfile $profile
     * @param string $username
     * @return void
     */
    public function createOrUpdateProfile(Account $scrappedProfile, InstagramProfile $profile, string $username): void
    {
        if ($profile->profilePictureUrl){
            Storage::delete($profile->profilePictureUrl);
        }

        InstagramProfileObjectMapper::map($scrappedProfile, $profile);

        $profile->profilePictureUrl = FileScrapper::downloadFile($profile->profilePictureUrl, 'postImages/' . $username);

        $profile->save();
    }

    /**
     * We use upsert here to make a massive insert into DB and not too many requests
     * @param Media[] $medias
     * @param InstagramProfile $profile
     * @return void
     */
    public function updatePosts(array $medias, InstagramProfile $profile): void
    {
        $postsUpdateQuery = [];
        foreach ($medias as $media) {
            $update = [];
            $update['profileId'] = $profile->id;
            InstagramPostArrayMapper::map($media, $update);
            $update['imageUrl'] = FileScrapper::downloadFile($update['imageUrl'], 'postImages/' . $profile->username);
            $postsUpdateQuery[] = $update;
        }

        // Delete all pictures on server
        /** @var InstagramPost $item */
        foreach ($profile->posts()->get() as $item) {
            Storage::delete($item->imageUrl);
        }

        $profile->posts()->delete();
        DB::table('instagram_posts')->upsert($postsUpdateQuery, 'instagramId');
    }

    /**
     * This function only work if we don't reach api limit when we are not logged (used at first then ip get banned)
     * Don't have time to add login, it's too complex to handle the trick, I'll get a lib to do that
     * @throws InstagramApiException
     * @throws BannedFromInstagramApiException
     * @throws Exception
     * @see InstagramScrapService::retrieveInstagramPostFromUsername()
     * @deprecated
     */
    public function retrieveInstagramPostNotLoggedAndWithoutLib(string $username): array
    {
        // Get good headers to be sure request will be handled
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
        ])
            ->get('https://www.instagram.com/' . $username . '/?__a=1&__d=dist');

        if (!$response->json()) {
            throw new BannedFromInstagramApiException();
        }

        if ($response->status() === 401) {
            throw new InstagramApiException();
        }


        $parsed = InstagramUserApiFormatter::parse($response->json());
        $newPost = [];
        if (!$stream = @fopen($parsed['profilePicUrl'], 'r')) {
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'post-file-');

        file_put_contents($tempFile, $stream);

        $filePath = Storage::putFile('postImages/' . $username, $tempFile);
        $parsed['profilePicUrl'] = $filePath;
        foreach ($parsed['posts'] as $post) {
            if (!$stream = @fopen($post['imageUrl'], 'r')) {
                throw new Exception("File open error");
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'post-file-');

            file_put_contents($tempFile, $stream);

            $filePath = Storage::putFile('postImages/' . $username, $tempFile);

            $post['imageUrl'] = $filePath;
            $newPost[] = $post;
        }
        $parsed['posts'] = $newPost;
        return $parsed;
    }
}
