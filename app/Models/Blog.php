<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Blog extends Eloquent
{
    public function DisplayBlogByCustomerID($customer_id)
    {
        return self::where('customer_id', '=', $customer_id)->get();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'id', 'category_id');
    }

    public function SaveBlog($blog, $customer_id)
    {
        if ($blog['id'] == 0) {
            $blogRec = new self();
            $blogRec->category_id = $customer_id;
        } else {
            $blogRec = self::find($blog['id']);
        }
        $blogRec->title = $blog['title'];
        $blogRec->description = $blog['description'];
        $blogRec->save();
    }
}