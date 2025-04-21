<?php $page = 'manage-users'; ?>
@extends('layout.mainlayout')
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
									<h4 class="page-title">User<span class="count-title" id="total-count"></span></h4>
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
											<input type="text" class="form-control" id="customSearch1" placeholder="Search User">
										</div>							
									</div>		
									<div class="col-sm-8">					
										<div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
										
											<a href="javascript:void(0);" id="get_users_list" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i class="ti ti-square-rounded-plus me-2"></i>Add Contacts</a>
											<a href="javascript:void(0);" class="btn btn-primary mx-2" id="uploadTrigger">
													<i class="ti ti-square-rounded-plus me-2"></i>Bulk Upload
												</a>
												<a href="javascript:void(0);" class="btn btn-primary mx-2" id="autouploadTrigger">
													<i class="ti ti-square-rounded-plus me-2"></i>Auto Upload
												</a>		

					
										</div>
									</div>
								</div>
								<!-- /Search -->
							</div>
							<div class="card-body">
								<!-- Filter -->
								<div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2 mb-4">
									<div class="d-flex align-items-center flex-wrap row-gap-2">
									
									</div>
									<div class="d-flex align-items-center flex-wrap row-gap-2">
										
									</div>
								</div>
								<!-- /Filter -->

								<!-- Manage Users List -->
								<div class="table-responsive custom-table">
									<table class="table" id="phone-users-list">
										<thead class="thead-light">
											<tr>
												
											<th>ID</th>
												<th>Name</th>
												<th>phone</th>
												<th>Email</th>
												<th>Total Calls</th>
												<th>Pending Calls</th>
												<th>Complete Calls</th>
												<th>Lead Count</th>
												<th>Deal Count</th>
												<!-- <th class="text-end">Action</th>	 -->

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
@component('components.model-popup')
@endcomponent
@endsection