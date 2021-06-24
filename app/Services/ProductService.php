<?php


namespace App\Services;

use App\Repository\ProductInterface;
use Illuminate\Support\Facades\Storage;

class ProductService implements ProductInterface
{
    public function create($attributes): array
    {
        $products = $this->getProducts();

        $numberOfProducts = count($products);

        $addProduct = [
            'id' => $numberOfProducts++,
            'product_name' => $attributes["product_name"],
            'product_quantity' => $attributes["product_quantity"],
            'product_price' => $attributes["product_price"],
            'product_total' => $attributes["product_quantity"] * $attributes["product_price"],
            'created_at' => now()
        ];

        $products[] = $addProduct;

        $newProduct = json_encode($products);


        $store = $this->saveProduct($newProduct);
        $this->getProducts();

        if ($store) {
            return [
                'error' => false,
                'message' => 'Error while saving.',
            ];
        }

        return [
            'error' => false,
            'message' => 'Successfully Saved.',
            'data' => $products
        ];
    }

    public function getProducts()
    {
        $path = storage_path() . "/products.json";
        return json_decode(file_get_contents($path), true);
    }

    public function saveProduct($product)
    {
        $path = storage_path() . "/products.json";
        return file_put_contents($path, $product);
    }

}
