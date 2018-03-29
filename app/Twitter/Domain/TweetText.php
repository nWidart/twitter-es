<?php

declare(strict_types=1);

namespace App\Twitter\Domain;

use Assert\Assertion;

class TweetText
{
    /**
     * @var string
     */
    private $text;

    public static function fromString(string $text): self
    {
        try {
            Assertion::minLength($text, 1);
            Assertion::maxLength($text, 140);
        } catch (\Exception $e) {
            throw Exception\InvalidText::reason($e->getMessage());
        }

        return new self($text);
    }

    private function __construct(string $text)
    {
        $this->text = $text;
    }

    public function toString(): string
    {
        return $this->text;
    }
}
