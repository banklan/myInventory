<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminTablesController extends Controller
{
    public function AdminGetCategs(){
        $categs = ProductCategory::orderBy('id', 'asc')->get();

        return response()->json($categs, 200);
    }

    public function AdminCreateCateg(Request $request)
    {
        $this->validate($request, [
            'categ' => 'required|min:3|max:30'
        ]);

        $categ = new ProductCategory;
        $categ->name = $request->categ;
        $categ->save();

        return response()->json($categ, 200);
    }

    public function AdminUpdateCateg(Request $request, $id)
    {
        $this->validate($request, [
            'categ' => 'required|min:3|max:30'
        ]);

        $categ = ProductCategory::findOrFail($id);
        $categ->update([
            $categ->name = $request->categ
        ]);

        return response()->json($categ, 200);
    }

    public function AdminDelCateg($id)
    {
        $cat = ProductCategory::findOrFail($id);
        $cat->delete();

        return response()->json(['message' => 'Category deleted!'], 200);
    }

    public function AdminGetProducts()
    {
        $products = Product::orderBy('id', 'asc')->get();

        return response()->json($products, 200);
    }

    public function AdminCreateProduct(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:60',
            'cat' => 'required|numeric',
            'cost' => 'required|numeric|between:1,100000000000',
            'selling' => 'required|numeric|between:1,100000000000',
            'size' => 'required',
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->product_category_id = intval($request->cat);
        $product->cost_price = $request->cost;
        $product->selling_price = $request->selling;
        $product->size = $request->size;
        $product->save();

        return response()->json($product->load('category'), 200);
    }

    public function AdminGetProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product, 200);
    }

    public function AdminDelProduct($id)
    {
        $prod = Product::findOrFail($id);

        $prod->delete();

        return response()->json(['message' => 'Product deleted!'], 200);
    }

    public function AdminUpdateProduct(Request $request, $id)
    {
        $prod = Product::findOrFail($id);
        $admin = Auth::guard('admin')->user()->full_name;
        
        $this->validate($request, [
            'product.name' => 'required|max:60',
            'product.cat' => 'required|numeric',
            'product.size' => 'required',
            'product.cost' => 'required|numeric',
            'product.selling' => 'required|numeric',
        ]);

        $prod->update([
            $prod->name = $request->product['name'],
            $prod->product_category_id = $request->product['cat'],
            $prod->size = $request->product['size'],
            $prod->cost_price = $request->product['cost'],
            $prod->selling_price = $request->product['selling'],
            $prod->user = $admin
        ]);

        return response()->json($prod, 201);
    }

    public function findAdmin()
    {
        $admin = Auth::guard('admin')->user()->full_name;

        return response()->json($admin, 200);
    }

    public function getProfile()
    {
        $me = Auth::guard('admin')->user();

        return response()->json($me, 200);
    }

    public function adminUpdateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $this->validate($request, [
            'profile.name' => 'required|max:60',
            'profile.email' => 'required|email',
        ]);

        $admin->update([
            $admin->full_name = $request->profile['name'],
            $admin->email = $request->profile['email']
        ]);

        return response()->json($admin, 200);
    }

    public function adminCheckPswd(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $oldPswd = $admin->password;
        $supplied = $request->old;
        $confirm = Hash::check($supplied, $oldPswd);
            
        return response()->json($confirm, 200);
    }

    public function adminChangePswd(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $old = $admin->password;

        $this->validate($request, [
            'newPswd' => 'required|min:5|max:25',
            'oldPswd' => 'required',
        ]);

        if(Hash::check($request->oldPswd, $old)){
            $admin->update([
                $admin->password = bcrypt($request->newPswd)
            ]);
            return response()->json(true, 200);
        }
    }
}
