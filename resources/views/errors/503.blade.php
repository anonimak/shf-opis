@extends('errors::layout')

@section('title', __('Under Maintenance'))
@section('code', '503') 
@section('image')
    <img src="{{ asset('/img/svg/cleanup.svg') }}" width="80%" alt="" srcset="">
@endsection
@section('message', __($exception->getMessage() ?: 'Unfortunately this site is currently down for maintenance.'))
