<?php

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Customer;
use App\Models\Helper;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Str;
use Hash;
use Auth;

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
        // this is the name of the variable -> customer
        return [
            'file' => ['type' => GraphQL::type('Upload')],
            'customer' => ['type' => GraphQL::type('customerInput')],
        ];
    }
    // validation error message
    public function validationErrorMessages(array $args = []): array
    {
        return [
            'customer.firstname.required' => 'Please enter your firstname',
            'customer.lastname.required' => 'Please enter your lastname',
            'customer.email.required' => 'Please enter your email',
            'customer.email.email' => 'Please enter your valid email address',
        ];
    }

    // for requiring inputs
    protected function rules(array $args = []): array
    {
        $rules = [];

        $rules['customer.firstname'] = ['required'];
        $rules['customer.lastname'] = ['required'];
        $rules['customer.email'] = ['required', 'email'];

        return $rules;
    }

    public function resolve($root, $args)
    {
        $customer = $args['customer'];
        $file = $args['file'];
        $customer_model = new Customer();
        $customerRec = $customer_model->GetCustomerID();

        $customer_model->UpdateProfile($customerRec->id, $customer);

        if ($file != null) {
            //upload the image
            $helper_model = new Helper();
            $filename = $helper_model->ImageUpload($args['file'], $customerRec->id, 'customer');
            $customer_model = $customer_model->UpdateProfileImage($customerRec->id, $filename);
        }
        return '';
    }
}

?>