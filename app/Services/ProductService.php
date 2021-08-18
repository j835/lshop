<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductService
{
    public function getMainPageProducts()
    {
        return cache()->remember('%mainpage_products', 60 * 60 * 24, function() {
            return Product::inRandomOrder()->with(['category', 'main_image'])->limit(20)->get();
        });
    }

    public function getByCode($code, $include_deleted = false)
    {
        if($include_deleted) {
            $product = Product::where('code', $code);
        } else {
            $product = Product::withTrashed()->where('code', $code);
        }

        return $product->with(['images', 'category', 'stores'])->first();
    }

    public function getById($id, $include_deleted = false)
    {
        if($include_deleted) {
            $product = Product::where('id', $id);
        } else {
            $product = Product::withTrashed()->where('id', $id);
        }

        return $product->with(['images', 'category', 'stores'])->first();
    }

    public function search($query, bool $include_deleted = false, int $limit = 0)
    {
        if(!trim($query)) {
            return [];
        }

        $words = preg_split('/ +?/', trim($query));
        $result = Product::with(['category', 'main_image']);

        $result->where(function ($query) use ($words) {
            foreach ($words as $string) {
                $query->where('name', 'LIKE', '%' . $string . '%');
            }
        });

        $include_deleted ? $result->withTrashed() : false;
        $limit ? $result->limit($limit) : false;

        return $result->get();
    }

    public function addImage($id, $image)
    {
        $photo = Image::make($image)->encode('jpg', 100);

        $name = time() . '_' . md5($photo->__toString()) . '.jpg';

        $preview = Image::make($image)
            ->resize(null, 300, function ($constraint) {$constraint->aspectRatio();})
            ->encode('jpg', 100);

        Storage::put(config('storage.product_img') . $name, $photo->__toString());
        Storage::put(config('storage.product_img_prevew') . $name, $preview->__toString());

        $is_main = ProductImage::where('product_id', '=', $id)->count() ? 0 : 1;

        $image = new ProductImage([
            'path' => $name,
            'product_id' => $id,
            'is_main' => $is_main,
        ]);

        $image->save();
    }

    public function deleteImage($img_id)
    {
        $img = ProductImage::find($img_id);
        $path = $img->path;
        Storage::delete([config('storage.product_img') . $path, config('storage.product_img_prevew') . $path]);
        if ($img->is_main) {
            if ($new_main = ProductImage::where('product_id', $img->product_id)->where('is_main', '=', 0)->first()) {
                $new_main->is_main = 1;
                $new_main->update();
            }
        }
        $img->delete();
    }

    public function updateQuantity($id) 
    {
        $quantity = 0;
        $product = Product::with('stores')->find($id);

        foreach($product->stores as $store) 
        {
            $quantity += $store->getQuantity();
        }

        $product->update(['quantity' => $quantity]);

    }
    
    public function updateAllProductsQuantity() 
    {
        $products = Product::withTrashed()->with('stores')->get();

        foreach($products as $product) 
        {
            $quantity = 0;
            foreach($product->stores as $store) 
            {
                $quantity += $store->getQuantity();
            }

            $product->update(['quantity' => $quantity]);
        }
    }

}
