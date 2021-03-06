<?php

namespace App\GraphQL\Types;

use App\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Category',
        'description'   => 'Details about a Category',
        'model'         => Category::class
    ];

    public function fields() : array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the category',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the category',
            ],
            'merchant_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Merchant Id',
            ],
            'status' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Availability of the category',
            ]
        ];
    }
}