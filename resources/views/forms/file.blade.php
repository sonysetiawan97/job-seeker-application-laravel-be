<div class="form-group">
  <label for="form-{{$field['name']}}">
    @if($field['label'])
      {{Str::title($field['label'])}}
    @else
      {{Str::title(str_replace('_', ' ', $field['name']))}}
    @endif
    @if(!$field['required'])
    <small class="text-muted">&mdash; Optional</small>
    @endif
  </label>
  <div></div>
  <div class="custom-file">
    <input
      type="file"
      class="custom-file-input"
      value="{{isset($field['value'])? $field['value']: @old($field['name'])}}"
      name="{{$field['name']}}"
      id="form-{{$field['name']}}"
      aria-describedby="form-help-{{$field['name']}}"
      placeholder="{{$field['placeholder']? Str::title($field['placeholder']) : Str::title(str_replace('_', ' ', $field['name']))}}"
      @if($field['required']) required @endif
      @if(isset($readonly) && $readonly === true ) readonly @endif
      accept="{{isset($field['accept'])? $field['accept']: '*'}}"
    >
    <label class="custom-file-label" for="form-{{$field['name']}}">{{$field['placeholder']? Str::title($field['placeholder']) : Str::title(str_replace('_', ' ', $field['name']))}}</label>
  </div>
  @if(isset($field['note']) && $field['note'])
  <small id="form-help-{{$field['name']}}" class="form-text text-muted">{{$field['note']}}</small>
  @endif
  @if ($errors->has($field['name']))
  <small id="form-error-{{$field['name']}}" class="form-text text-danger">
    {{ $errors->first($field['name']) }}
  </small>
  @endif
</div>
