<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Command;

use App\Twitter\Domain\TweetDate;
use App\Twitter\Domain\TweetId;
use App\Twitter\Domain\TweetText;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

final class ComposeTweet extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forAuthor(int $authorId, string $tweet, string $tweetId, \DateTime $tweetedAt)
    {
        return new self([
            'author_id' => $authorId,
            'tweet' => $tweet,
            'tweet_id' => $tweetId,
            'tweeted_at' => $tweetedAt,
        ]);
    }

    public function tweetId(): TweetId
    {
        return TweetId::fromString($this->payload['tweet_id']);
    }

    public function authorId(): int
    {
        return $this->payload['author_id'];
    }

    public function tweet(): TweetText
    {
        return TweetText::fromString($this->payload['tweet']);
    }

    public function tweetedAt(): TweetDate
    {
        return TweetDate::fromDateTime($this->payload['tweeted_at']);
    }
}
