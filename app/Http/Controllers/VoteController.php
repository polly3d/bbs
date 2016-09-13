<?php

namespace App\Http\Controllers;

use App\Services\VoteService;
use Illuminate\Http\Request;

use App\Http\Requests;

class VoteController extends Controller
{

    /**
     * VoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function votePost(VoteService $service, $id)
    {
        $result = $service->votePost($id);
        return redirect(route('post.show',$id));
    }

    public function voteComment(VoteService $service, $id)
    {
        $result = $service->voteComment($id);
        return redirect(route('post.show',$result->post->id));
    }
}
