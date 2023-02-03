<?php

namespace Tests\Utils;

use App\Models\InstagramProfile;
use InstagramScraper\Model\Account;
use InstagramScraper\Model\Media;
use Mockery\MockInterface;

class InstagramTestUtils
{
    public static function mockAccount(string $username, int $instagramId): Account
    {

        /** @var Account $mock */
        $mock = \Mockery::mock(Account::class,
            function (MockInterface $mock)
            use ($username, $instagramId) {
                $mock->shouldReceive('getUsername')->andReturn($username);
                $mock->shouldReceive('getId')->andReturn($instagramId);
                $mock->shouldReceive('getBiography')->andReturn('biography test');
                $mock->shouldReceive('getFollowsCount')->andReturn(12);
                $mock->shouldReceive('getFollowedByCount')->andReturn(13);
                $mock->shouldReceive('getProfilePicUrlHd')->andReturn('/storage');
                $mock->shouldReceive('getMediaCount')->andReturn(12);
            });

        return $mock;
    }

    public static function mockMedia(int $instagramId): Media
    {
        /** @var Media $mock */
        $mock = \Mockery::mock(Media::class,
            function (MockInterface $mock)
            use ($instagramId) {
                $mock->shouldReceive('getId')->andReturn($instagramId);
                $mock->shouldReceive('getImageThumbnailUrl')->andReturn('/storage');
                $mock->shouldReceive('getCaption')->andReturn('caption test');
                $mock->shouldReceive('getCommentsCount')->andReturn(12);
                $mock->shouldReceive('getLikesCount')->andReturn(13);
            });

        return $mock;
    }

    public static function createProfile(): InstagramProfile
    {
        $profile = new InstagramProfile([
            'instagramId' => 25,
            'username' => 'usernameTest',
            'biography' => 'test Bio',
            'followedCount' => 12,
            'followerCount' => 13,
            'profilePictureUrl' => '/storage',
            'mediaCount' => 12
        ]);
        $profile->save();
        return $profile;
    }
}
