<?php

namespace App\Services;

use App\Models\PackageCategory;

class PackageCategoryService
{

    public function getAllPackageCategories($per_page = -1)
    {
        if($per_page == -1){
            return PackageCategory::orderBy('created_at', 'desc')->get();    
        }
        return PackageCategory::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getPackageCategoryById($id)
    {
        return PackageCategory::find($id);
    }

    public function create($data)
    {
        return PackageCategory::create($data);
    }

    public function update($package_categories, $data)
    {
        return $package_categories->update($data);
    }

    public function delete($package_categories)
    {
        return $package_categories->delete($package_categories);
    }
}
