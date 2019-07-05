@extends("layouts.master")

@section("content")
    <h4>{{ config("app.name")  }}</h4>
    <h5><a href="{{ route('get-documents') }}">Documents</a></h5>
@endsection