<?php

namespace App\GraphQL\Mutations;

use Log;
use Hash;
use Closure;
use App\Models\Customer;
use Illuminate\Support\Str;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateProfileMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateProfileMutation',
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'customer' => ['type' => GraphQL::type('customerInput')],
        ];
    }

    public function resolve($root, array $args)
    {
        $customer = $args['customer'];
        $customer_model = new Customer();
        $customerRec = $customer_model->GetCustomerID();

        return '';
    }
}