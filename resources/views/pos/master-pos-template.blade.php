@extends('layouts.coreui.empty')


@section('main-app-body')
    <pos-s-p-a :user="{{ Auth::user() }}"></pos-s-p-a>
@endsection





