@extends('layouts.master_out')

@section('title', 'Sign Up')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center animatedParent animateOnce">
                </br>
                </br>
                <h1 class="signupHeader animated fadeInDownShort">Customer registration form</h1>
                </br>
                </br>
            </div>
        </div>

        <div class="row animatedParent animateOnce">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

                <!-- ================================================================================ -->

                <form role="form" method="POST" action="{{ url('/register') }}">

                    {!! csrf_field() !!}

                    <div class="animatedParent animateOnce" data-sequence='500'>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <div class="form-group animated fadeInLeftShort{{ $errors->has('name') ? ' has-error' : '' }}" data-id="5">
                                    <input type="name" name="name" class="form-control input-sm" placeholder="First Name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-left">
                                <div class="form-group animated fadeInRightShort" data-id="6">
                                    <input type="name" name="last_name" class="form-control input-sm" placeholder="Last Name">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                <div class="form-group animated fadeInLeftShort{{ $errors->has('email') ? ' has-error' : '' }}" data-id="7">
                                    <input name="email" type="email" class="form-control input-sm" placeholder="Enter Email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 text-left">
                                <div class="form-group animated fadeInRightShort" data-id="8">
                                    <input name="email_confirmation" type="email" class="form-control input-sm" placeholder="Confirm Email">
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group animated fadeInLeftShort{{ $errors->has('password') ? ' has-error' : '' }}" data-id="9">
                                    <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password" tabindex="5">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                              <strong>{{ $errors->first('password') }}</strong>
                                          </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group animated fadeInRightShort{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" data-id="10">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password" tabindex="6">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                                          </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-sm-3 col-md-3">
                                <span class="button-checkbox animated fadeInLeftShort" data-id="11">
                            <button name="is_agreed" type="button" class="btn btn-default" data-color="info"><i class="state-icon glyphicon glyphicon-unchecked"></i>I Agree</button>
                            <input type="checkbox" class="hidden" value="1"></span>
                            </div>
                            <div class="col-xs-8 col-sm-9 col-md-9 animated fadeInRightShort" data-id="12">
                                By clicking <strong class="label label-info">Registration</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-md-6 col-md-offset-3 animated fadeInUp">
                                <input type="submit" value="Registration" class="btn btn-info btn-block">
                            </div>
                        </div>
                    </div>
                </form>

                <!-- ==================================================================================== -->

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Terms &amp; Conditions</h4>
                    </div>
                    <div class="modal-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">I Agree</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
@endsection


@section('footer-script')
    <script src="{{ URL::asset('js/signUp.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-formhelpers-countries.js') }}"></script>
@endsection