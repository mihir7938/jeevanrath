<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Scan QR Code</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
				@if($qrcode_image)
					<img src="{{ $qrcode_image }}" >
					<input type="hidden" id="session_id" value="{{ $session_id }}" />
					<div class="ml-3">
						<button type="button" class="btn btn-primary" id="checkStatus">Check Status</button>
						<span id="message" class="ml-2"></span>
					</div>
				@else
					<div style="color:#FF0000;">Something went wrong</div>
				@endif
            </div>
        </div>
    </div>
</div>