<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Customer;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceOrder::with('customer')->latest();

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $serviceOrders = $query->paginate(15);
        
        return view('service-orders.index', compact('serviceOrders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('service-orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'diagnostic' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        ServiceOrder::create($validated);

        return redirect()->route('service-orders.index')
            ->with('success', 'Ordem de serviço criada com sucesso!');
    }

    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('customer');
        return view('service-orders.show', compact('serviceOrder'));
    }

    public function edit(ServiceOrder $serviceOrder)
    {
        $customers = Customer::orderBy('name')->get();
        return view('service-orders.edit', compact('serviceOrder', 'customers'));
    }

    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'diagnostic' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,in_progress,completed,cancelled',
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $serviceOrder->update($validated);

        return redirect()->route('service-orders.index')
            ->with('success', 'Ordem de serviço atualizada com sucesso!');
    }

    public function destroy(ServiceOrder $serviceOrder)
    {
        $serviceOrder->delete();

        return redirect()->route('service-orders.index')
            ->with('success', 'Ordem de serviço removida com sucesso!');
    }

    public function updateStatus(Request $request, ServiceOrder $serviceOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,in_progress,completed,cancelled',
        ]);

        $serviceOrder->update($validated);

        return redirect()->back()
            ->with('success', 'Status atualizado com sucesso!');
    }
}
