<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{

    public function getAllCategories($per_page = -1)
    {
        if($per_page == -1){
            return Category::orderBy('created_at', 'desc')->get();    
        }
        return Category::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getCategoryById($id)
    {
        return Category::find($id);
    }

    public function create($data)
    {
        return Category::create($data);
    }

    public function update($categories, $data)
    {
        return $categories->update($data);
    }

    public function delete($categories)
    {
        return $categories->delete($categories);
    }
}
