<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class BlogInput extends InputType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'blogInput',
        'description' => 'A blog information',
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
            'category_id' => [
                'type' => Type::string(),
            ],
        ];
    }
}
?>