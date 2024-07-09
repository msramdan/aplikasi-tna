<!-- resources/views/qrcode.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>QR Code Generator</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qrModal">
                    Show QR Code
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary ">
                    <h5 class="modal-title text-white id="qrModalLabel">QR Code</h5>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light bg-gradient">
                    <div id="qrcode">
                        <div class="visible-print text-center">
                            <!-- Bagian ini akan diisi dengan QR code -->
                            @isset($qrCode)
                                {!! $qrCode !!}
                                <h3 class="text-secondary mt-3">Scan Me</h3>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
