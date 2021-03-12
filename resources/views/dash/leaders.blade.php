@extends('dash.template.candidates')

@section('title') Calon Ketua @endsection
@section('candidates.type') Ketua @endsection
@section('candidates.newAction') {{ route('admin.newLeader') }} @endsection
