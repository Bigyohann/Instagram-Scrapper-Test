<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class InstagramApiException extends Exception
{
    #[Pure] public function __construct(
        string     $message = "The Instagram Api has a problem",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

}
