<?php

namespace App;

use App\Twitter\Domain\Tweet;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int id
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function composeTweet($tweet, $tweetId, $tweetedAt): Tweet
    {
        return Tweet::compose($tweetId, $tweet, $this->id, $tweetedAt);
    }
}
