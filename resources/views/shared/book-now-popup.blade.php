<div class="modal fade" id="book-now-modal" tabindex="-1" role="dialog" aria-labelledby="myBookNowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form method="POST" action="{{route('send_enquiry')}}" id="book-now-form" enctype="multipart/form-data">
	            <div class="modal-header">
	                <div class="modal-title" id="myBookNowModalLabel">Book Your Car Now</div>
	                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
	            </div>
	            <div class="modal-body">
	            	@csrf
                    <div class="message"></div>
                    <div class="row gy-3 gx-4">
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="First Name" name="name">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Date of Journey" id="datepicker" name="journey_date">
                        </div>
                        <div class="col-xl-6">
                            <input type="phone" class="form-control py-2 border-primary bg-transparent" placeholder="Mobile" name="mobile">
                        </div>
                        <div class="col-xl-6">
                            <input type="email" class="form-control py-2 border-primary bg-transparent" placeholder="Email" name="email">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Pickup From" name="pickup_from">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Drop To" name="drop_to">
                        </div>
                        <div class="col-xl-6">
                            <select class="form-select py-2 border-primary bg-transparent" aria-label="Default select car" name="car">
                                <option value="">Select Car</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Ac Sedan">Ac Sedan</option>
                                <option value="Ac Suv">Ac Suv</option>
                                <option value="Ac Innova">Ac Innova</option>
                                <option value="innova Crysta">innova Crysta</option>
                                <option value="tempo Traveller">tempo Traveller</option>
                            </select>
                        </div>
                        <div class="col-xl-6">
                            <select class="form-select py-2 border-primary bg-transparent" aria-label="Default select type of journey" name="journey_type">
                                <option value="">Type of journey</option>
                                <option value="One way Trip">One way Trip</option>
                                <option value="Round trip">Round trip</option>
                                <option value="Local car rental">Local car rental</option>
                            </select>
                        </div>
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary text-white py-2 px-3" data-bs-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-primary text-white py-2 px-5">Submit Now</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#book-now-modal').on('hidden.bs.modal', function (e) {
            $(this).find("input,textarea,select").val('').end();
            var $alertas = $('#book-now-modal');
            $alertas.validate().resetForm();
            $alertas.find('.error').removeClass('error');
            $(".message").html('');
        })
        $('#datepicker').datepicker({
            startDate: '+0d',
            format: 'dd/mm/yyyy',
            autoclose: true
        });
        $('#book-now-form').validate({
            rules:{
                name:{
                    required: true
                },
                journey_date:{
                    required: true
                },
                mobile:{
                    required: true,
          			digits: true,
                },
                email: {
		          	maxlength: 155,
		        },
                pickup_from:{
                    required: true
                },
                drop_to:{
                    required: true
                },
                car:{
                    required: true
                },
                journey_type:{
                    required: true
                },
            },
            messages:{
                name:{
                    required: "Please enter name."
                },
                journey_date:{
                    required: "Please select journey date."
                },
                mobile:{
                    required: "Plese enter mobile number.",
                },
                email:{
		          	email: "Please provide a valid email."
		        },
                pickup_from:{
                    required: "Please enter pickup from."
                },
                drop_to:{
                    required: "Please enter drop to."
                },
                car:{
                    required: "Please select car."
                },
                journey_type:{
                    required: "Please select journey type."
                },
            },
            submitHandler: function (form) {
                $('#spinner').addClass('show');
                $.ajax({
                    url: "{{ route('send_enquiry') }}",
                    method: "POST",
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                      'data' : $('#book-now-form').serialize(),
                    },
                    success: function (data) {
                      $('#spinner').removeClass('show');
                      if(data.status == true) {
                        $(".message").html('<div class="alert alert-success"><span>Enquiry has been sent successfully.</span></div>');
                        setTimeout(function(){
                            $('#book-now-modal').modal('hide')
                        }, 2000);
                      } else {
                        $(".message").html('<div class="alert alert-warning"><span>Something went wrong.</span></div>');
                      }
                    },
                });
            }
        }); 
    });
</script>