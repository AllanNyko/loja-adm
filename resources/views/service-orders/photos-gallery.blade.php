<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotos da OS #{{ $order->id }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --text-light: #e94560;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .header h1 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }
        
        .header .os-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-top: 0.5rem;
        }
        
        .problem-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .problem-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--text-light);
        }
        
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .photo-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }
        
        .photo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
        
        .photo-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            cursor: pointer;
        }
        
        .photo-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            color: white;
            padding: 1rem 0.75rem 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .download-btn:hover {
            background: white;
            transform: scale(1.1);
        }
        
        .download-btn i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .no-photos {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .no-photos i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
        
        /* Modal de visualização */
        .modal-content {
            background: transparent;
            border: none;
        }
        
        .modal-body {
            padding: 0;
            position: relative;
        }
        
        .modal-body img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        
        .modal-header {
            border: none;
            position: absolute;
            top: 0;
            right: 0;
            z-index: 10;
        }
        
        .btn-close {
            background: white;
            opacity: 1;
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.5rem;
            }
            
            .problem-section {
                padding: 1.5rem;
            }
            
            .photo-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1rem;
            }
            
            .photo-card img {
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1><i class="bi bi-images"></i> Galeria de Fotos</h1>
            <div class="os-info">
                <strong>OS #{{ $order->id }}</strong> | 
                Cliente: {{ $order->customer_name }} | 
                Aparelho: {{ $order->device_model }}
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @if($order->problems_photos && count($order->problems_photos) > 0)
            @foreach($order->problems_photos as $problemIndex => $problem)
                <div class="problem-section">
                    <h2 class="problem-title">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        {{ $problem['description'] ?? 'Problema sem descrição' }}
                    </h2>
                    
                    @if(isset($problem['photos']) && count($problem['photos']) > 0)
                        <div class="photo-grid">
                            @foreach($problem['photos'] as $photoIndex => $photoPath)
                                @php
                                    $fullPath = public_path('storage/' . $photoPath);
                                @endphp
                                
                                @if(file_exists($fullPath))
                                    <div class="photo-card">
                                        <img src="{{ asset('storage/' . $photoPath) }}" 
                                             alt="Foto {{ $photoIndex + 1 }}"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#photoModal{{ $problemIndex }}_{{ $photoIndex }}">
                                        
                                        <div class="photo-label">
                                            Foto {{ $photoIndex + 1 }} de {{ count($problem['photos']) }}
                                        </div>
                                        
                                        <a href="{{ asset('storage/' . $photoPath) }}" 
                                           download 
                                           class="download-btn"
                                           title="Baixar foto">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- Modal para visualização ampliada -->
                                    <div class="modal fade" id="photoModal{{ $problemIndex }}_{{ $photoIndex }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto {{ $photoIndex + 1 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="no-photos">
                            <i class="bi bi-image"></i>
                            <p>Nenhuma foto anexada para este problema.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="problem-section">
                <div class="no-photos">
                    <i class="bi bi-images"></i>
                    <p>Nenhum problema com fotos registrado para esta OS.</p>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
