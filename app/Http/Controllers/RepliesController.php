<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Channel $channel,Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $thread->addReply([
            'owner_id' => auth()->id(),
            'body' => request('body')
        ]);

        return redirect($thread->path());
    }
}
