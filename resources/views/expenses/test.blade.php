@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Teste de Despesas</h1>
    <p>Total Pendente: {{ $totalPending }}</p>
    <p>Total Pago: {{ $totalPaid }}</p>
    <p>Total Vencido: {{ $totalOverdue }}</p>
    <p>Número de despesas: {{ $expenses->count() }}</p>
</div>
@endsection
