<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotos da OS - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 24px;
            color: #333;
        }

        .info {
            margin-top: 10px;
            color: #666;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .problem {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .problem h2 {
            color: #d32f2f;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .photo-card {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 8px;
            cursor: pointer;
        }

        .photo-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .photo-card:hover img {
            transform: scale(1.1);
        }

        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
        }

        .lightbox.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
        }

        .lightbox-nav.prev {
            left: 20px;
        }

        .lightbox-nav.next {
            right: 20px;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1><i class="bi bi-images"></i> Galeria de Fotos - OS #{{ $order->id }}</h1>
        <div class="info">
            <span><i class="bi bi-person"></i> {{ $order->customer->name }}</span> |
            <span><i class="bi bi-phone"></i> {{ $order->device_model }}</span>
        </div>
    </div>

    <div class="container">
        @if($order->problems_photos && count($order->problems_photos) > 0)
        @foreach($order->problems_photos as $problemIndex => $problem)
        <div class="problem">
            <h2><i class="bi bi-exclamation-circle"></i> {{ $problem['description'] ?? 'Problema' }}</h2>
            @if(isset($problem['photos']) && count($problem['photos']) > 0)
            <div class="grid">
                @foreach($problem['photos'] as $photoIndex => $photoPath)
                @php
                $fullPath = storage_path('app/public/' . $photoPath);
                @endphp
                @if(file_exists($fullPath))
                <div class="photo-card" onclick="openLightbox('{{ asset('storage/' . $photoPath) }}')">
                    <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto {{ $photoIndex + 1 }}" loading="lazy">
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
        @else
        <div class="problem">
            <p style="text-align: center; color: #666;">Nenhuma foto registrada para esta OS.</p>
        </div>
        @endif
    </div>

    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()"><i class="bi bi-x"></i></button>
        <button class="lightbox-nav prev" onclick="navigate(-1); event.stopPropagation()"><i class="bi bi-chevron-left"></i></button>
        <img id="lightboxImg" src="" alt="">
        <button class="lightbox-nav next" onclick="navigate(1); event.stopPropagation()"><i class="bi bi-chevron-right"></i></button>
    </div>

    <script>
        let photos = [];
        let currentIndex = 0;
        document.querySelectorAll('.photo-card img').forEach(img => photos.push(img.src));

        function openLightbox(src) {
            currentIndex = photos.indexOf(src);
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightbox').classList.add('active');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
        }

        function navigate(dir) {
            currentIndex = (currentIndex + dir + photos.length) % photos.length;
            document.getElementById('lightboxImg').src = photos[currentIndex];
        }
        document.addEventListener('keydown', e => {
            if (document.getElementById('lightbox').classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                else if (e.key === 'ArrowLeft') navigate(-1);
                else if (e.key === 'ArrowRight') navigate(1);
            }
        });
    </script>
</body>

</html>