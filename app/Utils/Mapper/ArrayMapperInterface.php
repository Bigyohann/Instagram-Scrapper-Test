<?php

namespace App\Utils\Mapper;

interface ArrayMapperInterface
{
    public static function map($base, &$destination): void;
}
