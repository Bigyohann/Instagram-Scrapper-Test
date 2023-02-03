<?php

namespace App\Utils\Formatter;

class InstagramUserApiFormatter implements ApiFormaterInterface
{

    public static function parse(array $response): array
    {
        $data = $response['graphql']['user'];
        $userContent = [];
        $userContent['username'] = $data['username'];
        $userContent['biography'] = $data['biography'];
        $userContent['profilePicUrl'] = $data['profile_pic_url'];

        foreach ($data['edge_owner_to_timeline_media']['edges'] as $post) {
            $post = $post['node'];
            $userContent['posts'][] = [
                'id' => $post['id'],
                'imageUrl' => $post['display_url'],
                'caption' => $post['edge_media_to_caption']['edges'][0]['node']['text'],
                'commentCount' => $post['edge_media_to_comment']['count'],
                'likeCount' => $post['edge_liked_by']['count']
            ];
        }
        return $userContent;
    }
}
