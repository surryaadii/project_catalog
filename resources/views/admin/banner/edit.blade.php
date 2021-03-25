@extends('admin.layouts.master')

@section('contents')
    <div id="main-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Banner
            </h1>
            <ol class="breadcrumb">
                <li><a href="{!! route('admin.dashboard') !!}">Dashboard</a></li>
                <li><a href="{!! route('admin.banners.index') !!}">Banners</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.banner._form', compact('model'))
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/libs/basic.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/libs/dropzone.min.css')}}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/banners.js')}}"></script>
    <script src="{{ asset('assets/admin/js/libs/dropzone.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/dropzone.js')}}"></script>
@endsection

