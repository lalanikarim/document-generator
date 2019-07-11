@if ($errors->has($field))
<div class="col-sm">
  <div class="alert alert-danger">
    @foreach ($errors->get($field) as $error)
      <div class="row">{{ $error }}</div>
    @endforeach
  </div>
</div>
@endif