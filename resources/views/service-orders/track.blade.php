<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreamento OS #{{ $order->id }} - JD Smart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 10px;
        }
        .track-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header-section {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            color: white;
            padding: 20px 15px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header-section .company-name {
            font-size: 1.5rem;
            font-weight: 900;
            margin-bottom: 10px;
        }
        .header-section .jd {
            color: white;
        }
        .header-section .smart {
            color: #FFD700;
        }
        .header-section p {
            margin: 5px 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        .header-section h4 {
            font-size: 1rem;
        }
        .header-section h2 {
            font-size: 1.5rem;
        }
        .content-card {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .status-banner {
            padding: 20px 15px;
            text-align: center;
            font-size: 1rem;
            font-weight: 600;
        }
        .status-banner i {
            font-size: 1.2rem;
        }
        .status-banner.pending {
            background: #fff3cd;
            color: #664d03;
        }
        .status-banner.approved {
            background: #cff4fc;
            color: #055160;
        }
        .status-banner.in_progress {
            background: #cfe2ff;
            color: #084298;
        }
        .status-banner.completed {
            background: #d1e7dd;
            color: #0a3622;
        }
        .status-banner.cancelled {
            background: #f8d7da;
            color: #58151c;
        }
        .info-section {
            padding: 20px 15px;
        }
        .info-card {
            background: #f8f9fa;
            border-left: 4px solid #FFD700;
            padding: 12px 15px;
            margin-bottom: 12px;
            border-radius: 5px;
        }
        .info-card label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }
        .info-card .value {
            font-size: 1rem;
            font-weight: 600;
            color: #212529;
            word-break: break-word;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #212529;
            margin: 20px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 3px solid #FFD700;
        }
        .whatsapp-btn {
            background: #25D366;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
            width: 100%;
            max-width: 300px;
        }
        .whatsapp-btn:hover {
            background: #1fb855;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 211, 102, 0.4);
        }
        .whatsapp-btn i {
            font-size: 1.3rem;
        }
        .footer-info {
            background: #212529;
            color: white;
            padding: 20px 15px;
            text-align: center;
            margin-top: 20px;
            border-radius: 15px;
        }
        .footer-info .company-name {
            font-size: 1.3rem;
        }
        .footer-info .contact {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 10px;
            line-height: 1.8;
        }
        .footer-info .contact strong {
            color: #FFD700;
        }
        .footer-info .contact > div {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .timeline {
            position: relative;
            padding-left: 25px;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 15px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -20px;
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #FFD700;
            border: 2px solid #212529;
        }
        .timeline-item::after {
            content: '';
            position: absolute;
            left: -16px;
            top: 16px;
            width: 2px;
            height: calc(100% - 10px);
            background: #dee2e6;
        }
        .timeline-item:last-child::after {
            display: none;
        }
        .timeline-item .time {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 600;
        }
        .timeline-item .label {
            font-weight: 700;
            color: #212529;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        /* Media Queries para Desktop */
        @media (min-width: 768px) {
            body {
                padding: 20px;
            }
            .header-section {
                padding: 30px;
            }
            .header-section .company-name {
                font-size: 2rem;
            }
            .header-section p {
                font-size: 1rem;
            }
            .header-section h4 {
                font-size: 1.25rem;
            }
            .header-section h2 {
                font-size: 2rem;
            }
            .status-banner {
                padding: 25px;
                font-size: 1.1rem;
            }
            .status-banner i {
                font-size: 1.5rem;
            }
            .info-section {
                padding: 30px;
            }
            .info-card {
                padding: 15px 20px;
                margin-bottom: 15px;
            }
            .info-card label {
                font-size: 0.85rem;
            }
            .info-card .value {
                font-size: 1.1rem;
            }
            .section-title {
                font-size: 1.3rem;
                margin: 30px 0 20px 0;
                padding-bottom: 10px;
            }
            .whatsapp-btn {
                padding: 15px 30px;
                font-size: 1.1rem;
                width: auto;
            }
            .whatsapp-btn i {
                font-size: 1.5rem;
            }
            .footer-info {
                padding: 25px;
                margin-top: 30px;
            }
            .footer-info .company-name {
                font-size: 1.5rem;
            }
            .footer-info .contact {
                font-size: 0.9rem;
            }
            .timeline {
                padding-left: 30px;
            }
            .timeline-item {
                padding-bottom: 20px;
            }
            .timeline-item::before {
                left: -22px;
                top: 8px;
                width: 12px;
                height: 12px;
                border: 3px solid #212529;
            }
            .timeline-item::after {
                left: -17px;
                top: 20px;
            }
            .timeline-item .time {
                font-size: 0.85rem;
            }
            .timeline-item .label {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="track-container">
        <!-- Header -->
        <div class="header-section">
            <div class="company-name">
                <span class="jd">JD</span> <span class="smart">SMART</span>
            </div>
            <p>Reparos de Celular e Acessórios</p>
            <h4 class="mt-3">
                <i class="bi bi-search"></i>
                Rastreamento de Ordem de Serviço
            </h4>
            <h2 class="mt-2">OS #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
        </div>

        <!-- Content Card -->
        <div class="content-card">
            <!-- Status Banner -->
            <div class="status-banner {{ $order->status }}">
                <i class="bi 
                    @switch($order->status)
                        @case('pending') bi-clock-history @break
                        @case('approved') bi-check-circle @break
                        @case('in_progress') bi-gear @break
                        @case('completed') bi-check2-circle @break
                        @case('cancelled') bi-x-circle @break
                    @endswitch
                "></i>
                Status: 
                @switch($order->status)
                    @case('pending') Aguardando Aprovação @break
                    @case('approved') Aprovada @break
                    @case('in_progress') Em Execução @break
                    @case('completed') Concluída @break
                    @case('cancelled') Cancelada @break
                @endswitch
            </div>

            <!-- Information Section -->
            <div class="info-section">
                <!-- Customer Info -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <label><i class="bi bi-person"></i> Cliente</label>
                            <div class="value">{{ $order->customer->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <label><i class="bi bi-telephone"></i> Telefone</label>
                            <div class="value">{{ $order->customer->phone }}</div>
                        </div>
                    </div>
                </div>

                <!-- Device Info -->
                <h5 class="section-title"><i class="bi bi-phone"></i> Informações do Dispositivo</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-card">
                            <label>Modelo</label>
                            <div class="value">{{ $order->device_model }}</div>
                        </div>
                    </div>
                    @if($order->device_imei)
                    <div class="col-md-6">
                        <div class="info-card">
                            <label>IMEI</label>
                            <div class="value">{{ $order->device_imei }}</div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Problem Description -->
                <h5 class="section-title"><i class="bi bi-tools"></i> Descrição do Problema</h5>
                <div class="info-card">
                    <div class="value">{{ $order->problem_description }}</div>
                </div>

                <!-- Diagnostic -->
                @if($order->diagnostic)
                <h5 class="section-title"><i class="bi bi-clipboard-check"></i> Diagnóstico</h5>
                <div class="info-card">
                    <div class="value">{{ $order->diagnostic }}</div>
                </div>
                @endif

                <!-- Price -->
                @if($order->price)
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="info-card" style="border-left-color: #28a745;">
                            <label><i class="bi bi-currency-dollar"></i> Valor do Serviço</label>
                            <div class="value" style="color: #28a745; font-size: 1.5rem;">
                                R$ {{ number_format($order->price, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @if($order->deadline)
                    <div class="col-md-6">
                        <div class="info-card" style="border-left-color: #007bff;">
                            <label><i class="bi bi-calendar-event"></i> Prazo de Entrega</label>
                            <div class="value">{{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Timeline -->
                <h5 class="section-title"><i class="bi bi-clock-history"></i> Histórico</h5>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="label">Ordem Criada</div>
                        <div class="time">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($order->updated_at != $order->created_at)
                    <div class="timeline-item">
                        <div class="label">Última Atualização</div>
                        <div class="time">{{ $order->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                </div>

                <!-- WhatsApp Button -->
                <div class="text-center mt-4 pt-4 border-top">
                    <h5 class="mb-3">Precisa falar conosco?</h5>
                    <a href="https://wa.me/5513997841161?text=Olá! Gostaria de informações sobre a Ordem de Serviço #{{ $order->id }}" 
                       class="whatsapp-btn" 
                       target="_blank">
                        <i class="bi bi-whatsapp"></i>
                        Falar no WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <div class="company-name">
                <span class="jd" style="color: white;">JD</span> <span class="smart">SMART</span>
            </div>
            <div class="contact">
                <div style="margin-bottom: 8px;">
                    <strong>Endereço:</strong><br class="d-md-none">
                    <span class="d-block d-md-inline">Av. Pérsio de Queirós Filho, 919 - Catiapoã, São Vicente - SP, 11370-304</span>
                </div>
                <div>
                    <strong>Telefone:</strong> (13) 99784-1161
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
