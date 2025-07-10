<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h4>New Enquiry Submission:</h4>
    <p>
        <strong>Booking ID: </strong> {{ $result['booking_id'] }}<br>
        <strong>User Type: </strong> {{ $result['user_type'] }}<br>
        <strong>Company Name: </strong> {{ $result['company_name'] }}<br>
        @if($result['user_type'] == 'Company')
            <strong>Guest Name: </strong> {{ $result['name'] }}<br>
            <strong>Guest Mobile Number: </strong> {{ $result['mobile_number'] }}<br>
            <strong>Booker Name: </strong> {{ $result['booker_name'] }}<br>
            <strong>Booker Mobile Number: </strong> {{ $result['booker_mobile'] }}<br>
        @else
            <strong>Name: </strong> {{ $result['name'] }}<br>
            <strong>Mobile Number: </strong> {{ $result['mobile_number'] }}<br>
        @endif
        <strong>Journey Date: </strong> {{ $result['journey_date'] }}<br>
        <strong>End Journey Date: </strong> {{ $result['end_journey_date'] }}<br>
        <strong>Pickup From: </strong> {{ $result['pickup_from'] }}<br>
        <strong>Drop To: </strong> {{ $result['drop_to'] }}<br>
        <strong>Vehicle: </strong> {{ $result['vehicle_name'] }}<br>
        <strong>Journey Type: </strong> {{ $result['journey_type'] }}<br>
        <strong>Pickup Time: </strong> {{ $result['pickup_time'] }}
    </p>
</body>