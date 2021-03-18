@extends('admin.layouts.master')

@section('contents')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Roles
        <small><a href="{!! url('admin/roles') !!}"><i class="fa fa-plus"></i></a></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{!! route('admin.dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Roles</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Produk</h3>
                        </div>    
                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="table-product" data-api="{{ route('admin.api.users.index') }}">
                                <thead>
                                <tr>
                                    <th> Nama Produk </th>
                                    <th> Satuan </th>
                                    <th> Harga Beli </th>
                                    <th> Harga Jual </th>
                                    <th> Create At </th>

                                </tr>
                                </thead>
                                <div class="panel-body">
                                    <label for="name"> Filter Berdasarkan Nama Product: </label>
                                    <input type="text" name="name" class="form-control col-sm-4 filter-name" placeholder="Filter Berdasarkan Nama Product">
                                    
                                    <label for="filter-satuan"> Filter Berdasarkan Satuan : </label>
                                    
                                    <select data-column="1" class="form-control col-sm-4 filter-satuan" placeholder="Filter Berdasarkan Satuan Product">
                                        <option value=""> Pilih Satuan Product </option>
                                        <option value="kg"> KG </option>
                                        <option value="ton"> TON </option>
                                    </select>

                                    <label for="filter-periode"> Filter Berdasarkan Periode : </label>

                                    <select name="filter_periode" id="filter_periode" class="form-control">
                                        <option value=""> Pilih Periode </option>
                                        <option value="7"> 7 Hari Terakhir </option>
                                        <option value="14"> 14 Hari Terakhir </option>
                                        <option value="21"> 21 Hari Terakhir </option>
                                        <option value="31"> 31 Hari Terakhir </option>
                                        <option value="365"> 365 Hari Terakhir </option>
                                    </select>
                                    <br /> <br />
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('scripts')
<script src="{{asset('assets/admin/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/roles-dataTables.js')}}"></script>

@endsection