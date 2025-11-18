<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Faturamento - {{ $month }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            margin: 20px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 3px;
        }
        .summary-item h3 {
            margin: 0 0 5px 0;
            color: #666;
            font-size: 12px;
        }
        .summary-item p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .summary-item.total p {
            color: #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: bold;
            background-color: #e9ecef !important;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .chart-section {
            margin: 30px 0;
            page-break-inside: avoid;
        }
        .chart-section h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .chart-table {
            width: 100%;
            margin-top: 10px;
        }
        .chart-table th {
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📱 JD Smart Shop</h1>
        <p>Relatório de Faturamento - {{ $month }}</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <h2 style="margin-top: 0;">Resumo do Mês</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <h3>Vendas de Acessórios</h3>
                <p>R$ {{ number_format($monthTotal['sales'], 2, ',', '.') }}</p>
            </div>
            <div class="summary-item">
                <h3>Ordens de Serviço</h3>
                <p>R$ {{ number_format($monthTotal['orders'], 2, ',', '.') }}</p>
            </div>
            <div class="summary-item total">
                <h3>Faturamento Total</h3>
                <p>R$ {{ number_format($monthTotal['total'], 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <h2>Faturamento Diário do Mês</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Dia</th>
                <th>Data</th>
                <th class="text-right">Vendas</th>
                <th class="text-right">Ordens de Serviço</th>
                <th class="text-right">Total do Dia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyData as $data)
            <tr>
                <td class="text-center">{{ $data['day'] }}</td>
                <td>{{ $data['date'] }}</td>
                <td class="text-right">R$ {{ number_format($data['sales'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($data['orders'], 2, ',', '.') }}</td>
                <td class="text-right"><strong>R$ {{ number_format($data['total'], 2, ',', '.') }}</strong></td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL DO MÊS:</td>
                <td class="text-right">R$ {{ number_format($monthTotal['sales'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($monthTotal['orders'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($monthTotal['total'], 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="chart-section">
        <h2>Faturamento dos Últimos 6 Meses</h2>
        <table class="chart-table">
            <thead>
                <tr>
                    <th>Mês</th>
                    <th class="text-right">Vendas</th>
                    <th class="text-right">Ordens de Serviço</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($last6Months['labels'] as $index => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td class="text-right">R$ {{ number_format($last6Months['sales'][$index], 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($last6Months['orders'][$index], 2, ',', '.') }}</td>
                    <td class="text-right"><strong>R$ {{ number_format($last6Months['sales'][$index] + $last6Months['orders'][$index], 2, ',', '.') }}</strong></td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td class="text-right">TOTAL (6 meses):</td>
                    <td class="text-right">R$ {{ number_format(array_sum($last6Months['sales']), 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format(array_sum($last6Months['orders']), 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format(array_sum($last6Months['sales']) + array_sum($last6Months['orders']), 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>JD Smart - Sistema de Gestão</p>
        <p>Este documento foi gerado automaticamente pelo sistema</p>
    </div>
</body>
</html>
