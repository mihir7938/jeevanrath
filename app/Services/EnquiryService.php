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
}
