<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function store($channel, Thread $thread)
    {
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently. Please take a break.',
                429
            );
        }

        try {
            request()->validate([
                'body' => ['required', new SpamFree],
            ]);

            $reply = $thread->addReply([
                'body'    => request('body'),
                'user_id' => auth()->id(),
            ]);
        } catch (\Exception $e) {
            return response(
                'Sorry, Your Reply Could Not Be Saved.', 422
            );
        }

        return $reply->load('owner'); // for ajax.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            request()->validate([
                'body' => ['required', new SpamFree],
            ]);

            $reply->update(['body' => request('body')]);

        } catch (\Exception $e) {
            return response(
                'Sorry, Your Reply Could Not Be Updated.',
                422
            );
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
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
