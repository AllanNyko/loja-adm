@extends('layouts.app')

@section('title', 'Editar Ordem #' . $serviceOrder->id)
@section('page-title', 'Editar Ordem de Serviço #' . $serviceOrder->id)

@push('styles')
<style>
#device_suggestions {
    max-width: 100%;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
#device_suggestions .list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('service-orders.update', $serviceOrder) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="customer_id" class="form-label fw-bold">Cliente *</label>
                        <select name="customer_id" id="customer_id" class="form-select form-select-lg @error('customer_id') is-invalid @enderror" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        {{ old('customer_id', $serviceOrder->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="customer_document" class="form-label fw-bold">CPF/CNPJ do Cliente *</label>
                        <input type="text" name="customer_document" id="customer_document" 
                               class="form-control form-control-lg @error('customer_document') is-invalid @enderror" 
                               value="{{ old('customer_document', $serviceOrder->customer_document) }}" 
                               placeholder="000.000.000-00 ou 00.000.000/0000-00" 
                               required 
                               maxlength="20">
                        @error('customer_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">CPF ou CNPJ do cliente para vinculação jurídica do aparelho</small>
                    </div>

                    <!-- Campo de Busca de Dispositivo -->
                    <div class="mb-3">
                        <label for="device_search" class="form-label fw-bold">Buscar Dispositivo</label>
                        <input type="text" id="device_search" class="form-control form-control-lg" placeholder="Digite o modelo para buscar (ex: S23, iPhone 15)...">
                        <div id="device_suggestions" class="list-group mt-1" style="display: none; position: absolute; z-index: 1000; max-height: 300px; overflow-y: auto;"></div>
                        <small class="text-muted">Digite pelo menos 1 caractere para buscar</small>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="manufacturer" class="form-label fw-bold">Fabricante *</label>
                            <select name="manufacturer" id="manufacturer" class="form-select form-select-lg @error('manufacturer') is-invalid @enderror">
                                <option value="">Selecione o fabricante...</option>
                                @foreach($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer }}" {{ old('manufacturer', $serviceOrder->manufacturer) == $manufacturer ? 'selected' : '' }}>
                                        {{ $manufacturer }}
                                    </option>
                                @endforeach
                            </select>
                            @error('manufacturer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="device_model" class="form-label fw-bold">Modelo do Dispositivo *</label>
                            <select name="device_model" id="device_model" class="form-select form-select-lg @error('device_model') is-invalid @enderror" required>
                                <option value="">Primeiro selecione o fabricante...</option>
                            </select>
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="device_imei" class="form-label fw-bold">IMEI</label>
                        <input type="text" name="device_imei" id="device_imei" class="form-control form-control-lg @error('device_imei') is-invalid @enderror" value="{{ old('device_imei', $serviceOrder->device_imei) }}">
                        @error('device_imei')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="problem_description" class="form-label fw-bold">Descrição do Problema *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="form-control form-control-lg @error('problem_description') is-invalid @enderror" required>{{ old('problem_description', $serviceOrder->problem_description) }}</textarea>
                        @error('problem_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diagnostic" class="form-label fw-bold">Diagnóstico Técnico</label>
                        <textarea name="diagnostic" id="diagnostic" rows="3" class="form-control form-control-lg @error('diagnostic') is-invalid @enderror">{{ old('diagnostic', $serviceOrder->diagnostic) }}</textarea>
                        @error('diagnostic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="deadline" class="form-label fw-bold">Prazo de Entrega</label>
                            <input type="date" name="deadline" id="deadline" class="form-control form-control-lg @error('deadline') is-invalid @enderror" value="{{ old('deadline', $serviceOrder->deadline?->format('Y-m-d')) }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="status" class="form-label fw-bold">Status *</label>
                            <select name="status" id="status" class="form-select form-select-lg @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $serviceOrder->status) == 'pending' ? 'selected' : '' }}>Aguardando Aprovação</option>
                                <option value="approved" {{ old('status', $serviceOrder->status) == 'approved' ? 'selected' : '' }}>Aprovada</option>
                                <option value="in_progress" {{ old('status', $serviceOrder->status) == 'in_progress' ? 'selected' : '' }}>Em Execução</option>
                                <option value="completed" {{ old('status', $serviceOrder->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                                <option value="cancelled" {{ old('status', $serviceOrder->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-bold">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control form-control-lg @error('notes') is-invalid @enderror">{{ old('notes', $serviceOrder->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Informações de Valores (Somente Leitura) -->
                    @if($serviceOrder->price || $serviceOrder->parts_cost || $serviceOrder->final_cost)
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="bi bi-cash-stack"></i> Valores da Ordem (Somente Leitura)</h6>
                            <div class="row">
                                @if($serviceOrder->price)
                                <div class="col-md-4 mb-2">
                                    <label class="form-label fw-bold small">Mão de Obra:</label>
                                    <input type="text" class="form-control bg-white" value="R$ {{ number_format($serviceOrder->price, 2, ',', '.') }}" readonly>
                                </div>
                                @endif
                                @if($serviceOrder->parts_cost)
                                <div class="col-md-4 mb-2">
                                    <label class="form-label fw-bold small">Peças:</label>
                                    <input type="text" class="form-control bg-white" value="R$ {{ number_format($serviceOrder->parts_cost, 2, ',', '.') }}" readonly>
                                </div>
                                @endif
                                @if($serviceOrder->final_cost)
                                <div class="col-md-4 mb-2">
                                    <label class="form-label fw-bold small">Valor Final:</label>
                                    <input type="text" class="form-control bg-white text-success fw-bold" value="R$ {{ number_format($serviceOrder->final_cost, 2, ',', '.') }}" readonly>
                                </div>
                                @endif
                            </div>
                            <small class="text-muted"><i class="bi bi-info-circle"></i> Os valores não podem ser alterados após a criação da OS por questões de segurança.</small>
                        </div>
                    </div>
                    @endif

                    <!-- Razão de Cancelamento (se cancelada) -->
                    @if($serviceOrder->cancellation_reason)
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-x-circle"></i> Ordem Cancelada</strong>
                        <p class="mb-0 mt-2"><strong>Razão:</strong> {{ $serviceOrder->cancellation_reason }}</p>
                    </div>
                    @endif

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Salvar Alterações
                        </button>
                        <a href="{{ route('service-orders.index') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        @if($serviceOrder->status !== 'cancelled')
                        <button type="button" class="btn btn-danger btn-lg ms-auto" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="bi bi-x-circle"></i> Cancelar OS
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cancelamento -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('service-orders.cancel', $serviceOrder) }}" method="POST">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="cancelModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Cancelar Ordem de Serviço #{{ $serviceOrder->id }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong><i class="bi bi-exclamation-triangle-fill"></i> Atenção!</strong>
                        <p class="mb-0 mt-2">Esta ação <strong>NÃO PODE SER DESFEITA</strong>. A ordem de serviço será marcada como cancelada permanentemente.</p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cancellation_reason" class="form-label fw-bold">Razão do Cancelamento *</label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="4" class="form-control" required placeholder="Descreva o motivo do cancelamento desta ordem de serviço (mínimo 10 caracteres)"></textarea>
                        <small class="text-muted">Esta informação ficará registrada permanentemente no sistema.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Não, voltar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-circle"></i> Sim, cancelar OS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const manufacturerSelect = document.getElementById('manufacturer');
    const modelSelect = document.getElementById('device_model');
    const searchInput = document.getElementById('device_search');
    const suggestionsDiv = document.getElementById('device_suggestions');
    let searchTimeout;
    
    // Modelo atual da OS
    const currentModel = '{{ old("device_model", $serviceOrder->device_model) }}';
    
    // Carregar modelos quando fabricante mudar
    manufacturerSelect.addEventListener('change', function() {
        const manufacturer = this.value;
        
        if (!manufacturer) {
            modelSelect.disabled = true;
            modelSelect.innerHTML = '<option value="">Primeiro selecione o fabricante...</option>';
            return;
        }
        
        modelSelect.disabled = true;
        modelSelect.innerHTML = '<option value="">Carregando...</option>';
        
        fetch(`/api/devices/${encodeURIComponent(manufacturer)}/models`)
            .then(response => response.json())
            .then(models => {
                modelSelect.innerHTML = '<option value="">Selecione o modelo...</option>';
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    if (model === currentModel) {
                        option.selected = true;
                    }
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            })
            .catch(error => {
                console.error('Erro ao carregar modelos:', error);
                modelSelect.innerHTML = '<option value="">Erro ao carregar modelos</option>';
            });
    });
    
    // Carregar modelos iniciais se fabricante já estiver selecionado
    if (manufacturerSelect.value) {
        manufacturerSelect.dispatchEvent(new Event('change'));
    }
    
    // Busca de dispositivos
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 1) {
            suggestionsDiv.style.display = 'none';
            suggestionsDiv.innerHTML = '';
            return;
        }
        
        searchTimeout = setTimeout(() => {
            fetch(`/api/devices/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(results => {
                    suggestionsDiv.innerHTML = '';
                    
                    if (results.length === 0) {
                        suggestionsDiv.innerHTML = '<div class="list-group-item text-muted">Nenhum dispositivo encontrado</div>';
                    } else {
                        results.forEach(device => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.className = 'list-group-item list-group-item-action';
                            item.innerHTML = `<strong>${device.manufacturer}</strong> ${device.model}`;
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                
                                // Preencher os selects
                                manufacturerSelect.value = device.manufacturer;
                                manufacturerSelect.dispatchEvent(new Event('change'));
                                
                                // Aguardar os modelos carregarem e então selecionar
                                setTimeout(() => {
                                    modelSelect.value = device.model;
                                }, 500);
                                
                                // Limpar busca
                                searchInput.value = device.label;
                                suggestionsDiv.style.display = 'none';
                            });
                            suggestionsDiv.appendChild(item);
                        });
                    }
                    
                    suggestionsDiv.style.display = 'block';
                })
                .catch(error => {
                    console.error('Erro na busca:', error);
                });
        }, 300);
    });
    
    // Fechar sugestões ao clicar fora
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
});
</script>
@endpush

