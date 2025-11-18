<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Venda #{{ $sale->id }}</title>
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
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header h1 .jd {
            color: #000;
            font-weight: 900;
        }
        .header h1 .smart {
            color: #FFD700;
            font-weight: 900;
        }
        .header p {
            color: #333;
            font-size: 11px;
        }
        .header .contact-info {
            margin-top: 10px;
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }
        .sale-info {
            margin-bottom: 25px;
        }
        .sale-info h2 {
            font-size: 16px;
            color: #000;
            font-weight: bold;
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
            color: #000;
            display: block;
            font-size: 10px;
            margin-bottom: 3px;
        }
        .info-item p {
            color: #333;
            font-size: 12px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table thead {
            background-color: #333;
            color: white;
        }
        .items-table th {
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e9ecef;
            font-size: 11px;
        }
        .items-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .items-table tfoot td {
            padding: 10px;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-box {
            background: #0d6efd;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
        }
        .total-box h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .total-box p {
            font-size: 28px;
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
        .payment-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            color: white;
            background-color: #198754;
        }
        .discount-row {
            color: #dc3545;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 50px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin: 60px auto 0;
            padding-top: 5px;
            font-size: 11px;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><span class="jd">JD</span> <span class="smart">SMART</span></h1>
        <p>Reparos de Celular e Acessórios</p>
        <div class="contact-info">
            <strong>Endereço:</strong> Av. Pérsio de Queirós Filho, 919 - Catiapoã, São Vicente - SP, 11370-304<br>
            <strong>Telefone:</strong> (13) 99784-1161
        </div>
        <h2 style="margin-top: 15px; color: #000; font-weight: bold;">COMPROVANTE DE VENDA #{{ $sale->id }}</h2>
    </div>

    <div class="sale-info">
        <h2>Informações da Venda</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Data da Venda:</label>
                <p>{{ $sale->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-item">
                <label>Forma de Pagamento:</label>
                <p>
                    <span class="">
                        @switch($sale->payment_method)
                            @case('dinheiro') Dinheiro @break
                            @case('cartao_debito') Cartão de Débito @break
                            @case('cartao_credito') Cartão de Crédito @break
                            @case('pix') PIX @break
                            @default {{ $sale->payment_method }} @break
                        @endswitch
                    </span>
                </p>
            </div>
            @if($sale->customer)
            <div class="info-item">
                <label>Cliente:</label>
                <p>{{ $sale->customer->name }}</p>
            </div>
            <div class="info-item">
                <label>Telefone:</label>
                <p>{{ $sale->customer->phone }}</p>
            </div>
            @if($sale->customer->email)
            <div class="info-item">
                <label>E-mail:</label>
                <p>{{ $sale->customer->email }}</p>
            </div>
            @endif
            @endif
            @if($sale->notes)
            <div class="info-item full-width">
                <label>Observações:</label>
                <p>{{ $sale->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="sale-info">
        <h2>Itens da Venda</h2>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-center">Quantidade</th>
                    <th class="text-right">Valor Unit.</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">Subtotal:</td>
                    <td class="text-right">R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</td>
                </tr>
                @if($sale->discount_amount > 0)
                <tr class="discount-row">
                    <td colspan="3" class="text-right">
                        Desconto ({{ number_format($sale->discount_percentage, 2, ',', '.') }}%):
                    </td>
                    <td class="text-right">- R$ {{ number_format($sale->discount_amount, 2, ',', '.') }}</td>
                </tr>
                @endif
                <tr style="background-color: #198754; color: white;">
                    <td colspan="3" class="text-right" style="font-size: 14px;">TOTAL:</td>
                    <td class="text-right" style="font-size: 16px;">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="total-box">
        <h3>VALOR TOTAL PAGO</h3>
        <p>R$ {{ number_format($sale->total, 2, ',', '.') }}</p>
    </div>

    @if($sale->customer)
    <div class="signature-section">
        <div class="signature-line">
            {{ $sale->customer->name }}<br>
            Assinatura do Cliente
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Este comprovante é válido como recibo de venda</p>
        <p><strong>JD Smart</strong> - Sistema de Gerenciamento de Reparos e Vendas</p>
    </div>
</body>
</html>
