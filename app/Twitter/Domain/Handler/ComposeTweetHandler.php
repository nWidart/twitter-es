<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Handler;

use App\Twitter\Domain\Command\ComposeTweet;
use App\Twitter\Domain\TweetList;
use App\User;

final class ComposeTweetHandler
{
    /**
     * @var TweetList
     */
    private $tweetList;

    public function __construct(TweetList $tweetList)
    {
        $this->tweetList = $tweetList;
    }

    public function __invoke(ComposeTweet $command): void
    {
        /** @var User $user */
        $user = User::find($command->authorId());

        $tweet = $user->composeTweet($command->tweet(), $command->tweetId(), $command->tweetedAt());

        $this->tweetList->save($tweet);
    }
}
