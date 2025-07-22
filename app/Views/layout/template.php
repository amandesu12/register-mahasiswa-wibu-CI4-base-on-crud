<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> | UNIVERSITAS WIBU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bs-primary-rgb: 108, 92, 231; } /* Warna ungu tema */
        .btn-primary { --bs-btn-bg: #6c5ce7; --bs-btn-border-color: #6c5ce7; --bs-btn-hover-bg: #5a4bdb; --bs-btn-hover-border-color: #5a4bdb; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">🎓 **UNIVERSITAS WIBU**</a>
        </div>
    </nav>

    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>