@extends('layouts.app')

@section('title', 'View Certificate')

@section('content')
    <div class="mt-16">
        <x-certificate user_name="{{ $certificate->user_name }}" course_title="{{ $certificate->course_title }}"
            completed_at="{{ $certificate->completed_at }}" completed_year="{{ $certificate->completed_year }}"
            id="{{ $certificate->id }}" qrCode="{{ $qrCode }}" />
    </div>
@endsection
