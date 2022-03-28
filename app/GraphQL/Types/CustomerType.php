<?php

namespace App\GraphQL\Types;

use App\Models\BlogCategory;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CustomerType extends GraphQLType
{
    protected $attributes = [
        'name' => 'customerType',
        'description' => 'A customer type information',
    ];

    public function fields(): array
    {
        return [
            'firstname' => [
                'type' => Type::string(),
            ],
            'lastname' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
            ],
        ];
    }
}
?>