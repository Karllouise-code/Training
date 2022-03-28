<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class BlogCategory extends Eloquent
{
    public function DisplayCategoryByCustomerID($customer_id)
    {
        return self::where('customer_id', '=', $customer_id)->get();
    }

    public function CheckCategoryName($category_id, $name, $customer_id)
    {
        $category_rec = self::where('name', '=', $name)->where(
            'customer_id',
            '=',
            $customer_id
        );
        if ($category_id > 0) {
            $category_rec->where('id', '!=', $category_id);
        }
        $category = $category_rec->first();
        return $category;
    }

    function SaveCategory($type, $name, $customer_id)
    {
        if ($type == 0) {
            $category = new self();
            $category->customer_id = $customer_id;
        } else {
            $category = self::find($type);
        }
        $category->name = $name;
        $category->save();
    }

    public function DisplaySingleCategory($category_id, $customer_id)
    {
        $category = self::where('id', '=', $category_id)
            ->where('customer_id', '=', $customer_id)
            ->get();
        return $category;
    }

    public function DeleteCategory($category_id, $customer_id)
    {
        $category = self::where('id', '=', $category_id)
            ->where('customer_id', '=', $customer_id)
            ->first();
        if ($category) {
            $category->delete();
        }
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'id', 'category_id');
    }
}