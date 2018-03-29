<?php

declare(strict_types=1);

namespace App\Twitter\Domain;


use Carbon\Carbon;

final class TweetDate
{
    /**
     * @var \DateTime
     */
    private $tweetDate;

    public static function fromDateTime(\DateTime $tweetDate): TweetDate
    {
        return new self($tweetDate);
    }

    private function __construct(\DateTime $tweetDate)
    {
        $this->tweetDate = $tweetDate;
    }

    public function toString(): string
    {
        return $this->tweetDate->format(\DateTime::RFC3339);
    }

    public static function fromString($tweetedAt)
    {
        return new self(Carbon::createFromFormat(\DateTime::RFC3339, $tweetedAt));
    }
}
