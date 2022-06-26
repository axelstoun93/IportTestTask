<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Presenters\ApiProduct;
use Illuminate\Http\Request;


class ProductController extends Controller
{

    public function index(Request $request){

        $filterParams =  json_decode($request->filter);

        $products = Product::getProducts($filterParams)->paginate(20);

        $products->present(ApiProduct::class);

        try{
            return (new ProductResource($products));
        }catch (\Exception $exception){
            return response()->json(['message' => 'Ошибка при загрузке списка'], 500);
        }

    }

}
