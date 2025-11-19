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

                <hr>
                
                <!-- Detalhamento de Valores -->
                <div class="mb-3">
                    <strong>Valores do Serviço:</strong>
                    <table class="table table-sm mt-2">
                        <tr>
                            <td>Mão de Obra:</td>
                            <td class="text-end">R$ {{ number_format($serviceOrder->price ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        @if($serviceOrder->parts_cost && $serviceOrder->parts_cost > 0)
                        <tr>
                            <td>Peças:</td>
                            <td class="text-end">R$ {{ number_format($serviceOrder->parts_cost, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if($serviceOrder->extra_cost_value && $serviceOrder->extra_cost_value > 0)
                        <tr>
                            <td>{{ ucfirst($serviceOrder->extra_cost_type ?? 'Custo Extra') }}:</td>
                            <td class="text-end">R$ {{ number_format($serviceOrder->extra_cost_value, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        @php
                            $subtotal = ($serviceOrder->price ?? 0) + ($serviceOrder->parts_cost ?? 0) + ($serviceOrder->extra_cost_value ?? 0);
                            $discountAmount = 0;
                            if ($serviceOrder->discount_value > 0) {
                                if ($serviceOrder->discount_type === 'percentage') {
                                    $discountAmount = ($subtotal * $serviceOrder->discount_value) / 100;
                                } else {
                                    $discountAmount = $serviceOrder->discount_value;
                                }
                            }
                        @endphp
                        @if($discountAmount > 0)
                        <tr>
                            <td colspan="2"><hr class="my-1"></td>
                        </tr>
                        <tr>
                            <td>Subtotal:</td>
                            <td class="text-end">R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="text-danger">
                            <td>Desconto ({{ $serviceOrder->discount_type === 'percentage' ? $serviceOrder->discount_value . '%' : 'R$ ' . number_format($serviceOrder->discount_value, 2, ',', '.') }}):</td>
                            <td class="text-end">- R$ {{ number_format($discountAmount, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2"><hr class="my-1"></td>
                        </tr>
                        <tr class="fw-bold fs-5">
                            <td>Total a Pagar:</td>
                            <td class="text-end text-primary">R$ {{ number_format($serviceOrder->final_cost ?? ($subtotal - $discountAmount), 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Prazo de Entrega:</strong><br>
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
