@if ($errors->any())
  <div class="row">
    <div class="col-md-4">
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <div class="row">{{ $error }}</div>
        @endforeach
      </div>
    </div>
  </div>
@endif