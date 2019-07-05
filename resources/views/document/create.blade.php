@extends("layouts.master")

@section("content")
  <h4>Create Document</h4>
  <form action="{{ route('store-document') }}" method="post" enctype="multipart/form-data">
    {{ @csrf_field() }}
    <div class="row form-group">
    <label class="col-md-2 col-form-label" for="name">Document Name:</label>
    <input class="col-md-4 form-control" type="text" name="name" id="name">
    </div>
    <div class="row form-group">
      <label class="col-md-2 col-form-label">Template:</label>
      <div class="custom-file col-md-4">
        <input type="file" class="custom-file-input" id="file" name="template">
        <label for="file" class="custom-file-label">Choose template</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </div>
  </form>
@endsection

@section("deferred")
  <script type="application/javascript">
    bsCustomFileInput.init();
  </script>
@endsection