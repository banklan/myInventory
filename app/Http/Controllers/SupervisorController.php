<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Stock;
use App\Product;
use Carbon\Carbon;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:supervisor');
    }

    public function index()
    {
        return view('supervisor.home');
    }

    public function getCategs()
    {
        $categs = ProductCategory::orderBy('id', 'asc')->get();

        return response()->json($categs, 200);
    }

    public function getproductsFromCateg($id)
    {
        $products = Product::where('product_category_id', $id)->orderBy('id', 'asc')->get();

        return response()->json($products, 200);
    }

    // public function supAddNewStock(Request $request)
    // {
    //     $this->validate($request, [
    //         'stock.product' => 'required',
    //         'stock.category' => 'required',
    //         'stock.size' => 'required',
    //         'stock.packsRcvd' => 'required|numeric|between:1,1000',
    //         'stock.unitsPp' => 'required|numeric|between:1,1000',
    //         'stock.colour' => 'max:20',
    //         'stock.pricePU' => 'required|numeric|between:1,100000',
    //         'stock.totalUnits' => 'required|numeric|between:1,100000',
    //         'stock.totalCost' => 'required|numeric|between:1,10000000',
    //         'stock.sn' => 'required',
    //     ]);

    //     $stock = new Stock;
    //     $stock->product_id = $request->stock['product'];
    //     $stock->size = $request->stock['size'];
    //     $stock->pks_received = $request->stock['packsRcvd'];
    //     $stock->units_perpack = $request->stock['unitsPp'];
    //     $stock->colour = $request->stock['colour'];
    //     $stock->price_perunit = $request->stock['pricePU'];
    //     $stock->total_units = $request->stock['totalUnits'];
    //     $stock->total_cost = $request->stock['totalCost'];
    //     $stock->sn = $request->stock['sn'];
    //     $stock->mfg = $request->stock['mfg'];
    //     $stock->exp = $request->stock['exp'];
    //     $stock->save();

    //     return response()->json($stock, 200);
    // }

    public function supGetProducts()
    {
        $products = Product::orderBy('id', 'asc')->get();

        return response()->json($products, 200);
    }

    public function supAddNewStocks(Request $request, $id)
    { 
        $this->validate($request, [
            'stock.packsRcvd' => 'required|numeric|between:1,1000',
            'stock.unitsPp' => 'required|numeric|between:1,1000',
            'stock.colour' => 'max:20',
            'stock.unitPriceUnformatted' => 'required|numeric|between:1,100000',
            'stock.totalUnits' => 'required|numeric|between:1,100000',
            'stock.srln' => 'required',
        ]);

        $stock = new Stock;
        $stock->product_id = $id;
        $stock->pks_received = $request->stock['packsRcvd'];
        $stock->units_perpack = $request->stock['unitsPp'];
        $stock->colour = $request->stock['colour'];
        $stock->price_perunit = $request->stock['unitPriceUnformatted'];
        $stock->total_units = $request->stock['totalUnits'];
        $stock->total_cost = intval($request->stock['totalUnits'] * $request->stock['unitPriceUnformatted']);
        $stock->sn = $request->stock['srln'];
        $stock->mfg = $request->stock['mfg'];
        $stock->exp = $request->stock['expiry'];
        $stock->save();

        //get product and increase the instock value
        $product = Product::findOrFail($id);
        $instock = $product->total_in_stock;
        $total = intval($stock->total_units) + intval($instock);

        $product->update([
            $product->total_in_stock = $total
        ]);

        return response()->json($stock, 200);
    }

    public function supGetProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product, 200);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->q;
        $products = Product::where('id', 'like', "%".$search."%")->orWhere('name', 'like', "%".$search."%")
                            ->orWhere('product_category_id', 'like', "%".$search."%")->orWhere('selling_price', 'like', "%".$search."%")
                            ->orWhere('size', 'like', "%".$search."%")->get();

        return response()->json($products, 200);
    }

    public function updateProduct(Request $request, $id)
    {
        // $product = Product::findOrFail($id);
        // print_r($request->product);
    }

    public function getSupervisorProfile()
    {
        $sup = Auth::guard('supervisor')->user();
        return response()->json($sup, 200);
    }

    public function SupChangePswd(Request $request)
    {
        $sup = Auth::guard('supervisor')->user();
        $old = $sup->password;

        $this->validate($request, [
            'newPswd' => 'required|min:5|max:25',
            'oldPswd' => 'required',
        ]);

        if(Hash::check($request->oldPswd, $old)){
            $sup->update([
                $sup->password = bcrypt($request->newPswd)
            ]);
            return response()->json(true, 200);
        }
    }

    public function SupCheckPswd(Request $request)
    {
        $sup = Auth::guard('supervisor')->user();
        $oldPswd = $sup->password;
        $supplied = $request->old;
        $confirm = Hash::check($supplied, $oldPswd);
            
        return response()->json($confirm, 200);
    }

    public function updateProfile(Request $request)
    {
        $sup = Auth::guard('supervisor')->user();
        $this->validate($request, [
            'profile.name' => 'required|max:60',
            'profile.email' => 'required|email',
        ]);

        $sup->update([
            $sup->full_name = $request->profile['name'],
            $sup->email = $request->profile['email']
        ]);

        return response()->json($sup, 200);
    }

    public function supGetSales()
    {
        $sales = Sale::latest()->get();

        return response()->json($sales->load('user'), 200);
    }

    public function supGetBatches()
    {
        $batches = Sale::selectRaw('product_id, batch')->groupBy('batch')->latest()->get();

        return response()->json($batches, 200);
    }

    public function supGetUsers()
    {
        $users = Sale::selectRaw('user_id')->groupBy('user_id')->distinct()->get();

        return response()->json($users, 200);
    }

    public function supGetSalesToday()
    {
        $batch = Carbon::now()->toDateString();
        $sales = Sale::where('batch', $batch)->get();

        return response()->json($sales, 200);
    }

    public function supFindBatch(Request $request)
    {
        $batch = $request->batch;
        $sales = Sale::where('batch', $batch)->get();

        return response()->json($sales, 200);
    }

    public function supGetSalesByUser(Request $request)
    {
        $user = $request->user;
        $sales = Sale::where('user_id', $user)->get();

        return response()->json($sales, 200);
    }

    public function supGetSalesByProd(Request $request)
    {
        $prod = $request->product;
        $sales = Sale::where('product_id', 'like', "%".$prod."%")->orWhereHas('product', function($q) use($prod){
            $q->where('name', 'like', "%".$prod."%");
            })->get();
        
        return response()->json($sales, 200);
    }

    public function supGetSingleSale($id)
    {
        $sale = Sale::findOrFail($id);

        return response()->json($sale, 200);
    } 
}
