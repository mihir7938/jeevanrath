<?php

namespace App\Services;

use App\Models\PackageGrid;

class PackageGridService
{

    public function getAllPackageGrid($per_page = -1)
    {
        if($per_page == -1){
            return PackageGrid::orderBy('created_at', 'desc')->get();    
        }
        return PackageGrid::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getPackageGridById($id)
    {
        return PackageGrid::find($id);
    }

    public function create($data)
    {
        return PackageGrid::create($data);
    }

    public function update($package_grid, $data)
    {
        return $package_grid->update($data);
    }

    public function delete($package_grid)
    {
        return $package_grid->delete($package_grid);
    }

    public function getPackagesByEnqId($enq_id)
    {
        return PackageGrid::where('enquiry_id', $enq_id)->orderBy('id', 'asc')->get();    
    }
}
