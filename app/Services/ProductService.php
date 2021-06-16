<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    public static function getByCode($code)
    {
        return Product::where('code', $code)
            ->with(['images', 'category'])
            ->first();
    }

    public function getById($id)
    {
        return Product::where('id', $id)
            ->with(['images', 'category'])
            ->first();
    }

    public function getWithDeletedById($id)
    {
        return Product::withTrashed()->where('id', $id)
            ->with(['images', 'category'])
            ->first();
    }

    public function search($query, int $limit = 0)
    {
        $words = preg_split('/ +?/', trim($query));

        $result = Product::where(function ($query) use ($words) {
            foreach ($words as $string) {
                $query->where('name', 'LIKE', '%' . $string . '%');
            }
        });

        if ($limit) {
            $result->limit($limit);
        }

        return $result->get();
    }

    public function searchWithDeleted($query, int $limit = 0)
    {
        $words = preg_split('/ +?/', trim($query));

        $result = Product::withTrashed()
            ->where(function ($query) use ($words) {
                foreach ($words as $string) {
                    $query->where('name', 'LIKE', '%' . $string . '%');
                }
            });

        if ($limit) {
            $result->limit($limit);
        }

        return $result->get();
    }

    public function addImage($id, $image) 
    {

    }

}
