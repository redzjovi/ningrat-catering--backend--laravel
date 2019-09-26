<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ProductTrait
{
    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|object $product
     */
    public static function createProduct($attributes)
    {
        $product = self::create($attributes);
        $product = self::updateProductSetSlugWhereProduct($product);
        $product = $product->fresh();

        return $product;
    }

    /**
     * @param int $id
     * @return int
     */
    public static function deleteProductWhereId($id)
    {
        return self::destroy($id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|object
     */
    public static function getProductOrFailWhereId($id)
    {
        return self::findOrFail($id);
    }

    /**
     * @param \Illuminate\Http\Request $productRequest
     * @return \Illuminate\Database\Collection $products
     */
    public static function getProductsPaginateWhereData($data)
    {
        $data = collect($data)->filter(function ($value) {
            return $value != '';
        });
        $query = self::query();

        if ($data->has('id')) {
            $query = $query->where('id', $data['id']);
        }

        if ($data->has('slug')) {
            $query = $query->where('slug', $data['slug']);
        }

        if ($data->has('name')) {
            $query = $query->where('name', 'like', '%'.$data['name'].'%');
        }

        if ($data->has('sell_price_gte')) {
            $query = $query->where('sell_price', '>=', $data['sell_price_gte']);
        }

        if ($data->has('sell_price_lte')) {
            $query = $query->where('sell_price', '<=', $data['sell_price_lte']);
        }

        if ($data->has('active')) {
            $query = $query->where('active', $data['active']);
        }

        if ($data->has('order_by')) {
            $query = $query->orderBy(
                Str::replaceFirst('-', '', $data['order_by']),
                Str::contains($data['order_by'], '-') ? 'desc' : 'asc'
            );
        }

        if ($data->has('per_page')) {
            $products = $query->paginate((int) $data['per_page']);
        } else {
            $products = $query->paginate();
        }

        return $products;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|object $product
     * @return \Illuminate\Database\Eloquent\Model|object $product
     */
    public static function updateProductSetSlugWhereProduct($product)
    {
        $product->slug = Str::slug($product->name).'-'.$product->id;
        $product->save();

        return $product;
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|object $product
     */
    public static function updateProductOrFailWhereId($id, $attributes)
    {
        $product = self::findOrFail($id);
        $product->fill($attributes);
        $product->save();
        $product = self::updateProductSetSlugWhereProduct($product);

        return $product;
    }
}
