<?php

namespace App\Services;

use App\Models\Enquiry;

class EnquiryService
{

    public function getAllEnquiries($per_page = -1)
    {
        if($per_page == -1){
            return Enquiry::orderBy('created_at', 'desc')->get();    
        }
        return Enquiry::orderBy('created_at', 'desc')->paginate($per_page);
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

    public function getAllEnquiriesByStatus($status)
    {
        return Enquiry::orderBy('created_at', 'desc')->where('status', $status)->get(); 
    }

    public function getAllEnquiriesByFilter($request)
    {
        $query = Enquiry::orderBy('created_at', 'desc');
        if($request->has('status') && $request->status != ''){
            $query = $query->where('status', $request->status);
        }
        if($request->start_date && $request->end_date){
            $startDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $endDate = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
            $query = $query->whereBetween('journey_date', [$startDate, $endDate]);
        }
        return $query->select('*')->get();
    }
}
