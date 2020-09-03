<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
class ApiController extends Controller
{
    // get all products
    public function getAllProducts(){
        $products = Products::get()->toJson(JSON_PRETTY_PRINT);
        return response($products,200);

    }


    // create a new product
    public function createProduct(Request $request){
        $product = new Products;
        $product->name = $request->name;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->save();

        return response()->json([
            "message"=>"product record created"
        ], 201);

    }

    // get single product
    public function getProduct($id){
        if ( Products::where('id', $id)->exists() ){
            $product = Products::where('id',$id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($product,200);

        }else{

            return response()->json([
                "message"=> "Product not found"
            ],404);
        }    

    }
    

    // update a product
    public function updateProduct(Request $request, $id){
        if (Products::where('id',$id)->exists() ) {
            $product = Products::find($id);
            $product->name = is_null($request->name)? $product->name: $request->name;
            //NOTE: The format for the ternary operator is condition ? true : false
            $product->qty = is_null($request->qty)?$product->qty: $request->qty; 
            $product->price = is_null($request->price)? $product->price: $request->price;
            $product->save();

            return response()->json([
                "message"=>"records updated successfully"
            ],200);

        }else{
            return response()->json([
                "message"=>"Product not found"
            ],404);
        }
    }

    // Delete product
    public function deleteProduct($id){
        if (Products::where('id',$id)->exists() ) {
            $product = Products::find($id);
            $product->delete();

            return response()->json([
                "message"=>"record deleted"
            ],200);

        }else{

            return respons()->json([
                "message"=>"product not found"
            ],404);
            
        }
    }



}
