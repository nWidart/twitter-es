<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Projection;

use App\Twitter\Domain\Event\TweetWasComposed;
use App\User;
use Camuthig\EventStore\Package\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

final class TimelineProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        return $projector->fromStream('event_stream')
            ->when([
                TweetWasComposed::class => function ($state, TweetWasComposed $event) {
                    /** @var TimelineReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => $event->tweetId()->toString(),
                        'author' => User::find($event->authorId())->name,
                        'tweet' => $event->tweet()->toString(),
                        'tweeted_at' => $event->tweetedAt()->toString(),
                    ]);
                },
            ]);
    }
}
