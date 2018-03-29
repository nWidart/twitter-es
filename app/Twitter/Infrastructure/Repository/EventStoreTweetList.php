<?php

declare(strict_types=1);

namespace App\Twitter\Infrastructure\Repository;

use App\Twitter\Domain\Tweet;
use App\Twitter\Domain\TweetId;
use App\Twitter\Domain\TweetList;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

final class EventStoreTweetList extends AggregateRepository implements TweetList
{
    public function save(Tweet $todo): void
    {
        $this->saveAggregateRoot($todo);
    }

    public function get(TweetId $todoId): ?Tweet
    {
        return $this->getAggregateRoot($todoId->toString());
    }
}
