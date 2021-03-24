@extends('admin.layouts.master')

@section('contents')
    <div id="main-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Create Role
            </h1>
            <ol class="breadcrumb">
                <li><a href="{!! route('admin.dashboard') !!}">Dashboard</a></li>
                <li><a href="{!! route('admin.roles.index') !!}">Roles</a></li>
                <li class="active">Create</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.role._form', compact('model'))
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/roles.js')}}"></script>
@endsection

