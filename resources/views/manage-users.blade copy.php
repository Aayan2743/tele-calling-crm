<?php $page = 'manage-users'; ?>
@extends('layout.mainlayout')
<style>

.profile-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}

.profile-avatar {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    background-color: #4caf50; /* You can choose any color */
    color: white;
    font-weight: bold;
    font-size: 20px;
    border-radius: 50%;
    text-transform: uppercase;
}
</style>


@section('content')
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">

				<div class="row">
					<div class="col-md-12">

						<!-- Page Header -->
						<div class="page-header">
							<div class="row align-items-center">
								<div class="col-8">
									<h4 class="page-title">User<span class="count-title"></span></h4>
								</div>
								<div class="col-4 text-end">
									<div class="head-icons">
										<a href="{{url('manage-users')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
										<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
									</div>
								</div>
							</div>
						</div>
						<!-- /Page Header -->

						<div class="card">
							<div class="card-header">
								<!-- Search -->
								<div class="row align-items-center">
									<div class="col-sm-4">
										<div class="icon-form mb-3 mb-sm-0">
											<span class="form-icon"><i class="ti ti-search"></i></span>
											<input type="text" class="form-control" placeholder="Search User">
										</div>							
									</div>		
									<div class="col-sm-8">					
										<div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
											<div class="dropdown me-2">
												<a href="javascript:void(0);" class="dropdown-toggle"  data-bs-toggle="dropdown"><i class="ti ti-package-export me-2"></i>Export</a>
												<div class="dropdown-menu  dropdown-menu-end">
													<ul>
														<li>
															<a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-pdf text-danger me-1"></i>Export as PDF</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item"><i class="ti ti-file-type-xls text-green me-1"></i>Export as Excel </a>
														</li>
													</ul>
												</div>
											</div>	
											<a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus me-2"></i>Add user</a>
										</div>
									</div>
								</div>
								<!-- /Search -->
							</div>
							<div class="card-body">
								

								<!-- Manage Users List -->
								<div class="table-responsive custom-table">
									<table class="table" id="manage-users-list">
										<thead class="thead-light">
											<tr>
												<th>S No</th>
												<th>Name</th>
											
												<th>Email</th>
												<th>Phone</th>
												<th>Created</th>
												<th>Status</th>
												<th>Pic</th>
												<th class="text-end">Action</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="datatable-length"></div>
									</div>
									<div class="col-md-6">
										<div class="datatable-paginate"></div>
									</div>
								</div>
								<!-- /Manage Users List -->

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->
<!-- @component('components.model-popup')
@endcomponent -->












<script src="{{ URL::asset('build/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>







<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Add New User</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ti ti-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <form id="addUser">	
			@csrf						
            <div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
					<div class="col-md-12">
								<div class="profile-pic-upload">
									<div class="profile-pic">
										<span><i class="ti ti-photo"></i></span>
										<!-- Image preview area -->
										<img id="previewImage" src="#" alt="Image Preview" style="display: none; width: 120px; height: 120px; object-fit: cover; border-radius: 8px; margin-top: 10px;" />
									</div>
									<div class="upload-content">
										<div class="upload-btn">
											<input type="file" id="file" name="file" accept="image/*">
											<span>
												<i class="ti ti-file-broken"></i>Upload File
											</span>
										</div>
										<p>JPG, GIF or PNG. Max size of 800K</p>
									</div>
								</div>
							</div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label"> Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
								<span id="text-danger-name" class="text-danger pt-2"></span>
                            </div>
                        </div>
                       									
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                  
                                </div>
                                <input type="text" id="email" name="email" required  class="form-control">
								<span id="text-danger-email" class="text-danger pt-2"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
						<div class="mb-3">
								<label class="col-form-label">Role <span class="text-danger">*</span></label>
								<select class="form-control" name="role" id="role" required >
									<option value="">Select Role</option>
									<option value="Admin">Admin</option>
									<option value="Staff">Staff</option>
									
									<!-- Add more roles as needed -->
								</select>
								<span id="text-danger-role" class="text-danger pt-2"></span>
							</div>

                        </div>
                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Phone <span class="text-danger">*</span> </label>
							


                                <input type="number" id="phone" name="phone" required  class="form-control">
								<span id="text-danger-phone" class="text-danger pt-2"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                <div class="icon-form-end">
                                    <span class="form-icon"><i class="ti ti-eye-off"></i></span>
                                    <input type="password" id="password" name="password"  required class="form-control">
									<span id="text-danger-password" class="text-danger pt-2"></span>
                                </div>
                            </div>
                        </div>
                       
                        
                        <div class="col-md-6">
                            <div class="radio-wrap">
                                <label class="col-form-label">Status</label>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <input type="radio" class="status-radio" id="active1" name="status" value="1" checked="">
                                        <label for="active1">Active</label>
                                    </div>
                                    <div>
                                        <input type="radio" class="status-radio" id="inactive1" name="status" value="0">
                                        <label for="inactive1">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Basic Info -->
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                <button type="submit" id="addUserDetails" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    

</div>





<script>
$(document).ready(function () {



    let table =  $('#manage-users-list2').DataTable({
	
		
        processing: true,
        serverSide: true,
        ajax: '{{ route("user.index") }}', // Must match the route!
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'created_at', name: 'created_at' },
            { data: 'active_status', name: 'active_status',
				render: function(data, type, row) {
					if (data == 1) {
						return '<span class="badge bg-success">Active</span>';
					} else {
						return '<span class="badge bg-danger">Inactive</span>';
					}
				}
			},
			{ data: 'profile_image', name: 'profile_image',
				render: function(data, type, row) {
                // Assuming the image is stored in a directory like 'storage/profile_images/'
				// return data ? '<img src="{{ asset('storage') }}/' + data + '" alt="Profile Image" style="width: 50px; height: 50px; object-fit: cover;">' : 'No image';
				if (data) {
                    // If image exists, show the image
                    return '<img src="{{ asset('storage') }}/' + data + '" alt="Profile Image" class="profile-img">';
                } else {
                    // If no image, show the first letter of the name
                    // var firstLetter = row.name.charAt(0).toUpperCase();
                    // return '<div class="profile-avatar">' + firstLetter + '</div>';

					function getRandomColor() {
						const colors = ['#FF5733', '#33FF57', '#3357FF', '#FF33A1']; // Add more colors as needed
						const randomIndex = Math.floor(Math.random() * colors.length);
						return colors[randomIndex];
					}

					// Inside your DataTable rendering function
					var firstLetter = row.name.charAt(0).toUpperCase();
					var randomColor = getRandomColor();
					return '<div class="profile-avatar" style="background-color: ' + randomColor + ';">' + firstLetter + '</div>';
				}		
			
			},
			},
				
			{
					"render": function (data, type, row) {
						return '<div class="dropdown table-action">' +
							'<a href="#" class="action-icon" data-bs-toggle="dropdown" aria-expanded="false">' +
								'<i class="fa fa-ellipsis-v"></i>' +
							'</a>' +
							'<div class="dropdown-menu dropdown-menu-right">' +
								'<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#offcanvasExample">' +
									'<i class="ti ti-edit text-blue"></i> Edit' +
								'</a>' +
								'<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_faq">' +
									'<i class="ti ti-trash text-danger"></i> Delete' +
								'</a>' +
							'</div>' +
						'</div>';
					}
				}


        ]
    });


	$('#addUser').submit(function(e){
		
			e.preventDefault();

			let email = $('#email').val().trim();
            let password=$('#password').val().trim();
            let phone=$('#phone').val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			let phoneRegex = /^[0-9]{10}$/;
		


            $('#text-danger-email').html("");
            $('#text-danger-password').html("");
            $('#text-danger-phone').html("");
            $('#text-danger-password').html("");

			if (!emailRegex.test(email)) {
                    $('#text-danger-email').html("Please enter a valid email address");
            }

			if (!phoneRegex.test(phone)) {
				$('#text-danger-phone').text('Please enter a valid 10-digit phone number.');
            }
			if (password.length < 6) {
                $('#text-danger-password').text('Password must be at least 6 characters long.');
            }


			let formData = new FormData(this);

			$.ajax({
                url:'{{route("user.store")}}',
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
                        // window.location.href = '/dashboard';  
						Swal.fire({
						icon: "success",
						title: "Staff Details...",
						text: "Staff Added Successfully.",
						timer: 3000, // Show alert for 3 seconds (3000 milliseconds)
						showConfirmButton: false,
						willClose: () => {
							$('#addUser')[0].reset(); // Reset form fields
							$('#file').attr('src', ''); // If you're showing image preview
							$('#offcanvas_add').offcanvas('hide');
							table.ajax.reload(null, false);
							
							// location.reload(); // Reload page after the alert closes
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


<script>
document.getElementById('file').addEventListener('change', function (event) {
    const preview = document.getElementById('previewImage');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>

@endsection