@extends('site.master')

@section('content')
    <div class="editorial login">
        <div class="container">
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Create account</h3>
                        <form id="loginForm">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" id="user_name" class="form-control" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="password" class="form-control" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="form-group no-border margin-top-20">
                                <button class="btn btn-success btn-block">Log in</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h3>Create account</h3>
                        <form id="registerForm">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" id="new_name" class="form-control" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="text" id="new_email" class="form-control" placeholder="Correo">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="new_password" class="form-control" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="form-group no-border margin-top-20">
                                <button class="btn btn-success btn-block">Create user</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#loginForm").submit(function(event){
                event.preventDefault();

                var data = {};
                data.username = $("#user_name").val();
                data.password = $("#password").val();

                data._token = $('meta[name="csrf-token"]').attr('content');

                console.log(data);

                $.ajax({
                    url: '/authenticate',
                    data: data,
                    type: 'post',
                    success: function () {
                        document.location.href = '/profile'
                    },
                    error: function () {
                        alert("Error usuario y contraseña");
                    }
                })
            });

            $("#registerForm").submit(function(event){
                event.preventDefault();
                console.log("New User");


                var data = {};
                data.username = $("#new_name").val();
                data.email = $("#new_email").val();
                data.password = $("#new_password").val();

                data._token = $('meta[name="csrf-token"]').attr('content');

                console.log(data);

                $.ajax({
                    url: '/register',
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    success: function () {
                        alert("Your are ready, please login");
                        document.location.href = '/profile'
                    },
                    error: function (error) {
//                        var error = error.responseText
                        console.log(error.responseText);
//                        alert("Ups!, it seems like something is wrong, check your value");
                    }
                })
            });
        });
    </script>
@endsection