@extends('admin.layouts.master')

@section('contents')
    <div id="main-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit User
            </h1>
            <ol class="breadcrumb">
                <li><a href="{!! route('admin.dashboard') !!}">Dashboard</a></li>
                <li><a href="{!! route('admin.users.index') !!}">Users</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.user._form', compact('model', 'roles'))
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/users.js')}}"></script>
@endsection

