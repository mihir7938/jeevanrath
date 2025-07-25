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
                        <div class="col-xl-12">
                            <label class="custom-control">
                                <input type="radio" id="self" name="user_type" value="Self" checked>
                                <span>Self</span>
                            </label>
                            <label class="custom-control">
                                <input type="radio" id="company" name="user_type" value="Company">
                                <span>Company</span>
                            </label>
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Company Name" name="company_name">
                        </div>
                        <div class="col-xl-6">
                            <select class="form-select py-2 border-primary bg-transparent" aria-label="Default select type of journey" name="journey_type" id="journey_type">
                                <option value="">Type of Journey</option>
                                <option value="One Way Trip">One Way Trip</option>
                                <option value="Local Car Rental (8 hrs/80 km)">Local Car Rental (8 hrs/80 km)</option>
                                <option value="Out Station (300 km avg)">Out Station (300 km avg)</option>
                                <option value="Airport Pickup & Drop">Airport Pickup & Drop</option>
                                <option value="Railway Station Pickup & Drop">Railway Station Pickup & Drop</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Full Name" name="name">
                        </div>
                        <div class="col-xl-6">
                            <input type="phone" class="form-control py-2 border-primary bg-transparent" placeholder="Mobile" name="mobile">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Pickup Location" name="pickup_location">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Drop Location" name="drop_location">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Journey Start Date" id="journey_start_date" name="journey_start_date">
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Journey End Date" id="journey_end_date" name="journey_end_date">
                        </div>
                        <div class="col-xl-6 hidden">
                            <input type="text" class="form-control py-2 border-primary bg-transparent" placeholder="Booker Name" name="booker_name">
                        </div>
                        <div class="col-xl-6 hidden">
                            <input type="phone" class="form-control py-2 border-primary bg-transparent" placeholder="Booker Mobile" name="booker_mobile">
                        </div>
                        <div class="col-xl-6">
                            <select class="form-select py-2 border-primary bg-transparent" aria-label="Default select car" name="car">
                                <option value="">Select Vehicle Type</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Sedan">Sedan</option>
                                <option value="MUV">MUV</option>
                                <option value="SUV">SUV</option>
                                <option value="Premium SUV">Premium SUV</option>
                                <option value="Luxury Car">Luxury Car</option>
                                <option value="Bus">Bus</option>
                            </select>
                        </div>
                        <div class="col-xl-6">
                            <input type="text" class="form-control py-2 border-primary bg-transparent datetimepicker-input" id="pickup_time" name="pickup_time" placeholder="Pickup Time" data-toggle="datetimepicker">
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
            $(this).find("input.form-control,textarea,select").val('').end();
            var $alertas = $('#book-now-modal');
            $alertas.validate().resetForm();
            $alertas.find('.error').removeClass('error');
            $("#book-now-form .message").html('');
        })
        $('#book-now-form #journey_start_date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#book-now-form #journey_end_date').datepicker('setStartDate', minDate);
        });
        $("#book-now-form #journey_end_date").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#book-now-form #journey_start_date').datepicker('setEndDate', minDate);
        });
        $('#book-now-form #pickup_time').datetimepicker({
            'format': 'LT'
        })
        $("#book-now-form input[name='user_type']").change(function(){
            if($(this).is(':checked')){
                if($(this).val() == 'Company'){
                    $('#book-now-form .hidden').show();
                    $("#book-now-form input[name='name']").attr("placeholder", "Guest Name");
                    $("#book-now-form input[name='mobile']").attr("placeholder", "Guest Mobile");
                }else{  
                    $('#book-now-form .hidden').hide();
                    $("#book-now-form input[name='name']").attr("placeholder", "Full Name");
                    $("#book-now-form input[name='mobile']").attr("placeholder", "Mobile");
                }
            }
        });
        $('#book-now-form').validate({
            rules:{
                company_name: {
                    required:function(){
                        if($('#book-now-form input[name="user_type"]:checked').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                },
                name:{
                    required:function(){
                        if($('#book-now-form input[name="user_type"]:checked').val()  == 'Company' && $("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                mobile:{
                    required:function(){
                        if($('#book-now-form input[name="user_type"]:checked').val()  == 'Company' && $("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    },
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pickup_location:{
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                drop_location:{
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                },
                journey_start_date:{
                    required: true
                },
                journey_end_date:{
                    required: true
                },
                car:{
                    required: true
                },
                journey_type:{
                    required: true
                },
                booker_name: {
                    required:function(){
                        if($('#book-now-form input[name="user_type"]:checked').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                },
                booker_mobile: {
                    required:function(){
                        if($('#book-now-form input[name="user_type"]:checked').val()  == 'Company') {
                            return true;
                        }
                        return false;
                    },
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                pickup_time: {
                    required:function(){
                        if($("#journey_type").val() == 'Monthly') {
                            return false;
                        }
                        return true;
                    }
                }
            },
            messages:{
                company_name:{
                    required: "Please enter company name."
                },
                name:{
                    required: "Please enter name."
                },
                mobile:{
                    required: "Plese enter mobile number.",
                },
                pickup_location:{
                    required: "Please enter pickup location."
                },
                drop_location:{
                    required: "Please enter drop location."
                },
                journey_start_date:{
                    required: "Please select journey start date."
                },
                journey_end_date:{
                    required: "Please select journey end date."
                },
                car:{
                    required: "Please select vehicle."
                },
                journey_type:{
                    required: "Please select journey type."
                },
                booker_name:{
                    required: "Please enter booker name."
                },
                booker_mobile:{
                    required: "Plese enter booker mobile number.",
                },
                pickup_time:{
                    required: "Please enter pickup time."
                }
            },
            submitHandler: function (form) {
                $('.loader').show();
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
                      $('.loader').hide();
                      if(data.status == true) {
                        $("#book-now-form .message").html('<div class="alert alert-success"><span>Enquiry has been sent successfully.</span></div>');
                        setTimeout(function(){
                            $('#book-now-modal').modal('hide')
                        }, 2000);
                      } else {
                        $("#book-now-form .message").html('<div class="alert alert-warning"><span>Something went wrong.</span></div>');
                      }
                    },
                });
            }
        }); 
    });
</script>