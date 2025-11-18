@extends('layouts.app')

@section('title', 'Venda #' . $sale->id)
@section('page-title', 'Venda #' . $sale->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Detalhes da Venda</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong><br>
                        {{ $sale->customer?->name ?? 'Venda sem cadastro' }}
                        @if($sale->customer)
                            <br><small class="text-muted">{{ $sale->customer->phone }}</small>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Forma de Pagamento:</strong><br>
                        {{ $sale->payment_method_label }}
                    </div>
                </div>

                <h6>Itens Vendidos:</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Qtd.</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>R$ {{ number_format($sale->total, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($sale->notes)
                <div class="mb-3">
                    <strong>Observações:</strong>
                    <p class="mt-1">{{ $sale->notes }}</p>
                </div>
                @endif

                <div class="text-muted">
                    <small>
                        Data da venda: {{ $sale->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
