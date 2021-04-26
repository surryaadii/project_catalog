@extends('admin.layouts.master')

@section('contents')
    <div id="main-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Page
            </h1>
            <ol class="breadcrumb">
                <li><a href="{!! route('admin.dashboard') !!}">Dashboard</a></li>
                <li><a href="{!! route('admin.pages.index') !!}">pages</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.page._form', compact('model'))
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/libs/basic.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/libs/dropzone.min.css')}}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/pages.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages.assets.js')}}"></script>
    <script src="{{asset('assets/admin/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="{{ asset('assets/admin/js/libs/dropzone.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/js/dropzone.js')}}"></script>
@endsection

