@extends('admin.master')
@section('style')
    {{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
    {{ Html::style('css/admin/style.css')}}
@endsection

@section('content')
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
            Hi Admin 1
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Manager</a></li>
          <li class="active">Booking And Customer</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manager Customer</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body over-flow-edit">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Password</th>
                                    <th>Birthday</th>
                                    <th>Avatar</th>
                                    <th>Gender</th>
                                    <th>Permission</th>
                                    <th>Experience</th>
                                    <th>Specialize</th>
                                    <th>About_me</th>
                                    <th>Department_id</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>name_1</td>
                                    <td>name_1@gmail.com</td>
                                    <td>0984010953</td>
                                    <td>12345678</td>
                                    <td>12/11/1994</td>
                                    <td>name_1.jpg</td>
                                    <td>Man</td>
                                    <td>1</td>
                                    <td>2 nam</td>
                                    <td>Specialize</td>
                                    <td>a hihi</td>
                                    <td>Deparment 1</td>
                                    <th>Delete</th>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>name_2</td>
                                    <td>name_2@gmail.com</td>
                                    <td>0984010952</td>
                                    <td>12345672</td>
                                    <td>12/12/1994</td>
                                    <td>name_2.jpg</td>
                                    <td>Man</td>
                                    <td>1</td>
                                    <td>2 nam</td>
                                    <td>Specialize</td>
                                    <td>a hihi</td>
                                    <td>Deparment 2</td>
                                    <th>Delete</th>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>name_13</td>
                                    <td>name_13@gmail.com</td>
                                    <td>09840109533</td>
                                    <td>12345678</td>
                                    <td>12/113/1994</td>
                                    <td>name_13.jpg</td>
                                    <td>Man</td>
                                    <td>2</td>
                                    <td>2 nam</td>
                                    <td>Specialize</td>
                                    <td>a hihi</td>
                                    <td>Deparment 3</td>
                                    <th>Delete</th>
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
