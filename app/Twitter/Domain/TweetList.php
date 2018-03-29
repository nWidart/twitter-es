<?php

namespace App\Twitter\Domain;

interface TweetList
{
    public function save(Tweet $todo): void;

    public function get(TweetId $todoId): ?Tweet;
}
