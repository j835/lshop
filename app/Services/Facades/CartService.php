<?php


namespace App\Services\Facades;

use App\Models\Product;

class CartService
{

    private const ERR_WRONG_ID = 'Неправильный id товара';
    private const ERR_ALREADY_IN_CART = 'Товар уже есть в козрине';
    private const ERR_NOT_IN_CART = 'Товар отсутствует в корзине';
    private const ERR_WRONG_QUANTITY = 'Неверное количество товара';

    const SESSION_KEY = 'CART';


    public function __construct() {
    }

    private function update($session)
    {
        session()->put(self::SESSION_KEY, $session);
    }


    public function getSession() {
        $session = session()->get(self::SESSION_KEY);
        return is_array($session) ? $session : [];
    }


    public function getFullInfo()
    {
        $session = $this->getSession();
        $products = Product::whereIn('id', array_keys($session))->with('main_image', 'category')->get();
        $cart = [];

        foreach ($products as $item) {
            $cart[] = (object)[
                'id' => $item->id,
                'name' => $item->name,
                'preview_path' => $item->getMainImagePreview(),
                'price' => $item->getActualPrice(),
                'quantity' => $session[$item->id],
                'total' => $item->getActualPrice() * $session[$item->id],
                'path' => '/' . config('catalog.path') . '/' . $item->category->full_code .'/' . $item->code . '/',

            ];
        }

        return $cart;
    }


    public function push(int $product_id, int $quantity)
    {
        $session = $this->getSession();

        if (isset($session[$product_id])) {
            throw new \Exception(self::ERR_ALREADY_IN_CART);
        }

        if (!Product::find($product_id)) {
            throw new \Exception(self::ERR_WRONG_ID);
        }

        if($quantity < 1) {
            throw new \Exception(self::ERR_WRONG_QUANTITY);
        }

        $session[$product_id] = $quantity;
        $this->update($session);
        return true;
    }


    public function delete(int $product_id)
    {
        $session = $this->getSession();

        if (!isset($session[$product_id])) {
            throw new \Exception(self::ERR_NOT_IN_CART);
        }

        unset($session[$product_id]);
        $this->update($session);

        return true;
    }

    public function emptyCart() {
        session()->forget(self::SESSION_KEY);
    }

    public function getTotal() {
        $cart = $this->getFullInfo();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item->total;
        }

        return $total;
    }

}
