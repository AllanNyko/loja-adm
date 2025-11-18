<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0d6efd;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 11px;
        }
        .order-info {
            margin-bottom: 25px;
        }
        .order-info h2 {
            font-size: 16px;
            color: #0d6efd;
            margin-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }
        .info-item label {
            font-weight: bold;
            color: #495057;
            display: block;
            font-size: 10px;
            margin-bottom: 3px;
        }
        .info-item p {
            color: #212529;
            font-size: 12px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }
        .status-pending { background-color: #ffc107; }
        .status-approved { background-color: #0dcaf0; }
        .status-in_progress { background-color: #0d6efd; }
        .status-completed { background-color: #198754; }
        .status-cancelled { background-color: #dc3545; }
        .price-box {
            background: #198754;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }
        .price-box h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .price-box p {
            font-size: 24px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }
        .signature-section {
            margin-top: 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
        }
        .signature-box {
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ORDEM DE SERVIÇO #{{ $order->id }}</h1>
        <p>Sistema de Gerenciamento de Reparos de Celulares</p>
    </div>

    <div class="order-info">
        <h2>Informações do Cliente</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Nome do Cliente:</label>
                <p>{{ $order->customer->name }}</p>
            </div>
            <div class="info-item">
                <label>Telefone:</label>
                <p>{{ $order->customer->phone }}</p>
            </div>
            @if($order->customer->email)
            <div class="info-item">
                <label>E-mail:</label>
                <p>{{ $order->customer->email }}</p>
            </div>
            @endif
            @if($order->customer->address)
            <div class="info-item {{ $order->customer->email ? '' : 'full-width' }}">
                <label>Endereço:</label>
                <p>{{ $order->customer->address }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="order-info">
        <h2>Informações do Dispositivo</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Modelo do Dispositivo:</label>
                <p>{{ $order->device_model }}</p>
            </div>
            @if($order->device_imei)
            <div class="info-item">
                <label>IMEI:</label>
                <p>{{ $order->device_imei }}</p>
            </div>
            @endif
            <div class="info-item {{ $order->device_imei ? 'full-width' : '' }}">
                <label>Problema Relatado:</label>
                <p>{{ $order->problem_description }}</p>
            </div>
        </div>
    </div>

    <div class="order-info">
        <h2>Informações do Serviço</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Data de Entrada:</label>
                <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-item">
                <label>Status:</label>
                <p><span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span></p>
            </div>
            @if($order->deadline)
            <div class="info-item">
                <label>Prazo de Entrega:</label>
                <p>{{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}</p>
            </div>
            @endif
            @if($order->diagnostic)
            <div class="info-item {{ $order->deadline ? '' : 'full-width' }}">
                <label>Diagnóstico:</label>
                <p>{{ $order->diagnostic }}</p>
            </div>
            @endif
            @if($order->estimated_cost)
            <div class="info-item">
                <label>Custo Estimado:</label>
                <p>R$ {{ number_format($order->estimated_cost, 2, ',', '.') }}</p>
            </div>
            @endif
            @if($order->final_cost)
            <div class="info-item">
                <label>Custo Final:</label>
                <p>R$ {{ number_format($order->final_cost, 2, ',', '.') }}</p>
            </div>
            @endif
            @if($order->notes)
            <div class="info-item full-width">
                <label>Observações:</label>
                <p>{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    @if($order->price)
    <div class="price-box">
        <h3>VALOR DO SERVIÇO</h3>
        <p>R$ {{ number_format($order->price, 2, ',', '.') }}</p>
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Assinatura do Cliente
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Assinatura do Técnico
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Este documento é uma representação da ordem de serviço registrada no sistema</p>
    </div>
</body>
</html>
