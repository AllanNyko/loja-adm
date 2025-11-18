@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Cards de Resumo -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body p-3">
                <h6 class="card-title"><i class="bi bi-clock"></i> Aguardando</h6>
                <h3 class="mb-0">{{ $stats['pending_orders'] }}</h3>
                <small class="d-none d-md-block">Ordens pendentes</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body p-3">
                <h6 class="card-title"><i class="bi bi-gear"></i> Em Execução</h6>
                <h3 class="mb-0">{{ $stats['in_progress_orders'] }}</h3>
                <small class="d-none d-md-block">Ordens em andamento</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body p-3">
                <h6 class="card-title"><i class="bi bi-check-circle"></i> Concluídas</h6>
                <h3 class="mb-0">{{ $stats['completed_orders'] }}</h3>
                <small class="d-none d-md-block">Ordens finalizadas</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-white bg-danger h-100">
            <div class="card-body p-3">
                <h6 class="card-title"><i class="bi bi-exclamation-triangle"></i> Estoque Baixo</h6>
                <h3 class="mb-0">{{ $stats['low_stock_products'] }}</h3>
                <small class="d-none d-md-block">Produtos com estoque < 5</small>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Faturamento -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card text-white bg-info h-100">
            <div class="card-body p-3 p-md-4">
                <h5 class="card-title"><i class="bi bi-cash-stack"></i> Faturamento Hoje</h5>
                <h2 class="mb-0">R$ {{ number_format($stats['total_sales_today'], 2, ',', '.') }}</h2>
                <small>Vendas + Ordens de Serviço</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card text-white bg-dark h-100">
            <div class="card-body p-3 p-md-4">
                <h5 class="card-title"><i class="bi bi-calendar-month"></i> Faturamento do Mês</h5>
                <h2 class="mb-0">R$ {{ number_format($stats['total_sales_month'], 2, ',', '.') }}</h2>
                <small>Total em {{ now()->format('m/Y') }}</small>
                <hr class="my-2" style="border-color: rgba(255, 255, 255, 0.3);">
                <div class="mt-2">
                    @if($stats['difference_from_average'] > 0)
                        <div class="d-flex align-items-center">
                            <i class="bi bi-arrow-up-circle-fill text-success me-2" style="font-size: 1.2rem;"></i>
                            <div>
                                <strong class="text-success">R$ {{ number_format(abs($stats['difference_from_average']), 2, ',', '.') }}</strong>
                                <span class="d-block" style="font-size: 0.85rem;">acima da média mensal</span>
                            </div>
                        </div>
                    @elseif($stats['difference_from_average'] < 0)
                        <div class="d-flex align-items-center">
                            <i class="bi bi-arrow-down-circle-fill text-warning me-2" style="font-size: 1.2rem;"></i>
                            <div>
                                <strong class="text-warning">R$ {{ number_format(abs($stats['difference_from_average']), 2, ',', '.') }}</strong>
                                <span class="d-block" style="font-size: 0.85rem;">abaixo da média mensal</span>
                            </div>
                        </div>
                    @else
                        <div class="d-flex align-items-center">
                            <i class="bi bi-dash-circle-fill text-light me-2" style="font-size: 1.2rem;"></i>
                            <div>
                                <strong>Na média!</strong>
                                <span class="d-block" style="font-size: 0.85rem;">Exatamente na média mensal</span>
                            </div>
                        </div>
                    @endif
                    <small class="d-block mt-1 text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-info-circle"></i> Média: R$ {{ number_format($stats['monthly_average'], 2, ',', '.') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botão para Relatórios -->
<div class="mb-4">
    <a href="{{ route('reports.index') }}" class="btn btn-primary btn-lg w-100 w-md-auto">
        <i class="bi bi-graph-up"></i> Ver Gráficos e Relatórios Detalhados
    </a>
</div>

<!-- Tabelas de Itens Recentes -->
<div class="row g-3">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-tools"></i> Ordens Recentes</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Cliente</th>
                                <th class="d-none d-md-table-cell">Dispositivo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-3">{{ $order->id }}</td>
                                <td>{{ Str::limit($order->customer->name, 15) }}</td>
                                <td class="d-none d-md-table-cell">{{ Str::limit($order->device_model, 20) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }} d-none d-md-inline">
                                        {{ $order->status_label }}
                                    </span>
                                    <span class="badge bg-{{ $order->status_color }} d-md-none" style="font-size: 0.7rem;">
                                        {{ Str::limit($order->status_label, 8) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">Nenhuma ordem registrada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    <a href="{{ route('service-orders.index') }}" class="btn btn-sm btn-primary w-100 w-md-auto">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-cart"></i> Vendas Recentes</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th class="px-3">#</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th class="d-none d-md-table-cell">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td class="px-3">{{ $sale->id }}</td>
                                <td>{{ Str::limit($sale->customer?->name ?? 'N/I', 15) }}</td>
                                <td class="fw-bold">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                                <td class="d-none d-md-table-cell">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">Nenhuma venda registrada</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary w-100 w-md-auto">
                        Ver todas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
