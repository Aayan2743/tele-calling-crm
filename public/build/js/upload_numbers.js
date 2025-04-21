$(document).ready(function(){

	$('#manage-users-list_filter1').hide();

$("#get_users_list").click(function(e){



	$.ajax({
        url: user_list, // make sure this is defined or use a direct URL string like '/api/users'
        type: 'GET', // explicitly set the method
        dataType: 'json', // expect JSON in response
        success: function(response) {
            console.log('User data received:', response);
			
			if (response.status) {
				let roleDropdown = $('#users');
				roleDropdown.empty(); // clear previous options
	
				roleDropdown.append('<option value="" disabled selected>Select Staff</option>');
	
				$.each(response.data, function(index, staff) {
					roleDropdown.append(`<option value="${staff.id}">${staff.name}</option>`);
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

$('#customSearch1').on('keyup', function () {
	$('#phone-users-list').DataTable().search(this.value).draw();
});

$('#AddphoneNumber').submit(function(e){
	e.preventDefault();

	

	
	
	let formData = new FormData(this);
		
	let name =$('#name').val().trim();



	let role=$('#users').val().trim();
	let phone=$('#phone').val().trim();
	let phoneRegex = /^[0-9]{10}$/; // Adjust this regex to fit your desired format



	
	


	$('#text-danger-name').html("");
	
	$('#text-danger-users').html("");
	$('#text-danger-number').html("");


	if(name==""){
		$('#text-danger-name').html("Name field required");
	}

	

	if(role==""){
		$('#text-danger-role').html("Role field required");
	}

	if(phone==""){
		$('#text-dangernumber-phone').html("Phone field required");
	}

	

	if (!phoneRegex.test(phone)) {
		$('#text-danger-phone').text('Please enter a valid 10-digit phone number.');
	}

	// return false;

	$.ajax({
		url:add_phone_number,
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
					title: "Assigned...",
					text: "Phone Number Assined...",
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
						$('#AddphoneNumber')[0].reset();
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


// upload bulk

$('#uploadTrigger').on('click', function() {
	// $('#upload_file').click();

	$('.countDetails').hide();

	$('#uploadFile').val('');

	
	$.ajax({
        url: user_list, // make sure this is defined or use a direct URL string like '/api/users'
        type: 'GET', // explicitly set the method
        dataType: 'json', // expect JSON in response
        success: function(response) {
            console.log('User data received:', response);
			
			if (response.status) {
				let roleDropdown = $('#staff_id');
				roleDropdown.empty(); // clear previous options
	
				roleDropdown.append('<option value="" disabled selected>Select Staff</option>');
	
				$.each(response.data, function(index, staff) {
					roleDropdown.append(`<option value="${staff.id}">${staff.name}</option>`);
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
	
	
	
	
	
	$('#bulkUploadModal').modal('show');





});



$('#autouploadTrigger').on('click', function() {
	// $('#upload_file').click();

	$('.countDetailsauto').hide();

	// $('#uploadFile').val('');

	$('#autobulkUploadModal').modal('show');





});

// Handle file selection


//
$('#bulkUploadForm').submit(function(e){
	e.preventDefault();

	
	// $('#inserted-count').text('');
	// $('#duplicate-count').text('');
	

	let formData = new FormData($('#bulkUploadForm')[0]);

	$.ajax({
		url: bulk_upload, // Replace with your actual route
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			// alert('File uploaded successfully!');
			$('.countDetails').show();
			$('#inserted-count').text(response.inserted);
			$('#duplicate-count').text(response.duplicates);
			$('#uploadFile').val('');
			$('#phone-users-list').DataTable().ajax.reload(null, false);
		},
		error: function(xhr) {
			console.error(xhr.responseJSON);
			alert('File upload failed.',xhr.responseJSON);
		}
	});

	

})

//auto bulk upload code
$('#autobulkUploadForm').submit(function(e){
	e.preventDefault();

	let formData = new FormData($('#autobulkUploadForm')[0]);

	$.ajax({
		url: bulk_auto_upload, // Replace with your actual route
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			// alert('File uploaded successfully!');
			$('.countDetailsauto').show();
			$('#inserted-count-auto').text(response.success_count);
			$('#duplicate-count-auto').text(response.duplicate_count);
			$('#uploadFile').val('');
			$('#phone-users-list').DataTable().ajax.reload(null, false);
		},
		error: function(xhr) {
			console.error(xhr.responseJSON);
			alert('File upload failed.',xhr.responseJSON);
		}
	});

	

})
//auto bulk upload end


$('#upload_file').on('change', function() {
	let formData = new FormData($('#uploadForm')[0]);

	$.ajax({
		url: bulk_upload, // Replace with your actual route
		type: 'POST',
		data: formData,
		contentType: false,
		processData: false,
		success: function(response) {
			alert('File uploaded successfully!');
		},
		error: function(xhr) {
			alert('File upload failed.');
		}
	});
});



	

	
	
});