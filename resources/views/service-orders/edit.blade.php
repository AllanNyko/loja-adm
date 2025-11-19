@extends('layouts.app')

@section('title', 'Editar Ordem #' . $serviceOrder->id)
@section('page-title', 'Editar Ordem de Serviço #' . $serviceOrder->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('service-orders.update', $serviceOrder) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Cliente *</label>
                        <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        {{ old('customer_id', $serviceOrder->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="customer_document" class="form-label">CPF/CNPJ do Cliente *</label>
                        <input type="text" name="customer_document" id="customer_document" 
                               class="form-control @error('customer_document') is-invalid @enderror" 
                               value="{{ old('customer_document', $serviceOrder->customer_document) }}" 
                               placeholder="000.000.000-00 ou 00.000.000/0000-00" 
                               required 
                               maxlength="20">
                        @error('customer_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">CPF ou CNPJ do cliente para vinculação jurídica do aparelho</small>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="device_model" class="form-label">Modelo do Dispositivo *</label>
                            <input type="text" name="device_model" id="device_model" class="form-control @error('device_model') is-invalid @enderror" value="{{ old('device_model', $serviceOrder->device_model) }}" required>
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="device_imei" class="form-label">IMEI</label>
                            <input type="text" name="device_imei" id="device_imei" class="form-control @error('device_imei') is-invalid @enderror" value="{{ old('device_imei', $serviceOrder->device_imei) }}">
                            @error('device_imei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="problem_description" class="form-label">Descrição do Problema *</label>
                        <textarea name="problem_description" id="problem_description" rows="4" class="form-control @error('problem_description') is-invalid @enderror" required>{{ old('problem_description', $serviceOrder->problem_description) }}</textarea>
                        @error('problem_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Valor do Serviço *</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $serviceOrder->price) }}" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diagnostic" class="form-label">Diagnóstico Técnico</label>
                        <textarea name="diagnostic" id="diagnostic" rows="3" class="form-control @error('diagnostic') is-invalid @enderror">{{ old('diagnostic', $serviceOrder->diagnostic) }}</textarea>
                        @error('diagnostic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="estimated_cost" class="form-label">Custo Estimado</label>
                            <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control @error('estimated_cost') is-invalid @enderror" value="{{ old('estimated_cost', $serviceOrder->estimated_cost) }}">
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="final_cost" class="form-label">Custo Final</label>
                            <input type="number" step="0.01" name="final_cost" id="final_cost" class="form-control @error('final_cost') is-invalid @enderror" value="{{ old('final_cost', $serviceOrder->final_cost) }}">
                            @error('final_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="deadline" class="form-label">Prazo de Entrega</label>
                            <input type="date" name="deadline" id="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', $serviceOrder->deadline?->format('Y-m-d')) }}">
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $serviceOrder->status) == 'pending' ? 'selected' : '' }}>Aguardando Aprovação</option>
                            <option value="approved" {{ old('status', $serviceOrder->status) == 'approved' ? 'selected' : '' }}>Aprovada</option>
                            <option value="in_progress" {{ old('status', $serviceOrder->status) == 'in_progress' ? 'selected' : '' }}>Em Execução</option>
                            <option value="completed" {{ old('status', $serviceOrder->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                            <option value="cancelled" {{ old('status', $serviceOrder->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Observações</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $serviceOrder->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Atualizar
                        </button>
                        <a href="{{ route('service-orders.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

