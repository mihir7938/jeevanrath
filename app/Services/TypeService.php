<?php

namespace App\Services;

use App\Models\Type;

class TypeService
{

    public function getAllTypes($per_page = -1)
    {
        if($per_page == -1){
            return Type::orderBy('created_at', 'desc')->get();    
        }
        return Type::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getTypeById($id)
    {
        return Type::find($id);
    }

    public function create($data)
    {
        return Type::create($data);
    }

    public function update($types, $data)
    {
        return $types->update($data);
    }

    public function delete($types)
    {
        return $types->delete($types);
    }
}
