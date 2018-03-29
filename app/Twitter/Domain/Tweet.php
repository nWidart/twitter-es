<?php

declare(strict_types=1);

namespace App\Twitter\Domain;

use App\Twitter\Domain\Event\TweetWasComposed;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

final class Tweet extends AggregateRoot
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

    public function tweetId(): TweetId
    {
        return $this->tweetId;
    }

    /**
     * @return TweetText
     */
    public function tweet(): TweetText
    {
        return $this->tweet;
    }

    /**
     * @return int
     */
    public function authorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return TweetDate
     */
    public function tweetedAt(): TweetDate
    {
        return $this->tweetedAt;
    }

    public static function compose(TweetId $tweetId, TweetText $tweet, int $authorId, TweetDate $tweetedAt): self
    {
        $self = new self();
        $self->recordThat(Event\TweetWasComposed::byAuthor($authorId, $tweetId, $tweet, $tweetedAt));

        return $self;
    }

    protected function aggregateId(): string
    {
        return $this->tweetId->toString();
    }

    public function whenTweetWasComposed(TweetWasComposed $event): void
    {
        $this->tweetId = $event->tweetId();
        $this->tweet = $event->tweet();
        $this->tweetedAt = $event->tweetedAt();
        $this->authorId = $event->authorId();
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
