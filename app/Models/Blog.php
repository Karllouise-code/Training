<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Blog extends Eloquent
{
    public function DisplayBlogByCustomerID($customer_id)
    {
        return self::where('customer_id', '=', $customer_id)->get();
    }

    public function DisplayBlogByID($blog_id, $customer_id)
    {
        return self::where('id', '=', $blog_id)
            ->where('customer_id', '=', $customer_id)
            ->get();
    }

    public function DeleteBlogById($blog_id, $customer_id)
    {
        $blog = self::where('id', '=', $blog_id)
            ->where('customer_id', '=', $customer_id)
            ->first();
        if ($blog) {
            $blog->delete();
        }
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }

    public function SaveBlog($blog, $customer_id)
    {
        if ($blog['id'] == '0') {
            $blogRec = new self();
            $blogRec->customer_id = $customer_id;
        } else {
            $blogRec = self::find($blog['id']);
        }
        $blogRec->title = $blog['title'];
        $blogRec->description = $blog['description'];
        $blogRec->category_id = $blog['category_id'];
        $blogRec->save();
    }
}