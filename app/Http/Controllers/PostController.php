<?php

namespace App\Http\Controllers;

use App\Models\InstagramPost;
use App\Models\InstagramProfile;
use App\Services\InstagramScrapService;
use InstagramScraper\Exception\InstagramAuthException;
use InstagramScraper\Exception\InstagramChallengeRecaptchaException;
use InstagramScraper\Exception\InstagramChallengeSubmitPhoneNumberException;
use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Exception\InstagramNotFoundException;
use Psr\SimpleCache\InvalidArgumentException;

class PostController extends Controller
{
    public function __construct(private readonly InstagramScrapService $instagramScrapService)
    {
    }

    /**
     * @throws InstagramChallengeRecaptchaException
     * @throws InstagramChallengeSubmitPhoneNumberException
     * @throws InstagramNotFoundException
     * @throws InstagramAuthException
     * @throws InvalidArgumentException
     * @throws InstagramException
     */
    public function retrieveInstagramPostFromUsername(string $username): InstagramProfile
    {
        return $this->instagramScrapService->retrieveInstagramPostFromUsername($username);

    }


}
