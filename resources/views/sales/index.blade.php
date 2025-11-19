@extends('layouts.app')

@section('title', 'Vendas')
@section('page-title', 'Vendas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Registro de Vendas</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Venda
    </a>
</div>

<!-- Filtros -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('sales.index') }}" class="row g-3">
            <div class="col-md-3">
                <label for="date_from" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label for="payment_method" class="form-label">Método de Pagamento</label>
                <select class="form-select" id="payment_method" name="payment_method">
                    <option value="">Todos</option>
                    <option value="dinheiro" {{ request('payment_method') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                    <option value="cartao_debito" {{ request('payment_method') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                    <option value="cartao_credito" {{ request('payment_method') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                    <option value="pix" {{ request('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                    <option value="outro" {{ request('payment_method') == 'outro' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-filter"></i> Filtrar
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>
                            <a href="{{ route('sales.index', array_merge(request()->all(), ['sort' => 'total', 'direction' => request('sort') == 'total' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-dark">
                                Total
                                @if(request('sort') == 'total')
                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>Pagamento</th>
                        <th>
                            <a href="{{ route('sales.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => request('sort') == 'created_at' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                               class="text-decoration-none text-dark">
                                Data
                                @if(request('sort') == 'created_at' || !request('sort'))
                                    <i class="bi bi-arrow-{{ request('direction', 'desc') == 'asc' ? 'up' : 'down' }}"></i>
                                @else
                                    <i class="bi bi-arrow-down-up text-muted"></i>
                                @endif
                            </a>
                        </th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer?->name ?? 'Venda Comum' }}</td>
                        <td><strong>R$ {{ number_format($sale->total, 2, ',', '.') }}</strong></td>
                        <td>{{ $sale->payment_method_label }}</td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sales.export-pdf', $sale) }}" class="btn btn-warning" title="Exportar PDF">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza? O estoque será restaurado.')" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma venda encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $sales->onEachSide(1)->links() }}
    </div>
</div>
@endsection
