<?php

namespace App\Http\Controllers;

use App\Repository\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $productRepo;

    public function __construct(ProductInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $products = $this->productRepo->getProducts();
        return view("welcome", compact("products"));
    }

    public function create(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'product_quantity' => 'required|integer',
            'product_price' => 'required|integer'
        ]);

        $response = $this->productRepo->create($request->all());
        if ($response['error']) {
            return redirect()->back()->with('error', $response['message']);
        }else{
            return redirect()->route("welcome");
        }
    }

}
