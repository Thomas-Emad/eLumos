@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))


@extends('errors.layout')

@section('title', __('Service Unavailable - 503'))
@section('message', __('Service Unavailable..'))
