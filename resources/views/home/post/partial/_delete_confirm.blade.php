<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">警告</h4>
      </div>
      <div class="modal-body">
        确定要删除吗？
      </div>
      <div class="modal-footer">
          <form action="{{ route('post.destroy',$post->id) }}" method="post">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="button" class="btn btn-default" data-dismiss="modal">不删除</button>
              <button class="btn btn-primary">确定</button>
          </form>
      </div>
    </div>
  </div>
</div>
