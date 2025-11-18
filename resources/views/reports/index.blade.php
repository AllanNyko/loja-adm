@extends('layouts.app')

@section('title', 'Relatórios e Gráficos')
@section('page-title', 'Relatórios e Gráficos')

@section('content')
<!-- Resumo do Mês Atual -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Resumo de {{ $currentMonthSummary['month'] }}</h5>
        <form action="{{ route('reports.export-pdf') }}" method="GET" class="d-inline">
            <input type="hidden" name="month" value="{{ now()->format('Y-m') }}">
            <button type="submit" class="btn btn-danger btn-mobile">
                <i class="bi bi-file-pdf"></i> <span class="d-none d-sm-inline">Exportar PDF</span>
            </button>
        </form>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Vendas de Acessórios</h6>
                        <h3 class="text-info">R$ {{ number_format($currentMonthSummary['sales'], 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Ordens de Serviço</h6>
                        <h3 class="text-success">R$ {{ number_format($currentMonthSummary['orders'], 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h6>Faturamento Total</h6>
                        <h3>R$ {{ number_format($currentMonthSummary['sales'] + $currentMonthSummary['orders'], 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de Tendência Mensal -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-graph-up-arrow"></i> Evolução do Faturamento - {{ now()->year }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Faturamento Total (Jan - {{ now()->format('M') }}):</strong> 
                    R$ {{ number_format($monthlyTrend['totalRevenue'], 2, ',', '.') }}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="alert alert-primary mb-0">
                    <i class="bi bi-calculator"></i> 
                    <strong>Média Mensal:</strong> 
                    R$ {{ number_format($monthlyTrend['averageValue'], 2, ',', '.') }}
                </div>
            </div>
        </div>
        <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
            <canvas id="monthlyTrendChart"></canvas>
        </div>
        <p class="text-muted text-center mt-3 mb-0">
            <small>
                <i class="bi bi-lightbulb"></i> 
                A linha azul mostra o faturamento real de cada mês. A linha verde tracejada representa a média mensal.
            </small>
        </p>
    </div>
</div>

<!-- Gráfico dos Últimos 7 Dias -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-graph-up"></i> Faturamento dos Últimos 7 Dias</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <h6 class="text-center text-info mb-3">Vendas de Acessórios</h6>
                <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                    <canvas id="last7DaysSalesChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h6 class="text-center text-success mb-3">Ordens de Serviço (Concluídas)</h6>
                <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                    <canvas id="last7DaysOrdersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico dos Últimos 6 Meses -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-bar-chart-line"></i> Faturamento dos Últimos 6 Meses</h5>
```
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <h6 class="text-center text-info mb-3">Vendas de Acessórios</h6>
                <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
                    <canvas id="last6MonthsSalesChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h6 class="text-center text-success mb-3">Ordens de Serviço (Concluídas)</h6>
                <div class="chart-container" style="position: relative; height: 350px; width: 100%;">
                    <canvas id="last6MonthsOrdersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Exportar Relatório de Meses Anteriores -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-download"></i> Exportar Relatório de Outros Meses</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('reports.export-pdf') }}" method="GET" class="row g-3">
            <div class="col-12 col-md-6">
                <label for="month" class="form-label fw-bold">Selecione o Mês</label>
                <input type="month" name="month" id="month" class="form-control form-control-lg" value="{{ now()->format('Y-m') }}" required>
            </div>
            <div class="col-12 col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-danger btn-lg w-100 btn-mobile">
                    <i class="bi bi-file-pdf"></i> Exportar PDF
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de Tendência Mensal (Linha)
const ctxTrend = document.getElementById('monthlyTrendChart');
new Chart(ctxTrend, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyTrend['labels']) !!},
        datasets: [
            {
                label: 'Faturamento Mensal',
                data: {!! json_encode($monthlyTrend['revenue']) !!},
                borderColor: 'rgba(13, 110, 253, 1)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            },
            {
                label: 'Média Mensal',
                data: {!! json_encode($monthlyTrend['average']) !!},
                borderColor: 'rgba(25, 135, 84, 1)',
                backgroundColor: 'transparent',
                borderWidth: 2,
                borderDash: [10, 5],
                fill: false,
                pointRadius: 0,
                pointHoverRadius: 0
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 15
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': R$ ' + context.parsed.y.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                    }
                }
            }
        }
    }
});

// Configuração comum para os gráficos
const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function(value) {
                    return 'R$ ' + value.toFixed(2);
                }
            }
        }
    },
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            callbacks: {
                label: function(context) {
                    return 'R$ ' + context.parsed.y.toFixed(2);
                }
            }
        }
    }
};

// Gráfico de Vendas - Últimos 7 dias
const ctx7DaysSales = document.getElementById('last7DaysSalesChart');
new Chart(ctx7DaysSales, {
    type: 'bar',
    data: {
        labels: {!! json_encode($last7Days['labels']) !!},
        datasets: [{
            label: 'Vendas',
            data: {!! json_encode($last7Days['sales']) !!},
            backgroundColor: 'rgba(13, 202, 240, 0.7)',
            borderColor: 'rgba(13, 202, 240, 1)',
            borderWidth: 2
        }]
    },
    options: commonOptions
});

// Gráfico de Ordens - Últimos 7 dias
const ctx7DaysOrders = document.getElementById('last7DaysOrdersChart');
new Chart(ctx7DaysOrders, {
    type: 'bar',
    data: {
        labels: {!! json_encode($last7Days['labels']) !!},
        datasets: [{
            label: 'Ordens de Serviço',
            data: {!! json_encode($last7Days['orders']) !!},
            backgroundColor: 'rgba(25, 135, 84, 0.7)',
            borderColor: 'rgba(25, 135, 84, 1)',
            borderWidth: 2
        }]
    },
    options: commonOptions
});

// Gráfico de Vendas - Últimos 6 meses
const ctx6MonthsSales = document.getElementById('last6MonthsSalesChart');
new Chart(ctx6MonthsSales, {
    type: 'bar',
    data: {
        labels: {!! json_encode($last6Months['labels']) !!},
        datasets: [{
            label: 'Vendas',
            data: {!! json_encode($last6Months['sales']) !!},
            backgroundColor: 'rgba(13, 202, 240, 0.7)',
            borderColor: 'rgba(13, 202, 240, 1)',
            borderWidth: 2
        }]
    },
    options: commonOptions
});

// Gráfico de Ordens - Últimos 6 meses
const ctx6MonthsOrders = document.getElementById('last6MonthsOrdersChart');
new Chart(ctx6MonthsOrders, {
    type: 'bar',
    data: {
        labels: {!! json_encode($last6Months['labels']) !!},
        datasets: [{
            label: 'Ordens de Serviço',
            data: {!! json_encode($last6Months['orders']) !!},
            backgroundColor: 'rgba(25, 135, 84, 0.7)',
            borderColor: 'rgba(25, 135, 84, 1)',
            borderWidth: 2
        }]
    },
    options: commonOptions
});
</script>
@endpush
