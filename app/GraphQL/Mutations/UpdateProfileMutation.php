<?php

namespace App\GraphQL\Mutations;

use Log;
use Hash;
use Closure;
use App\Models\Helper;
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
            'file' => ['type' => GraphQL::type('Upload')],
            'customer' => ['type' => GraphQL::type('customerInput')],
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'customer.firstname.required' => 'Please enter your first name',
            'customer.lastname.required' => 'Please enter your last name',
            'customer.email.required' => 'Please select your email address ',
            'customer.email.email' => 'Please enter your valid email address ',
        ];
    }

    protected function rules(array $args = []): array
    {
        $rules = [];

        $rules['customer.firstname'] = ['required'];
        $rules['customer.lastname'] = ['required'];
        $rules['customer.email'] = ['required', 'email'];

        return $rules;
    }

    public function resolve($root, array $args)
    {
        $customer = $args['customer'];
        $customer_model = new Customer();
        $customerRec = $customer_model->GetCustomerID();

        $customer_model = $customer_model->UpdateProfile(
            $customerRec->customer_id,
            $customer
        );

        if ($args['file'] != null) {
            //upload image
            $helper_model = new Helper();
            $filename = $helper_model->ImageUpload(
                $args['file'],
                $customerRec->customer_id,
                'customer'
            );
            $customer_model = $customer_model->UpdateProfileImage(
                $customerRec->customer_id,
                $filename
            );
        }

        return '';
    }
}