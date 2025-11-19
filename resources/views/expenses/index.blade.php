@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2><i class="bi bi-wallet2"></i> Despesas</h2>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Despesa
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cards de Resumo -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pendentes</h6>
                            <h3 class="mb-0">R$ {{ number_format($totalPending, 2, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Pagas</h6>
                            <h3 class="mb-0">R$ {{ number_format($totalPaid, 2, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Vencidas</h6>
                            <h3 class="mb-0">R$ {{ number_format($totalOverdue, 2, ',', '.') }}</h3>
                        </div>
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('expenses.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Pago</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Vencido</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Categoria</label>
                    <select name="category" class="form-select">
                        <option value="">Todas</option>
                        <option value="utilities" {{ request('category') == 'utilities' ? 'selected' : '' }}>Utilidades</option>
                        <option value="internet" {{ request('category') == 'internet' ? 'selected' : '' }}>Internet/Telefone</option>
                        <option value="rent" {{ request('category') == 'rent' ? 'selected' : '' }}>Aluguel</option>
                        <option value="supplies" {{ request('category') == 'supplies' ? 'selected' : '' }}>Insumos</option>
                        <option value="equipment" {{ request('category') == 'equipment' ? 'selected' : '' }}>Equipamentos</option>
                        <option value="salary" {{ request('category') == 'salary' ? 'selected' : '' }}>Salários</option>
                        <option value="taxes" {{ request('category') == 'taxes' ? 'selected' : '' }}>Impostos</option>
                        <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="maintenance" {{ request('category') == 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                        <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Outros</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Data Inicial</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Data Final</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Despesas -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>#{{ $expense->id }}</td>
                                <td>{{ $expense->description }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $expense->category_name }}</span>
                                </td>
                                <td class="fw-bold">R$ {{ number_format($expense->amount, 2, ',', '.') }}</td>
                                <td>
                                    @if($expense->due_date)
                                        {{ $expense->due_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($expense->status)
                                        @case('pending')
                                            <span class="badge bg-warning">{{ $expense->status_name }}</span>
                                            @break
                                        @case('paid')
                                            <span class="badge bg-success">{{ $expense->status_name }}</span>
                                            @break
                                        @case('overdue')
                                            <span class="badge bg-danger">{{ $expense->status_name }}</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-secondary">{{ $expense->status_name }}</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('expenses.edit', $expense) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta despesa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mt-2">Nenhuma despesa cadastrada</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $expenses->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
