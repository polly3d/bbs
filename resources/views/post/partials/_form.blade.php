<div class="form-group">
    {{ csrf_field() }}
    <label for="">title</label>
    <input type="text" class="form-control" name="title" value="{{ $title or '' }}">
</div>
<div class="form-group">
    <label for="">content</label>
    <textarea name="content" class="form-control" rows="10">{{ $content or '' }}</textarea>
</div>
