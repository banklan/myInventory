<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Stock;
use App\Product;
use Carbon\Carbon;
use App\DailyBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSalesController extends Controller
{
    public function fetchItem(Request $request)
    {
        $item = $request->item;
        $results = Product::where('id', 'like', "%".$item."%")->orWhere('name',  'like', "%".$item."%")->orWhere('size', 'like', "%".$item."%")
                            ->orWhereHas('category', function($q) use($item){
                            $q->where('name', 'like', "%".$item."%");
                            })->get();

        return response()->json($results, 200);
    }

    public function getProduct($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product, 200);
    }

    public function checkout(Request $request)
    { 
        $sales = $request->sales;
        // for($i=0; $i<count($sales); $i++){
        //     dd($sales[$i]['name']);
        // }
        // dd($sales);
        foreach($request->sales as $i => $items) {
            // foreach($items as $j => $item){dd($item);
        // for($i = 0; $i<count($request->sales); $i++){
            $this->validate($request, [
                'sales.*.name' => 'required', 
                'sales.*.id' => 'required', 
                'sales.*.unitCost' => 'required', 
                'sales.*.price' => 'required', 
                'sales.*.unit' => 'required', 
                'sales.*.totalCost' => 'required', 
            ]);
            $data = array(
                'product_id' => $item['id'],
                'units_sold' => $item['unit'],
                'unit_price' => $item['price'],
                'total_price' => $item['totalCost'] * 100,
            );

            //   $data = array(
            //       'product_id' => $request->sales[$item]['id'],
            //       'units_sold' => $request->sales[$item]['unit'],
            //       'unit_price' => $request->sales[$item]['price'],
            //       'total_price' => $request->sales[$item]['totalCost'] * 100,
            //   );

            // $data = array(
            //     'product_id' => $request->sales[$i]['id'],
            //     'units_sold' => $request->sales[$i]['unit'],
            //     'unit_price' => $request->sales[$i]['price'],
            //     'total_price' => $request->sales[$i]['totalCost'] * 100,
            // );

              $sales = Sale::insert($data);
            // $item->units_sold = $request->sales[$i]['unit'];
            // $item->unit_price = $request->sales[$i]['price'];
            // $item->total_price = $request->sales[$i]['totalCost'];
            // $item->save();
            // $item->product_id = intval($sales[$i]['id']);
            // $item->units_sold = intval($sales[$i]['unit']);
            // $item->unit_price = intval($sales[$i]['price']);
            // $item->total_price = intval($sales[$i]['totalCost']) * 100;
            // $item->save();

            return response()->json($sales, 200);
        } 
    }

    public function checkoutss(Request $request)
    {
        $user = Auth::id();
        $batch = Carbon::now()->toDateString();
        foreach ($request->sales as $k => $item) {
            $sale = new Sale;
            $sale->product_id = $item['id'];
            $sale->units_sold = $item['unit'];
            $sale->unit_price = $item['price'];
            $sale->total_price = $item['totalCost'] * 100;
            $sale->user_id = $user;
            $sale->batch = $batch;
            $sale->save();
        }

        //update the product in stock column of the product
        foreach($request->sales as $k => $item){
            $prod_id = $item['id'];
            $product = Product::findOrFail($prod_id);
            $units_sold = $sale->units_sold;
            $instock = $product->total_in_stock;
            $product->update([
                $product->total_in_stock = intval($instock) - intval($units_sold)
            ]);
        }
    }

    public function getLog()
    {
        $user = Auth::id();
        $today = Carbon::now()->toDateString();
        $log = Sale::where('user_id', $user)->where('batch', $today)->get();

        return response()->json($log, 200);
    }

    public function getBatches()
    {
        $user = Auth::id();
        $batches = DailyBatch::where('user_id', $user)->get();
        // $sales = Sale::where('user_id', $user)->get();
        return response()->json($batches, 200);
    }

    public function getBatchSales(Request $request)
    {
        $user = Auth::id();
        $batch = $request->batch;
    //    print_r($batch);
        $sales = Sale::where('user_id', $user)->where('batch', $batch)->get();

        return response()->json($sales, 200);
    }

    public function getAllStocks()
    {
        // $stocks =  Stock::selectRaw('product_id, colour, price_perunit, SUM(total_units) as total_in_stock')
        //                 ->groupBy('product_id')->get();

        $stocks = Product::orderBy('id', 'asc')->get();

        return response()->json($stocks, 200);
    }

    public function getUserProfile()
    {
        $user = Auth::user();

        return response()->json($user, 200);
    }
    
    public function changePswd(Request $request)
    {
        $user = Auth::user();
        $old = $user->password;

        $this->validate($request, [
            'newPswd' => 'required|min:5|max:25',
            'oldPswd' => 'required',
        ]);

        if(Hash::check($request->oldPswd, $old)){
            $user->update([
                $user->password = bcrypt($request->newPswd)
            ]);
            return response()->json(true, 200);
        }
    }

    public function UserCheckPswd(Request $request)
    {
        $user = Auth::user();
        $oldPswd = $user->password;
        $supplied = $request->old;
        $confirm = Hash::check($supplied, $oldPswd);
            
        return response()->json($confirm, 200);
    }

    public function UserUpdateprofile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'profile.name' => 'required|max:60',
            'profile.email' => 'required|email',
        ]);

        $user->update([
            $user->full_name = $request->profile['name'],
            $user->email = $request->profile['email']
        ]);

        return response()->json($user, 200);
    }
}
