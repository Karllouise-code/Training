<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class CustomerInput extends InputType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'customerInput',
        'description' => 'A customer information',
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
            'password' => [
                'type' => Type::string(),
            ],
        ];
    }
}
?>