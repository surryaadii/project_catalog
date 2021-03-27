@extends('admin.layouts.master')

@section('contents')
    <div id="main-content" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Create Product
            </h1>
            <ol class="breadcrumb">
                <li><a href="{!! route('admin.dashboard') !!}">Dashboard</a></li>
                <li><a href="{!! route('admin.products.index') !!}">Products</a></li>
                <li class="active">Create</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.product._form', compact('model', 'dataCategories'))
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/products.js')}}"></script>
@endsection

