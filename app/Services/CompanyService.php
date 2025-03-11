<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{

    public function getAllCompanies($per_page = -1)
    {
        if($per_page == -1){
            return Company::orderBy('created_at', 'desc')->get();    
        }
        return Company::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getCompanyById($id)
    {
        return Company::find($id);
    }

    public function create($data)
    {
        return Company::create($data);
    }

    public function update($companies, $data)
    {
        return $companies->update($data);
    }

    public function delete($companies)
    {
        return $companies->delete($companies);
    }
}
