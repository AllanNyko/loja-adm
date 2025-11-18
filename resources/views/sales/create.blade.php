@extends('layouts.app')

@section('title', 'Nova Venda')
@section('page-title', 'Nova Venda')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Cliente (Opcional)</label>
                            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
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

                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Forma de Pagamento *</label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
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

                    <h5>Itens da Venda</h5>
                    <div id="items-container">
                        <div class="row mb-2 item-row">
                            <div class="col-md-6">
                                <label class="form-label">Produto *</label>
                                <select name="items[0][product_id]" class="form-select product-select" required>
                                    <option value="">Selecione...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }} (Estoque: {{ $product->stock }}) - R$ {{ number_format($product->price, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantidade *</label>
                                <input type="number" name="items[0][quantity]" class="form-control quantity-input" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control subtotal-display" readonly value="R$ 0,00">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item" disabled>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-item">
                        <i class="bi bi-plus"></i> Adicionar Item
                    </button>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Total da Venda</label>
                            <h3 class="text-success" id="total-display">R$ 0,00</h3>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Registrar Venda
                        </button>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancelar</a>
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
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        total += price * quantity;
    });
    
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
</script>
@endpush
