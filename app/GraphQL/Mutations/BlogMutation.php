<?php

namespace App\GraphQL\Mutations;

use Log;
use Str;
use Closure;
use App\Models\Customer;
use App\Models\BlogCategory;
use GraphQL\Type\Definition\Type;
use Hash;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BlogMutation extends Mutation
{
    protected $attributes = [
        'name' => 'blogMutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('responseType');
    }

    public function args(): array
    {
        return [
            'blog' => ['type' => GraphQL::type('blogInput')],
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'blog.title.required' => 'Please enter your blog title',
            'blog.description.required' => 'Please enter your blog description',
            'blog.category.required' => 'Please select your blog category ',
        ];
    }

    protected function rules(array $args = []): array
    {
        $rules = [];

        $rules['blog.title'] = ['required'];
        $rules['blog.description'] = ['required'];
        $rules['blog.category_id'] = ['required'];

        return $rules;
    }

    public function resolve($root, array $args)
    {
        $blog = $args['blog'];

        $blog_model = new Blog();
        $customer_model = new Customer();

        $customer = $customer_model->GetCustomerID();

        $blog_model->SaveBlog($blog, $customer->id);

        $response_obj = new \stdClass();
        $response_obj->error = false;
        $response_obj->message = 'Blog was succesfully saved.';

        return $response_obj;
    }
}