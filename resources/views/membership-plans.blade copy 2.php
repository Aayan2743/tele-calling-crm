<?php $page = 'membership-plans'; ?>
@extends('layout.mainlayout1')
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
									<h4 class="page-title">Membership Plans</h4>
								</div>
								
							</div>
						</div>
						<!-- /Page Header -->

					
						<div class="d-block">
							
							<div class="row justify-content-center">
								<div class="col-lg-4 col-md-6">
									<div class="card border">
										<div class="card-body">
											<div class="text-center border-bottom pb-3 mb-3">
												<span>Basic</span>
												<h2 class="d-flex align-items-end justify-content-center mt-1" >$50 <span class="fs-14 fw-medium ms-2">/ month</span></h2>
												<input type="text" id="plan_amount" value="50"/>
											</div>
											<div class="d-block">
												<div>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>10 Contacts
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>10 Leads
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>20 Companies
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>50 Compaigns
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>100 Projects
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Deals
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Tasks
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Pipelines
													</p>
												</div>
												<div class="text-center mt-3">
													
													<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="choosePlanBtn" >Choose</button>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-md-6">
									<div class="card border">
										<div class="card-body">
											<div class="text-center border-bottom pb-3 mb-3">
												<span>Business</span>
												<h2 class="d-flex align-items-end justify-content-center mt-1">$200
													<span class="fs-14 fw-medium ms-2">/ month</span>
												</h2>
											</div>
											<div class="d-block">
												<div>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>20 Contacts
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>20 Leads
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>50 Companies
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Compaigns
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Projects
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Deals
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Tasks
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark">
														<span class="bg-danger d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-x"></i>
														</span>Pipelines
													</p>
												</div>
												<div class="text-center mt-3">
													<a href="{{ route('phonepe.pay') }}" class="btn btn-primary">Choose dddd</a>
												</div>

												


											</div>
										</div>
									</div>
								</div>

								
								<div class="col-lg-4 col-md-6">
									<div class="card border">
										<div class="card-body">
											<div class="text-center border-bottom pb-3 mb-3">
												<span>Enterprise</span>
												<h2 class="d-flex align-items-end justify-content-center mt-1">$400
													<span class="fs-14 fw-medium ms-2">/ month</span>
												</h2>
											</div>
											<div class="d-block">
												<div>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Contacts
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Leads
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Companies
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Compaigns
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Unlimited Projects
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Deals
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark mb-2">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Tasks
													</p>
													<p class="d-flex align-items-center fs-16 fw-medium text-dark">
														<span class="bg-success d-flex align-items-center justify-content-center fs-12 wh-14 me-1 rounded"><i class="ti ti-check"></i>
														</span>Pipelines
													</p>
												</div>
												<div class="text-center mt-3">
													<a href="#" class="btn btn-primary">Choose</a>
												</div>
											</div>
										</div>
									</div>
								</div>



								<!-- new rozar -->
							
								<!-- end -->
							</div>
						</div>				
					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

<script>
document.getElementById('choosePlanBtn').addEventListener('click', function() {
    // Get the plan amount
    var planAmount = document.getElementById('plan_amount').value;
	console.log("eeee"+ planAmount);
    // Update the modal with the plan amount
    document.getElementById('amount1').value = planAmount;
});

</script>

@component('components.model-popup')
@component('components.models')
@endcomponent
<script src="{{ URL::asset('build/js/jquery-3.7.1.min.js') }}"></script>
<script>
$('a').on('click', function(e) {
    e.preventDefault();  // Prevent default link behavior
    var url = $(this).attr('href');
    window.location.href = url;  // Manually redirect
});



</script>
@endsection