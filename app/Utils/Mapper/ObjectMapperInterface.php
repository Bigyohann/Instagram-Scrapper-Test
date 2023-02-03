<?php

namespace App\Utils\Mapper;

interface ObjectMapperInterface
{
    public static function map($base, $destination): void;
}
