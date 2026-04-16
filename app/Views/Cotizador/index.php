<?php
// app/Views/Cotizador/index.php
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Cotizador</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <script>
    const baseUrl = "<?= base_url() ?>"
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#0D3850',
            primaryb: '#0B3C59',
            grayb: '#E3E8EB',
            secondary: '#AD2E2E'
          },
          borderRadius: {
            'none': '0px',
            'sm': '4px',
            DEFAULT: '8px',
            'md': '12px',
            'lg': '16px',
            'xl': '20px',
            '2xl': '24px',
            '3xl': '32px',
            'full': '9999px',
            'button': '8px'
          }
        }
      }
    }
    </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
    }
  </style>
</head>
<body class="bg-white">
    <?= $this->include('partials/header') ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">MIRT - Cotizador</a>
        </div>
    </nav>

    <main class="container">
        <h1 class="mb-3">Cotizador</h1>
        <p class="text-muted">Estructura básica de la vista. Personaliza según tus datos y controladores.</p>

        <div class="card mb-4">
            <div class="card-body">
                <form action="<?= isset($action) ? esc($action) : '#' ?>" method="post">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Producto</label>
                            <input type="text" name="producto" class="form-control" placeholder="Nombre del producto">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" min="1" value="1">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Calcular</button>
                        <a href="<?= isset($back) ? esc($back) : '/' ?>" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultado -->
        <?php if (!empty($resultado)): ?>
            <div class="alert alert-success">
                <?= esc($resultado) ?>
            </div>
        <?php endif; ?>
    </main>

    <footer class="text-center py-3">
        &copy; <?= date('Y') ?> MIRT
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>