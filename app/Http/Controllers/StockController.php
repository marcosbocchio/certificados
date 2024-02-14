<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use App\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $stockItems = Stock::orderBy('id', 'DESC')->paginate(10);
        return response()->json($stockItems);
    }

    public function store(Request $request) 
    {
        $stockItem = new Stock([
            'fecha' => $request->fecha,
            'obs' => $request->obs,
            'cantidad' => $request->cantidad,
            'stock' => $request->stock,
        ]);
        $stockItem->save();

        return response()->json($stockItem, 201); 
    }

    public function update(Request $request, $id) 
    {
        $stockItem = Stock::findOrFail($id);
        $stockItem->update([
            'fecha' => $request->fecha,
            'obs' => $request->obs,
            'cantidad' => $request->cantidad,
            'stock' => $request->stock,
        ]);

        return response()->json($stockItem);
    }

    public function destroy($id)
    {
        $stockItem = Stock::findOrFail($id);
        $stockItem->delete();

        return response()->json(null, 204); // 204: No Content
    }
}