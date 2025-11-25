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
        $query = ServiceOrder::with('customer')->orderBy('id', 'desc');

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por busca (nome do cliente ou documento)
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function($q) use ($search) {
                    $q->whereHas('customer', function($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('customer_document', 'like', '%' . $search . '%');
                });
            }
        }

        $serviceOrders = $query->paginate(15);
        
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
            'manufacturer' => 'required|string|max:255',
            'device_model' => 'required|string|max:255',
            'device_imei' => 'nullable|string|max:255',
            'problems_data' => 'nullable|json',
            'problem_description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'parts_cost' => 'nullable|numeric|min:0',
            'extra_cost_type' => 'nullable|string|max:50',
            'extra_cost_value' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,amount',
            'discount_value' => 'nullable|numeric|min:0',
            'diagnostic' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // Processar problemas com fotos - SALVAR EM DISCO
        $problemsPhotos = [];
        if ($request->has('problems_data') && $request->input('problems_data')) {
            $problemsData = json_decode($request->input('problems_data'), true);
            
            if ($problemsData && is_array($problemsData)) {
                $customerDocument = preg_replace('/[^0-9]/', '', $validated['customer_document']);
                
                foreach ($problemsData as $problem) {
                    $photoPaths = [];
                    
                    if (isset($problem['photos']) && is_array($problem['photos'])) {
                        foreach ($problem['photos'] as $index => $photoBase64) {
                            // Extrair dados da imagem base64
                            if (preg_match('/^data:image\/(\w+);base64,/', $photoBase64, $type)) {
                                $photoBase64 = substr($photoBase64, strpos($photoBase64, ',') + 1);
                                $type = strtolower($type[1]); // jpg, png, gif, etc
                                
                                $photoData = base64_decode($photoBase64);
                                
                                if ($photoData !== false) {
                                    // Criar diretório se não existir
                                    $directory = storage_path('app/public/service-orders-photos');
                                    if (!file_exists($directory)) {
                                        mkdir($directory, 0755, true);
                                    }
                                    
                                    // Nome único: os_{cpf}_{timestamp}_{random}.{ext}
                                    $timestamp = now()->format('YmdHis');
                                    $filename = "os_{$customerDocument}_{$timestamp}_" . uniqid() . ".{$type}";
                                    $filepath = $directory . '/' . $filename;
                                    
                                    // Salvar arquivo
                                    file_put_contents($filepath, $photoData);
                                    
                                    // Guardar caminho relativo
                                    $photoPaths[] = 'service-orders-photos/' . $filename;
                                }
                            }
                        }
                    }
                    
                    $problemsPhotos[] = [
                        'description' => $problem['description'] ?? 'Sem descrição',
                        'photos' => $photoPaths
                    ];
                }
            }
        }

        $validated['problems_photos'] = !empty($problemsPhotos) ? $problemsPhotos : null;

        // Calcular final_cost
        $subtotal = ($validated['price'] ?? 0) + ($validated['parts_cost'] ?? 0) + ($validated['extra_cost_value'] ?? 0);
        
        $discountAmount = 0;
        if (isset($validated['discount_value']) && $validated['discount_value'] > 0) {
            if (($validated['discount_type'] ?? 'amount') === 'percentage') {
                $discountAmount = ($subtotal * $validated['discount_value']) / 100;
            } else {
                $discountAmount = $validated['discount_value'];
            }
        }
        
        $validated['final_cost'] = $subtotal - $discountAmount;

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
        $manufacturers = array_keys(config('devices'));
        return view('service-orders.edit', compact('serviceOrder', 'customers', 'manufacturers'));
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
            'extra_cost_type' => 'nullable|string|max:50',
            'extra_cost_value' => 'nullable|numeric|min:0',
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

    public function cancelOrder(Request $request, ServiceOrder $serviceOrder)
    {
        $validated = $request->validate([
            'cancellation_reason' => 'required|string|min:10',
        ]);

        $serviceOrder->update([
            'status' => 'cancelled',
            'cancellation_reason' => $validated['cancellation_reason'],
        ]);

        return redirect()->route('service-orders.index')
            ->with('success', 'Ordem de serviço cancelada com sucesso!');
    }

    public function exportPdf(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('customer');
        
        $pdf = Pdf::loadView('service-orders.pdf', [
            'order' => $serviceOrder,
        ]);

        return $pdf->download('ordem-servico-' . $serviceOrder->id . '.pdf');
    }

    public function exportClientPdf(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('customer');
        
        $pdf = Pdf::loadView('service-orders.client-pdf', [
            'order' => $serviceOrder,
        ]);

        return $pdf->download('ordem-servico-cliente-' . $serviceOrder->id . '.pdf');
    }

    /**
     * Gera PDF, salva no servidor e redireciona para WhatsApp
     */
    public function sendToWhatsApp(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('customer');
        
        // Gerar hash único se não existir
        if (!$serviceOrder->pdf_hash) {
            $serviceOrder->pdf_hash = hash('sha256', $serviceOrder->id . time() . uniqid());
            $serviceOrder->save();
        }
        
        // Gerar PDF
        $pdf = Pdf::loadView('service-orders.client-pdf', [
            'order' => $serviceOrder,
        ]);
        
        // Criar diretório se não existir
        $directory = storage_path('app/public/os-pdfs');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Salvar PDF
        $filename = 'os-' . $serviceOrder->id . '-' . $serviceOrder->pdf_hash . '.pdf';
        $filepath = $directory . '/' . $filename;
        $pdf->save($filepath);
        
        // Gerar URL de download usando domínio de produção
        $baseUrl = config('app.url');
        $downloadUrl = $baseUrl . '/os/download/' . $serviceOrder->pdf_hash;
        $photosUrl = $baseUrl . '/os/photos/' . $serviceOrder->pdf_hash;
        
        // Preparar mensagem do WhatsApp (sem emojis para evitar problemas de codificação)
        $phone = preg_replace('/[^0-9]/', '', $serviceOrder->customer->phone); // Remove formatação
        
        $message = "Ola *{$serviceOrder->customer->name}*!\n\n";
        $message .= "Agradecemos por escolher a *JD SMART*!\n\n";
        $message .= "Sua *Ordem de Servico #{$serviceOrder->id}* foi gerada com sucesso!\n\n";
        $message .= "*Dispositivo:* {$serviceOrder->device_model}\n";
        $message .= "*Data:* " . $serviceOrder->created_at->format('d/m/Y H:i') . "\n\n";
        $message .= "Voce pode acessar:\n\n";
        $message .= "- Documento completo (PDF):\n{$downloadUrl}\n\n";
        
        // Verificar se há fotos documentadas
        if ($serviceOrder->problems_photos && count($serviceOrder->problems_photos) > 0) {
            $totalProblems = count($serviceOrder->problems_photos);
            $message .= "- Galeria de Fotos ({$totalProblems} observações(s) documentado(s)):\n{$photosUrl}\n\n";
        }
        
        $message .= "_Estes links ficarao disponiveis para voce consultar sempre que precisar!_\n\n";
        $message .= "Em caso de duvidas, estamos a disposicao!\n";
        $message .= "Telefone: (13) 99784-1161";
        
        // Gerar link do WhatsApp
        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
        
        return redirect($whatsappUrl);
    }

    /**
     * Download público do PDF via hash
     */
    public function downloadPdf($hash)
    {
        // Buscar ordem de serviço pelo hash
        $serviceOrder = ServiceOrder::where('pdf_hash', $hash)->first();
        
        if (!$serviceOrder) {
            abort(404, 'Documento não encontrado');
        }
        
        $filename = 'os-' . $serviceOrder->id . '-' . $hash . '.pdf';
        $filepath = storage_path('app/public/os-pdfs/' . $filename);
        
        // Se o arquivo não existir, gerar novamente
        if (!file_exists($filepath)) {
            $serviceOrder->load('customer');
            $pdf = Pdf::loadView('service-orders.client-pdf', [
                'order' => $serviceOrder,
            ]);
            
            $directory = storage_path('app/public/os-pdfs');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            $pdf->save($filepath);
        }
        
        return response()->download($filepath, 'Ordem-Servico-' . $serviceOrder->id . '-JDSmart.pdf');
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

    /**
     * Galeria pública de fotos via hash
     */
    public function showPhotosGallery($hash)
    {
        // Buscar ordem de serviço pelo hash
        $serviceOrder = ServiceOrder::where('pdf_hash', $hash)->first();
        
        if (!$serviceOrder) {
            abort(404, 'Galeria não encontrada');
        }
        
        return view('service-orders.photos-gallery', [
            'order' => $serviceOrder
        ]);
    }
}
