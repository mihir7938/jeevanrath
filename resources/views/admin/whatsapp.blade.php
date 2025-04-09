@extends('layouts.admin-app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Whatsapp Setup</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="btn btn-primary" id="btnsubmit" name="btnsubmit">Generate QR Code</button>
								</div>
							</div>
						</div>
					</div>
					<div id="qr_code" style="display: none;">							
						@include('admin.qr-code', ['qrcode_image' => $qrcode_image])
					</div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Test Whatsapp</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('admin.whatsapp.send')}}" class="form" id="send-message-form" enctype="multipart/form-data">
                                @csrf
                                @include('shared.alert')
                                @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($active_whatsapp_number)
                                            <div><label>Active Whatsapp Number :</label> {{ $active_whatsapp_number }}</div>
                                            <div class="mb-2"><label>Active Session :</label> {{ $active_session_id }}</div>
                                        @else
                                            <div style="color:#FF0000;" class="mb-2">Whatsapp Number not activated</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="phone" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary" id="sendMsg" name="sendMsg">Send Test Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
<script>
    $(function () {
		$(document).on('click', '#btnsubmit', function(){
			$('.loader').show();
			$.ajax({
				url: "{{ route('admin.whatsapp.qrcode') }}",
				method: "GET",
				headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function (data) {
					$('.loader').hide();						
					$("#qr_code").html('');						
					$("#qr_code").show();						
					$('#qr_code').append(data);
				},
			});
		});
		$(document).on('click', '#checkStatus', function(){
			$('.loader').show();
			$.ajax({
				url: "{{ route('admin.whatsapp.check') }}",
				method: "GET",
				headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
				  'session_id' : $("#session_id").val(),
				},
				success: function (response) {
					$('.loader').hide();
					if(response.status == true) {
						$("#message").html('<strong style="color:green;">Connected</strong>');
						window.setTimeout(function() {
							document.location.reload(true);
						}, 5000);
					} else {
						$("#message").html('<strong style="color:red;">Not Connected</strong>');	
					}
				},
			});
		});
        $('#send-message-form').validate({
            rules:{
                mobile:{
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                }
            },
            messages:{
                mobile:{
                    required: "Please enter mobile number.",
                }
            }
        });
    });
</script>
@endsection