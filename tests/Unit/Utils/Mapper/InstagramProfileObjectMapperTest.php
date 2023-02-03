<?php

namespace Tests\Unit\Utils\Mapper;

use App\Models\InstagramProfile;
use App\Utils\Mapper\InstagramProfileObjectMapper;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Tests\TestCase;
use Tests\Utils\InstagramTestUtils;

class InstagramProfileObjectMapperTest extends TestCase
{
    public function testFunctionMapCorrectlyToObject(){

        $acccountMock = InstagramTestUtils::mockAccount('usernameTest', 25);
        $profile = new InstagramProfile();

        InstagramProfileObjectMapper::map($acccountMock, $profile);

        $this->assertEquals('usernameTest', $profile->username);
    }
}
