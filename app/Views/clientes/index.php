<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Clientes</title>
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
    :where([class^="ri-"])::before {
      content: "\f3c2";
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
    }
  </style>
</head>

<!--<script src="<?= base_url('js/table.js') ?>"></script>
<script src="<?= base_url('js/user-modal.js') ?>"></script>-->



<body class="bg-white">

  <?php
  $session = session();
  $rol = $session->get('rol');
  $allowedRoles = ['Administrador', 'Jefatura', 'admin'];
  ?>
  <!-- Header -->

  <?= $this->include('partials/header') ?>

  <!--Main-->
  <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-primary">Gestión de Clientes</h1>
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>

        <?php if (in_array($rol, $allowedRoles)): ?>
        <div class="flex items-center space-x-2">
          <button id="addClientButton"
            class="bg-primary text-white px-4 py-2 rounded-button hover:bg-secondary transition-all duration-200 flex items-center whitespace-nowrap !rounded-button">
            <div class="w-4 h-4 flex items-center justify-center mr-1.5">
              <i class="ri-user-add-line"></i>
            </div>
            Nuevo Cliente
          </button>
        </div>
        <?php endif; ?>
      </div>
    </div>

      <!-- Agregar cliente -->

      <div id="addClientModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-green-600">Agregar Nuevo Cliente</h3>
            <button id="closeAddClientModal" class="text-gray-400 hover:text-gray-700">
              <i class="ri-close-line text-xl"></i>
            </button>
          </div>
          <form id="clientForm" class="space-y-4">
            <div>
              <label for="clientName" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cliente</label>
              <input type="text" id="clientName" name="Cliente" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-green-500 focus:outline-none" required>
            </div>
            <div>
              <label for="clientCompany" class="block text-sm font-medium text-gray-700 mb-1">Empresa (Opcional)</label>
              <select id="clientCompany" name="idempresa" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-green-500 focus:outline-none">
                <option value="">Seleccionar empresa</option>
                <?php foreach ($empresas as $empresa): ?>
                  <option value="<?= $empresa['idempresa'] ?>"><?= esc($empresa['empresa']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
              <button type="button" id="cancelAddClient" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:text-white hover:bg-green-700">Cancelar</button>
              <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-button hover:bg-green-700">Guardar Cliente</button>
            </div>
          </form>
        </div>
      </div>
                <!--agencias -->
      <div class="flex items-center space-x-2">
      <button id="openAgenciasModal"
        class="bg-gray-100 text-primary border border-primary/20 px-4 py-2 rounded-button hover:bg-gray-200 transition-all duration-200 flex items-center whitespace-nowrap">
    <i class="ri-building-line mr-1.5"></i>
    Agencias
  </button>
  <button id="addClientButton" ... >
  </button>
</div>

      <!-- Lista de clientes -->

      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Lista de Clientes</h2>
        <div class="overflow-x-auto">

        <!-- Filtros de búsqueda -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
          <input type="text" id="searchInput" placeholder="Nombre del cliente…"
                class="w-full px-3 py-2 border rounded-button">
          <select id="filterEmpresa" class="w-full px-3 py-2 border rounded-button">
            <option value="">Todas las empresas</option>
            <?php foreach ($empresas as $empresa): ?>
              <option value="<?= esc($empresa['empresa']) ?>"><?= esc($empresa['empresa']) ?></option>
            <?php endforeach; ?>
          </select>
          <button id="clearFilters"
                  class="px-4 py-2 bg-gray-100 text-sm font-medium rounded-button hover:text-white hover:bg-secondary">
            <i class="ri-refresh-line mr-1"></i>Limpiar
          </button>
        </div>
 
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase
                        hover:bg-gray-50" onclick="sortTable(0)">
                <div class="flex items-center">Nombre <i class="ri-arrow-up-down-line ml-1 text-xs"></i></div>
              </th>
              <th class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase
                        hover:bg-gray-50" onclick="sortTable(1)">
                <div class="flex items-center">Empresa <i class="ri-arrow-up-down-line ml-1 text-xs"></i></div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($clientes as $cliente): ?>
              <tr>
                <td class="px-6 py-4 text-sm text-gray-900"><?= esc($cliente['cliente']) ?></td>
                <td class="px-6 py-4 text-sm text-gray-500"><?= esc($cliente['nombre_empresa'] ?: 'Sin empresa') ?></td>
                <td class="px-6 py-4 text-sm font-medium">
                  <?php if (in_array($rol, $allowedRoles)): ?>
                  <button class="view-client text-primary hover:text-primary/80 mr-3" data-client-id="<?= $cliente['idcliente'] ?>">
                    <i class="ri-eye-line"></i>
                  </button>
                  <button class="edit-client text-blue-600 hover:text-blue-800 mr-3" data-client-id="<?= $cliente['idcliente'] ?>">
                    <i class="ri-edit-line"></i>
                  </button>
                  <button class="delete-client text-red-600 hover:text-red-800" data-client-id="<?= $cliente['idcliente'] ?>">
                    <i class="ri-delete-bin-line"></i>
                  </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>



      <!-- Detalles de cliente -->
      <div id="clientDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-md relative">
          <!-- Boton cerrar -->
          <button id="closeDetailModalButton" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
            <i class="ri-close-line text-xl"></i>
          </button>

          <!-- Contenido -->
          <h2 class="text-xl font-bold mb-4 text-primary">Detalles del Cliente</h2>
          <div class="space-y-4 text-sm text-gray-700">
            <div>
              <p class="font-medium text-gray-500">Nombre</p>
              <p id="detailName" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">Empresa</p>
              <p id="detailCompany" class="text-gray-900">—</p>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end space-x-2 mt-6">
            <button id="editClientButton" data-client-id="" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-button hover:text-white hover:bg-secondary">
              Editar
            </button>
            <button id="closeDetailButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:text-white hover:bg-secondary">
              Cerrar
            </button>
          </div>
        </div>
      </div>

      <!-- Editar Cliente -->

      <div id="editClientModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-primary">Editar Cliente</h3>
            <button id="closeEditClientModal" class="text-gray-400 hover:text-gray-700">
              <i class="ri-close-line text-xl"></i>
            </button>
          </div>
          <form id="editClientForm" class="space-y-4">
            <input type="hidden" id="editClientId">

            <div>
              <label for="editClientName" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
              <input type="text" id="editClientName" class="w-full px-3 py-2 border rounded-button">
            </div>

            <div>
              <label for="editClientCompany" class="block text-sm font-medium text-gray-700">Empresa</label>
              <select id="editClientCompany" class="w-full px-3 py-2 border rounded-button">
                <option value="">Sin empresa</option>
                <?php foreach ($empresas as $empresa): ?>
                  <option value="<?= $empresa['idempresa'] ?>"><?= esc($empresa['empresa']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
              <button type="button" id="cancelEditClient" class="px-4 py-2 text-sm bg-gray-100 rounded-button hover:text-white hover:bg-secondary">Cancelar</button>
              <button type="submit" class="px-4 py-2 text-sm bg-primary text-white rounded-button hover:text-white hover:bg-secondary">Guardar</button>
            </div>
          </form>

        </div>
      </div>
  <!-- model agencia -->
   <div id="agenciasModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden transition-opacity duration-300">
  <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-xl font-bold text-primary">Gestión de Agencias</h3>
      <div class="flex space-x-2">
        <button id="btnNuevaAgencia" class="bg-green-600 text-white px-3 py-1.5 rounded-button text-sm hover:bg-green-700">
            <i class="ri-add-line"></i> Nueva Agencia
        </button>
        <button id="closeAgenciasModal" class="text-gray-400 hover:text-gray-700">
          <i class="ri-close-line text-2xl"></i>
        </button>
      </div>
    </div>

    <div id="agenciaFormContainer" class="hidden mb-6 p-4 border border-gray-100 bg-gray-50 rounded-lg">
        <form id="agenciaForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" id="idagencia" name="idagencia"> 
        
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase">Nombre de Agencia</label>
            <input type="text" id="inputAgencia" name="agencia" class="w-full px-3 py-2 border rounded-button text-sm" required>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase">Dirección</label>
            <input type="text" id="inputDireccion" name="dirrecion" class="w-full px-3 py-2 border rounded-button text-sm" required>
        </div>
        <div class="md:col-span-2 flex justify-end space-x-2">
            <button type="button" id="cancelAgencia" class="text-xs text-gray-500 hover:underline">Cancelar</button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-button text-xs font-bold">
                <i class="ri-save-line mr-1"></i> Guardar Agencia
            </button>
        </div>
    </form>
    </div>

    <div class="overflow-y-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agencia</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dirección</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
          </tr>
        </thead>
        <tbody id="agenciasTableBody" class="divide-y divide-gray-200 text-sm text-gray-700">
    </tbody>
      </table>
    </div>
  </div>
</div>


  </main>

  <script>

    document.addEventListener('DOMContentLoaded', () => {
      // Funcionalidad modal agregar cliente
      const addClientButton = document.getElementById('addClientButton');
      const addClientModal = document.getElementById('addClientModal');
      const closeAddClientModal = document.getElementById('closeAddClientModal');
      const cancelAddClient = document.getElementById('cancelAddClient');
      const clientForm = document.getElementById('clientForm');

      addClientButton?.addEventListener('click', () => addClientModal.classList.remove('hidden'));
      closeAddClientModal?.addEventListener('click', () => addClientModal.classList.add('hidden'));
      cancelAddClient?.addEventListener('click', () => addClientModal.classList.add('hidden'));

      clientForm?.addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
          cliente: clientForm.Cliente.value.trim(),
          idempresa: clientForm.idempresa.value || null
        };

        fetch('<?= base_url('clientes/create') ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(data)
        })
          .then(async response => {
            const res = await response.json();
            if (!response.ok) {
              throw new Error(res.error || 'Error desconocido al crear cliente');
            }

            alert('Cliente agregado exitosamente');
            addClientModal.classList.add('hidden');
            clientForm.reset();
            location.reload();
          })
          .catch(error => {
            alert('Error al agregar cliente: ' + error.message);
          });
      });

      // Botones de vista, editar y eliminar
      document.addEventListener('click', function(e) {
        const target = e.target;

        // Ver detalles del cliente
        if (target.closest('.view-client')) {
          e.preventDefault();
          const button = target.closest('.view-client');
          const clientId = button.getAttribute('data-client-id');

          fetch(`${baseUrl}/clientes/getClient/${clientId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.cliente) {
              document.getElementById('detailName').textContent = data.cliente;
              document.getElementById('detailCompany').textContent = data.nombre_empresa || 'Sin empresa';
              document.getElementById('editClientButton').setAttribute('data-client-id', data.idcliente);
              document.getElementById('clientDetailModal').classList.remove('hidden');
            } else {
              alert('Cliente no encontrado');
            }
          })
          .catch(error => {
            alert('Error al cargar detalles del cliente: ' + error.message);
          });
        }

        // Boton editar desde modal detalles
        if (target.closest('#editClientButton')) {
          e.preventDefault();
          const button = target.closest('#editClientButton');
          const clientId = button.getAttribute('data-client-id');

          // Cerrar modal detalles
          document.getElementById('clientDetailModal').classList.add('hidden');

          // cargar datos del cliente en el modal de editar
          fetch(`${baseUrl}/clientes/getClient/${clientId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.cliente) {
              document.getElementById('editClientId').value = data.idcliente;
              document.getElementById('editClientName').value = data.cliente;
              document.getElementById('editClientCompany').value = data.idempresa || '';
              document.getElementById('editClientModal').classList.remove('hidden');
            } else {
              alert('Cliente no encontrado');
            }
          })
          .catch(error => {
            alert('Error al cargar datos del cliente: ' + error.message);
          });
        }
      });

      // Editar cliente
      document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-client')) {
          const button = e.target.closest('.edit-client');
          const clientId = button.getAttribute('data-client-id');

          fetch(`${baseUrl}/clientes/getClient/${clientId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.cliente) {
              document.getElementById('editClientId').value = data.idcliente;
              document.getElementById('editClientName').value = data.cliente;
              document.getElementById('editClientCompany').value = data.idempresa || '';
              document.getElementById('editClientModal').classList.remove('hidden');
            } else {
              alert('Cliente no encontrado');
            }
          })
          .catch(error => {
            alert('Error al cargar datos del cliente');
          });
        }
      });

      // Cerrar modals
      document.getElementById('closeDetailModalButton')?.addEventListener('click', () => {
        document.getElementById('clientDetailModal').classList.add('hidden');
      });

      document.getElementById('closeDetailButton')?.addEventListener('click', () => {
        document.getElementById('clientDetailModal').classList.add('hidden');
      });

      document.getElementById('closeEditClientModal')?.addEventListener('click', () => {
        document.getElementById('editClientModal').classList.add('hidden');
      });

      document.getElementById('cancelEditClient')?.addEventListener('click', () => {
        document.getElementById('editClientModal').classList.add('hidden');
      });

      // Editar cliente - submit
      document.getElementById('editClientForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const clientId = document.getElementById('editClientId').value;

        const data = {
          cliente: document.getElementById('editClientName').value,
          idempresa: document.getElementById('editClientCompany').value || null
        };

        fetch(`${baseUrl}/clientes/update/${clientId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(data)
        })
          .then(async response => {
            const res = await response.json();
            if (!response.ok) throw new Error(res.error || 'Error al actualizar cliente');
            alert('Cliente actualizado correctamente');
            document.getElementById('editClientModal').classList.add('hidden');
            location.reload();
          })
          .catch(err => alert(err.message));
      });

      // Borrar cliente
      document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-client')) {
          const button = e.target.closest('.delete-client');
          const clientId = button.getAttribute('data-client-id');

          if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
            fetch(`${baseUrl}/clientes/delete/${clientId}`, {
              method: 'DELETE',
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Cliente eliminado correctamente');
                location.reload();
              } else {
                alert('Error al eliminar cliente');
              }
            })
            .catch(error => {
              alert('Error al eliminar cliente');
            });
          }
        }
      });
    });

    /* Ordenar tabla */
      function sortTable(n) {
        let table, rows, switching, i, x, y, shouldSwitch, dir, switchCount = 0;
        table = document.querySelector('table');
        switching = true;
        dir = "asc";
        while (switching) {
          switching = false;
          rows = table.rows;
          for (i = 1; i < rows.length - 1; i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir === "asc") {
              if (x.textContent.trim().toLowerCase() > y.textContent.trim().toLowerCase()) {
                shouldSwitch = true;
                break;
              }
            } else if (dir === "desc") {
              if (x.textContent.trim().toLowerCase() < y.textContent.trim().toLowerCase()) {
                shouldSwitch = true;
                break;
              }
            }
          }
          if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchCount++;
          } else {
            if (switchCount === 0 && dir === "asc") {
              dir = "desc";
              switching = true;
            }
          }
        }
      }

      /* Filtros de tabla */
      function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const empresaFilter = document.getElementById('filterEmpresa').value;

        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
          let showRow = true;
          const nombre = row.cells[0].textContent.trim();
          const empresa = row.cells[1].textContent.trim();

          if (search && !nombre.toLowerCase().includes(search)) showRow = false;
          if (empresaFilter && empresa !== empresaFilter) showRow = false;

          row.style.display = showRow ? '' : 'none';
        });
      }

      document.addEventListener('DOMContentLoaded', () => {
        const inputs = ['searchInput','filterEmpresa'];
        inputs.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.addEventListener('input', filterTable);
        });

        document.getElementById('clearFilters')?.addEventListener('click', () => {
          document.getElementById('searchInput').value = '';
          document.getElementById('filterEmpresa').value = '';
          filterTable();
        });

        /* Orden inicial por defecto (columna 0 Nombre ASC) */
        sortTable(0);
      });
      /*Agencia*/ 
      // Abrir y cerrar modal principal
const agenciasModal = document.getElementById('agenciasModal');
document.getElementById('openAgenciasModal').onclick = () => {
    agenciasModal.classList.remove('hidden');
    cargarAgencias();
};

document.getElementById('closeAgenciasModal').onclick = () => agenciasModal.classList.add('hidden');

// Función para cargar datos
function cargarAgencias() {
    fetch(`${baseUrl}/agencias/getAgencias`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('agenciasTableBody');
            tbody.innerHTML = data.map(a => `
                <tr>
                    <td class="px-4 py-3 font-medium">${a.agencia}</td>
                    <td class="px-4 py-3 text-gray-500">${a.dirrecion}</td>
                    <td class="px-4 py-3 text-right">
                        <button onclick="editarAgencia(${a.idagencia}, '${a.agencia}', '${a.dirrecion}')" class="text-blue-600 mr-2"><i class="ri-edit-line"></i></button>
                        <button onclick="eliminarAgencia(${a.idagencia})" class="text-red-600"><i class="ri-delete-bin-line"></i></button>
                    </td>
                </tr>
            `).join('');
        });
}

// Mostrar/Ocultar formulario de edición/creación
document.getElementById('btnNuevaAgencia').onclick = () => {
    document.getElementById('agenciaForm').reset();
    document.getElementById('idagencia').value = '';
    document.getElementById('agenciaFormContainer').classList.remove('hidden');
};

document.getElementById('cancelAgencia').onclick = () => {
    document.getElementById('agenciaFormContainer').classList.add('hidden');
};

// Guardar Agencia (Create/Update)
// Función para mostrar el spinner
function mostrarCargandoAgencias() {
    const tbody = document.getElementById('agenciasTableBody');
    tbody.innerHTML = `
        <tr>
            <td colspan="3" class="py-10 text-center">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <i class="ri-loader-4-line text-3xl text-primary animate-spin"></i>
                    <span class="text-sm text-gray-500 font-medium">Cargando agencias...</span>
                </div>
            </td>
        </tr>
    `;
}

function cargarAgencias() {
    // 1. Mostrar la animación antes de la petición
    mostrarCargandoAgencias();
    
    // 2. Pequeño timeout opcional para que la animación sea visible si el server es muy rápido
    fetch(`${baseUrl}/agencias/getAgencias`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('agenciasTableBody');
        
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" class="text-center py-4 text-gray-400">No hay agencias registradas</td></tr>';
            return;
        }

        // 3. Reemplazar el spinner con los datos reales
        // Dentro de cargarAgencias(), en el .map:
// Dentro de cargarAgencias(), en el .map:
tbody.innerHTML = data.map(a => `
    <tr class="hover:bg-gray-50 transition-colors border-b">
        <td class="px-4 py-3 font-medium text-gray-900">${a.agencia}</td>
        <td class="px-4 py-3 text-gray-500">${a.dirrecion || 'Sin dirección'}</td>
        <td class="px-4 py-3 text-right">
            <button onclick="eliminarAgencia(${a.idagencia})" 
                    class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 p-2"
                    title="Eliminar Agencia">
                <i class="ri-delete-bin-line text-lg"></i>
            </button>
        </td>
    </tr>
`).join('');
    })
    .catch(err => {
        document.getElementById('agenciasTableBody').innerHTML = `
            <tr>
                <td colspan="3" class="py-4 text-center text-red-500">
                    <i class="ri-error-warning-line mr-1"></i> Error al cargar los datos
                </td>
            </tr>
        `;
    });
}
const modal = document.getElementById('agenciasModal');
document.getElementById('openAgenciasModal').onclick = () => {
    modal.classList.remove('hidden');
    modal.style.opacity = "0";
    setTimeout(() => { modal.style.opacity = "1"; }, 10);
    cargarAgencias();
};
//agregar agencia
// Manejo del envío del formulario
document.getElementById('agenciaForm').onsubmit = function(e) {
    e.preventDefault();
    
    // Mostramos un estado de carga en el botón si gustas
    const btnGuardar = this.querySelector('button[type="submit"]');
    const originalText = btnGuardar.innerHTML;
    btnGuardar.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> Guardando...';
    btnGuardar.disabled = true;

    const formData = Object.fromEntries(new FormData(this));
    
    fetch(`${baseUrl}/agencias/save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
    if (data.success) {
        alert('¡Agencia guardada con éxito!');
        this.reset();
        document.getElementById('idagencia').value = ''; 
        document.getElementById('agenciaFormContainer').classList.add('hidden');
        cargarAgencias();
    } else {
        // Ahora mostramos los errores específicos de validación si existen
        const errorMsg = data.errors ? Object.values(data.errors).join('\n') : data.message;
        alert('No se pudo guardar:\n' + errorMsg);
    }
})
    .catch(err => {
        console.error('Error:', err);
        alert('Ocurrió un error en la comunicación con el servidor');
    })
    .finally(() => {
        btnGuardar.innerHTML = originalText;
        btnGuardar.disabled = false;
    });
};

function eliminarAgencia(id) {
    if (confirm('¿Estás seguro de eliminar esta agencia?')) {
        fetch(`${baseUrl}/agencias/delete/${id}`, {
            method: 'DELETE',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Eliminado con éxito');
                cargarAgencias();
            } else {
                // Aquí mostramos el mensaje de seguridad que definimos en el controlador
                alert('Advertencia: ' + data.message);
            }
        })
        .catch(err => alert('Error de conexión con el servidor'));
    }
}
  </script>

  <?= $this->include('partials/notification-js') ?>

</body>

</html>
