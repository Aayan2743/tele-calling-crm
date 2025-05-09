<?php $page = 'forgot-password'; ?>
@extends('layout.mainlayout')
@section('content')

    <div class="account-content">
        <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden account-bg-03">
            <div class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-50 bg-backdrop">
                <form id="frmForgotpassword" class="flex-fill">
                @csrf
                    <div class="mx-auto mw-450">
                        <div class="text-center mb-4">
                      
                        <img src="{{ URL::asset('/build/img/logo-telecalling.png')}}" class="img-fluid" alt="Logo">
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-2 fs-20">Forgot Password?</h4>
                            <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email Address</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="email" value="" id="email" name="email" class="form-control">
                            </div>
                            <span id="text-danger-email" class="text-danger pt-2"></span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" id="submit_button" disabled>Submit</button>
                        </div>
                        <div class="mb-3 text-center">
                            <h6>Return to <a href="{{route('loginindex')}}" class="text-purple link-hover"> Login</a></h6>
                        </div>
                        <div class="form-set-login or-text mb-3">
                            <h4>OR</h4>
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
            $('#submit_button').prop('disabled', false);
            $('#frmForgotpassword').submit(function(e){
            e.preventDefault();
            
            let formData = new FormData(this);
                
            let email = $('#email').val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            $('#text-danger-email').html("");
          


            if(email==""){
                $('#text-danger-email').html("Email field required");
            }else if (!emailRegex.test(email)) {
                    $('#text-danger-email').html("Please enter a valid email address");
            }

           
           
            $.ajax({
                url:'{{route("forgot.password.check")}}',
                type:"POST",
                data:formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                  
                     if(response.status==false){
                        Swal.fire({
                            icon: "error",
                            title: "Error...",
                            text: "Email Id Not Registered....",
                            // footer: '<a href="#">Why do I have this issue?</a>'
                            });
                     }   

                     else if(response.status==true){
                        // window.location.href = '/dashboard';  
                        // alert("senf email");

                        Swal.fire({
                            icon: "success",
                            title: "Eamil...",
                            text: "Email Sent....",
                            // footer: '<a href="#">Why do I have this issue?</a>'
                            });


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