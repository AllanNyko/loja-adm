@extends('layouts.app')

@section('title', 'Nova Ordem de Serviço')
@section('page-title', 'Nova Ordem de Serviço')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('service-orders.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Cliente *</label>
                        <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
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
                        <small class="text-muted">
                            Não encontrou? <a href="{{ route('customers.create') }}" target="_blank">Cadastre um novo cliente</a>
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="device_model" class="form-label">Modelo do Dispositivo *</label>
                            <input type="text" name="device_model" id="device_model" class="form-control @error('device_model') is-invalid @enderror" value="{{ old('device_model') }}" required>
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="device_imei" class="form-label">IMEI</label>
                            <input type="text" name="device_imei" id="device_imei" class="form-control @error('device_imei') is-invalid @enderror" value="{{ old('device_imei') }}">
                            @error('device_imei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="problem_description" class="form-label">Descrição do Problema *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="form-control @error('problem_description') is-invalid @enderror" required>{{ old('problem_description') }}</textarea>
                        @error('problem_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diagnostic" class="form-label">Diagnóstico Técnico</label>
                        <textarea name="diagnostic" id="diagnostic" rows="3" class="form-control @error('diagnostic') is-invalid @enderror">{{ old('diagnostic') }}</textarea>
                        @error('diagnostic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="estimated_cost" class="form-label">Custo Estimado</label>
                            <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost') }}">
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="deadline" class="form-label">Prazo de Entrega</label>
                            <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Ordem
                        </button>
                        <a href="{{ route('service-orders.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
