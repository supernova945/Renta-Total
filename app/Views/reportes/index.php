<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Reportes</title>
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

  <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-primary">Sistema de Reportes</h1>
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>
      </div>
    </div>

    <!-- System Statistics Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <i class="ri-motorbike-line text-2xl text-blue-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Total Motocicletas</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['total_motorcycles'] ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <i class="ri-check-line text-2xl text-green-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Disponibles</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['available_motorcycles'] ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-red-100 rounded-full">
            <i class="ri-calendar-check-line text-2xl text-red-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Alquiladas</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['rented_motorcycles'] ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <i class="ri-tools-line text-2xl text-yellow-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Servicios Activos</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['active_services'] ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full">
            <i class="ri-checkbox-circle-line text-2xl text-purple-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Servicios Completados</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['completed_services'] ?? 0 ?></p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-indigo-100 rounded-full">
            <i class="ri-user-line text-2xl text-indigo-600"></i>
          </div>
          <div class="ml-4">
            <h3 class="text-sm font-medium text-gray-500">Total Clientes</h3>
            <p class="text-2xl font-bold text-gray-900"><?= $stats['total_clients'] ?? 0 ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Report Generation Section -->
    <div class="bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-bold text-primary mb-6">Generar Reportes</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Available Motorcycles Report -->
        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
              <i class="ri-motorbike-line text-green-600"></i>
            </div>
            <h3 class="font-semibold text-gray-900">Motocicletas Disponibles</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Reporte de motocicletas disponibles para alquiler</p>

          <!-- Period Selection -->
          <div class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">Período:</label>
            <div class="flex gap-2">
              <label class="flex items-center">
                <input type="radio" name="period-available" value="" class="mr-1" checked>
                <span class="text-xs">Todo</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-available" value="week" class="mr-1">
                <span class="text-xs">Semanal</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-available" value="month" class="mr-1">
                <span class="text-xs">Mensual</span>
              </label>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button onclick="previewReport('available-motorcycles')"
              class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-eye-line mr-1"></i>
              Vista Previa
            </button>
            <button onclick="generateReport('available-motorcycles')"
              class="flex-1 bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-file-pdf-line mr-1"></i>
              PDF
            </button>
          </div>
        </div>

        <!-- Leased Motorcycles Report -->
        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
              <i class="ri-calendar-check-line text-red-600"></i>
            </div>
            <h3 class="font-semibold text-gray-900">Motocicletas Alquiladas</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Reporte de motocicletas actualmente alquiladas</p>

          <!-- Period Selection -->
          <div class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">Período:</label>
            <div class="flex gap-2">
              <label class="flex items-center">
                <input type="radio" name="period-leased" value="" class="mr-1" checked>
                <span class="text-xs">Todo</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-leased" value="week" class="mr-1">
                <span class="text-xs">Semanal</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-leased" value="month" class="mr-1">
                <span class="text-xs">Mensual</span>
              </label>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button onclick="previewReport('leased-motorcycles')"
              class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-eye-line mr-1"></i>
              Vista Previa
            </button>
            <button onclick="generateReport('leased-motorcycles')"
              class="flex-1 bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-file-pdf-line mr-1"></i>
              PDF
            </button>
          </div>
        </div>

        <!-- Active Services Report -->
        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
              <i class="ri-tools-line text-yellow-600"></i>
            </div>
            <h3 class="font-semibold text-gray-900">Servicios Activos</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Reporte de servicios en proceso o pendientes</p>

          <!-- Period Selection -->
          <div class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">Período:</label>
            <div class="flex gap-2">
              <label class="flex items-center">
                <input type="radio" name="period-active-services" value="" class="mr-1" checked>
                <span class="text-xs">Todo</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-active-services" value="week" class="mr-1">
                <span class="text-xs">Semanal</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-active-services" value="month" class="mr-1">
                <span class="text-xs">Mensual</span>
              </label>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button onclick="previewReport('active-services')"
              class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-eye-line mr-1"></i>
              Vista Previa
            </button>
            <button onclick="generateReport('active-services')"
              class="flex-1 bg-yellow-600 text-white px-3 py-2 rounded hover:bg-yellow-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-file-pdf-line mr-1"></i>
              PDF
            </button>
          </div>
        </div>

        <!-- Historical Services Report -->
        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
              <i class="ri-history-line text-purple-600"></i>
            </div>
            <h3 class="font-semibold text-gray-900">Historial de Servicios</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Historial completo de servicios realizados</p>

          <!-- Period Selection -->
          <div class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">Período:</label>
            <div class="flex gap-2">
              <label class="flex items-center">
                <input type="radio" name="period-historical-services" value="" class="mr-1" checked>
                <span class="text-xs">Todo</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-historical-services" value="week" class="mr-1">
                <span class="text-xs">Semanal</span>
              </label>
              <label class="flex items-center">
                <input type="radio" name="period-historical-services" value="month" class="mr-1">
                <span class="text-xs">Mensual</span>
              </label>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button onclick="previewReport('historical-services')"
              class="flex-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-eye-line mr-1"></i>
              Vista Previa
            </button>
            <button onclick="generateReport('historical-services')"
              class="flex-1 bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700 transition-colors text-xs flex items-center justify-center">
              <i class="ri-file-pdf-line mr-1"></i>
              PDF
            </button>
          </div>
        </div>

        <!-- System Report -->
        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors md:col-span-2 lg:col-span-1">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
              <i class="ri-bar-chart-line text-primary"></i>
            </div>
            <h3 class="font-semibold text-gray-900">Reporte General</h3>
          </div>
          <p class="text-sm text-gray-600 mb-4">Reporte completo del estado del sistema</p>
          <button onclick="generateReport('system')"
            class="w-full bg-primary text-white px-4 py-2 rounded hover:bg-secondary transition-colors flex items-center justify-center">
            <i class="ri-file-pdf-line mr-2"></i>
            Generar PDF
          </button>
        </div>
      </div>
    </div>

    <!-- Information Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
      <div class="flex items-start">
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-1">
          <i class="ri-information-line text-blue-600"></i>
        </div>
        <div>
          <h3 class="font-semibold text-blue-900 mb-2">Información sobre Reportes</h3>
          <ul class="text-sm text-blue-800 space-y-1">
            <li>• Los reportes se generan en formato PDF para impresión externa</li>
            <li>• Cada reporte incluye fecha de generación y estadísticas relevantes</li>
            <li>• Los reportes de motocicletas incluyen información detallada de marca, modelo y estado</li>
            <li>• Los reportes de servicios incluyen costos estimados y reales</li>
            <li>• El reporte general del sistema incluye un resumen completo de todas las operaciones</li>
          </ul>
        </div>
      </div>
    </div>

  </main>

  <!-- Loading Modal -->
  <div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="ri-loader-4-line text-3xl text-primary animate-spin"></i>
        </div>
        <h3 class="text-lg font-medium text-primary mb-2">Generando Reporte</h3>
        <p class="text-gray-600">Por favor espere mientras se genera el reporte PDF...</p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Mobile menu functionality
      const mobileMenuButton = document.getElementById('mobileMenuButton');
      const mobileMenu = document.getElementById('mobileMenu');

      mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });

      // Close mobile menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!mobileMenuButton?.contains(e.target) && !mobileMenu?.contains(e.target)) {
          mobileMenu?.classList.add('hidden');
        }
      });
    });

    function getSelectedPeriod(containerSelector) {
      const container = document.querySelector(containerSelector);
      if (!container) return '';

      const selectedRadio = container.querySelector('input[type="radio"]:checked');
      return selectedRadio ? selectedRadio.value : '';
    }

    function generateReport(type) {
      const loadingModal = document.getElementById('loadingModal');
      loadingModal.classList.remove('hidden');

      let url = `${baseUrl}/reportes/${type}`;
      const period = getSelectedPeriod(`[name^="period-${type === 'available-motorcycles' ? 'available' : type === 'leased-motorcycles' ? 'leased' : type === 'active-services' ? 'active-services' : type === 'historical-services' ? 'historical-services' : ''}"]`);

      if (period) {
        url += `/${period}`;
      }

      setTimeout(() => {
        window.location.href = url;
        loadingModal.classList.add('hidden');
      }, 1000);
    }

    function previewReport(type) {
      let url = `${baseUrl}/reportes/preview/${type}`;
      const periodMap = {
        'available-motorcycles': 'available',
        'leased-motorcycles': 'leased',
        'active-services': 'active-services',
        'historical-services': 'historical-services'
      };
      const periodSelector = periodMap[type];

      if (periodSelector) {
        const period = getSelectedPeriod(`[name="period-${periodSelector}"]`);
        if (period) {
          url += `/${period}`;
        }
      }

      window.location.href = url;
    }
  </script>

  <?= $this->include('partials/notification-js') ?>

</body>

</html>
