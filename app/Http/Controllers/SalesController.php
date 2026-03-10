<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        return view('pages.sales.index');
    }

    public function load(Request $request)
    {
        $sales = Sale::with(['client', 'status'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pages.sales.partials.load', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['client', 'saleProducts.product', 'status', 'typeVoucher', 'orderShippingInformation']);
        return view('pages.sales.show', compact('sale'));
    }

    public function updateStatus(Request $request, Sale $sale)
    {
        $sale->update([
            'status_id' => $request->status_id
        ]);

        return response()->json(['rpt' => 1]);
    }
}
