<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::query();

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por categoria
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filtro por período
        if ($request->filled('start_date')) {
            $query->whereDate('due_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        $expenses = $query->orderBy('due_date', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);

        // Estatísticas
        $totalPending = Expense::where('status', 'pending')->sum('amount');
        $totalPaid = Expense::where('status', 'paid')->sum('amount');
        $totalOverdue = Expense::where('status', 'overdue')->sum('amount');

        return view('expenses.index', compact('expenses', 'totalPending', 'totalPaid', 'totalOverdue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|in:utilities,internet,rent,supplies,equipment,salary,taxes,marketing,maintenance,other',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'paid_date' => 'nullable|date',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'payment_method' => 'nullable|in:cash,debit_card,credit_card,pix,bank_transfer,other',
            'notes' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')
                        ->with('success', 'Despesa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|in:utilities,internet,rent,supplies,equipment,salary,taxes,marketing,maintenance,other',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'paid_date' => 'nullable|date',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'payment_method' => 'nullable|in:cash,debit_card,credit_card,pix,bank_transfer,other',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
                        ->with('success', 'Despesa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
                        ->with('success', 'Despesa excluída com sucesso!');
    }

    /**
     * Marca uma despesa como paga
     */
    public function markAsPaid(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,debit_card,credit_card,pix,bank_transfer,other',
            'paid_date' => 'nullable|date',
        ]);

        $expense->markAsPaid(
            $validated['payment_method'],
            $validated['paid_date'] ?? now()
        );

        return redirect()->back()
                        ->with('success', 'Despesa marcada como paga!');
    }
}
