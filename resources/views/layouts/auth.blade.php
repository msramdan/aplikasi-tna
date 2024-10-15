<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - {{ config('app.name', 'Aplikasi TNA') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi TNA" name="description" />
    <meta content="Muhammad saeful ramdan - 083874731480" name="author" />
    <link rel="icon"
        @if (setting_web()->favicon != null) href="{{ Storage::url('public/img/setting_app/') . setting_web()->favicon }}" @endif
        type="image/x-icon">
    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    @yield('content')
    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('js')

    <a href="https://wa.me/62818965879?text=Hello%20Admin,%20saya%20ingin%20bertanya%20mengenai%20Aplikasi%20TNA.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih."
        target="_blank" id="whatsapp-button">
        <img src="{{ asset('wa.png') }}" alt="WhatsApp" style="width: 60px;">
        <span id="whatsapp-text">Hubungi kami</span>
    </a>

    <style>
        #whatsapp-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 2000;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        #whatsapp-text {
            margin-left: 10px;
            font-size: 16px;
            color: #25D366;
            /* Warna hijau khas WhatsApp */
            font-weight: bold;
        }

        #whatsapp-button:hover #whatsapp-text {
            color: #128C7E;
            /* Warna hijau lebih gelap untuk efek hover */
        }
    </style>

</body>

</html>
