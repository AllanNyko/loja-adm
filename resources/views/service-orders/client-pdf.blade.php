<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de Serviço #{{ $order->id }} - Cliente</title>
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
            color: #000;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
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
            color: #000;
            font-size: 11px;
        }

        .header .contact-info {
            margin-top: 10px;
            font-size: 10px;
            color: #000;
            line-height: 1.4;
        }

        .order-info {
            margin-bottom: 25px;
        }

        .order-info h2 {
            font-size: 12px;
            color: #000;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .info-item {
            padding: 10px;
        }

        .info-item label {
            font-weight: bold;
            color: #000;
            display: block;
            font-size: 10px;
            margin-bottom: 3px;
        }

        .info-item p {
            color: #000;
            font-size: 12px;
        }

        .info-item-inline {
            padding: 10px;
        }

        .info-item-inline label {
            font-weight: bold;
            color: #000;
            display: inline;
            font-size: 10px;
            margin-right: 5px;
        }

        .info-item-inline span {
            color: #000;
            font-size: 12px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .payment-summary {
            border: 2px solid #000;
            padding: 20px;
            margin-top: 25px;
        }

        .payment-summary h2 {
            font-size: 16px;
            color: #000;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        /*  .payment-line {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #000;
        }
        .payment-line:last-child {
            border-bottom: none;
        }
        .payment-line.total {
            border-top: 2px solid #000;s
            margin-top: 10px;
            padding-top: 15px;
            font-size: 16px;
            font-weight: bold;
        }
       .payment-line.discount {
            color: #000;
            font-weight: bold;
        } */
        .payment-label {
            font-weight: 600;
            color: #000;
        }

        .payment-value {
            font-weight: bold;
            color: #000;
        }

        .total-box {
            border: 2px solid #000;
            padding: 15px 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-box h3 {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .total-box p {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .warranty-section {
            border: 2px solid #000;
            padding: 20px;
            margin-top: 30px;
            page-break-before: always;
        }

        .warranty-section h2 {
            color: #000;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .warranty-section h3 {
            color: #000;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        .warranty-section p,
        .warranty-section ul {
            font-size: 11px;
            margin-bottom: 10px;
            line-height: 1.8;
            color: #000;
        }

        .warranty-section ul {
            margin-left: 20px;
        }

        .warranty-section li {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #000;
            text-align: center;
            font-size: 10px;
            color: #000;
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
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
            font-size: 11px;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1><span class="jd">JD</span> <span class="smart">SMART</span></h1>
        <p>Reparos de Celular e Acessórios</p>
        <div class="contact-info">
            <strong>Endereço:</strong> Av. Pérsio de Queirós Filho, 919 - Catiapoã, São Vicente - SP, 11370-304 | <strong>Telefone:</strong> (13) 99784-1161
        </div>
        <h2 style="margin-top: 15px; color: #000; font-weight: bold;">ORDEM DE SERVIÇO #{{ $order->id }}</h2>
    </div>

    <div class="order-info">
        <h2>Informações do Cliente</h2>
        <div class="info-grid">
            <div class="info-item-inline full-width">
                <label>Nome do Cliente:</label>
                <span>{{ $order->customer->name }}</span>
                <label style="margin-left: 20px;">CPF/CNPJ:</label>
                <span>{{ $order->customer_document ?? 'Não informado' }}</span>
            </div>
            <div class="info-item-inline full-width">
                <label>Telefone:</label>
                <span>{{ $order->customer->phone }}</span>
                @if($order->customer->email)
                <label style="margin-left: 20px;">E-mail:</label>
                <span>{{ $order->customer->email }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="order-info">
        <h2>Informações do Dispositivo</h2>
        <div class="info-grid">
            <div class="info-item-inline full-width">
                <label>Modelo do Dispositivo:</label>
                <span>{{ $order->device_model }}</span>
                @if($order->device_imei)
                <label style="margin-left: 20px;">IMEI:</label>
                <span>{{ $order->device_imei }}</span>
                @endif
            </div>
            <div class="info-item full-width">
                <label>Problema Relatado:</label>
                <p>{{ $order->problem_description }}</p>
            </div>
        </div>
    </div>

    <!-- Problemas Documentados com Fotos -->
    @if($order->problems_photos && count($order->problems_photos) > 0)
    <div class="order-info" style="page-break-inside: avoid;">
        <h2>Avaliação técnica inicial</h2>

        @foreach($order->problems_photos as $index => $problem)
        <div style="margin-bottom: 10px; border: 1px solid #000; padding: 8px; background: #fff;">
            <p style="font-size: 11px; margin: 0; font-weight: bold;">
                {{ ($index + 1) }}. {{ $problem['description'] ?? 'Problema ' . ($index + 1) }}
            </p>
            <p style="font-size: 9px; margin: 3px 0 0 0; color: #666;">
                {{ count($problem['photos'] ?? []) }} foto(s) disponível(is) na galeria online
            </p>
        </div>
        @endforeach

        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
            <p style="margin: 0 0 10px 0; font-size: 11px;">
                <strong>Fotos disponíveis online:</strong> Para visualizar as imagens da avaliação prévia, basta acessar o link abaixo:
            </p>

            <div style="margin: 15px 0;">
                @php
                $galleryUrl = url('/os/photos/' . $order->pdf_hash);
                @endphp

                <p style="font-size: 11px; margin: 10px 0; word-break: break-all;">
                    <strong>Link direto:</strong><br>
                    {{ $galleryUrl }}
                </p>
            </div>

            <p style="font-size: 9px; font-style: italic; margin: 0;">
                Acesse o link acima para ver todas as fotos.
            </p>
        </div>

        <div style="background: #fffbcc; padding: 10px; border-left: 3px solid #ffcc00; margin-top: 10px;">
            <p style="font-size: 9px; margin: 0;">
                <strong>Importante:</strong> As fotos ficam armazenadas de forma segura e podem ser acessadas
                a qualquer momento através do link acima. Recomendamos salvar este documento para
                referência futura. Após 90 dias, as fotos podem ser removidas do servidor por questões de
                armazenamento.
            </p>
        </div>
    </div>
    @endif

    <div class="order-info">
        <h2>Informações do Serviço</h2>
        <div class="info-grid">
            <div class="info-item-inline full-width">
                <label>Data de Entrada:</label>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                <label style="margin-left: 20px;">Data de Emissão do Documento</label>
                <span>{{ now()->format('d/m/Y H:i') }}</span>
            </div>
            @if($order->diagnostic)
            <div class="info-item full-width">
                <label>Diagnóstico:</label>
                <p>{{ $order->diagnostic }}</p>
            </div>
            @endif
        </div>
    </div>

    @php
    // Calcular valores
    $laborCost = $order->price ?? 0;
    $partsCost = $order->parts_cost ?? 0;
    $extraCost = $order->extra_cost_value ?? 0;
    $subtotal = $laborCost + $partsCost + $extraCost;

    $discountAmount = 0;
    $discountLabel = '';

    if ($order->discount_value && $order->discount_value > 0) {
    if ($order->discount_type === 'percentage') {
    $discountAmount = ($subtotal * $order->discount_value) / 100;
    $discountLabel = number_format($order->discount_value, 2, ',', '.') . '%';
    } else {
    $discountAmount = min($order->discount_value, $subtotal);
    $discountLabel = 'R$ ' . number_format($discountAmount, 2, ',', '.');
    }
    }

    $totalValue = $subtotal - $discountAmount;

    // Se tiver final_cost definido, usa ele
    if ($order->final_cost !== null) {
    $totalValue = $order->final_cost;
    }
    @endphp

    <div class="payment-summary">
        <h2>Resumo de Pagamento</h2>

        <!-- @if($laborCost > 0)
        <div class="payment-line">
            <span class="payment-label">Mão de Obra:</span>
            <span class="payment-value">R$ {{ number_format($laborCost, 2, ',', '.') }}</span>
        </div>
        @endif -->

        <!-- @if($partsCost > 0)
        <div class="payment-line">
            <span class="payment-label">Peças/Componentes:</span>
            <span class="payment-value">R$ {{ number_format($partsCost, 2, ',', '.') }}</span>
        </div>
        @endif

        @if($extraCost > 0 && $order->extra_cost_type)
        <div class="payment-line">
            <span class="payment-label">{{ $order->extra_cost_type }}:</span>
            <span class="payment-value">R$ {{ number_format($extraCost, 2, ',', '.') }}</span>
        </div>
        @endif -->

        @if($laborCost > 0 || $partsCost > 0 || $extraCost > 0)
        <div class="payment-line">
            <span class="payment-label">Valor Total:</span>
            <span class="payment-value">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
        </div>
        @endif

        <!-- @if($discountAmount > 0)
        <div class="payment-line discount">
            <span class="payment-label">Desconto Aplicado ({{ $discountLabel }}):</span>
            <span class="payment-value">- R$ {{ number_format($discountAmount, 2, ',', '.') }}</span>
        </div>
        @endif -->

        @if($discountAmount > 0)
        <div class="payment-line discount">
            <span class="payment-label">Desconto Aplicado :</span>
            <span class="payment-value">- R$ {{ number_format($discountAmount, 2, ',', '.') }}</span>
        </div>
        @endif


        <div class="payment-line total">
            <span class="payment-label">VALOR A PAGAR:</span>
            <span class="payment-value">R$ {{ number_format($totalValue, 2, ',', '.') }}</span>
        </div>
    </div>

    <!-- <div class="total-box">
        <h3>VALOR TOTAL DO SERVIÇO:</h3>
        <p>R$ {{ number_format($totalValue, 2, ',', '.') }}</p>
    </div> -->

    <!-- <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Assinatura do Cliente:
                <span style="margin-top: 10px; margin-left: 10pxs; font-size: 10px;">
                    {{ $order->customer->name }}<span> {{'N° documento ' . $order->customer_document ?? 'CPF/CNPJ não informado' }}</span>

                </span>
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Assinatura do Técnico
            </div>
        </div>
    </div>
    -->

    <!-- TERMO DE GARANTIA -->
    <div class="warranty-section">
        <h2>TERMO DE GARANTIA</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="text-align: center;">
                <strong>Ordem de Serviço: #{{ $order->id }}</strong>
            </div>
            <div style="text-align: center;">
                <strong>Data de Emissão:</strong> {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>

        <h3>1. GARANTIA DO SERVIÇO</h3>
        <p>
            A JD SMART garante o serviço executado e as peças substituídas pelo período de <strong>90 (noventa) dias</strong>
            contados a partir da data de entrega do aparelho ao cliente, nas seguintes condições:
        </p>
        <ul>
            <li>A garantia cobre apenas defeitos relacionados ao serviço executado e às peças substituídas.</li>
            <li>A garantia não cobre danos causados por mau uso, queda, contato com líquidos ou qualquer ação externa.</li>
            <li>A garantia não cobre defeitos em componentes que não foram substituídos durante o reparo.</li>
        </ul>

        <h3>2. PERDA DA GARANTIA</h3>
        <p>A garantia será automaticamente cancelada nos seguintes casos:</p>
        <ul>
            <li>Violação do aparelho por terceiros não autorizados pela JD SMART.</li>
            <li>Danos causados por queda, impacto, contato com líquidos ou uso inadequado.</li>
            <li>Remoção ou danificação dos selos de garantia aplicados pela JD SMART.</li>
            <li>Uso de peças ou acessórios não originais ou incompatíveis.</li>
            <li>Tentativa de reparo por conta própria ou por terceiros.</li>
        </ul>

        <h3>3. RESPONSABILIDADES DO CLIENTE</h3>
        <ul>
            <li>Realizar backup dos dados antes de entregar o aparelho para reparo.</li>
            <li>Retirar o aparelho no prazo de <strong>30 (trinta) dias</strong> após a notificação de conclusão do serviço.</li>
            <li>Apresentar este documento para solicitar atendimento em garantia.</li>
            <li>Pagar eventuais taxas de diagnóstico caso o defeito não esteja coberto pela garantia.</li>
        </ul>

        <h3>4. RESPONSABILIDADES DA JD SMART</h3>
        <ul>
            <li>Executar o serviço com qualidade e utilizar peças adequadas.</li>
            <li>Realizar reparo ou substituição gratuita em caso de defeito coberto pela garantia.</li>
            <li>Manter o aparelho em local seguro pelo período de até 30 dias após notificação.</li>
            <li>Notificar o cliente sobre a conclusão do serviço pelos meios de contato fornecidos.</li>
        </ul>

        <h3>5. APARELHOS NÃO RETIRADOS</h3>
        <p>
            Aparelhos não retirados no prazo de 30 dias após notificação estarão sujeitos a taxa de armazenamento
            de <strong>R$ 5,00 (cinco reais) por dia</strong>. Após 90 dias sem retirada, o aparelho poderá ser
            destinado conforme legislação vigente.
        </p>

        <h3>6. DISPOSIÇÕES FINAIS</h3>
        <p>
            Este termo de garantia é parte integrante da Ordem de Serviço e deve ser apresentado para qualquer
            solicitação de garantia. A JD SMART não se responsabiliza por dados, configurações, aplicativos ou
            arquivos armazenados no aparelho.
        </p>

        <p style="margin-top: 25px; text-align: center;">
            <strong>Ao assinar este documento, o cliente declara estar ciente e de acordo com todos os termos acima.</strong>
        </p>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">
                    Assinatura do Cliente:
                    <span style="margin-top: 10px; margin-left: 10pxs; font-size: 10px;">
                        {{ $order->customer->name }}<span> {{'N° documento ' . $order->customer_document ?? 'CPF/CNPJ não informado' }}</span>

                    </span>
                </div>
            </div>
            <!-- <div class="signature-box">
            <div class="signature-line">
                Assinatura do Técnico
            </div>
        </div> -->
        </div>
    </div>

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Este documento é uma representação da ordem de serviço registrada no sistema e inclui o termo de garantia</p>
        <p style="margin-top: 5px;">
            <strong>Em caso de dúvidas, entre em contato: (13) 99784-1161</strong>
        </p>
    </div>
</body>

</html>