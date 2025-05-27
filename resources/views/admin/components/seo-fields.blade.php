<div class="form-group">
    <label>SEO URL</label>
    <input type="text" name="seo_url" class="form-control" value="{{ old('seo_url', $data->seo_url ?? '') }}">
</div>
<div class="form-group">
    <label>Meta Title</label>
    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $data->meta_title ?? '') }}">
</div>
<div class="form-group">
    <label>Meta Description</label>
    <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description', $data->meta_description ?? '') }}">
</div>
<div class="form-group">
    <label>Meta Keywords</label>
    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $data->meta_keywords ?? '') }}">
</div>
<div class="form-group">
    <label>H1 Tag</label>
    <input type="text" name="h1_tag" class="form-control" value="{{ old('h1_tag', $data->h1_tag ?? '') }}">
</div>
<div class="form-group">
    <label>H2 Tag</label>
    <input type="text" name="h2_tag" class="form-control" value="{{ old('h2_tag', $data->h2_tag ?? '') }}">
</div>
<div class="form-group">
    <label>H3 Tag</label>
    <input type="text" name="h3_tag" class="form-control" value="{{ old('h3_tag', $data->h3_tag ?? '') }}">
</div>
<div class="form-group">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $data->description ?? '') }}</textarea>
</div>
