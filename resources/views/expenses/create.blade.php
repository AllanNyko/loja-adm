@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="bi bi-plus-circle"></i> Nova Despesa</h2>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="description" class="form-label">Descrição <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('description') is-invalid @enderror" 
                                       id="description" 
                                       name="description" 
                                       value="{{ old('description') }}" 
                                       required
                                       placeholder="Ex: Conta de Luz - Janeiro 2025">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="amount" class="form-label">Valor (R$) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" 
                                       name="amount" 
                                       value="{{ old('amount') }}" 
                                       step="0.01" 
                                       min="0"
                                       required
                                       placeholder="0,00">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Categoria <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category" 
                                        required>
                                    <option value="">Selecione...</option>
                                    <option value="utilities" {{ old('category') == 'utilities' ? 'selected' : '' }}>Utilidades (Luz, Água, Gás)</option>
                                    <option value="internet" {{ old('category') == 'internet' ? 'selected' : '' }}>Internet/Telefone</option>
                                    <option value="rent" {{ old('category') == 'rent' ? 'selected' : '' }}>Aluguel</option>
                                    <option value="supplies" {{ old('category') == 'supplies' ? 'selected' : '' }}>Insumos/Materiais</option>
                                    <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>Equipamentos</option>
                                    <option value="salary" {{ old('category') == 'salary' ? 'selected' : '' }}>Salários</option>
                                    <option value="taxes" {{ old('category') == 'taxes' ? 'selected' : '' }}>Impostos</option>
                                    <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>Marketing/Publicidade</option>
                                    <option value="maintenance" {{ old('category') == 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Outros</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Pago</option>
                                    <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Vencido</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="due_date" class="form-label">Data de Vencimento</label>
                                <input type="date" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       id="due_date" 
                                       name="due_date" 
                                       value="{{ old('due_date') }}">
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="paid_date" class="form-label">Data de Pagamento</label>
                                <input type="date" 
                                       class="form-control @error('paid_date') is-invalid @enderror" 
                                       id="paid_date" 
                                       name="paid_date" 
                                       value="{{ old('paid_date') }}">
                                @error('paid_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Preencha apenas se a despesa já foi paga</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Método de Pagamento</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" 
                                    name="payment_method">
                                <option value="">Não informado</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Dinheiro</option>
                                <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Cartão de Débito</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Cartão de Crédito</option>
                                <option value="pix" {{ old('payment_method') == 'pix' ? 'selected' : '' }}>PIX</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transferência Bancária</option>
                                <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3" 
                                      placeholder="Informações adicionais sobre a despesa...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Cadastrar Despesa
                            </button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle"></i> Informações</h5>
                    <p class="card-text"><small>
                        <strong>Categorias disponíveis:</strong><br>
                        • Utilidades: Contas de luz, água, gás<br>
                        • Internet/Telefone: Provedores de internet e telefonia<br>
                        • Aluguel: Pagamento de aluguel do imóvel<br>
                        • Insumos: Materiais de trabalho e consumo<br>
                        • Equipamentos: Compra ou manutenção de equipamentos<br>
                        • Salários: Folha de pagamento<br>
                        • Impostos: Tributos e taxas governamentais<br>
                        • Marketing: Publicidade e propaganda<br>
                        • Manutenção: Reparos e manutenções diversas<br>
                        • Outros: Outras despesas não categorizadas
                    </small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
