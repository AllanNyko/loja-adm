@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-clock"></i> Aguardando</h5>
                <h2>{{ $stats['pending_orders'] }}</h2>
                <p class="card-text">Ordens pendentes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-gear"></i> Em Execução</h5>
                <h2>{{ $stats['in_progress_orders'] }}</h2>
                <p class="card-text">Ordens em andamento</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-check-circle"></i> Concluídas</h5>
                <h2>{{ $stats['completed_orders'] }}</h2>
                <p class="card-text">Ordens finalizadas</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-cash"></i> Vendas Hoje</h5>
                <h2>R$ {{ number_format($stats['total_sales_today'], 2, ',', '.') }}</h2>
                <p class="card-text">Total vendido</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-tools"></i> Ordens Recentes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Dispositivo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->device_model }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma ordem registrada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('service-orders.index') }}" class="btn btn-sm btn-primary">Ver todas</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-cart"></i> Vendas Recentes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->customer?->name ?? 'Não informado' }}</td>
                                <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma venda registrada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Ver todas</a>
            </div>
        </div>
    </div>
</div>
@endsection
