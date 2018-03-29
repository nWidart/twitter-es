<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Exception;

class InvalidText extends \InvalidArgumentException
{
    public static function reason(string $msg): InvalidText
    {
        return new self('The tweet text is invalid: ' . $msg);
    }
}
