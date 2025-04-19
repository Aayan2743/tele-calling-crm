$(document).ready(function(){


	$('#file').on('change', function(e) {
		const file = e.target.files[0];
	
		if (file) {
			const reader = new FileReader();
	
			reader.onload = function(e) {
				$('#previewImage').attr('src', e.target.result).show();
			};
	
			reader.readAsDataURL(file);
		}
	});


	
	$('#edit-profile-image-input').on('change', function(e) {
		const file = e.target.files[0];
	
		if (file) {
			const reader = new FileReader();
	
			reader.onload = function(e) {
				$('#edit-preview-image').attr('src', e.target.result).show();
			};
	
			reader.readAsDataURL(file);
		}
	});

	
	$('#AddStaffFrm').submit(function(e){
		e.preventDefault();
	
		
	
		
		
		let formData = new FormData(this);
			
		let name =$('#name').val().trim();
	
		let email = $('#email').val().trim();
		
		let password=$('#password').val().trim();
		let role=$('#role').val().trim();
		let phone=$('#phone').val().trim();
		let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format
		let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


		
		


		$('#text-danger-name').html("");
		$('#text-danger-email').html("");
		$('#text-danger-role').html("");
		$('#text-danger-phone').html("");
		$('#text-danger-password').html("");

		if(name==""){
			$('#text-danger-name').html("Name field required");
		}

		if(email==""){
			$('#text-danger-email').html("Email field required");
		}else if (!emailRegex.test(email)) {
				$('#text-danger-email').html("Please enter a valid email address");
		}

		if(role==""){
			$('#text-danger-role').html("Role field required");
		}

		if(phone==""){
			$('#text-danger-phone').html("Phone field required");
		}

		

		if (!phoneRegex.test(phone)) {
			$('#text-danger-phone').text('Please enter a valid 10-digit phone number.');
		}

		if(password==""){
			$('#text-danger-password').html("Password field required");
		}
		if (password.length < 6) {
			$('#text-danger-password').text('Password must be at least 6 characters long.');
		}

		$.ajax({
			url:storeStaffUrl,
			type:"POST",
			data:formData,
			processData: false,
			contentType: false, 
			success: function(response) {
				console.log('Success:', response.status);
				 if(response.status==false){
					Swal.fire({
						icon: "error",
						title: "Error...",
						text: "Something went wrong....",
						// footer: '<a href="#">Why do I have this issue?</a>'
						});
				 }   

				 else if(response.status==true){

					Swal.fire({
						icon: "success",
						title: "Staff...",
						text: "Staff Created...",
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false,
						didClose: () => {
							// Reload DataTable without resetting pagination
							$('#manage-users-list').DataTable().ajax.reload(null, false);
					
							// Close offcanvas gracefully
							const offcanvasEl = document.getElementById('offcanvas_add');
							const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
							offcanvasInstance.hide();
					
							// Reset form and error messages
							$('#AddStaffFrm')[0].reset();
							$('.text-danger').html('');
							$('#previewImage').attr('src', ''); // Clear image preview if needed
						}
					});
					

					// window.location.href = '/dashboard';  
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
		

		

	})

	$(document).on('click', '.edit-btn', function() {
		// Fetch data from data attributes
		let id = $(this).data('id');
		let name = $(this).data('name');
		let email = $(this).data('email');
		let phone = $(this).data('phone');
		let role = $(this).data('role');
		let status = $(this).data('status');
		let profileImage = $(this).data('image');
		let defaultImage = 'default.jpg';
		
		console.log("null", profileImage + defaultImage);
		
		// Set the values in the offcanvas form
		$('#edit-id').val(id);          // Example: input field for ID (if you want to show it)
		$('#edit-name').val(name);      // Example: input field for Name
		$('#edit-email').val(email);    // Example: input field for Email
		$('#edit-phone').val(phone);    // Example: input field for Phone
		$('#edit-role').val(role);      // Example: select field for Role
		

		if (profileImage) {
			$('#edit-preview-image').attr('src', profileImage); // Assuming you have an img element with id "edit-profile-image"
		} else {
			// If there is no image, set a default image or leave it blank
			$('#edit-preview-image').attr('src', defaultImage); // Replace with your default image path
		}
		
		$('input[name="edit-status"][value="' + status + '"]').prop('checked', true);

	
	});

	$('#EditStaffFrm').submit(function(e){
		e.preventDefault();
	
		
		
		
		let formData = new FormData(this);
			
		let name =$('#edit-name').val().trim();
	
		let email = $('#edit-email').val().trim();
		
		let password=$('#edit-password').val().trim();
		let role=$('#edit-role').val().trim();
		let phone=$('#edit-phone').val().trim();
		let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format
		let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


		
		


		$('#text-danger-edit-name').html("");
		$('#text-danger-edit-email').html("");
		$('#text-danger-edit-role').html("");
		$('#text-danger-edit-phone').html("");
		$('#text-danger-edit-password').html("");

		if(name==""){
			$('#text-danger-edit-name').html("Name field required");
		}

		if(email==""){
			$('#text-danger-edit-email').html("Email field required");
		}else if (!emailRegex.test(email)) {
				$('#text-danger-edit-email').html("Please enter a valid email address");
		}

		if(role==""){
			$('#text-danger-edit-role').html("Role field required");
		}

		if(phone==""){
			$('#text-danger-edit-phone').html("Phone field required");
		}

		

		if (!phoneRegex.test(phone)) {
			$('#text-danger-edit-phone').text('Please enter a valid 10-digit phone number.');
		}

	
		$.ajax({
			url:updateStaffUrl,
			type:"POST",
			data:formData,
			processData: false,
			contentType: false, 
			success: function(response) {
				console.log('Success:', response.status);
				 if(response.status==false){
					Swal.fire({
						icon: "error",
						title: "Error...",
						text: "Something went wrong....",
						// footer: '<a href="#">Why do I have this issue?</a>'
						});
				 }   

				 else if(response.status==true){

					Swal.fire({
						icon: "success",
						title: "updated...",
						text: "Staff updated...",
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false,
						didClose: () => {
							// Reload DataTable without resetting pagination
							$('#manage-users-list').DataTable().ajax.reload(null, false);
					
							// Close offcanvas gracefully
							const offcanvasEl = document.getElementById('offcanvas_edit');
							const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
							offcanvasInstance.hide();
					
							// Reset form and error messages
							$('#EditStaffFrm')[0].reset();
							$('.text-danger').html('');
							$('#previewImage').attr('src', ''); // Clear image preview if needed
						}
					});
					

					// window.location.href = '/dashboard';  
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
		

		

	})


	
});