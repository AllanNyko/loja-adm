<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ServiceOrderController extends Controller
{
    public function index(Request $request)
    {
        \Log::info('ServiceOrder Index - Parâmetros:', [
            'search' => $request->search,
            'status' => $request->status,
            'filled_search' => $request->filled('search'),
        ]);

        $query = ServiceOrder::with('customer')->orderBy('created_at', 'desc');

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            \Log::info('Filtro status aplicado:', ['status' => $request->status]);
        }

        // Filtro por busca (nome do cliente ou documento)
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                \Log::info('Filtro busca aplicado:', ['search' => $search]);
                $query->where(function($q) use ($search) {
                    $q->whereHas('customer', function($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('customer_document', 'like', '%' . $search . '%');
                });
            }
        }

        $serviceOrders = $query->paginate(15);
        
        \Log::info('Resultado da busca:', ['total' => $serviceOrders->total()]);
        
        return view('service-orders.index', compact('serviceOrders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $manufacturers = array_keys(config('devices'));
        return view('service-orders.create', compact('customers', 'manufacturers'));
    }
    
    public function searchDevices(Request $request)
    {
        $search = $request->get('q', '');
        $devices = config('devices');
        $results = [];
        
        if (strlen($search) >= 1) {
            foreach ($devices as $manufacturer => $models) {
                foreach ($models as $model) {
                    if (stripos($model, $search) !== false) {
                        $results[] = [
                            'manufacturer' => $manufacturer,
                            'model' => $model,
                            'label' => $manufacturer . ' ' . $model
                        ];
                    }
                }
            }
        }
        
        return response()->json(array_slice($results, 0, 20));
    }
    
    public function getManufacturerModels($manufacturer)
    {
        $devices = config('devices');
        $models = $devices[$manufacturer] ?? [];
        
        return response()->json($models);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'customer_document' => 'required|string|max:20',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,amount',
            'discount_value' => 'nullable|numeric|min:0',
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
            'customer_document' => 'required|string|max:20',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:255',
            'problem_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,amount',
            'discount_value' => 'nullable|numeric|min:0',
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

    public function exportPdf(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('customer');
        
        $pdf = Pdf::loadView('service-orders.pdf', [
            'order' => $serviceOrder,
        ]);

        return $pdf->download('ordem-servico-' . $serviceOrder->id . '.pdf');
    }

    /**
     * Rastreamento público de ordem de serviço
     */
    public function track($orderNumber)
    {
        // Busca a ordem pelo ID
        $serviceOrder = ServiceOrder::with('customer')->find($orderNumber);

        if (!$serviceOrder) {
            return view('service-orders.track-not-found', [
                'orderNumber' => $orderNumber
            ]);
        }

        return view('service-orders.track', [
            'order' => $serviceOrder
        ]);
    }
}
