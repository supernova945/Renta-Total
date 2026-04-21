<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Vista Previa de Reporte</title>
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

    .report-content {
      font-family: Arial, sans-serif;
      background: white;
      padding: 20px;
      margin: 20px 0;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .report-content .header {
      text-align: center;
      border-bottom: 2px solid #0D3850;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .report-content .logo {
      font-size: 24px;
      font-weight: bold;
      color: #0D3850;
    }

    .report-content .title {
      font-size: 18px;
      font-weight: bold;
      color: #0D3850;
      margin: 10px 0;
    }

    .report-content .subtitle {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
    }

    .report-content .date {
      text-align: right;
      font-size: 12px;
      color: #666;
      margin-bottom: 20px;
    }

    .report-content table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .report-content th,
    .report-content td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .report-content th {
      background-color: #f5f5f5;
      font-weight: bold;
    }

    .report-content .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 10px;
      color: #666;
    }

    .report-content .stats {
      background-color: #f9f9f9;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
  </style>
</head>

<body class="bg-white">

  <?= $this->include('partials/header') ?>

  <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-primary">Vista Previa del Reporte</h1>
      <div class="flex gap-3">
        <button onclick="window.history.back()"
          class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors flex items-center">
          <i class="ri-arrow-left-line mr-2"></i>
          Volver
        </button>
        <button onclick="generatePDF()"
          class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition-colors flex items-center">
          <i class="ri-file-pdf-line mr-2"></i>
          Generar PDF
        </button>
      </div>
    </div>

    <!-- Report Preview -->
    <div class="report-content">
      <div class="header">
        <div class="logo">MI RENTA TOTAL</div>
        <div class="title"><?= esc($title) ?></div>
        <div class="subtitle"><?= esc($subtitle) ?></div>
      </div>
      <div class="date">Fecha de generación: <?= date('d/m/Y H:i') ?></div>

      <?php if (isset($motorcycles)): ?>
        <!-- Motorcycles Report -->
        <div class="stats">
          <strong>Total de motocicletas: <?= count($motorcycles) ?></strong>
        </div>
        <table>
          <thead>
            <tr>
              <th>Placa</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Año</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($motorcycles as $moto): ?>
              <tr>
                <td><?= esc($moto['placa']) ?></td>
                <td><?= esc($moto['nombre_marca']) ?></td>
                <td><?= esc($moto['modelo']) ?></td>
                <td><?= esc($moto['año']) ?></td>
                <td><?= esc($moto['nombre_estado']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php elseif (isset($rentals)): ?>
        <!-- Rentals Report -->
        <div class="stats">
          <strong>Total de alquileres activos: <?= count($rentals) ?></strong>
        </div>
        <table>
          <thead>
            <tr>
              <th>Placa</th>
              <th>Marca/Modelo</th>
              <th>Cliente</th>
              <th>Fecha Entrega</th>
              <th>Fecha Renovación</th>
              <th>Renta (sin IVA)</th>
              <th>Renta (con IVA)</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rentals as $rental): ?>
              <tr>
                <td><?= esc($rental['placa']) ?></td>
                <td><?= esc($rental['nombre_marca']) ?> <?= esc($rental['modelo']) ?> (<?= esc($rental['año']) ?>)</td>
                <td><?= esc($rental['nombre_cliente']) ?></td>
                <td><?= date('d/m/Y', strtotime($rental['fecha_entrega'])) ?></td>
                <td><?= date('d/m/Y', strtotime($rental['fecha_renovacion'])) ?></td>
                <td>$<?= number_format($rental['renta_sinIva'], 2) ?></td>
                <td>$<?= number_format($rental['renta_conIva'], 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      <?php elseif (isset($services)): ?>
        <!-- Services Report -->
        <div class="stats">
          <strong>Total de servicios: <?= count($services) ?></strong>
        </div>
        <table>
          <thead>
            <tr>
              <th>Placa</th>
              <th>Marca/Modelo</th>
              <th>Tipo de Servicio</th>
              <th>Estado</th>
              <th>Fecha Solicitud</th>
              <th>Costo Estimado</th>
              <th>Costo Real</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($services as $service): ?>
              <tr>
                <td><?= esc($service['placa']) ?></td>
                <td><?= esc($service['nombre_marca']) ?> <?= esc($service['modelo']) ?></td>
                <td><?= esc($service['tipo_servicio']) ?></td>
                <td><?= esc($service['estado_servicio']) ?></td>
                <td><?= date('d/m/Y', strtotime($service['fecha_solicitud'])) ?></td>
                <td>$<?= number_format($service['costo_estimado'] ?? 0, 2) ?></td>
                <td>$<?= number_format($service['costo_real'] ?? 0, 2) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

      <div class="footer">
        Reporte generado por MI RENTA TOTAL - <?= date('d/m/Y H:i') ?>
      </div>
    </div>

  </main>

  <script>
    function generatePDF() {
      const reportType = '<?= $report_type ?>';
      const period = '<?= $period ?>';
      let url = `${baseUrl}/reportes/${reportType}`;

      if (period) {
        url += `/${period}`;
      }

      window.location.href = url;
    }
  </script>

  <?= $this->include('partials/notification-js') ?>

</body>

</html>
