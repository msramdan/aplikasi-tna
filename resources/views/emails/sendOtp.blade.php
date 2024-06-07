<!DOCTYPE html>
<html>

<head>
    <title>Kode OTP Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border: 1px solid #dddddd;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 250px;
            /* Ubah lebar gambar */
        }

        .content {
            text-align: center;
        }

        .otp-code {
            display: inline-block;
            font-size: 36px;
            /* Ubah ukuran font OTP */
            font-weight: bold;
            color: #ffffff;
            background-color: #28a745;
            /* Ubah warna hijau */
            padding: 10px 20px;
            border-radius: 10px;
            /* Ubah sudut membulat */
            margin: 20px 0;
            text-decoration: none;
            letter-spacing: 10px;
            /* Tambahkan jarak antar angka */
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666666;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="" alt="Interna TNA">
        </div>
        <div class="content">
            <h2>Kode OTP Anda</h2>
            <p>Terima kasih telah menggunakan layanan kami. Untuk login, masukkan kode OTP berikut:</p>
            <a class="otp-code">{{ $otp }}</a>
            <p>Kode ini berlaku selama 1 menit. Jangan berikan kode ini kepada siapapun.</p>
            <p>Terima kasih,</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 © Badan Pengawasan Keuangan dan Pembangunan.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>

</html>
