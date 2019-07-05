@extends("layouts.master")

@section("content")
  <h4>{{ config("app.name") }}</h4>
  @foreach($documents as $document)
      <div>
        <a href="{{ route('show-document',$document->id) }}">{{ $document->name }}</a>
        <i class="material-icons md-top">{{ $document->active ? "check":"clear" }}</i>
      </div>
  @endforeach
@endsection