@extends('layouts.contentLayoutMaster')

@section('title', 'Backups')

@section('page-style')
<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<!-- Styles -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<link href="{{ asset('vendor/laravel_backup_panel/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/laravel_backup_panel/app.css') }}" rel="stylesheet">
@endsection

@section('content')
<livewire:laravel_backup_panel::app />
@endsection

@section('page-script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection



