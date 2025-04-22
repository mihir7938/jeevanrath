<?php

namespace App\Services;

use App\Models\Vendor;

class VendorService
{

    public function getAllVendors($per_page = -1)
    {
        if($per_page == -1){
            return Vendor::orderBy('created_at', 'desc')->get();    
        }
        return Vendor::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getVendorById($id)
    {
        return Vendor::find($id);
    }

    public function create($data)
    {
        return Vendor::create($data);
    }

    public function update($vendors, $data)
    {
        return $vendors->update($data);
    }

    public function delete($vendors)
    {
        return $vendors->delete($vendors);
    }
}
