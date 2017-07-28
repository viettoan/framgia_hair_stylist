@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ __('User Profile') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src={{ asset('bower/AdminLTE/dist/img/user4-128x128.jpg') }} alt="User profile picture">
                        <h3 class="profile-username text-center">Nina Mcintire</h3>
                        <p class="text-muted text-center">Software Engineer</p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">About Me</h3>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
                        <p class="text-muted">
                            B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                        <p class="text-muted">Dong Da , Ha Noi</p>
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
                        <p>
                            <span class="label label-danger">Working 2 year</span>
                            <span class="label label-success">Pro</span>
                            <span class="label label-info"></span>
                            <span class="label label-warning"></span>
                            <span class="label label-primary"></span>
                        </p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="tab-pane active " id="settings">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">{{ __('Name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">{{ __('Email') }}</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone" class="col-sm-2 control-label">{{ __('Phone') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPhone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">{{ __('Password') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPassword" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPasswordConfirm" class="col-sm-2 control-label">{{ __('Password Confirm') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPasswordConfirm" placeholder="Password Confirm">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputBirthday" class="col-sm-2 control-label">{{ __('Birthday') }}</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="inputBirthday" placeholder="Birthday">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAvatar" class="col-sm-2 control-label">{{ __('Avatar') }}</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="inputAvatar" name="avatar" placeholder="Avatar">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ __('Gender') }}</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-2">
                                            <input type="radio" name ="gender" value="male" checked> Male<br>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="radio" name ="gender" value="female" checked> female<br>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="radio" name ="gender" value="other" checked> other<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPermission" class="col-sm-2 control-label">{{ __('Permission') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPermission" placeholder="Permission">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">{{ __('Experience') }}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Specialize</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAbout" class="col-sm-2 control-label">{{ __('About me') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputAbout" placeholder="About Me">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDepartment" class="col-sm-2 control-label">{{ __('Department') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputDepartment" placeholder="Department">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> {{ __('I agree to the') }} <a href="#">{{ __('terms and conditions') }}</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

