@extends('layouts.app')

@section('title', 'Nova Venda')
@section('page-title', 'Nova Venda')

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label for="customer_id" class="form-label fw-bold">Cliente (Opcional)</label>
                            <select name="customer_id" id="customer_id" class="form-select form-select-lg @error('customer_id') is-invalid @enderror">
                                <option value="">Venda sem cadastro</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} - {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="payment_method" class="form-label fw-bold">Forma de Pagamento *</label>
                            <select name="payment_method" id="payment_method" class="form-select form-select-lg @error('payment_method') is-invalid @enderror" required>
                                <option value="dinheiro" {{ old('payment_method') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                                <option value="cartao_debito" {{ old('payment_method') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                                <option value="cartao_credito" {{ old('payment_method') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                                <option value="pix" {{ old('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                                <option value="outro" {{ old('payment_method') == 'outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3"><i class="bi bi-cart-plus"></i> Itens da Venda</h5>
                    <div id="items-container">
                        <div class="row g-2 mb-2 item-row">
                            <div class="col-12 col-md-5">
                                <label class="form-label fw-bold d-none d-md-block">Produto *</label>
                                <select name="items[0][product_id]" class="form-select form-select-lg product-select" required>
                                    <option value="">Selecione...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }} (Est: {{ $product->stock }}) - R$ {{ number_format($product->price, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label fw-bold d-none d-md-block">Quantidade *</label>
                                <input type="number" name="items[0][quantity]" class="form-control form-control-lg quantity-input" min="1" value="1" required placeholder="Qtd">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="form-label fw-bold d-none d-md-block">Subtotal</label>
                                <input type="text" class="form-control form-control-lg subtotal-display" readonly value="R$ 0,00">
                            </div>
                            <div class="col-2 col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-lg w-100 remove-item" disabled title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary btn-mobile mb-3" id="add-item">
                        <i class="bi bi-plus-circle"></i> Adicionar Item
                    </button>

                    <hr>

                    <!-- Seção de Desconto -->
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="bi bi-tag"></i> Desconto (Opcional)</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <label for="discount_type" class="form-label fw-bold">Tipo de Desconto</label>
                                    <select name="discount_type" id="discount_type" class="form-select form-select-lg">
                                        <option value="percentage">Porcentagem (%)</option>
                                        <option value="amount">Valor (R$)</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="discount_value" class="form-label fw-bold">Valor do Desconto</label>
                                    <input type="number" name="discount_value" id="discount_value" class="form-control form-control-lg" min="0" step="0.01" value="0" placeholder="0.00">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold">Desconto Calculado</label>
                                    <input type="text" id="discount_display" class="form-control form-control-lg bg-white" readonly value="R$ 0,00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumo da Venda -->
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <small>Subtotal:</small>
                                    <h5 id="subtotal-display">R$ 0,00</h5>
                                </div>
                                <div class="col-6 text-end">
                                    <small>Total a Pagar:</small>
                                    <h3 id="total-display">R$ 0,00</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control form-control-lg" placeholder="Informações adicionais sobre a venda">{{ old('notes') }}</textarea>
                    </div>

                    <div class="d-grid d-md-flex gap-2">
                        <button type="submit" class="btn btn-success btn-lg btn-mobile">
                            <i class="bi bi-check-circle"></i> Registrar Venda
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-lg btn-mobile">
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
let itemIndex = 1;

function updateSubtotal(row) {
    const select = row.querySelector('.product-select');
    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const selectedOption = select.options[select.selectedIndex];
    const price = parseFloat(selectedOption.dataset.price) || 0;
    const subtotal = price * quantity;
    
    row.querySelector('.subtotal-display').value = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
    updateTotal();
}

function updateTotal() {
    let subtotal = 0;
    
    // Calcular subtotal de todos os itens
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        subtotal += price * quantity;
    });
    
    // Calcular desconto
    const discountType = document.getElementById('discount_type').value;
    const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
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
    document.getElementById('subtotal-display').textContent = 'R$ ' + subtotal.toFixed(2).replace('.', ',');
    document.getElementById('discount_display').value = 'R$ ' + discountAmount.toFixed(2).replace('.', ',');
    document.getElementById('total-display').textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
}

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const newRow = container.querySelector('.item-row').cloneNode(true);
    
    // Update indices
    newRow.querySelectorAll('[name]').forEach(input => {
        input.name = input.name.replace(/\[\d+\]/, '[' + itemIndex + ']');
    });
    
    // Reset values
    newRow.querySelector('.product-select').selectedIndex = 0;
    newRow.querySelector('.quantity-input').value = 1;
    newRow.querySelector('.subtotal-display').value = 'R$ 0,00';
    newRow.querySelector('.remove-item').disabled = false;
    
    container.appendChild(newRow);
    itemIndex++;
    
    // Add event listeners to new row
    newRow.querySelector('.product-select').addEventListener('change', function() {
        updateSubtotal(newRow);
    });
    newRow.querySelector('.quantity-input').addEventListener('input', function() {
        updateSubtotal(newRow);
    });
    newRow.querySelector('.remove-item').addEventListener('click', function() {
        newRow.remove();
        updateTotal();
    });
});

// Add event listeners to initial row
document.querySelectorAll('.item-row').forEach(row => {
    row.querySelector('.product-select').addEventListener('change', function() {
        updateSubtotal(row);
    });
    row.querySelector('.quantity-input').addEventListener('input', function() {
        updateSubtotal(row);
    });
});

// Event listeners para desconto
document.getElementById('discount_type').addEventListener('change', updateTotal);
document.getElementById('discount_value').addEventListener('input', updateTotal);
</script>
@endpush
