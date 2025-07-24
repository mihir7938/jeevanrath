<?php

namespace App\Services;

use App\Models\Charge;

class ChargeService
{

    public function getAllCharges($per_page = -1)
    {
        if($per_page == -1){
            return Charge::orderBy('created_at', 'asc')->get();    
        }
        return Charge::orderBy('created_at', 'asc')->paginate($per_page);
    }

    public function getChargeById($id)
    {
        return Charge::find($id);
    }

    public function create($data)
    {
        return Charge::create($data);
    }

    public function update($charges, $data)
    {
        return $charges->update($data);
    }

    public function delete($charges)
    {
        return $charges->delete($charges);
    }
}
