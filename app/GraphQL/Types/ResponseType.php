<?php

namespace App\GraphQL\Types;

use App\Models\BlogCategory;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'responseType',
        'description' => 'A response type information',
    ];

    public function fields(): array
    {
        return [
            'error' => [
                'type' => Type::boolean(),
            ],
            'message' => [
                'type' => Type::string(),
            ],
        ];
    }
}
?>