@extends('layouts.app')

@section('title', 'Nova Ordem de Serviço')
@section('page-title', 'Nova Ordem de Serviço')

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
                <form action="{{ route('service-orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="customer_id" class="form-label fw-bold">Cliente *</label>
                        <select name="customer_id" id="customer_id" class="form-select form-select-lg @error('customer_id') is-invalid @enderror" required>
                            <option value="">Selecione...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            Não encontrou? <a href="{{ route('customers.create') }}" target="_blank">Cadastre um novo cliente</a>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="customer_document" class="form-label fw-bold">CPF/CNPJ do Cliente *</label>
                        <input type="text" name="customer_document" id="customer_document" 
                               class="form-control form-control-lg @error('customer_document') is-invalid @enderror" 
                               value="{{ old('customer_document') }}" 
                               placeholder="000.000.000-00 ou 00.000.000/0000-00" 
                               required 
                               maxlength="20">
                        @error('customer_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Digite o CPF ou CNPJ do cliente para amarrar o aparelho juridicamente</small>
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
                                    <option value="{{ $manufacturer }}" {{ old('manufacturer') == $manufacturer ? 'selected' : '' }}>
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
                            <select name="device_model" id="device_model" class="form-select form-select-lg @error('device_model') is-invalid @enderror" required disabled>
                                <option value="">Primeiro selecione o fabricante...</option>
                            </select>
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="device_imei" class="form-label fw-bold">IMEI</label>
                        <input type="text" name="device_imei" id="device_imei" class="form-control form-control-lg @error('device_imei') is-invalid @enderror" value="{{ old('device_imei') }}" placeholder="Opcional">
                        @error('device_imei')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="problem_description" class="form-label fw-bold">Descrição do Problema *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="form-control form-control-lg @error('problem_description') is-invalid @enderror" required placeholder="Descreva o problema relatado pelo cliente">{{ old('problem_description') }}</textarea>
                        @error('problem_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold">Valor do Serviço (Mão de Obra) *</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', '0.00') }}" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="parts_cost" class="form-label fw-bold">Valor Total das Peças</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" name="parts_cost" id="parts_cost" class="form-control @error('parts_cost') is-invalid @enderror" value="{{ old('parts_cost', '0.00') }}" placeholder="0.00">
                            </div>
                            @error('parts_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Custo total das peças necessárias para o reparo</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="diagnostic" class="form-label fw-bold">Diagnóstico Técnico</label>
                        <textarea name="diagnostic" id="diagnostic" rows="3" class="form-control form-control-lg @error('diagnostic') is-invalid @enderror" placeholder="Opcional - Diagnóstico após análise">{{ old('diagnostic') }}</textarea>
                        @error('diagnostic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="estimated_cost" class="form-label fw-bold">Custo Estimado Total</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control bg-light @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost', '0.00') }}" placeholder="0.00" readonly>
                            </div>
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Calculado automaticamente (Mão de Obra + Peças)</small>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="deadline" class="form-label fw-bold">Prazo de Entrega</label>
                            <input type="date" name="deadline" id="deadline" class="form-control form-control-lg @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <!-- Seção de Desconto -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="bi bi-tag"></i> Desconto (Opcional)</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label for="discount_type" class="form-label fw-bold">Tipo de Desconto</label>
                                    <select name="discount_type" id="discount_type" class="form-select form-select-lg">
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Porcentagem (%)</option>
                                        <option value="amount" {{ old('discount_type') == 'amount' ? 'selected' : '' }}>Valor (R$)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="discount_value" class="form-label fw-bold">Valor do Desconto</label>
                                    <input type="number" name="discount_value" id="discount_value" class="form-control form-control-lg" min="0" step="0.01" value="{{ old('discount_value', '0') }}" placeholder="0.00">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold">Desconto Calculado</label>
                                    <input type="text" id="discount_display" class="form-control form-control-lg bg-white" readonly value="R$ 0,00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo da OS -->
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <small>Subtotal:</small>
                                    <h5 id="subtotal_display">R$ 0,00</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <small>Total a Pagar:</small>
                                    <h3 id="total_display">R$ 0,00</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-bold">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control form-control-lg @error('notes') is-invalid @enderror" placeholder="Informações adicionais">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid d-md-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-mobile">
                            <i class="bi bi-save"></i> Salvar Ordem
                        </button>
                        <a href="{{ route('service-orders.index') }}" class="btn btn-secondary btn-lg btn-mobile">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
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
                    modelSelect.appendChild(option);
                });
                modelSelect.disabled = false;
            })
            .catch(error => {
                console.error('Erro ao carregar modelos:', error);
                modelSelect.innerHTML = '<option value="">Erro ao carregar modelos</option>';
            });
    });
    
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
    
    // Cálculo automático do custo estimado total
    const priceInput = document.getElementById('price');
    const partsCostInput = document.getElementById('parts_cost');
    const estimatedCostInput = document.getElementById('estimated_cost');
    const discountTypeSelect = document.getElementById('discount_type');
    const discountValueInput = document.getElementById('discount_value');
    const discountDisplay = document.getElementById('discount_display');
    const subtotalDisplay = document.getElementById('subtotal_display');
    const totalDisplay = document.getElementById('total_display');
    
    function calculateTotals() {
        // Calcular subtotal (mão de obra + peças)
        const price = parseFloat(priceInput.value) || 0;
        const partsCost = parseFloat(partsCostInput.value) || 0;
        const subtotal = price + partsCost;
        
        // Atualizar custo estimado
        estimatedCostInput.value = subtotal.toFixed(2);
        
        // Calcular desconto
        const discountType = discountTypeSelect.value;
        const discountValue = parseFloat(discountValueInput.value) || 0;
        let discountAmount = 0;
        
        if (discountValue > 0) {
            if (discountType === 'percentage') {
                const percentage = Math.min(discountValue, 100);
                discountAmount = (subtotal * percentage) / 100;
            } else {
                discountAmount = Math.min(discountValue, subtotal);
            }
        }
        
        const total = subtotal - discountAmount;
        
        // Atualizar displays
        subtotalDisplay.textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
        discountDisplay.value = 'R$ ' + discountAmount.toFixed(2).replace('.', ',');
        totalDisplay.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
    }
    
    // Adicionar listeners para atualizar em tempo real
    priceInput.addEventListener('input', calculateTotals);
    partsCostInput.addEventListener('input', calculateTotals);
    discountTypeSelect.addEventListener('change', calculateTotals);
    discountValueInput.addEventListener('input', calculateTotals);
    
    // Calcular valores iniciais ao carregar a página
    calculateTotals();
});
</script>
@endpush
