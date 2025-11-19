<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OS Não Encontrada - JD Smart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .container {
            max-width: 600px;
        }
        .error-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .error-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .error-header .company-name {
            font-size: 1.5rem;
            font-weight: 900;
            margin-bottom: 15px;
        }
        .error-header .jd {
            color: white;
        }
        .error-header .smart {
            color: #FFD700;
        }
        .error-header .icon {
            font-size: 3.5rem;
            margin-bottom: 15px;
            opacity: 0.9;
        }
        .error-header h3 {
            font-size: 1.1rem;
            margin: 0;
        }
        .error-content {
            padding: 30px 20px;
            text-align: center;
        }
        .error-content h2 {
            color: #dc3545;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        .error-content p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .order-number {
            background: #f8d7da;
            color: #721c24;
            padding: 12px 20px;
            border-radius: 10px;
            display: inline-block;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 25px;
        }
        .error-content ul {
            font-size: 0.9rem;
            margin-bottom: 25px;
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
        .contact-info {
            background: #f8f9fa;
            padding: 20px 15px;
            border-radius: 10px;
            margin-top: 25px;
            text-align: left;
        }
        .contact-info h5 {
            color: #212529;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
            font-size: 1rem;
        }
        .contact-info .info-item {
            padding: 10px 0;
            color: #495057;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        .contact-info .info-item i {
            color: #FFD700;
            width: 20px;
            margin-right: 8px;
            vertical-align: top;
            flex-shrink: 0;
        }
        .contact-info .info-item strong {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        .contact-info .info-item .address-text,
        .contact-info .info-item .phone-text,
        .contact-info .info-item .hours-text {
            display: block;
            margin-left: 28px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
        }

        /* Media Queries para Desktop */
        @media (min-width: 768px) {
            body {
                padding: 20px;
            }
            .error-header {
                padding: 40px 30px;
            }
            .error-header .company-name {
                font-size: 1.8rem;
            }
            .error-header .icon {
                font-size: 5rem;
                margin-bottom: 20px;
            }
            .error-header h3 {
                font-size: 1.25rem;
            }
            .error-content {
                padding: 40px 30px;
            }
            .error-content h2 {
                font-size: 1.5rem;
                margin-bottom: 20px;
            }
            .error-content p {
                font-size: 1.1rem;
                margin-bottom: 30px;
            }
            .order-number {
                padding: 15px 25px;
                font-size: 1.3rem;
                margin-bottom: 30px;
            }
            .error-content ul {
                font-size: 1rem;
            }
            .whatsapp-btn {
                padding: 15px 30px;
                font-size: 1.1rem;
                width: auto;
            }
            .whatsapp-btn i {
                font-size: 1.5rem;
            }
            .contact-info {
                padding: 25px;
            }
            .contact-info h5 {
                font-size: 1.1rem;
            }
            .contact-info .info-item {
                padding: 12px 0;
                font-size: 1rem;
            }
            .contact-info .info-item strong {
                display: inline;
                margin-bottom: 0;
                font-size: 1rem;
            }
            .contact-info .info-item .address-text,
            .contact-info .info-item .phone-text,
            .contact-info .info-item .hours-text {
                display: inline;
                margin-left: 0;
            }
            .footer {
                font-size: 0.9rem;
                margin-top: 30px;
                padding-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-card">
            <!-- Error Header -->
            <div class="error-header">
                <div class="company-name">
                    <span class="jd">JD</span> <span class="smart">SMART</span>
                </div>
                <div class="icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h3>Ordem de Serviço Não Encontrada</h3>
            </div>

            <!-- Error Content -->
            <div class="error-content">
                <h2>Ops! Não encontramos esta OS</h2>
                
                <p>O número de ordem de serviço que você está procurando não foi encontrado em nosso sistema.</p>
                
                <div class="order-number">
                    OS #{{ $orderNumber }}
                </div>

                <p><strong>Possíveis motivos:</strong></p>
                <ul style="text-align: left; display: inline-block; color: #6c757d;">
                    <li>O número da OS pode estar incorreto</li>
                    <li>A ordem ainda não foi registrada no sistema</li>
                    <li>A OS pode ter sido cancelada ou removida</li>
                </ul>

                <!-- WhatsApp Button -->
                <div class="mt-4 pt-3">
                    <p style="margin-bottom: 15px; font-weight: 600;">Entre em contato conosco para mais informações:</p>
                    <a href="https://wa.me/5513997841161?text=Olá! Estou tentando rastrear a Ordem de Serviço #{{ $orderNumber }} mas não a encontrei no sistema." 
                       class="whatsapp-btn" 
                       target="_blank">
                        <i class="bi bi-whatsapp"></i>
                        Falar no WhatsApp
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="contact-info">
                    <h5><i class="bi bi-info-circle"></i> Informações de Contato</h5>
                    <div class="info-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <strong>Endereço:</strong>
                            <span class="address-text">Av. Pérsio de Queirós Filho, 919 - Catiapoã, São Vicente - SP, 11370-304</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <strong>Telefone:</strong>
                            <span class="phone-text">(13) 99784-1161</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-clock-fill"></i>
                        <div>
                            <strong>Horário:</strong>
                            <span class="hours-text">Segunda a Sexta, 9h às 18h</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>© 2024 JD SMART - Reparos de Celular e Acessórios</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
