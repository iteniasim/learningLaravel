<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->latest()->paginate(10);
    }

    public function store($channelId, Thread $thread, CreateReplyRequest $request)
    {
        if ($thread->locked) {
            return response('Thread is locked.', 422);
        }
        return $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        request()->validate(['body' => ['required', new SpamFree]]);

        $reply->update(['body' => request('body')]);

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if (request()->wantsJson()) {
            return response(['status' => 'Your reply has been deleted.']);
        }

        return back();
    }
}
