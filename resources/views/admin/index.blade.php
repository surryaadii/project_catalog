@extends('admin.layouts.master')

@section('contents')
<div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="{!! route('admin.dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <section class="content">
        <p>ini contents</p>
    </section>
</div>
@endsection