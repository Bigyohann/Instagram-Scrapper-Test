<?php

namespace Tests\Unit\Utils\Mapper;

use App\Models\InstagramProfile;
use App\Utils\Mapper\InstagramPostArrayMapper;
use App\Utils\Mapper\InstagramProfileObjectMapper;
use Tests\TestCase;
use Tests\Utils\InstagramTestUtils;

class InstagramPostArrayMapperTest extends TestCase
{
    public function testFunctionMapCorrectlyToArray(){

        $mediaMock = InstagramTestUtils::mockMedia(25);

        $post = [];
        InstagramPostArrayMapper::map($mediaMock, $post);

        $this->assertEquals(25, $post['instagramId']);
        $this->assertArrayHasKey('caption', $post);
    }
}
