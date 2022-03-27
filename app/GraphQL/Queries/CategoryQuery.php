<?php
namespace App\GraphQL\Queries;

use Log;
use GraphQL;
use App\Models\BlogCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use App\Models\Customer;

class CategoryQuery extends Query
{
    protected $attributes = [
        'name' => 'category query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('categoryType'));
    }

    public function args(): array
    {
        return [
            'category_id' => ['type' => Type::String()],
            'delete_category_id' => ['type' => Type::String()],
        ];
    }

    public function resolve($root, $args)
    {
        $blog_category_model = new BlogCategory();
        $customer_model = new Customer();
        $customer = $customer_model->GetCustomerID();

        if (isset($args['category_id'])) {
            $blog_category = $blog_category_model->DisplaySingleCategory(
                $args['category_id'],
                $customer->id
            );
            return $blog_category;
        }

        if (isset($args['delete_category_id'])) {
            $blog_category_model->DeleteCategory(
                $args['delete_category_id'],
                $customer->id
            );
        }

        $blog_category = $blog_category_model->DisplayCategoryByCustomerID(
            $customer->id
        );
        return $blog_category;
    }
}
?>