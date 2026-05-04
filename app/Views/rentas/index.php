<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Rentas</title>
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
      overflow-x: hidden;
    }

    /* Ensure notification dropdown is visible */
    #notificationDropdown {
      position: fixed !important;
      z-index: 10000 !important;
      top: 60px !important;
      right: 20px !important;
      left: auto !important;
      transform: none !important;
    }
  </style>
</head>

<body class="bg-white">

  <!-- Header -->

  <?= $this->include('partials/header') ?>

  <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-primary">Gestión de Rentas</h1>
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>

        <button id="addRentalButton"
          class="bg-primary text-white px-4 py-2 rounded-button hover:bg-secondary transition-all duration-200 flex items-center whitespace-nowrap !rounded-button">
          <div class="w-4 h-4 flex items-center justify-center mr-1.5">
            <i class="ri-add-line"></i>
          </div>
          Nueva Renta
        </button>
      </div>
    </div>

    <!-- Active Rentals Table -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-primary">Rentas Activas</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placa</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca/Modelo</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Entrega</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Renovación</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renta (sin IVA)</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renta (con IVA)</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($rentas)): ?>
              <?php foreach ($rentas as $renta): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= esc($renta['placa']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= esc($renta['nombre_marca']) ?> <?= esc($renta['modelo']) ?> (<?= esc($renta['año']) ?>)
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($renta['nombre_cliente']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= date('d/m/Y', strtotime($renta['fecha_entrega'])) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= date('d/m/Y', strtotime($renta['fecha_renovacion'])) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?= number_format($renta['renta_sinIva'], 2) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$<?= number_format($renta['renta_conIva'], 2) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    <?= esc($renta['nombre_estado']) ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button onclick="editRental('<?= esc($renta['placa']) ?>')" class="text-primary hover:text-secondary mr-3">
                    <i class="ri-edit-line"></i> Editar
                  </button>
                  <button onclick="endRental('<?= esc($renta['placa']) ?>')" class="text-red-600 hover:text-red-900">
                    <i class="ri-close-line"></i> Finalizar
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                  No hay rentas activas en este momento.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Available Motorcycles Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-primary">Motocicletas Disponibles</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placa</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca/Modelo</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Año</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (!empty($motos_disponibles)): ?>
              <?php foreach ($motos_disponibles as $moto): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= esc($moto['placa']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= esc($moto['nombre_marca']) ?> <?= esc($moto['modelo']) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= esc($moto['año']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    <?= esc($moto['nombre_estado']) ?>
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button onclick="rentMotorcycle('<?= esc($moto['placa']) ?>')" class="text-primary hover:text-secondary">
                    <i class="ri-play-line"></i> Rentar
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                  No hay motocicletas disponibles para rentar.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <!-- Create/Edit Rental Modal -->
  <div id="rentalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
      <div class="mt-3">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-primary" id="modalTitle">Nueva Renta</h3>
          <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
            <i class="ri-close-line text-xl"></i>
          </button>
        </div>

          <form id="rentalForm">
          <input type="hidden" id="rentalId" name="placa">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div id="motocicletaField" style="display: none;">
              <label for="modalMotocicleta" class="block text-sm font-medium text-gray-700 mb-1">Motocicleta</label>
              <select id="modalMotocicleta" name="motocicleta" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Seleccionar motocicleta</option>
                <?php if (!empty($motos_disponibles)): ?>
                  <?php foreach ($motos_disponibles as $moto): ?>
                    <option value="<?= esc($moto['placa']) ?>" data-marca="<?= esc($moto['nombre_marca']) ?>" data-modelo="<?= esc($moto['modelo']) ?>" data-año="<?= esc($moto['año']) ?>">
                      <?= esc($moto['placa']) ?> - <?= esc($moto['nombre_marca']) ?> <?= esc($moto['modelo']) ?> (<?= esc($moto['año']) ?>)
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div id="motocicletaField" style="display: none;">
              <label for="modalMotocicleta" class="block text-sm font-medium text-gray-700 mb-1">Motocicleta</label>
              <select id="modalMotocicleta" name="motocicleta" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Seleccionar motocicleta</option>
                <?php if (!empty($motos_disponibles)): ?>
                  <?php foreach ($motos_disponibles as $moto): ?>
                    <option value="<?= esc($moto['placa']) ?>" data-marca="<?= esc($moto['nombre_marca']) ?>" data-modelo="<?= esc($moto['modelo']) ?>" data-año="<?= esc($moto['año']) ?>">
                      <?= esc($moto['placa']) ?> - <?= esc($moto['nombre_marca']) ?> <?= esc($moto['modelo']) ?> (<?= esc($moto['año']) ?>)
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
 
            <div>
              <label for="modalCliente" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
              <select id="modalCliente" name="idcliente" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
                <option value="">Seleccionar cliente</option>
                <?php if (!empty($clientes)): ?>
                  <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= esc($cliente['idcliente']) ?>"><?= esc($cliente['cliente']) ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>

          <div class="mb-4">
            <label for="modalPlaca" class="block text-sm font-medium text-gray-700 mb-1">Placa</label>
            <input type="text" id="modalPlaca" name="placa" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-gray-50" readonly>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
              <label for="modalFechaEntrega" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Entrega</label>
              <input type="date" id="modalFechaEntrega" name="fecha_entrega" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>

            <div>
              <label for="modalFechaRenovacion" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Renovación</label>
              <input type="date" id="modalFechaRenovacion" name="fecha_renovacion" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label for="modalRentaSinIva" class="block text-sm font-medium text-gray-700 mb-1">Renta sin IVA ($)</label>
              <input type="number" step="0.01" id="modalRentaSinIva" name="renta_sinIva" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>

            <div>
              <label for="modalRentaConIva" class="block text-sm font-medium text-gray-700 mb-1">Renta con IVA ($)</label>
              <input readonly type="number" step="0.01" id="modalRentaConIva" name="renta_conIva" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            </div>
          </div>

          <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary border border-transparent rounded-md hover:bg-secondary">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Success/Error Messages -->
  <div id="message" class="fixed top-4 right-4 p-4 rounded-md shadow-lg hidden z-50">
    <div class="flex">
      <div class="flex-shrink-0">
        <i id="messageIcon" class="text-xl"></i>
      </div>
      <div class="ml-3">
        <p id="messageText" class="text-sm font-medium"></p>
      </div>
      <div class="ml-auto pl-3">
        <button onclick="closeMessage()" class="text-gray-400 hover:text-gray-600">
          <i class="ri-close-line"></i>
        </button>
      </div>
    </div>
  </div>

  <script>
    let editingPlaca = null;
    let availableMotorcycles = <?= json_encode($motos_disponibles) ?>;
    let clients = <?= json_encode($clientes) ?>;

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

      // Motorcycle selection handler
      document.getElementById('modalMotocicleta').addEventListener('change', function(e) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const placa = e.target.value;
        document.getElementById('modalPlaca').value = placa;
        document.getElementById('rentalId').value = placa;
      });

      // Form submission
      document.getElementById('rentalForm').addEventListener('submit', handleFormSubmit);

      // Initialize notifications (functions loaded from partial)
    });

    function showMessage(message, type = 'success') {
      const messageDiv = document.getElementById('message');
      const messageText = document.getElementById('messageText');
      const messageIcon = document.getElementById('messageIcon');

      messageText.textContent = message;
      messageDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${type === 'success' ? 'bg-green-100 border-l-4 border-green-500' : 'bg-red-100 border-l-4 border-red-500'}`;
      messageIcon.className = `text-xl ${type === 'success' ? 'text-green-500 ri-check-line' : 'text-red-500 ri-error-warning-line'}`;

      messageDiv.classList.remove('hidden');
      setTimeout(() => closeMessage(), 5000);
    }

    function closeMessage() {
      document.getElementById('message').classList.add('hidden');
    }

    function openModal(title = 'Nueva Renta') {
      document.getElementById('modalTitle').textContent = title;
      document.getElementById('rentalModal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('rentalModal').classList.add('hidden');
      document.getElementById('rentalForm').reset();
      document.getElementById('modalMotocicleta').value = '';
      const motocicletaField = document.getElementById('motocicletaField');
      if (motocicletaField) {
        motocicletaField.style.display = 'none';
      }
      editingPlaca = null;
    }

    function rentMotorcycle(placa) {
      editingPlaca = null;
      const motorcycle = availableMotorcycles.find(m => m.placa === placa);
      if (motorcycle) {
        document.getElementById('modalMotocicleta').value = motorcycle.placa;
        document.getElementById('modalMotocicleta').disabled = false;
        document.getElementById('modalPlaca').value = motorcycle.placa;
        document.getElementById('rentalId').value = motorcycle.placa;
        // Show motorcycle field for renting from available motorcycles
        const motocicletaField = document.getElementById('motocicletaField');
        if (motocicletaField) {
          motocicletaField.style.display = 'block';
        }
        openModal('Nueva Renta');
      }
    }

    function editRental(placa) {
      editingPlaca = placa;

      fetch(`${baseUrl}/rentas/details/${placa}`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        }
      })
      .then(response => response.json())
        .then(data => {
          if (data.placa) {
            document.getElementById('modalMotocicleta').value = data.placa;
            document.getElementById('modalMotocicleta').disabled = true;
            document.getElementById('modalPlaca').value = data.placa;
            document.getElementById('rentalId').value = data.placa;
            document.getElementById('modalCliente').value = data.idcliente;
            document.getElementById('modalFechaEntrega').value = data.fecha_entrega;
            document.getElementById('modalFechaRenovacion').value = data.fecha_renovacion;
            document.getElementById('modalRentaSinIva').value = data.renta_siniva;
            document.getElementById('modalRentaConIva').value = data.renta_coniva;
            openModal('Editar Renta');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showMessage('Error al cargar los datos de la renta', 'error');
        });
    }

    function endRental(placa) {
      if (confirm('¿Está seguro de que desea finalizar esta renta? La motocicleta pasara a disponible para la venta.')) {
        fetch(`${baseUrl}/rentas/end/${placa}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.message) {
            showMessage(data.message, 'success');
            setTimeout(() => location.reload(), 2000);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showMessage('Error al finalizar la renta', 'error');
        });
      }
    }

    function handleFormSubmit(e) {
      e.preventDefault();

      const formData = new FormData(e.target);
      const data = Object.fromEntries(formData);

      // Remove the motocicleta field since we only need placa
      delete data.motocicleta;

      const url = editingPlaca ? `${baseUrl}/rentas/update/${editingPlaca}` : `${baseUrl}/rentas/createRental`;
      const method = editingPlaca ? 'POST' : 'POST';

      fetch(url, {
        method: method,
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data.message) {
          showMessage(data.message, 'success');
          closeModal();
          setTimeout(() => location.reload(), 2000);
        } else if (data.error) {
          showMessage(data.error, 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showMessage('Error al guardar la renta', 'error');
      });
    }

    document.getElementById('addRentalButton').addEventListener('click', () => {
      if (availableMotorcycles.length === 0) {
        showMessage('No hay motocicletas disponibles para rentar', 'error');
        return;
      }
      editingPlaca = null;
      document.getElementById('rentalForm').reset();
      document.getElementById('modalMotocicleta').disabled = false;
      document.getElementById('rentalId').value = '';
      // Show motorcycle field for new rentals
      const motocicletaField = document.getElementById('motocicletaField');
      if (motocicletaField) {
        motocicletaField.style.display = 'block';
      }
      openModal('Nueva Renta');
    });

  // Configuración del IVA (0.13 = 13%, cámbialo según tu país, ej: 0.16, 0.19)
const TASA_IVA = 0.13; 

const inputSinIva = document.getElementById('modalRentaSinIva');
const inputConIva = document.getElementById('modalRentaConIva');

// Función 1: Calcular CON IVA cuando se escribe el neto
inputSinIva.addEventListener('input', function() {
    const valorSinIva = parseFloat(this.value);
    
    if (!isNaN(valorSinIva)) {
        // Fórmula: Base * (1 + 0.13)
        const total = valorSinIva * (1 + TASA_IVA);
        inputConIva.value = total.toFixed(2); // Redondeamos a 2 decimales
    } else {
        inputConIva.value = '';
    }
});

// Función 2: Calcular SIN IVA cuando se escribe el total (Inverso)
inputConIva.addEventListener('input', function() {
    const valorConIva = parseFloat(this.value);
    
    if (!isNaN(valorConIva)) {
        // Fórmula: Total / (1 + 0.13)
        const base = valorConIva / (1 + TASA_IVA);
        inputSinIva.value = base.toFixed(2);
    } else {
        inputSinIva.value = '';
    }
});
  </script>

  <?= $this->include('partials/notification-js') ?>

</body>

</html>
