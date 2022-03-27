<?php

namespace App\GraphQL\Types;

use App\Models\BlogCategory;
use App\Models\Blog;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BlogType extends GraphQLType
{
    protected $attributes = [
        'name' => 'blogType',
        'description' => 'A blog type information',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::string(),
            ],
            'title' => [
                'type' => Type::string(),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'customer_id' => [
                'type' => Type::string(),
            ],
            'category_id' => [
                'type' => Type::string(),
            ],
            'category' => [
                'type' => GraphQL::type('categoryType'),
            ],
        ];
    }
}
?>