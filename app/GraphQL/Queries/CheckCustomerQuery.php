<?php
namespace App\GraphQL\Queries;

use Log;
use GraphQL;
use App\Models\BlogCategory;
use App\Models\Customer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class CheckCustomerQuery extends Query
{
    protected $attributes = [
        'name' => 'CheckCustomerQuery query',
    ];

    public function type(): Type
    {
        return Type::string('');
    }

    public function resolve($root, $args)
    {
        return '';
    }
}
?>