<?php

namespace App\Utils\Mapper;

use App\Models\InstagramProfile;
use InstagramScraper\Model\Account;

class InstagramProfileObjectMapper implements ObjectMapperInterface
{

    /**
     * @param Account $account
     * @param InstagramProfile $profileModel
     * @return void
     */
    public static function map($account, $profileModel) : void
    {
        $profileModel->username = $account->getUsername();
        $profileModel->biography = $account->getBiography();
        $profileModel->followedCount = $account->getFollowsCount();
        $profileModel->followerCount = $account->getFollowedByCount();
        $profileModel->instagramId = $account->getId();
        $profileModel->profilePictureUrl = $account->getProfilePicUrlHd();
        $profileModel->mediaCount = $account->getMediaCount();

    }
}
