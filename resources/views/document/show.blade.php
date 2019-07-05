@extends("layouts.master")

@section("content")
<h4>Document</h4>
  <dl>
    <dt>
      Name
    </dt>
    <dd>
      {{ $document->name }}
    </dd>
  </dl>
  <form action="{{ route('launch-document',$document) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-form-label col-sm-2">Data File</label>
      <div class="custom-file col-sm-4">
        <input type="file" name="datafile" class="custom-file-input" id="datafile">
        <label for="datafile" class="custom-file-label">Select data file</label>
      </div>
    </div>
    <div class="form-group row">
      <div class="col">
        <button class="btn btn-primary" type="submit">Process</button>
      </div>
    </div>
  </form>
@endsection

@section("deferred")
  <script type="application/javascript">
    bsCustomFileInput.init();
  </script>
@endsection