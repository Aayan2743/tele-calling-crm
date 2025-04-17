<?php $page = 'register'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="account-content">
        <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden account-bg-02">
            <div class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-50 bg-backdrop">
                <form id="customerRegisterFrm" class="flex-fill">
                    @csrf
                    <div class="mx-auto mw-450">
                        <div class="text-center mb-4">
                            
                            <img src="{{ URL::asset('/build/img/logo-telecalling.png')}}" class="img-fluid" alt="Logo">
                        </div>
                        <div class="mb-4">
                            <h4 class="mb-2 fs-20">Register</h4>
                            <p>Create new  account</p>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Name</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-user"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <span id="text-danger-name" class="text-danger pt-2"></span>     

                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email Address</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <span id="text-danger-email" class="text-danger pt-2"></span>     
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label">Phone</label>
                            <div class="pass-group">
                                <input type="number" class="pass-input form-control" id="phone" name="phone">
                            
                            </div>
                            <span id="text-danger-phone" class="text-danger pt-2"></span>     

                        </div>



                        <div class="mb-3">
                            <label class="col-form-label">Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" id="password" name="password">
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                            <span id="text-danger-password" class="text-danger pt-2"></span>   
                        </div>


                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check form-check-md d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" value="" id="checkebox-md" checked="">
                                <label class="form-check-label" for="checkebox-md">
                                    I agree to the <a href="javascript:void(0);" class="text-primary link-hover">Terms & Privacy</a>                                     
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </div>
                        <div class="mb-3">
                            <h6>Already have an account? <a href="{{url('index')}}" class="text-purple link-hover"> Sign In Instead</a></h6>
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

            $('#name').focus();
            $('#customerRegisterFrm').submit(function(e){
            e.preventDefault();
            
            let formData = new FormData(this);
                
            let email = $('#email').val().trim();
            let name = $('#name').val().trim();
            let phone = $('#phone').val().trim();
            let password=$('#password').val().trim();


            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format




            $('#text-danger-name').html("");
            $('#text-danger-email').html("");
            $('#text-danger-phone').html("");
            $('#text-danger-password').html("");


            if(name==""){
                $('#text-danger-name').html("Name field required");
            }    

            if(email==""){
                $('#text-danger-email').html("Email field required");
            }
            else if (!emailRegex.test(email)) {
                    $('#text-danger-email').html("Please enter a valid email address");
            }

            if(password==""){
                $('#text-danger-password').html("Password field required");
            }
            if (password.length < 6) {
                $('#text-danger-password').text('Password must be at least 6 characters long.');
            }

            if (!phoneRegex.test(phone)) {
                $('#text-danger-phone').text('Please enter a valid 10-digit phone number.');
            }


            // return false;

            $.ajax({
                url:'{{route("customer.store")}}',
                type:"POST",
                data:formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                    console.log('Success:', response.status);
                     if(response.status==false){
                        Swal.fire({
                            icon: "error",
                            title: "Registration Error...",
                            text: "Some thing went wrong please try again later....",
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
