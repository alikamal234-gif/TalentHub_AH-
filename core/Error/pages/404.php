<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - Page non trouvée</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="display-1 fw-bold text-danger">404</div>
            <div class="display-4 mb-4">Page non trouvée</div>
            <p class="lead mb-4">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            
            <div class="card shadow-sm mx-auto" style="max-width: 500px;">
                <div class="card-body py-5">
                    <i class="bi bi-exclamation-triangle display-1 text-warning mb-3"></i>
                    <p class="card-text">L'adresse peut être erronée ou la page a peut-être été supprimée.</p>
                    
                    <div class="mt-4">
                        <a href="/" class="btn btn-primary me-2">
                            <i class="bi bi-house-door"></i> Retour à l'accueil
                        </a>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Page précédente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>