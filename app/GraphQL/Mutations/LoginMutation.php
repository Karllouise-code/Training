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

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LoginMutation',
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'customer.email.required' => 'Please enter your email address',
            'customer.password.required' => 'Please enter your password',
            'customer.email.email' => 'Please enter your valid email address',
        ];
    }

    protected function rules(array $args = []): array
    {
        $rules = [];

        $rules['customer.email'] = ['required', 'email'];
        $rules['customer.password'] = ['required'];

        return $rules;
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
        $email = $customer['email'];
        $password = $customer['password'];
        $guard = 'customerweb';

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::guard($guard)->attempt($credentials)) {
            $customer_id = Auth::guard($guard)->user()->id;
            $new_token = Str::random(60);
            $customer = Customer::find($customer_id);
            if ($customer) {
                $customer->api_token = $new_token;
                $customer->save();
            }
            Auth::guard($guard)->user()->api_token = $new_token;
            return $new_token;
        }

        return '';
    }
}