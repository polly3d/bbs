<div class="form-group">
    <label for="">标题：</label>
    <input name="title" type="text" class="form-control" value="{{ $title or old('title') }}">
</div>
<div class="form-group">
    <label for="">分类：</label>
    <select id="category" name="category_id" class="form-control">
        <option value="">请选择分类</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">内容：</label>
    <textarea name="content_md" class="form-control" cols="30" rows="10">{{ $content_md or old('content_md') }}</textarea>
</div>
{{ csrf_field() }}