<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

class BannedFromInstagramApiException extends Exception
{
    #[Pure] public function __construct(
        string     $message = "The api respond with no response, probably banned for 2 days",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

}
