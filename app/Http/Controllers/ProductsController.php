<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{

    public function index()
    {
        //get all records from DB
        $products = Product::all();
        return response()->json($products);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required'
        ]);

        $product = new Product();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $allowFileExt = ['png','jpg','jpeg'];
            $fileExtension = $file->getClientOriginalExtension();
            $check = in_array($fileExtension, $allowFileExt);

            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->image = $name;
            }else{
                return response()->json("error - only allow image file extension of ". implode(', ', $allowFileExt));
            }
        }

        try{
            $product->title = $request->input('title');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            if($product->save()){
                return response()->json($product);
            }
        }catch(\Expection $e){
            return response()->json(['status'=>'Error', 'message'=>$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try{
            $product = Product::findOrFail($id);
            return response()->json($product);  
            //$product['status'] = "success"; 
            return dd($product);
        }catch(\Exception $e){
            return response()->json(['status'=> 'Error', 'message'=>$e->getMessage()]);
        }   
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required'
        ]);

        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $allowFileExt = ['png','jpg','jpeg'];
            $fileExtension = $file->getClientOriginalExtension();
            $check = in_array($fileExtension, $allowFileExt);

            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->image = $name;
            }else{
                return response()->json("error - only allow image file extension of ". implode(', ', $allowFileExt));
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return response()->json($product);
    }

    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id);
            if($product->delete($id)){
                return response()->json(['status'=>'Success', 'message'=>'Product deleted successfully']);
            }else{
                return response()->json(['status'=>'Error', 'message'=>'Delete unsuccessful']);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>'Error', 'message'=>$e->getMessage()]);
        }
        
        $product->delete($id);
        
    }
}
