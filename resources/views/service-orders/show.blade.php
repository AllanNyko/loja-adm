@extends('layouts.app')

@section('title', 'Ordem #' . $serviceOrder->id)
@section('page-title', 'Ordem de Serviço #' . $serviceOrder->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Detalhes da Ordem</h5>
                <span class="badge bg-{{ $serviceOrder->status_color }} fs-6">
                    {{ $serviceOrder->status_label }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong><br>
                        {{ $serviceOrder->customer->name }}<br>
                        <small class="text-muted">{{ $serviceOrder->customer->phone }}</small>
                    </div>
                    <div class="col-md-6">
                        <strong>CPF/CNPJ:</strong><br>
                        {{ $serviceOrder->customer_document ?? 'Não informado' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Dispositivo:</strong><br>
                        {{ $serviceOrder->device_model }}
                        @if($serviceOrder->device_imei)
                            <br><small class="text-muted">IMEI: {{ $serviceOrder->device_imei }}</small>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Problema Relatado:</strong>
                    <p class="mt-1">{{ $serviceOrder->problem_description }}</p>
                </div>

                @if($serviceOrder->diagnostic)
                <div class="mb-3">
                    <strong>Diagnóstico Técnico:</strong>
                    <p class="mt-1">{{ $serviceOrder->diagnostic }}</p>
                </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Custo Estimado:</strong><br>
                        R$ {{ number_format($serviceOrder->estimated_cost ?? 0, 2, ',', '.') }}
                    </div>
                    @if($serviceOrder->final_cost)
                    <div class="col-md-4">
                        <strong>Custo Final:</strong><br>
                        R$ {{ number_format($serviceOrder->final_cost, 2, ',', '.') }}
                    </div>
                    @endif
                    <div class="col-md-4">
                        <strong>Prazo:</strong><br>
                        {{ $serviceOrder->deadline?->format('d/m/Y') ?? 'Não definido' }}
                    </div>
                </div>

                @if($serviceOrder->notes)
                <div class="mb-3">
                    <strong>Observações:</strong>
                    <p class="mt-1">{{ $serviceOrder->notes }}</p>
                </div>
                @endif

                <div class="text-muted">
                    <small>
                        Criada em: {{ $serviceOrder->created_at->format('d/m/Y H:i') }}<br>
                        Última atualização: {{ $serviceOrder->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('service-orders.edit', $serviceOrder) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="{{ route('service-orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
