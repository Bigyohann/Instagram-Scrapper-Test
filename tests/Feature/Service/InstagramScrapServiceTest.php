<?php

namespace Tests\Feature\Service;

use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Services\InstagramScrapService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use InstagramScraper\Exception\InstagramAuthException;
use InstagramScraper\Exception\InstagramChallengeRecaptchaException;
use InstagramScraper\Exception\InstagramChallengeSubmitPhoneNumberException;
use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Exception\InstagramNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;
use Tests\TestCase;
use Tests\Utils\InstagramTestUtils;

class InstagramScrapServiceTest extends TestCase
{
    use DatabaseMigrations;

    private InstagramScrapService $instagramScrapService;

    public function setUp(): void
    {
        $this->instagramScrapService = new InstagramScrapService();
        parent::setUp();
    }

    /**
     * Test this only if you have set username and password from env
     * @throws InstagramChallengeSubmitPhoneNumberException
     * @throws InstagramChallengeRecaptchaException
     * @throws InstagramNotFoundException
     * @throws InvalidArgumentException
     * @throws InstagramAuthException
     * @throws InstagramException
     */
    public function testRetrieveInstagramPostFromUsername()
    {
        $profile = $this->instagramScrapService->retrieveInstagramPostFromUsername('youtube');

        $this->assertSame(1337343, $profile->instagramId);
        $this->assertGreaterThan(1, $profile->mediaCount);
    }

    public function testCreateOrUpdateProfile()
    {
        $account = InstagramTestUtils::mockAccount('usernameTest', 25);
        $profile = new InstagramProfile();

        $this->instagramScrapService->createOrUpdateProfile($account, $profile, 'usernameTest');

        $this->assertEquals('usernameTest', $profile->username);
        $this->assertEquals(25, $profile->instagramId);
        $this->assertDatabaseCount(InstagramProfile::class, 1);
    }

    public function testUpdatePosts()
    {

        $medias = [InstagramTestUtils::mockMedia(45), InstagramTestUtils::mockMedia(78)];

        $profile = InstagramTestUtils::createProfile();

        $this->instagramScrapService->updatePosts($medias, $profile);

        $this->assertDatabaseCount(InstagramPost::class, 2);
    }

}
