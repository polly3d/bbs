<div class="col-md-3">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            {{ $user->name }}
        </div>
        <div class="panel-body">
            <p>帖子：{{ $user->posts->count() }}</p>
            <p>回复：{{ $user->comments->count() }}</p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            与Ta有相关
        </div>
        <div class="panel-body">
            <ul>
                <li>
                    <a href="{{ route('userPosts',$user->id) }}">Ta发布的帖子</a>
                </li>
                <li>
                    <a href="{{ route('userComments',$user->id) }}">Ta发表的回复</a>
                </li>
                <li>
                    <a href="{{ route('userVotePosts',$user->id) }}">Ta赞过的帖子</a>
                </li>
            </ul>
        </div>
    </div>
</div>