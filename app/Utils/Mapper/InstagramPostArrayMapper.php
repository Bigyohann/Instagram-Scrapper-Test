<?php

namespace App\Utils\Mapper;


use InstagramScraper\Model\Media;

class InstagramPostArrayMapper implements ArrayMapperInterface
{

    /**
     * @param Media $media
     * @param array $postModel
     * @return void
     * Map as array this time, use bulk update for multiple posts
     */
    public static function map($media, &$postModel) : void
    {
       $postModel['instagramId'] = $media->getId();
       $postModel['imageUrl'] = $media->getImageThumbnailUrl();
       $postModel['caption'] = $media->getCaption();
       $postModel['commentCount'] = $media->getCommentsCount();
       $postModel['likedCount'] = $media->getLikesCount();
    }
}
