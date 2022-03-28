<?php
namespace App\GraphQL\Queries;

use Log;
use GraphQL;
use App\Models\BlogCategory;
use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\Models\Customer;

class CustomerQuery extends Query
{
    protected $attributes = [
        'name' => 'customer query',
    ];

    public function type(): Type
    {
        return GraphQL::type('customerType');
    }

    public function args(): array
    {
        return [
            'customer_id' => ['type' => Type::String()],
        ];
    }

    public function resolve($root, $args)
    {
        $customer_model = new Customer();
        $customer = $customer_model->GetCustomerID();
        Log::debug(print_r($customer, true));
        return $customer;
    }
}
?>