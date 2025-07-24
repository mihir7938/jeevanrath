<?php

namespace App\Services;

use App\Models\AssignPackage;

class AssignPackageService
{

    public function getAllAssignPackages($per_page = -1)
    {
        if($per_page == -1){
            return AssignPackage::orderBy('created_at', 'desc')->get();    
        }
        return AssignPackage::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getAssignPackageById($id)
    {
        return AssignPackage::find($id);
    }

    public function create($data)
    {
        return AssignPackage::create($data);
    }

    public function update($assign_package, $data)
    {
        return $assign_package->update($data);
    }

    public function delete($assign_package)
    {
        return $assign_package->delete($assign_package);
    }

    public function getAssignPackagesByCompany($company_id)
    {
        return AssignPackage::where('company_id', $company_id)->get();
    }

    public function getAssignPackageByCompany($company_id, $package_id)
    {
        return AssignPackage::where('company_id', $company_id)->where('package_id', $package_id)->first();
    }
}
