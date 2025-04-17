<?php $page = 'forgot-password'; ?>
@extends('layout.mainlayout')
@section('content')

    <div class="account-content">
        <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden account-bg-03">
            <div class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-50 bg-backdrop">
                <form id="frmResetPassword" class="flex-fill">
                @csrf
                    <div class="mx-auto mw-450">
                        <div class="text-center mb-4">
                      
                        <img src="{{ URL::asset('/build/img/logo-telecalling.png')}}" class="img-fluid" alt="Logo">
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-2 fs-20">Reset Password?</h4>
                           
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email Address</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="email" value="{{  $user->email  }}" id="email" readonly name="email" class="form-control">
                            </div>
                            <span id="text-danger-email" class="text-danger pt-2"></span>
                        </div>

                       
                        <div class="mb-3">
                            <label class="col-form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="password" id="password" placeholder="Password  Required" >
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                            <span id="text-danger-password" class="text-danger pt-2"></span>
                        </div>  

                       

                      

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100" id="submit_button" disabled>Update</button>
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



            $('#password').focus();
            $('#submit_button').prop('disabled', false);
            $('#frmResetPassword').submit(function(e){
            e.preventDefault();
            
            $('#text-danger-password').html("");
            let formData = new FormData(this);
                
            let password = $('#password').val().trim();
          

           


            if(password==""){
                $('#text-danger-password').html("Password field required");
            }

           
           
            $.ajax({
                url:'{{route("forgot.updatePassword")}}',
                type:"POST",
                data:formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                  console.log(response);
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
                        Swal.fire({
                            icon: "success",
                            title: "Password Updated...",
                            text: "Password updated successfully...",
                            timer: 3000, // 3000ms = 3 seconds
                            showConfirmButton: false,
                            willClose: () => {
                                window.location.href = '/';
                            }
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