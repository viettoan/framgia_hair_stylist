@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
    {{ Html::style('css/admin/style.css')}}
@endsection

@section('content')
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
            {{ __('Hi Admin 1') }}
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('Home') }} </a></li>
          <li><a href="#"> {{ __('Manager') }}</a></li>
          <li class="active"> {{ __('Booking And Customer') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ __('Manager Booking') }}</h3>
                </div>
                <div class="box-body over-flow-edit">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Render booking id</th>
                                <th>User id</th>
                                <th>Phone</th>
                                <th>Name</th>
                                <th>Name Stylist</th>
                                <th>Grand total</th>
                                <th>Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                             <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>123456789</td>
                                <td>User 1</td>
                                <td>Stylist 1</td>
                                <td>80.000</td>
                                <td class=" ">
                                    {{-- <a href="#" class="btn btn-success"><i class="fa fa-search-plus "></i></a> --}}
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    {{ Html::script('js/admin/manager_customer.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}
@endsection

Tiếng Nhật 7 JP2210
Tiếng Nhật chuyên ngành 1 JP3110
{{-- Hệ thống thông tin trên Web IT3402 --}}
Thực hành Lập trình mạng IT4062
{{-- Thực hành Lập trình Web  IT4552 --}}
{{-- Bảo mật thông tin IT4012 --}}
{{-- Hệ thống máy tinh   IT4272 --}}
{{-- Hệ điều hành và quản trị mạng Linux theo chuẩn kỹ năng ITSS IT4944 --}}