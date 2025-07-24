<?php

namespace App\Services;

use App\Models\Enquiry;

class EnquiryService
{

    public function getAllEnquiries($per_page = -1)
    {
        if($per_page == -1){
            return Enquiry::orderBy('created_at', 'desc')->where('duty_closed', 0)->get();    
        }
        return Enquiry::orderBy('created_at', 'desc')->where('duty_closed', 0)->paginate($per_page);
    }

    public function getEnquiryById($id)
    {
        return Enquiry::find($id);
    }

    public function create($data)
    {
        return Enquiry::create($data);
    }

    public function update($enquiries, $data)
    {
        return $enquiries->update($data);
    }

    public function delete($enquiries)
    {
        return $enquiries->delete($enquiries);
    }

    public function getAllEnquiriesByStatus($status, $duty_closed = '', $journey_type = '')
    {
        $query = Enquiry::orderBy('created_at', 'desc')->whereIn('status', $status);
        if ($duty_closed !== '') {
            $query = $query->where('duty_closed', $duty_closed);
        }
        if ($journey_type == 'oncall') {
            $query = $query->whereColumn('journey_date','end_journey_date');
        }
        return $query->select('*')->get();
    }

    public function getAllEnquiriesByFilter($request)
    {
        $query = Enquiry::where('duty_closed', 0)->orderBy('created_at', 'desc');
        if($request->has('status') && $request->status != '' && isset($request->status[0])){
            $query = $query->whereIn('status', $request->status);
        }
        if($request->has('booking_id') && $request->booking_id != ''){
            $query = $query->where('booking_id', $request->booking_id);
        }
        if($request->start_date && $request->end_date){
            $startDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
            $query = $query->whereBetween('journey_date', [$startDate, $endDate]);
        }
        return $query->select('*')->get();
    }

    public function getAllDutiesByFilter($request, $status)
    {
        $query = Enquiry::orderBy('created_at', 'desc')->whereIn('status', $status)->whereColumn('journey_date','end_journey_date');
        if($request->has('duty_status') && $request->duty_status != ''){
            $query = $query->where('duty_closed', $request->duty_status);
        }
        if($request->has('booking_id') && $request->booking_id != ''){
            $query = $query->where('booking_id', $request->booking_id);
        }
        if($request->start_date && $request->end_date){
            $startDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
            $query = $query->whereBetween('journey_date', [$startDate, $endDate]);
        }
        return $query->select('*')->get();
    }

    public function getBookingId($mobile)
    {
        $booking_id = substr($mobile, -5).rand(10000,99999);
        $check_booking_id_exists = Enquiry::where('booking_id', $booking_id)->exists();
        if($check_booking_id_exists) {
            $booking_id = substr($mobile, -5).rand(10000,99999);
        }
        return $booking_id;
    }

    public function assignedBookingsToDriver($driver_id, $duty_closed)
    {
        return Enquiry::orderBy('created_at', 'desc')->where('driver_id', $driver_id)->where('status', 3)->where('duty_closed', $duty_closed)->get(); 
    }

    public function assignedBookingsToVendor($vendor_id, $duty_closed)
    {
        return Enquiry::orderBy('created_at', 'desc')->where('vendor_id', $vendor_id)->where('status', 3)->where('duty_closed', $duty_closed)->get(); 
    }

    public function getEnquiryByBookingId($booking_id)
    {
        return Enquiry::where('booking_id', $booking_id)->where('status', 3)->first(); 
    }

    public function getClosedDutyData()
    {
        return Enquiry::orderBy('created_at', 'desc')->where('duty_closed', 1)->get(); 
    }

    public function getClosedDutyById($id)
    {
        return Enquiry::where('id', $id)->where('duty_closed', 1)->first(); 
    }

    public function getTripConfirmedById($id)
    {
        return Enquiry::where('id', $id)->whereColumn('journey_date', 'end_journey_date')->where('status', 3)->first(); 
    }

    public function getTotalEnquiries()
    {
        return Enquiry::where('duty_closed', 0)->count(); 
    }

    public function getTotalInquiriesByStatus($status_id)
    {
        return Enquiry::where('status', $status_id)->where('duty_closed', 0)->count();
    }

    public function getTotalDuties()
    {
        return Enquiry::where('status', 3)->whereColumn('journey_date', 'end_journey_date')->count(); 
    }

    public function getTotalDutiesByStatus($duty_status_id)
    {
        return Enquiry::where('status', 3)->where('duty_closed', $duty_status_id)->whereColumn('journey_date', 'end_journey_date')->count();
    }

    public function getMonthlyPackags()
    {
        return Enquiry::orderBy('created_at', 'desc')->whereColumn('journey_date', '!=', 'end_journey_date')->where('status', 3)->get(); 
    }
    public function getMonthlyPackageById($id)
    {
        return Enquiry::where('id', $id)->whereColumn('journey_date', '!=', 'end_journey_date')->where('status', 3)->first(); 
    }
}
