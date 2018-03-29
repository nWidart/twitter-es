<?php

namespace App\Http\Controllers;

use App\Twitter\Domain\Command\ComposeTweet;
use App\Twitter\Domain\Projection\MyTimelineFinder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Prooph\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;

class TweetController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var MyTimelineFinder
     */
    private $myTimelineFinder;

    public function __construct(CommandBus $commandBus, MyTimelineFinder $myTimelineFinder)
    {
        $this->commandBus = $commandBus;
        $this->myTimelineFinder = $myTimelineFinder;
    }

    public function index()
    {
        $tweets = $this->myTimelineFinder->findAll();

        return view('twitter.tweet.new', compact('tweets'));
    }

    public function store(Request $request)
    {
        $command = ComposeTweet::forAuthor(
            $request->user()->id,
            $request->get('tweet'),
            Uuid::uuid4()->toString(),
            Carbon::now()
        );
        $this->commandBus->dispatch($command);

        return redirect()->route('tweet:index');
    }
}
