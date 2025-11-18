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
            padding: 20px;
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
            padding: 40px 30px;
            text-align: center;
        }
        .error-header .company-name {
            font-size: 1.8rem;
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
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .error-content {
            padding: 40px 30px;
            text-align: center;
        }
        .error-content h2 {
            color: #dc3545;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .error-content p {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .order-number {
            background: #f8d7da;
            color: #721c24;
            padding: 15px 25px;
            border-radius: 10px;
            display: inline-block;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .whatsapp-btn {
            background: #25D366;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
        }
        .whatsapp-btn:hover {
            background: #1fb855;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 211, 102, 0.4);
        }
        .whatsapp-btn i {
            font-size: 1.5rem;
        }
        .contact-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: left;
        }
        .contact-info h5 {
            color: #212529;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
        }
        .contact-info .info-item {
            padding: 8px 0;
            color: #495057;
        }
        .contact-info .info-item i {
            color: #FFD700;
            width: 20px;
            margin-right: 10px;
        }
        .footer {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
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
                        <strong>Endereço:</strong><br>
                        <span style="margin-left: 30px;">Av. Pérsio de Queirós Filho, 919 - Catiapoã</span><br>
                        <span style="margin-left: 30px;">São Vicente - SP, 11370-304</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-telephone-fill"></i>
                        <strong>Telefone:</strong> (13) 99784-1161
                    </div>
                    <div class="info-item">
                        <i class="bi bi-clock-fill"></i>
                        <strong>Horário:</strong> Segunda a Sexta, 9h às 18h
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
