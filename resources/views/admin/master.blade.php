<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('css/admin/style.css')}}
    {{ Html::style('bower/font-awesome/css/font-awesome.min.css') }}
    {{ Html::style('bower/Ionicons/css/ionicons.min.css') }}
    {{ Html::style('bower/AdminLTE/dist/css/AdminLTE.min.css') }}
    {{ Html::style('bower/AdminLTE/dist/css/skins/_all-skins.min.css') }}
    {{ Html::style('bower/AdminLTE/plugins/iCheck/flat/blue.css') }}
    {{ Html::style('bower/AdminLTE/plugins/morris/morris.css') }}
    {{ Html::style('bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}
    {{ Html::style('bower/AdminLTE/plugins/datepicker/datepicker3.css') }}
    {{ Html::style('bower/AdminLTE/plugins/daterangepicker/daterangepicker.css') }}
    {{ Html::style('bower/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}
    {{ Html::style('bower/toastr/toastr.min.css') }}
    {{ Html::style('bower/AdminLTE/plugins/select2/select2.min.css') }}

    @yield('style')

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
    @include('admin._section.header')
    @include('admin._section.aside')
    @yield('content')
    </div>
    {{ Html::script('bower/vue/dist/vue.js') }}
    {{ Html::script('bower/vue-ls/dist/vue-ls.js') }}
    {{ Html::script('bower/vue-ls/dist/vue-ls.min.js') }}
    {{ Html::script('bower/jquery/dist/jquery.min.js') }}
    {{ Html::script('bower/toastr/toastr.min.js') }}
    {{ Html::script('bower/axios/dist/axios.min.js') }}
    {{ Html::script('bower/AdminLTE/bootstrap/js/bootstrap.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/sparkline/jquery.sparkline.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
    {{ Html::script('bower/AdminLTE/plugins/knob/jquery.knob.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datepicker/bootstrap-datepicker.js') }}
    {{ Html::script('bower/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js') }}
    {{ Html::script('bower/AdminLTE/plugins/fastclick/fastclick.js') }}
    {{ Html::script('bower/AdminLTE/dist/js/app.min.js') }}
    {{ Html::script('bower/AdminLTE/dist/js/demo.js') }}
    {{ Html::script('js/admin/header.js') }}
    {{ Html::script('js/admin/helper.js') }}
    {{ Html::script('js/admin/aside_admin.js') }}
    {{ Html::script('bower/AdminLTE/plugins/select2/select2.min.js') }}
    {{ Html::script('bower/elevatezoom/jquery.elevatezoom.js') }}
    @yield('script')
</body>
</html>
