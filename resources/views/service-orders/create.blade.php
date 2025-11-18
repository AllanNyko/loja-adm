@extends('layouts.app')

@section('title', 'Nova Ordem de Serviço')
@section('page-title', 'Nova Ordem de Serviço')

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 col-xl-8 mx-auto">
        <div class="card">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('service-orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="customer_id" class="form-label fw-bold">Cliente *</label>
                        <select name="customer_id" id="customer_id" class="form-select form-select-lg @error('customer_id') is-invalid @enderror" required>
                            <option value="">Selecione...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            Não encontrou? <a href="{{ route('customers.create') }}" target="_blank">Cadastre um novo cliente</a>
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-8 mb-3">
                            <label for="device_model" class="form-label fw-bold">Modelo do Dispositivo *</label>
                            <input type="text" name="device_model" id="device_model" class="form-control form-control-lg @error('device_model') is-invalid @enderror" value="{{ old('device_model') }}" required placeholder="Ex: iPhone 13, Galaxy A32">
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <label for="device_imei" class="form-label fw-bold">IMEI</label>
                            <input type="text" name="device_imei" id="device_imei" class="form-control form-control-lg @error('device_imei') is-invalid @enderror" value="{{ old('device_imei') }}" placeholder="Opcional">
                            @error('device_imei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="problem_description" class="form-label fw-bold">Descrição do Problema *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="form-control form-control-lg @error('problem_description') is-invalid @enderror" required placeholder="Descreva o problema relatado pelo cliente">{{ old('problem_description') }}</textarea>
                        @error('problem_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-bold">Valor do Serviço *</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', '0.00') }}" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diagnostic" class="form-label fw-bold">Diagnóstico Técnico</label>
                        <textarea name="diagnostic" id="diagnostic" rows="3" class="form-control form-control-lg @error('diagnostic') is-invalid @enderror" placeholder="Opcional - Diagnóstico após análise">{{ old('diagnostic') }}</textarea>
                        @error('diagnostic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="estimated_cost" class="form-label fw-bold">Custo Estimado</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">R$</span>
                                <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost') }}" placeholder="0.00">
                            </div>
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="deadline" class="form-label fw-bold">Prazo de Entrega</label>
                            <input type="date" name="deadline" id="deadline" class="form-control form-control-lg @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-bold">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control form-control-lg @error('notes') is-invalid @enderror" placeholder="Informações adicionais">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid d-md-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg btn-mobile">
                            <i class="bi bi-save"></i> Salvar Ordem
                        </button>
                        <a href="{{ route('service-orders.index') }}" class="btn btn-secondary btn-lg btn-mobile">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
