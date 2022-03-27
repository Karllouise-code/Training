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

class SaveCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'SaveCategoryMutation',
    ];

    public function type(): Type
    {
        return GraphQL::type('responseType');
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'name.required' => 'Please enter your category name',
        ];
    }

    protected function rules(array $args = []): array
    {
        $rules = [];
        $rules['name'] = ['required'];

        return $rules;
    }

    public function args(): array
    {
        return [
            'name' => ['type' => Type::String()],
            'id' => ['type' => Type::String()],
        ];
    }

    public function resolve($root, array $args)
    {
        $name = $args['name'];
        $category_id = $args['id'];
        $blog_category_model = new BlogCategory();
        $customer_model = new Customer();

        $customer = $customer_model->GetCustomerID();

        //check if category name exist
        $category = $blog_category_model->CheckCategoryName(
            $category_id,
            $name,
            $customer->id
        );
        $response_obj = new \stdClass();
        if ($category) {
            //return an error message that category name already name in used
            $response_obj->error = true;
            $response_obj->message = 'Category name already exist.';
        } else {
            //save category name
            $blog_category_model->SaveCategory(
                $category_id,
                $name,
                $customer->id
            );
            //return a success message
            $response_obj->error = false;
            $response_obj->message = 'Category was succesfully saved.';
        }
        return $response_obj;
    }
}