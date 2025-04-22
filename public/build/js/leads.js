$(document).ready(function(){

	$("#addlead_get_users").click(function(e){



		$.ajax({
			url: user_list, // make sure this is defined or use a direct URL string like '/api/users'
			type: 'GET', // explicitly set the method
			dataType: 'json', // expect JSON in response
			success: function(response) {
				console.log('User data received:', response);
				
				if (response.status) {
					let roleDropdown = $('#staff');
					roleDropdown.empty(); // clear previous options
		
					roleDropdown.append('<option value="" disabled selected>Select Staff</option>');
		
					// $.each(response.data, function(index, staff) {
					// 	roleDropdown.append(`<option value="${staff.id}">${staff.name}</option>`);
					// });
					
					$.each(response.data, function(index, staff) {
						// let image = staff.profile_image || defaultImage;

						if(staff.profile_image==null){
							var fullImageUrl =defaultImage;
						}else{
							var fullImageUrl = userImageStorage +'/'+ staff.profile_image;
						}
						
						roleDropdown.append(
							`<option value="${staff.id}" data-image="${fullImageUrl}">${staff.name}</option>`
						);
					});
				} else {
					console.error("No staff found.");
				}
				// You can now use the data to populate a table, console log, or do whatever you need
			},
			error: function(xhr, status, error) {
				console.error('Error fetching users:', error);
			}
		});
	
	});



	$('#LeadAdd').submit(function(e){
		e.preventDefault();
	
		let formData = new FormData(this);
			
		let name =$('#leadname').val().trim();
		let phone=$('#leadphone').val().trim();
		let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format
		let leadsource=$('#leadsource').val().trim();
	


		$('#text-danger-leadname').html("");	
		$('#text-danger-leadphone').html("");
		$('#text-danger-number').html("");
	
	
	
		
	
		
		if(phone==""){
			$('#text-dangernumber-leadphone').html("Phone field required");
		}
	
		
	
		if (!phoneRegex.test(phone)) {
			$('#text-danger-leadphone').text('Please enter a valid 10-digit phone number.');
		}
	
		// return false;
	
		$.ajax({
			url:add_lead,
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
						title: "Lead...",
						text: "Lead Created...",
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false,
						didClose: () => {
							// Reload DataTable without resetting pagination
							$('#phone-users-list').DataTable().ajax.reload(null, false);
					
							// Close offcanvas gracefully
							const offcanvasEl = document.getElementById('offcanvas_add');
							const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
							offcanvasInstance.hide();
					
							// Reset form and error messages
							$('#LeadAdd')[0].reset();
							$('.text-danger').html('');
						
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

	function get_users(selectedStaffId=null){
		$.ajax({
			url: user_list, // make sure this is defined or use a direct URL string like '/api/users'
			type: 'GET', // explicitly set the method
			dataType: 'json', // expect JSON in response
			success: function(response) {
				console.log('User data received:', response);
				
				if (response.status) {
					let roleDropdown = $('#editstaff');
					roleDropdown.empty(); // clear previous options
		
					roleDropdown.append('<option value="" disabled selected>Select Staff</option>');
		
					// $.each(response.data, function(index, staff) {
					// 	roleDropdown.append(`<option value="${staff.id}">${staff.name}</option>`);
					// });
					
					$.each(response.data, function(index, staff) {
						// let image = staff.profile_image || defaultImage;

						if(staff.profile_image==null){
							var fullImageUrl =defaultImage;
						}else{
							var fullImageUrl = userImageStorage +'/'+ staff.profile_image;
						}
						
						roleDropdown.append(
							`<option value="${staff.id}" data-image="${fullImageUrl}">${staff.name}</option>`
						);
					});

					if (selectedStaffId) {
						roleDropdown.val(selectedStaffId);
					}

				} else {
					console.error("No staff found.");
				}
				// You can now use the data to populate a table, console log, or do whatever you need
			},
			error: function(xhr, status, error) {
				console.error('Error fetching users:', error);
			}
		});
	}




	$(document).on('click', '.edit-btn', function() {
		// Fetch data from data attributes

	
	
		let id = $(this).data('id');
		


		let name = $(this).data('name');
		let number = $(this).data('number');
		let lead_source = $(this).data('lead_source');
		let lead_industry = $(this).data('lead_industry');
		let email = $(this).data('email');
		let staff = $(this).data('staff');
		let description = $(this).data('description');
		
		get_users(staff); 
		
		
		// Set the values in the offcanvas form
		$('#edit_id').val(id);          // Example: input field for ID (if you want to show it)
		$('#edit_name').val(name);      // Example: input field for Name
		$('#edit_email').val(email);    // Example: input field for Email
		$('#edit_number').val(number);    // Example: input field for Phone
		$('#edit_lead_source').val(lead_source);      // Example: select field for Role
		$('#edit_lead_industry').val(lead_industry);      // Example: select field for Role
		$('#editstaff').val(staff);      // Example: select field for Role
		$('#editdescription').val(description);      // Example: select field for Role
		// $('#editstaff').val(staff).trigger('change');
		

	
	
	});



	$('#EditLead').submit(function(e){
		e.preventDefault();
	
		let formData = new FormData(this);
			
		let name =$('#leadname').val().trim();
		let phone=$('#edit_number').val().trim();
		let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format
		let leadsource=$('#leadsource').val().trim();
	


	
		$('#text-danger-edit_number').html("");
	
	
	
		
	
		
		if(phone==""){
			$('#text-danger-edit_number').html("Phone field required");
		}
	
		
	
		if (!phoneRegex.test(phone)) {
			$('#text-danger-edit_number').text('Please enter a valid 10-digit phone number.');
		}
	
		// return false;
	
		$.ajax({
			url:update_lead,
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
						title: "Lead...",
						text: "Lead Updated...",
						timer: 2000,
						timerProgressBar: true,
						showConfirmButton: false,
						didClose: () => {
							// Reload DataTable without resetting pagination
							$('#leads_list').DataTable().ajax.reload(null, false);
					
							// Close offcanvas gracefully
							const offcanvasEl = document.getElementById('offcanvas_edit');
							const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
							offcanvasInstance.hide();
					
							// Reset form and error messages
							$('#EditLead')[0].reset();
							$('.text-danger').html('');
						
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