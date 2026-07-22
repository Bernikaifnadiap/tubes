<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->paginate(15);
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $products = Product::orderBy('nama_barang')->get();
        $selectedProductId = $request->query('product_id');
        $type = $request->query('type', 'masuk');
        
        return view('transactions.create', compact('products', 'selectedProductId', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:masuk,keluar',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($validated['product_id']);

            if ($validated['type'] === 'keluar' && $product->stok < $validated['quantity']) {
                return back()->withInput()->withErrors(['quantity' => 'Stok tidak mencukupi untuk transaksi keluar. Stok saat ini: ' . $product->stok]);
            }

            Transaction::create($validated);

            if ($validated['type'] === 'masuk') {
                $product->increment('stok', $validated['quantity']);
            } else {
                $product->decrement('stok', $validated['quantity']);
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Transaksi stok berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }
}
