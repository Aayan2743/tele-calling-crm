<?php $page = 'index'; ?>
@extends('layout.mainlayout')
@section('content')

    <div class="account-content">
        <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden account-bg-01">
            <div class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-50 bg-backdrop">
                <form id="loginFrm"  class="flex-fill"> 
                @csrf
                    <div class="mx-auto mw-450">
                        <div class="text-center mb-4">
                            <img src="{{ URL::asset('/build/img/logo-telecalling.png')}}" class="img-fluid" alt="Logo">
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-2 fs-20">Sign In</h4>
                         
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email Address</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email id Required">
                            </div>
                            <span id="text-danger-email" class="text-danger pt-2"></span>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="password" id="password" placeholder="Password  Required" >
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                            <span id="text-danger-password" class="text-danger pt-2"></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                              <div class="text-end">
                                <a href="{{url('forgot-password')}}" class="text-primary fw-medium link-hover">Login With OTP</a>
                            </div>
                            <div class="text-end">
                                <a href="{{route('forgot.password')}}" class="text-primary fw-medium link-hover">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                        <div class="mb-3">
                            <h6>New on our platform?<a href="{{url('register')}}" class="text-purple link-hover"> Create an account</a></h6>
                        </div>
                       
                        <div class="text-center">
                            <p class="fw-medium text-gray">Copyright &copy; 2025 - OZRIT</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('build/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){

            $('#email').focus();
            $('#loginFrm').submit(function(e){
            e.preventDefault();
            
            let formData = new FormData(this);
                
            let email = $('#email').val().trim();
            let password=$('#password').val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            $('#text-danger-email').html("");
            $('#text-danger-password').html("");


            if(email==""){
                $('#text-danger-email').html("Email field required");
            }else if (!emailRegex.test(email)) {
                    $('#text-danger-email').html("Please enter a valid email address");
            }

            if(password==""){
                $('#text-danger-password').html("Password field required");
            }

            $.ajax({
                url:'{{route("login")}}',
                type:"POST",
                data:formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                    console.log('Success:', response.status);
                     if(response.status==false){
                        Swal.fire({
                            icon: "error",
                            title: "Login Error...",
                            text: "Invalid Credentails....",
                            // footer: '<a href="#">Why do I have this issue?</a>'
                            });
                     }   

                     else if(response.status==true){
                        window.location.href = '/dashboard';  
                     }

                     // Handle success (show message, reset form, etc.)
                    },
                    error: function(xhr) {


                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                // Append the first error message for each field
                                $('#text-danger-' + field).html(messages[0]);
                            });
                        } else {
                            // Handle other errors (if any)
                            console.log('Error:', xhr);
            }

                       
                        // Handle error (show error messages)
                    }


            });




           });
        });

    </script>

@endsection
