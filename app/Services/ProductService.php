<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        $photo = Image::make($image)->encode('jpg', 100);

        $name = time() . '_' . md5($photo->__toString()) . '.jpg';

        $preview = Image::make($image)
        ->resize(null, 300, function ($constraint) { $constraint->aspectRatio(); } )
        ->encode('jpg',100);

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
        if($img->is_main) {
            if($new_main = ProductImage::where('product_id', '=', $img->product_id)->where('is_main', '=', 0)->first()) {
                $new_main->is_main = 1;
                $new_main->update();
            }
        }
        $img->delete();
    }

    
}
