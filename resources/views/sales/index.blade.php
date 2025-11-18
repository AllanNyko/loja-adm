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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Pagamento</th>
                        <th>Data</th>
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
                        <td colspan="6" class="text-center">Nenhuma venda registrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $sales->links() }}
    </div>
</div>
@endsection
