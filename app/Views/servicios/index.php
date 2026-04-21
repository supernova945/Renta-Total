<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Servicios</title>
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
      <h1 class="text-2xl font-bold text-primary">Gestión de Servicios</h1>
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>

        <button id="addServiceButton"
          class="bg-primary text-white px-4 py-2 rounded-button hover:bg-secondary transition-all duration-200 flex items-center whitespace-nowrap !rounded-button">
          <div class="w-4 h-4 flex items-center justify-center mr-1.5">
            <i class="ri-add-line"></i>
          </div>
          Nuevo Servicio
        </button>
      </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->has('success')) : ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <i class="ri-check-circle-line mr-2 text-green-600"></i>
            <span><?php echo session('success'); ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
            <i class="ri-error-warning-line mr-2 text-red-600"></i>
            <span><?php echo session('error'); ?></span>
        </div>
    <?php endif; ?>

    <!-- Add Service Modal -->
    <div id="addServiceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
      <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-bold text-primary">Agregar Nuevo Servicio</h3>
          <button id="closeAddServiceModal" class="text-gray-400 hover:text-gray-700">
            <i class="ri-close-line text-xl"></i>
          </button>
        </div>
        <form id="serviceForm" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="placa_motocicleta" class="block text-sm font-medium text-gray-700 mb-1">Motocicleta *</label>
              <select id="placa_motocicleta" name="placa_motocicleta" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
                <option value="">Seleccione una motocicleta</option>
              </select>
            </div>
            <div>
              <label for="tipo_servicio" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Servicio *</label>
              <select id="tipo_servicio" name="tipo_servicio" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
                <option value="">Seleccione tipo</option>
                <option value="Mantenimiento Preventivo">Mantenimiento Preventivo</option>
                <option value="Reparación">Reparación</option>
                <option value="Cambio de Aceite">Cambio de Aceite</option>
                <option value="Cambio de Llantas">Cambio de Llantas</option>
                <option value="Revisión Eléctrica">Revisión Eléctrica</option>
                <option value="Ajuste de Frenos">Ajuste de Frenos</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
          </div>

          <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción del Servicio *</label>
            <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" placeholder="Describa detalladamente el servicio requerido" required></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
              <select id="prioridad" name="prioridad" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
                <option value="baja">Baja</option>
                <option value="media" selected>Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
              </select>
            </div>
            <div>
              <label for="fecha_solicitud" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Solicitud *</label>
              <input type="date" id="fecha_solicitud" name="fecha_solicitud" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="costo_estimado" class="block text-sm font-medium text-gray-700 mb-1">Costo Estimado ($)</label>
              <input type="number" id="costo_estimado" name="costo_estimado" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" placeholder="0.00">
            </div>
            <div>
              <label for="kilometraje_actual" class="block text-sm font-medium text-gray-700 mb-1">Kilometraje Actual</label>
              <input type="number" id="kilometraje_actual" name="kilometraje_actual" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" placeholder="Ej: 15000">
            </div>
          </div>

          <div>
            <label for="tecnico_responsable" class="block text-sm font-medium text-gray-700 mb-1">Técnico Responsable</label>
            <input type="text" id="tecnico_responsable" name="tecnico_responsable" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" placeholder="Nombre del técnico asignado">
          </div>

          <div class="flex justify-end space-x-2 pt-2">
            <button type="button" id="cancelAddService" class="px-4 py-2 text-sm font-medium text-primary bg-gray-100 rounded-button hover:text-white hover:bg-secondary">Cancelar</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-button hover:text-white hover:bg-secondary">Guardar Servicio</button>
          </div>
      </form>
      </div>
    </div>

    <!-- Service Detail Modal -->
    <div id="serviceDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden flex justify-center items-center">
      <div class="relative bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
          <h3 class="text-2xl font-semibold text-gray-800">Detalles del Servicio</h3>
          <button id="closeDetailModalBtn" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-left text-gray-700">
          <div>
            <p class="mb-2"><span class="font-medium text-gray-900">ID Servicio:</span> <span id="detailServiceId"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Motocicleta:</span> <span id="detailServiceMoto"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Tipo Servicio:</span> <span id="detailServiceTipo"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Estado:</span> <span id="detailServiceEstado"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Prioridad:</span> <span id="detailServicePrioridad"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Fecha Solicitud:</span> <span id="detailServiceFechaSolicitud"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Técnico:</span> <span id="detailServiceTecnico"></span></p>
          </div>

          <div>
            <p class="mb-2"><span class="font-medium text-gray-900">Costo Estimado:</span> <span id="detailServiceCostoEstimado"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Costo Real:</span> <span id="detailServiceCostoReal"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Fecha Inicio:</span> <span id="detailServiceFechaInicio"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Fecha Completado:</span> <span id="detailServiceFechaCompletado"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Kilometraje:</span> <span id="detailServiceKilometraje"></span></p>
            <p class="mb-2"><span class="font-medium text-gray-900">Fecha Creación:</span> <span id="detailServiceFechaCreacion"></span></p>
          </div>
        </div>

        <div class="mt-4">
          <p class="mb-2"><span class="font-medium text-gray-900">Descripción:</span></p>
          <p id="detailServiceDescripcion" class="text-gray-600 bg-gray-50 p-3 rounded"></p>
        </div>

        <div class="mt-4">
          <p class="mb-2"><span class="font-medium text-gray-900">Notas:</span></p>
          <p id="detailServiceNotas" class="text-gray-600 bg-gray-50 p-3 rounded"></p>
        </div>

        <div class="flex justify-end gap-3 pt-4 mt-6 border-t">
          <button id="editFromDetailModalBtn" class="px-6 py-2 bg-gray-200 text-primary rounded-md hover:text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-blue-500">
            Editar
          </button>
          <button id="closeDetailModalBtn2" class="px-6 py-2 bg-primary text-white rounded-md hover:text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-gray-400">
            Cerrar
          </button>
        </div>
      </div>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden flex justify-center items-center">
      <div class="relative bg-white rounded-lg shadow-xl p-6 w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
          <h3 class="text-2xl font-semibold text-gray-800">Editar Servicio</h3>
          <button id="closeEditServiceModalBtn" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <form id="editServiceForm" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
          <input type="hidden" id="editServiceId" name="id">

          <div>
            <div class="mb-4">
              <label for="editPlacaMotocicleta" class="block text-sm font-medium text-gray-700 mb-1">Motocicleta *</label>
              <select id="editPlacaMotocicleta" name="placa_motocicleta" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Seleccione una motocicleta</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="editTipoServicio" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Servicio *</label>
              <select id="editTipoServicio" name="tipo_servicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Seleccione tipo</option>
                <option value="Mantenimiento Preventivo">Mantenimiento Preventivo</option>
                <option value="Reparación">Reparación</option>
                <option value="Cambio de Aceite">Cambio de Aceite</option>
                <option value="Cambio de Llantas">Cambio de Llantas</option>
                <option value="Revisión Eléctrica">Revisión Eléctrica</option>
                <option value="Ajuste de Frenos">Ajuste de Frenos</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="editEstadoServicio" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
              <select id="editEstadoServicio" name="estado_servicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                <option value="pendiente">Pendiente</option>
                <option value="en_progreso">En Progreso</option>
                <option value="completado">Completado</option>
                <option value="cancelado">Cancelado</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="editPrioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
              <select id="editPrioridad" name="prioridad" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                <option value="baja">Baja</option>
                <option value="media">Media</option>
                <option value="alta">Alta</option>
                <option value="urgente">Urgente</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="editFechaSolicitud" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Solicitud *</label>
              <input type="date" id="editFechaSolicitud" name="fecha_solicitud" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="mb-4">
              <label for="editFechaInicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
              <input type="date" id="editFechaInicio" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
              <label for="editFechaCompletado" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Completado</label>
              <input type="date" id="editFechaCompletado" name="fecha_completado" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
          </div>

          <div>
            <div class="mb-4">
              <label for="editCostoEstimado" class="block text-sm font-medium text-gray-700 mb-1">Costo Estimado ($)</label>
              <input type="number" id="editCostoEstimado" name="costo_estimado" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
              <label for="editCostoReal" class="block text-sm font-medium text-gray-700 mb-1">Costo Real ($)</label>
              <input type="number" id="editCostoReal" name="costo_real" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
              <label for="editKilometrajeActual" class="block text-sm font-medium text-gray-700 mb-1">Kilometraje Actual</label>
              <input type="number" id="editKilometrajeActual" name="kilometraje_actual" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
              <label for="editTecnicoResponsable" class="block text-sm font-medium text-gray-700 mb-1">Técnico Responsable</label>
              <input type="text" id="editTecnicoResponsable" name="tecnico_responsable" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
              <label for="editNotas" class="block text-sm font-medium text-gray-700 mb-1">Notas Adicionales</label>
              <textarea id="editNotas" name="notas" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
          </div>

          <div class="col-span-1 md:col-span-2 mb-4">
            <label for="editDescripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción del Servicio *</label>
            <textarea id="editDescripcion" name="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
          </div>
        </form>

        <div class="flex justify-end gap-3 pt-4 mt-6 border-t">
          <button id="cancelEditService" class="px-6 py-2 bg-gray-200 text-primary rounded-md hover:text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-blue-500">
            Cancelar
          </button>
          <button type="submit" form="editServiceForm" class="px-6 py-2 bg-primary text-white rounded-md hover:text-white hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-gray-400">
            Guardar Cambios
          </button>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded shadow">

      <!-- Filtros de búsqueda -->
      <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
              <input type="text" id="searchInput" placeholder="Servicio, motocicleta..." class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-primary">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Servicio</label>
              <select id="filterTipoServicio" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-primary">
                  <option value="">Todos</option>
                  <option value="Mantenimiento Preventivo">Mantenimiento Preventivo</option>
                  <option value="Reparación">Reparación</option>
                  <option value="Cambio de Aceite">Cambio de Aceite</option>
                  <option value="Cambio de Llantas">Cambio de Llantas</option>
                  <option value="Revisión Eléctrica">Revisión Eléctrica</option>
                  <option value="Ajuste de Frenos">Ajuste de Frenos</option>
                  <option value="Otro">Otro</option>
              </select>
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
              <select id="filterEstadoServicio" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-primary">
                  <option value="">Todos</option>
                  <option value="pendiente">Pendiente</option>
                  <option value="en_progreso">En Progreso</option>
                  <option value="completado">Completado</option>
                  <option value="cancelado">Cancelado</option>
              </select>
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
              <select id="filterPrioridad" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-primary">
                  <option value="">Todas</option>
                  <option value="baja">Baja</option>
                  <option value="media">Media</option>
                  <option value="alta">Alta</option>
                  <option value="urgente">Urgente</option>
              </select>
          </div>
      </div>

      <!-- Botón limpiar filtros -->
      <div class="mb-4">
          <button id="clearFilters" class="text-sm text-primary hover:text-secondary">
              <i class="ri-refresh-line mr-1"></i>Limpiar filtros
          </button>
      </div>

      <h2 class="text-xl font-bold mb-4">Lista de Servicios</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-50"
                  onclick="sortTable(0)">
                <div class="flex items-center justify-between">
                  Motocicleta
                  <i class="ri-arrow-up-down-line text-xs ml-1"></i>
                </div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-50"
                  onclick="sortTable(1)">
                <div class="flex items-center justify-between">
                  Tipo Servicio
                  <i class="ri-arrow-up-down-line text-xs ml-1"></i>
                </div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-50"
                  onclick="sortTable(2)">
                <div class="flex items-center justify-between">
                  Estado
                  <i class="ri-arrow-up-down-line text-xs ml-1"></i>
                </div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer hover:bg-gray-50"
                  onclick="sortTable(3)">
                <div class="flex items-center justify-between">
                  Prioridad
                  <i class="ri-arrow-up-down-line text-xs ml-1"></i>
                </div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                Fecha Solicitud
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                Técnico
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($servicios)): ?>
              <?php foreach ($servicios as $servicio): ?>
                <tr>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div>
                      <div class="font-medium"><?php echo esc($servicio['modelo'] ?? 'N/A'); ?></div>
                      <div class="text-gray-500 text-xs"><?php echo esc($servicio['placa_motocicleta']); ?></div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500"><?php echo esc($servicio['tipo_servicio']); ?></td>
                  <td class="px-6 py-4 text-sm">
                    <?php
                      $estadoColor = 'bg-gray-100 text-gray-800';
                      switch ($servicio['estado_servicio']) {
                        case 'pendiente':
                          $estadoColor = 'bg-yellow-100 text-yellow-800';
                          break;
                        case 'en_progreso':
                          $estadoColor = 'bg-blue-100 text-blue-800';
                          break;
                        case 'completado':
                          $estadoColor = 'bg-green-100 text-green-800';
                          break;
                        case 'cancelado':
                          $estadoColor = 'bg-red-100 text-red-800';
                          break;
                      }
                    ?>
                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo $estadoColor; ?>">
                      <?php echo ucfirst(str_replace('_', ' ', $servicio['estado_servicio'])); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm">
                    <?php
                      $prioridadColor = 'bg-gray-100 text-gray-800';
                      switch ($servicio['prioridad']) {
                        case 'baja':
                          $prioridadColor = 'bg-green-100 text-green-800';
                          break;
                        case 'media':
                          $prioridadColor = 'bg-yellow-100 text-yellow-800';
                          break;
                        case 'alta':
                          $prioridadColor = 'bg-orange-100 text-orange-800';
                          break;
                        case 'urgente':
                          $prioridadColor = 'bg-red-100 text-red-800';
                          break;
                      }
                    ?>
                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo $prioridadColor; ?>">
                      <?php echo ucfirst($servicio['prioridad']); ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    <?php echo date('d/m/Y', strtotime($servicio['fecha_solicitud'])); ?>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    <?php echo esc($servicio['tecnico_responsable'] ?? 'No asignado'); ?>
                  </td>
                  <td class="px-6 py-4 text-sm font-medium">
                    <button class="view-service text-primary hover:text-primary/80 mr-3" data-service-id="<?php echo esc($servicio['id']); ?>">
                      <i class="ri-eye-line"></i>
                    </button>
                    <button class="edit-service text-primary hover:text-primary/80 mr-3" data-service-id="<?php echo esc($servicio['id']); ?>">
                      <i class="ri-pencil-line"></i>
                    </button>
                    <button class="delete-service text-red-600 hover:text-red-800" data-service-id="<?php echo esc($servicio['id']); ?>">
                      <i class="ri-delete-bin-line"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No hay servicios registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Referencias a los modales
      const addServiceModal = document.getElementById('addServiceModal');
      const serviceDetailModal = document.getElementById('serviceDetailModal');
      const editServiceModal = document.getElementById('editServiceModal');

      // Referencias a los botones para abrir/cerrar el modal de agregar
      const addServiceButton = document.getElementById('addServiceButton');
      const closeAddServiceModal = document.getElementById('closeAddServiceModal');
      const cancelAddService = document.getElementById('cancelAddService');

      // Referencias a los formularios
      const serviceForm = document.getElementById('serviceForm');
      const editServiceForm = document.getElementById('editServiceForm');

      // Función para mostrar/ocultar modales
      const showModal = (modalElement) => modalElement.classList.remove('hidden');
      const hideModal = (modalElement) => modalElement.classList.add('hidden');
      const showAlert = (message, isError = false) => {
          alert(message);
      };

      // Load motorcycles for the select dropdown
      const loadMotocicletas = async () => {
        try {
          const response = await fetch(`${baseUrl}/servicios/get-motocicletas`, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });
          const motocicletas = await response.json();

          const selects = ['placa_motocicleta', 'editPlacaMotocicleta'];
          selects.forEach(selectId => {
            const select = document.getElementById(selectId);
            if (select) {
              select.innerHTML = '<option value="">Seleccione una motocicleta</option>';
              motocicletas.forEach(moto => {
                const option = document.createElement('option');
                option.value = moto.placa;
                option.textContent = `${moto.placa} - ${moto.modelo} ${moto.nombre_marca} ${moto.año}`;
                select.appendChild(option);
              });
            }
          });
        } catch (error) {
          console.error('Error loading motocicletas:', error);
        }
      };

      // Eventos para el modal de "Agregar Nuevo Servicio"
      addServiceButton?.addEventListener('click', () => {
        loadMotocicletas();
        showModal(addServiceModal);
      });

      closeAddServiceModal?.addEventListener('click', () => hideModal(addServiceModal));
      cancelAddService?.addEventListener('click', () => {
          hideModal(addServiceModal);
          serviceForm.reset();
      });

      // Evento de envío del formulario para "Agregar Nuevo Servicio"
      serviceForm?.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Validación básica de HTML5
        if (!this.checkValidity()) {
          showAlert('Por favor, completa todos los campos requeridos y asegúrate de que el formato sea correcto.', true);
          return;
        }

        const data = {
          placa_motocicleta: this.placa_motocicleta.value,
          tipo_servicio: this.tipo_servicio.value,
          descripcion: this.descripcion.value,
          estado_servicio: this.estado_servicio?.value || 'pendiente',
          fecha_solicitud: this.fecha_solicitud.value,
          costo_estimado: this.costo_estimado.value || null,
          tecnico_responsable: this.tecnico_responsable.value || null,
          prioridad: this.prioridad.value,
          kilometraje_actual: this.kilometraje_actual.value || null
        };

        try {
          const response = await fetch(`${baseUrl}/servicios/createViaAjax`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
          });

          const res = await response.json();

          if (!response.ok) {
            const errorMessage = res.error || 'Error desconocido al crear servicio.';
            throw new Error(errorMessage);
          }

          showAlert('Servicio creado exitosamente.');
          hideModal(addServiceModal);
          serviceForm.reset();
          location.reload();

        } catch (error) {
          showAlert(`Error al crear servicio: ${error.message}`, true);
        }
      });

      // Evento para ver detalles del servicio
      document.querySelector('table tbody').addEventListener('click', async (event) => {
        const viewButton = event.target.closest('.view-service');
        if (viewButton) {
          const serviceId = viewButton.dataset.serviceId;

          try {
            const response = await fetch(`${baseUrl}/servicios/details/${serviceId}`, {
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            });
            const data = await response.json();

            if (response.ok) {
              // Populate detail modal
              document.getElementById('detailServiceId').textContent = data.id || 'N/A';
              document.getElementById('detailServiceMoto').textContent = `${data.modelo || 'N/A'} ${data.nombre_marca || ''} ${data.año || ''} (${data.placa_motocicleta || 'N/A'})`;
              document.getElementById('detailServiceTipo').textContent = data.tipo_servicio || 'N/A';
              document.getElementById('detailServiceEstado').textContent = data.estado_servicio ? data.estado_servicio.replace('_', ' ').toUpperCase() : 'N/A';
              document.getElementById('detailServicePrioridad').textContent = data.prioridad ? data.prioridad.toUpperCase() : 'N/A';
              document.getElementById('detailServiceFechaSolicitud').textContent = data.fecha_solicitud ? new Date(data.fecha_solicitud).toLocaleDateString('es-ES') : 'N/A';
              document.getElementById('detailServiceTecnico').textContent = data.tecnico_responsable || 'No asignado';
              document.getElementById('detailServiceCostoEstimado').textContent = data.costo_estimado ? `$${parseFloat(data.costo_estimado).toFixed(2)}` : 'N/A';
              document.getElementById('detailServiceCostoReal').textContent = data.costo_real ? `$${parseFloat(data.costo_real).toFixed(2)}` : 'N/A';
              document.getElementById('detailServiceFechaInicio').textContent = data.fecha_inicio ? new Date(data.fecha_inicio).toLocaleDateString('es-ES') : 'N/A';
              document.getElementById('detailServiceFechaCompletado').textContent = data.fecha_completado ? new Date(data.fecha_completado).toLocaleDateString('es-ES') : 'N/A';
              document.getElementById('detailServiceKilometraje').textContent = data.kilometraje_actual || 'N/A';
              document.getElementById('detailServiceFechaCreacion').textContent = data.created_at ? new Date(data.created_at).toLocaleDateString('es-ES') : 'N/A';
              document.getElementById('detailServiceDescripcion').textContent = data.descripcion || 'Sin descripción';
              document.getElementById('detailServiceNotas').textContent = data.notas || 'Sin notas';

              showModal(serviceDetailModal);
            } else {
              showAlert(`Error al cargar detalles: ${data.error || 'Error desconocido'}`, true);
            }
          } catch (error) {
            console.error('Error fetching service details:', error);
            showAlert('Error de conexión al cargar detalles.', true);
          }
        }
      });

      // Evento para editar servicio desde la tabla
      document.querySelector('table tbody').addEventListener('click', async (event) => {
        const editButton = event.target.closest('.edit-service');
        if (editButton) {
          const serviceId = editButton.dataset.serviceId;

          try {
            const response = await fetch(`${baseUrl}/servicios/details/${serviceId}`, {
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            });
            const data = await response.json();

            if (response.ok) {
              // Load motorcycles first
              await loadMotocicletas();

              // Populate edit form
              document.getElementById('editServiceId').value = data.id;
              document.getElementById('editPlacaMotocicleta').value = data.placa_motocicleta || '';
              document.getElementById('editTipoServicio').value = data.tipo_servicio || '';
              document.getElementById('editEstadoServicio').value = data.estado_servicio || '';
              document.getElementById('editPrioridad').value = data.prioridad || '';
              document.getElementById('editFechaSolicitud').value = data.fecha_solicitud ? data.fecha_solicitud.split(' ')[0] : '';
              document.getElementById('editFechaInicio').value = data.fecha_inicio ? data.fecha_inicio.split(' ')[0] : '';
              document.getElementById('editFechaCompletado').value = data.fecha_completado ? data.fecha_completado.split(' ')[0] : '';
              document.getElementById('editCostoEstimado').value = data.costo_estimado || '';
              document.getElementById('editCostoReal').value = data.costo_real || '';
              document.getElementById('editKilometrajeActual').value = data.kilometraje_actual || '';
              document.getElementById('editTecnicoResponsable').value = data.tecnico_responsable || '';
              document.getElementById('editNotas').value = data.notas || '';
              document.getElementById('editDescripcion').value = data.descripcion || '';

              showModal(editServiceModal);
            } else {
              showAlert(`Error al cargar datos para edición: ${data.error || 'Error desconocido'}`, true);
            }
          } catch (error) {
            console.error('Error fetching data for edit modal:', error);
            showAlert('Error de conexión al cargar datos para edición.', true);
          }
        }
      });

      // Evento para editar desde el modal de detalles
      document.getElementById('editFromDetailModalBtn')?.addEventListener('click', () => {
        const serviceId = document.getElementById('detailServiceId').textContent;
        hideModal(serviceDetailModal);

        // Load data for edit modal
        fetch(`${baseUrl}/servicios/details/${serviceId}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data) {
            loadMotocicletas().then(() => {
              // Populate edit form
              document.getElementById('editServiceId').value = data.id;
              document.getElementById('editPlacaMotocicleta').value = data.placa_motocicleta || '';
              document.getElementById('editTipoServicio').value = data.tipo_servicio || '';
              document.getElementById('editEstadoServicio').value = data.estado_servicio || '';
              document.getElementById('editPrioridad').value = data.prioridad || '';
              document.getElementById('editFechaSolicitud').value = data.fecha_solicitud ? data.fecha_solicitud.split(' ')[0] : '';
              document.getElementById('editFechaInicio').value = data.fecha_inicio ? data.fecha_inicio.split(' ')[0] : '';
              document.getElementById('editFechaCompletado').value = data.fecha_completado ? data.fecha_completado.split(' ')[0] : '';
              document.getElementById('editCostoEstimado').value = data.costo_estimado || '';
              document.getElementById('editCostoReal').value = data.costo_real || '';
              document.getElementById('editKilometrajeActual').value = data.kilometraje_actual || '';
              document.getElementById('editTecnicoResponsable').value = data.tecnico_responsable || '';
              document.getElementById('editNotas').value = data.notas || '';
              document.getElementById('editDescripcion').value = data.descripcion || '';

              showModal(editServiceModal);
            });
          }
        })
        .catch(error => {
          console.error('Error loading data for edit:', error);
          showAlert('Error al cargar datos para edición.', true);
        });
      });

      // Evento para eliminar servicio
      document.querySelector('table tbody').addEventListener('click', async (event) => {
        const deleteButton = event.target.closest('.delete-service');
        if (deleteButton) {
          const serviceId = deleteButton.dataset.serviceId;

          if (confirm('¿Estás seguro de que deseas eliminar este servicio? Esta acción no se puede deshacer.')) {
            try {
              const response = await fetch(`${baseUrl}/servicios/delete/${serviceId}`, {
                method: 'DELETE',
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                }
              });

              if (response.ok) {
                showAlert('Servicio eliminado exitosamente.');
                location.reload();
              } else {
                const data = await response.json();
                showAlert(`Error al eliminar servicio: ${data.error || 'Error desconocido'}`, true);
              }
            } catch (error) {
              console.error('Error deleting service:', error);
              showAlert('Error de conexión al eliminar servicio.', true);
            }
          }
        }
      });

      // Evento de envío del formulario de edición
      editServiceForm?.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
          showAlert('Por favor, completa todos los campos requeridos.', true);
          return;
        }

        const serviceId = this.id.value;
        const data = {
          placa_motocicleta: this.placa_motocicleta.value,
          tipo_servicio: this.tipo_servicio.value,
          descripcion: this.descripcion.value,
          estado_servicio: this.estado_servicio.value,
          prioridad: this.prioridad.value,
          fecha_solicitud: this.fecha_solicitud.value,
          fecha_inicio: this.fecha_inicio.value || null,
          fecha_completado: this.fecha_completado.value || null,
          costo_estimado: this.costo_estimado.value || null,
          costo_real: this.costo_real.value || null,
          tecnico_responsable: this.tecnico_responsable.value || null,
          kilometraje_actual: this.kilometraje_actual.value || null,
          notas: this.notas.value || null
        };

        try {
          const response = await fetch(`${baseUrl}/servicios/update/${serviceId}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
          });

          const res = await response.json();

          if (!response.ok) {
            const errorMessage = res.error || 'Error desconocido al actualizar servicio.';
            throw new Error(errorMessage);
          }

          showAlert('Servicio actualizado exitosamente.');
          hideModal(editServiceModal);
          location.reload();

        } catch (error) {
          showAlert(`Error al actualizar servicio: ${error.message}`, true);
        }
      });

      // Eventos para cerrar modales
      document.getElementById('closeDetailModalBtn')?.addEventListener('click', () => hideModal(serviceDetailModal));
      document.getElementById('closeDetailModalBtn2')?.addEventListener('click', () => hideModal(serviceDetailModal));
      document.getElementById('closeEditServiceModalBtn')?.addEventListener('click', () => hideModal(editServiceModal));
      document.getElementById('cancelEditService')?.addEventListener('click', () => hideModal(editServiceModal));

      // Funcionalidad de búsqueda y filtros
      const searchInput = document.getElementById('searchInput');
      const filterTipoServicio = document.getElementById('filterTipoServicio');
      const filterEstadoServicio = document.getElementById('filterEstadoServicio');
      const filterPrioridad = document.getElementById('filterPrioridad');
      const clearFilters = document.getElementById('clearFilters');

      function filterTable() {
        const searchTerm = searchInput?.value.toLowerCase() || '';
        const tipoFilter = filterTipoServicio?.value || '';
        const estadoFilter = filterEstadoServicio?.value || '';
        const prioridadFilter = filterPrioridad?.value || '';

        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
          if (row.cells.length < 7) return; // Skip if not a data row

          const motocicleta = row.cells[0].textContent.toLowerCase();
          const tipo = row.cells[1].textContent.toLowerCase();
          const estado = row.cells[2].textContent.toLowerCase();
          const prioridad = row.cells[3].textContent.toLowerCase();

          const matchesSearch = !searchTerm ||
            motocicleta.includes(searchTerm) ||
            tipo.includes(searchTerm);

          const matchesTipo = !tipoFilter || tipo.includes(tipoFilter.toLowerCase());
          const matchesEstado = !estadoFilter || estado.includes(estadoFilter.toLowerCase());
          const matchesPrioridad = !prioridadFilter || prioridad.includes(prioridadFilter.toLowerCase());

          if (matchesSearch && matchesTipo && matchesEstado && matchesPrioridad) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      }

      searchInput?.addEventListener('input', filterTable);
      filterTipoServicio?.addEventListener('change', filterTable);
      filterEstadoServicio?.addEventListener('change', filterTable);
      filterPrioridad?.addEventListener('change', filterTable);

      clearFilters?.addEventListener('click', () => {
        if (searchInput) searchInput.value = '';
        if (filterTipoServicio) filterTipoServicio.value = '';
        if (filterEstadoServicio) filterEstadoServicio.value = '';
        if (filterPrioridad) filterPrioridad.value = '';
        filterTable();
      });

      // Función para ordenar tabla
      function sortTable(columnIndex) {
        const table = document.querySelector('table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Skip the "No services" row
        const dataRows = rows.filter(row => row.cells.length >= 7);

        dataRows.sort((a, b) => {
          const aText = a.cells[columnIndex].textContent.trim().toLowerCase();
          const bText = b.cells[columnIndex].textContent.trim().toLowerCase();

          if (aText < bText) return -1;
          if (aText > bText) return 1;
          return 0;
        });

        // Re-append sorted rows
        dataRows.forEach(row => tbody.appendChild(row));
      }

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
  </script>

  <?= $this->include('partials/notification-js') ?>

</body>
</html>
