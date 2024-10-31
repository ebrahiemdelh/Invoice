<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProduct;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id')->get();
        $sections = Section::all();
        return view('products.products', compact(['products', 'sections']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProduct $request)
    {
        $id = $request->id;
        $validated = $request->validated();
        DB::table('products')->insert([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);
        session()->flash('Add', 'تمت إضافة المنتج');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $validate = $request->validate([
            'product_name' => 'required|max:255|unique:products,product_name,' . $id,
            'section_id' => 'required',
            'description' => 'required'
        ], [
            'product_name.required' => 'يجب إدخال اسم المنتج',
            'product_name.unique' => 'هذا المنتج مسجل بالفعل',
            'section_id.unique' => 'هذا القسم مسجل بالفعل',
            'description.required' => 'تفاصيل القسم مطلوبة'
        ]);
        $data = Product::find($id);
        $data->update([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description
        ]);
        session()->flash('Edit', 'تم تعديل بيانات القسم بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Product::find($id)->delete();
        session()->flash('Delete', 'تم حذف البيانات بنجاح');
        return redirect('/products');
    }
}
