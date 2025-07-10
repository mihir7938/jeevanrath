<?php

namespace App\Services;

use App\Models\Package;

class PackageService
{

    public function getAllPackages($per_page = -1)
    {
        if($per_page == -1){
            return Package::orderBy('created_at', 'desc')->get();    
        }
        return Package::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getPackageById($id)
    {
        return Package::find($id);
    }

    public function create($data)
    {
        return Package::create($data);
    }

    public function update($package, $data)
    {
        return $package->update($data);
    }

    public function delete($package)
    {
        return $package->delete($package);
    }

    public function getPackagesByCategory($category_id){
        return Package::where('category_id', $category_id)->get();
    }

    public function getAllPackagesOrderByName()
    {
        return Package::orderBy('name', 'asc')->get();
    }
}
