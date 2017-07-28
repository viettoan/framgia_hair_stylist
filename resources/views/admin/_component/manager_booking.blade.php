 get-color-icon-edit"@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
    {{ Html::style('css/admin/style.css')}}
@endsection

@section('content')
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
            {{ _('Hi Admin 1') }}
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> {{ _('Home') }} </a></li>
          <li><a href="#"> {{ _('Manager') }}</a></li>
          <li class="active"> {{ _('Booking And Customer') }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ _('Manager Booking') }}</h3>
                </div>
                <div class="box-body">
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
                            <tr>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>123456789</td>
                                <td>User 2</td>
                                <td>Stylist 2</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>3</td>
                                <td>3</td>
                                <td>3</td>
                                <td>123456783</td>
                                <td>User 3</td>
                                <td>Stylist 3</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>4</td>
                                <td>4</td>
                                <td>4</td>
                                <td>123456784</td>
                                <td>User 4</td>
                                <td>Stylist 4</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>      
                            <tr>
                                <td>5</td>
                                <td>5</td>
                                <td>5</td>
                                <td>153456789</td>
                                <td>User 5</td>
                                <td>Stylist 5</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>6</td>
                                <td>6</td>
                                <td>6</td>
                                <td>123456769</td>
                                <td>User 6</td>
                                <td>Stylist 6</td>
                                <td>80.600</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>7</td>
                                <td>7</td>
                                <td>7</td>
                                <td>123756789</td>
                                <td>User 7</td>
                                <td>Stylist 7</td>
                                <td>80.070</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>8</td>
                                <td>8</td>
                                <td>8</td>
                                <td>123856789</td>
                                <td>User 8</td>
                                <td>Stylist 8</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>6</td>
                                <td>6</td>
                                <td>6</td>
                                <td>123456789</td>
                                <td>User 6</td>
                                <td>Stylist 6</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            </tr>   
                            <tr>
                                <td>10</td>
                                <td>10</td>
                                <td>10</td>
                                <td>1234510789</td>
                                <td>User 10</td>
                                <td>Stylist 10</td>
                                <td>80.000</td>
                                <td class=" ">
                                    <a href="#" class="btn btn-info"><i class="fa fa-edit "></i></a>
                                    <a class="btn btn-danger" href="#"><i class="fa fa-trash-o "></i></a>
                                </td>
                            <tr>
                                <td>11</td>
                                <td>11</td>
                                <td>11</td>
                                <td>1231456789</td>
                                <td>User 11</td>
                                <td>Stylist 11</td>
                                <td>80.000</td>
                                <td class=" ">
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
