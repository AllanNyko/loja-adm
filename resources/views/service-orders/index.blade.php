@extends('layouts.app')

@section('title', 'Ordens de Serviço')
@section('page-title', 'Ordens de Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Ordens de Serviço</h2>
    <a href="{{ route('service-orders.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Ordem
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Aguardando</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovada</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em Execução</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filtrar</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Dispositivo</th>
                        <th>Problema</th>
                        <th>Status</th>
                        <th>Valor</th>
                        <th>Prazo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->device_model }}</td>
                        <td>{{ Str::limit($order->problem_description, 50) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($order->final_cost ?? $order->estimated_cost ?? 0, 2, ',', '.') }}</td>
                        <td>{{ $order->deadline?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('service-orders.show', $order) }}" class="btn btn-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('service-orders.edit', $order) }}" class="btn btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('service-orders.destroy', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Nenhuma ordem de serviço encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $serviceOrders->links() }}
    </div>
</div>
@endsection
