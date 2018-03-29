<?php

declare(strict_types=1);

namespace App\Twitter\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class TweetId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): TweetId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $todoId): TweetId
    {
        return new self(Uuid::fromString($todoId));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }
}
