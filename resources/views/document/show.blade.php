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
  <form action="{{ route('processfile-document',$document) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-form-label col-sm-2">Data File</label>
      <div class="custom-file col-sm-4">
        <input type="file" name="datafile" class="custom-file-input" id="datafile">
        <label for="datafile" class="custom-file-label">Select data file</label>
      </div>
      @include('partials.fielderrors',['field'=>'datafile'])
    </div>
    <div class="form-group row">
      <div class="col">
        <button class="btn btn-primary" type="submit">Process File</button>
      </div>
    </div>
  </form>

  <form action="{{ route('processinline-document',$document) }}" method="post">
    {{ csrf_field() }}
    <div class="form-group row">
      <label class="col-form-label col-sm-2">File Name</label>
      <input type="text" class="form-control col-sm-4" name="outputfilename" placeholder="Output File Name">
      @include('partials.fielderrors',['field'=>'outputfilename'])
    </div>
    <div class="form-group row">
      <label class="col-form-label col-sm-2">Data</label>
      <textarea class="form-control col-sm-4" name="data" placeholder="Input data"></textarea>
      @include('partials.fielderrors',['field'=>'data'])
    </div>
    <div class="form-group row">
      <div class="col">
        <button class="btn btn-primary" type="submit">Process Inline</button>
      </div>
    </div>
  </form>
@endsection

@section("deferred")
  <script type="application/javascript">
    bsCustomFileInput.init();
  </script>
@endsection