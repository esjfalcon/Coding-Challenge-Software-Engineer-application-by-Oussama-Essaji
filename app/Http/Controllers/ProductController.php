<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("test");
        $products = Product::all();
        $categories = Category::get();
        // dd($products);
        return view('welcome', ['products' => $products, 'categories'=> $categories]);
    }


    public function getpost(Request $request)
    {
        $products=Product::where('category_id',$request->category_id)->get();
        return response()->json([
            'product'=>$products
        ]);
         
    }


    public function search(Request $request)
    {
        if ($request->keywords && $request->price<20000) {
            $products=Product::where('name', 'like','%'.$request->keywords.'%')->where('price', '<=',$request->price)->get();
            return response()->json($products);
        }
        if (!$request->keywords && $request->price<20000) {
            $products=Product::where('price', '<=',$request->price)->get();
            return response()->json($products);
        }
        $products=Product::where('name', 'like','%'.$request->keywords.'%')->get();
        return response()->json($products);
        
         
    }

    public function addproduct(){
        $categories = Category::get();
        return view('addproduct', ['categories'=> $categories]);
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreProductRequest $request)
    {
        // dd($request->input());
        $file = $request->file('image');
        $extension = $file->extension();
        $name = uniqid().'.'.$extension;

        Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'image' => $name,
            'price' => $request['price'],
            'category_id' => $request['category_id'],
        ]);
        $file->move('images',$name);

        return redirect('/add-product')->with(['message' => "Product created successfuly!"]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
