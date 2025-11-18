<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'items')->latest()->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:dinheiro,cartao_debito,cartao_credito,pix,outro',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $total = 0;
            $items = [];

            // Calcular total e preparar itens
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Verificar estoque
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Estoque insuficiente para {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                // Atualizar estoque
                $product->decrement('stock', $item['quantity']);
            }

            // Criar venda
            $sale = Sale::create([
                'customer_id' => $validated['customer_id'],
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Criar itens da venda
            foreach ($items as $item) {
                $sale->items()->create($item);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Venda registrada com sucesso!');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        // Restaurar estoque
        foreach ($sale->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Venda removida com sucesso!');
    }
}
