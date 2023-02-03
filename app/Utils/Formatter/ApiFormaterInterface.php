<?php

namespace App\Utils\Formatter;

interface ApiFormaterInterface
{
    public static function parse(array $data): array;
}
