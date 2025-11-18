@extends('layouts.app')

@section('title', 'Ordens de Serviço')
@section('page-title', 'Ordens de Serviço')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 d-none d-md-block">Ordens de Serviço</h4>
    <a href="{{ route('service-orders.create') }}" class="btn btn-primary btn-mobile w-100 w-md-auto">
        <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Nova Ordem</span>
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-9 col-md-3">
                <select name="status" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Aguardando</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprovada</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em Execução</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
            <div class="col-3 col-md-2">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel d-md-none"></i>
                    <span class="d-none d-md-inline">Filtrar</span>
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th class="px-2">#</th>
                        <th>Cliente</th>
                        <th class="d-none d-lg-table-cell">Dispositivo</th>
                        <th class="d-none d-xl-table-cell">Problema</th>
                        <th class="d-none d-md-table-cell">Data Entrada</th>
                        <th class="d-none d-md-table-cell">Finalização</th>
                        <th>Status</th>
                        <th class="d-none d-lg-table-cell">Valor</th>
                        <th class="text-end px-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceOrders as $order)
                    <tr>
                        <td class="px-2">{{ $order->id }}</td>
                        <td>
                            <div>{{ Str::limit($order->customer->name, 20) }}</div>
                            <small class="text-muted d-lg-none">{{ Str::limit($order->device_model, 18) }}</small>
                        </td>
                        <td class="d-none d-lg-table-cell">{{ $order->device_model }}</td>
                        <td class="d-none d-xl-table-cell" title="{{ $order->problem_description }}">
                            {{ Str::limit($order->problem_description, 40) }}
                        </td>
                        <td class="d-none d-md-table-cell">
                            <small>{{ $order->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($order->status === 'completed' && $order->updated_at)
                                <small class="text-success">{{ $order->updated_at->format('d/m/Y') }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status_color }}" style="font-size: 0.7rem;">
                                <span class="d-none d-md-inline">{{ $order->status_label }}</span>
                                <span class="d-md-none">{{ substr($order->status_label, 0, 3) }}</span>
                            </span>
                        </td>
                        <td class="d-none d-lg-table-cell">R$ {{ number_format($order->price ?? 0, 2, ',', '.') }}</td>
                        <td class="text-end px-2">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('service-orders.show', $order) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('service-orders.edit', $order) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('service-orders.export-pdf', $order) }}" class="btn btn-danger btn-sm" title="Exportar PDF">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">Nenhuma ordem encontrada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $serviceOrders->links() }}
        </div>
    </div>
</div>
@endsection

