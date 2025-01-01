@extends('layouts.app')
@section('content')
	<div class="container-fluid bg-breadcrumb">
		<div class="container text-center py-5" style="max-width: 900px;">
			<h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contact Us</h1>   
		</div>
	</div>
    <div class="container-fluid contact py-5">
		<div class="container py-5">
			<div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.1s">
				<div class="sub-style mb-4">
					<h4 class="sub-title text-white px-3 mb-0">Contact Us</h4>
				</div>
				<div class="bg-transparent rounded">
				    <div class="row g-4">
				        <div class="col-lg-4 col-xl-4">
        					<div class="d-flex flex-column align-items-center text-center mb-4">
        						<div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-map-marker-alt fa-2x text-primary"></i></div>
        						<h4 class="text-dark">Address</h4>
        						<p class="mb-0 text-white">A-106-Truimph Plaza, Near Palanpur Fire Station Canal Road, Gaurav Path Road, Pal Gam, Surat, Gujarat 395009</p>
        					</div>
    					</div>
    					<div class="col-lg-4 col-xl-4">
        					<div class="d-flex flex-column align-items-center text-center mb-4">
        						<div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-phone-alt fa-2x text-primary"></i></div>
        						<h4 class="text-dark">Mobile</h4>
        						<p class="mb-0 text-white">+919726400024</p>
        					</div>
    					</div>
    				    <div class="col-lg-4 col-xl-4">
        					<div class="d-flex flex-column align-items-center text-center">
        						<div class="bg-white d-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px; border-radius: 50px;"><i class="fa fa-envelope-open fa-2x text-primary"></i></div>
        						<h4 class="text-dark">Email</h4>
        						<p class="mb-0 text-white">bookings.jeevanrath@gmail.com</p>
        					</div>
    					</div>
					</div>
				</div>
			</div>
			<div class="row g-4 align-items-center">
				<div class="col-lg-6 col-xl-6 contact-form wow fadeInLeft" data-wow-delay="0.1s">
					<h2 class="display-5 text-white mb-4">Get in Touch</h2>
					<form>
						<div class="row g-3">
							<div class="col-lg-12 col-xl-6">
								<div class="form-floating">
									<input type="text" class="form-control bg-transparent border border-white" id="first_name" placeholder="First Name">
									<label for="first_name">First Name</label>
								</div>
							</div>
							<div class="col-lg-12 col-xl-6">
								<div class="form-floating">
									<input type="text" class="form-control bg-transparent border border-white" id="last_name" placeholder="Last Name">
									<label for="last_name">Last Name</label>
								</div>
							</div>
							<div class="col-lg-12 col-xl-6">
								<div class="form-floating">
									<input type="phone" class="form-control bg-transparent border border-white" id="phone" placeholder="Phone">
									<label for="phone">Your Phone</label>
								</div>
							</div>
							<div class="col-lg-12 col-xl-6">
								<div class="form-floating">
									<input type="email" class="form-control bg-transparent border border-white" id="email" placeholder="Your Email">
									<label for="email">Your Email</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-floating">
									<input type="text" class="form-control bg-transparent border border-white" id="subject" placeholder="Subject">
									<label for="subject">Subject</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-floating">
									<textarea class="form-control bg-transparent border border-white" placeholder="Leave a message here" id="message" style="height: 160px"></textarea>
									<label for="message">Message</label>
								</div>
							</div>
							<div class="col-12">
								<button class="btn btn-light text-primary w-100 py-3">Send Message</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-6 col-xl-6 wow fadeInRight" data-wow-delay="0.3s">
					<div class="d-flex justify-content-center mb-4">
						<a class="btn btn-lg-square btn-light rounded-circle mx-2" href="https://www.facebook.com/p/Jeevanrath-Rental-Cars-Surat-100066783011785/"><i class="fab fa-facebook-f"></i></a>
						<a class="btn btn-lg-square btn-light rounded-circle mx-2" href="#"><i class="fab fa-instagram"></i></a>
					</div>
					<div class="rounded h-100">
						<iframe class="rounded w-100" 
						style="height: 500px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.6904867403478!2d72.7674068!3d21.204451!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04d9a1f047753%3A0xca1c84bc4b88a5ee!2sJeevanrath%20Tours%20%26%20Travels!5e0!3m2!1sen!2sin!4v1734790757164!5m2!1sen!2sin" 
						loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('footer')
@endsection