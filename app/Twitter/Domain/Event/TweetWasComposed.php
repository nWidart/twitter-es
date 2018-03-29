<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Event;

use App\Twitter\Domain\TweetDate;
use App\Twitter\Domain\TweetId;
use App\Twitter\Domain\TweetText;
use Prooph\EventSourcing\AggregateChanged;

final class TweetWasComposed extends AggregateChanged
{
    /**
     * @var TweetId
     */
    private $tweetId;

    /**
     * @var TweetText
     */
    private $tweet;

    /**
     * @var int
     */
    private $authorId;

    /**
     * @var TweetDate
     */
    private $tweetedAt;

    public static function byAuthor(int $authorId, TweetId $tweetId, TweetText $tweet, TweetDate $tweetedAt): TweetWasComposed
    {
        /** @var self $event */
        $event = new self($tweetId->toString(), [
            'author_id' => $authorId,
            'tweet' => $tweet->toString(),
            'tweeted_at' => $tweetedAt->toString(),
        ]);

        $event->tweetId = $tweetId;
        $event->tweet = $tweet;
        $event->tweetedAt = $tweetedAt;
        $event->authorId = $authorId;

        return $event;
    }

    public function tweetId(): TweetId
    {
        if (null === $this->tweetId) {
            $this->tweetId = TweetId::fromString($this->aggregateId());
        }

        return $this->tweetId;
    }

    public function tweet(): TweetText
    {
        if (null === $this->tweet) {
            $this->tweet = TweetText::fromString($this->payload['tweet']);
        }

        return $this->tweet;
    }

    public function tweetedAt(): TweetDate
    {
        if (null === $this->tweetedAt) {
            $this->tweetedAt = TweetDate::fromString($this->payload['tweeted_at']);
        }

        return $this->tweetedAt;
    }

    public function authorId()
    {
        if (null === $this->authorId) {
            return $this->authorId = $this->payload['author_id'];
        }

        return $this->authorId;
    }
}
