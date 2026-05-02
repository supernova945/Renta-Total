<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MI Renta Total - Empresas</title>
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

<script src="<?= base_url('js/table.js') ?>"></script>
<script src="<?= base_url('js/user-modal.js') ?>"></script>



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
      <h1 class="text-2xl font-bold text-primary">Gestión de Empresas</h1>
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>

        <?php if (in_array($rol, $allowedRoles)): ?>
        <div class="flex items-center space-x-2">
          <button id="addCompanyButton"
            class="bg-primary text-white px-4 py-2 rounded-button hover:bg-secondary transition-all duration-200 flex items-center whitespace-nowrap !rounded-button">
            <div class="w-4 h-4 flex items-center justify-center mr-1.5">
              <i class="ri-building-add-line"></i>
            </div>
            Nueva Empresa
          </button>
        </div>
        <?php endif; ?>
      </div>
    </div>

      <!-- Agregar empresa -->

      <div id="addCompanyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-blue-600">Agregar Nueva Empresa</h3>
            <button id="closeAddCompanyModal" class="text-gray-400 hover:text-gray-700">
              <i class="ri-close-line text-xl"></i>
            </button>
          </div>
          <form id="companyForm" class="space-y-4">
            <div>
              <label for="companyName" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa</label>
              <input type="text" id="companyName" name="Empresa" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
              <label for="companyAddress" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
              <input type="text" id="companyAddress" name="direccion" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" placeholder="Dirección de la empresa">
            </div>
            <div>
              <label for="companyPhone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
              <input type="text" id="companyPhone" name="telefono" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" placeholder="00000000" maxlength="9">
            </div>
            <div>
              <label for="companyEmail" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
              <input type="email" id="companyEmail" name="correo" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" placeholder="empresa@ejemplo.com">
            </div>
            <div>
              <label for="companyNIT" class="block text-sm font-medium text-gray-700 mb-1">NIT</label>
              <input type="text" id="companyNIT" name="nit" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" placeholder="0000-000000-000-0" maxlength="17">
            </div>
            <div>
              <label for="companyRepresentative" class="block text-sm font-medium text-gray-700 mb-1">Representante Legal</label>
              <input type="text" id="companyRepresentative" name="representante_legal" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-blue-500 focus:outline-none" placeholder="Nombre del representante legal">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
              <button type="button" id="cancelAddCompany" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:text-white hover:bg-blue-700">Cancelar</button>
              <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-button hover:bg-blue-700">Guardar Empresa</button>
            </div>
          </form>
        </div>
      </div>


      <!-- Lista de empresas -->

      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Lista de Empresas</h2>
        <div class="overflow-x-auto">

        <!-- Filtros de búsqueda -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" id="searchInput" placeholder="Nombre de la empresa…"
                class="w-full px-3 py-2 border rounded-button">
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
                <div class="flex items-center">Teléfono <i class="ri-arrow-up-down-line ml-1 text-xs"></i></div>
              </th>
              <th class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase
                        hover:bg-gray-50" onclick="sortTable(2)">
                <div class="flex items-center">Correo <i class="ri-arrow-up-down-line ml-1 text-xs"></i></div>
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($empresas as $empresa): ?>
              <tr>
                <td class="px-6 py-4 text-sm text-gray-900 font-medium"><?= esc($empresa['empresa']) ?></td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  <?= esc($empresa['telefono'] ?: '—') ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  <?= esc($empresa['correo'] ?: '—') ?>
                </td>
                <td class="px-6 py-4 text-sm font-medium">
                  <?php if (in_array($rol, $allowedRoles)): ?>
                  <button class="view-company text-primary hover:text-primary/80 mr-3" data-company-id="<?= $empresa['idempresa'] ?>" title="Ver detalles">
                    <i class="ri-eye-line"></i>
                  </button>
                  <button class="edit-company text-blue-600 hover:text-blue-800 mr-3" data-company-id="<?= $empresa['idempresa'] ?>" title="Editar empresa">
                    <i class="ri-edit-line"></i>
                  </button>
                  <button class="delete-company text-red-600 hover:text-red-800" data-company-id="<?= $empresa['idempresa'] ?>" title="Eliminar empresa">
                    <i class="ri-delete-bin-line"></i>
                  </button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>



      <!-- Detalles de empresa -->
      <div id="companyDetailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded shadow-xl w-full max-w-lg relative">
          <!-- Boton cerrar -->
          <button id="closeDetailModalButton" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
            <i class="ri-close-line text-xl"></i>
          </button>

          <!-- Contenido -->
          <h2 class="text-xl font-bold mb-4 text-primary">Detalles de la Empresa</h2>
          <div class="space-y-4 text-sm text-gray-700">
            <div>
              <p class="font-medium text-gray-500">Nombre</p>
              <p id="detailName" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">Dirección</p>
              <p id="detailAddress" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">Teléfono</p>
              <p id="detailPhone" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">Correo Electrónico</p>
              <p id="detailEmail" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">NIT</p>
              <p id="detailNIT" class="text-gray-900">—</p>
            </div>
            <div>
              <p class="font-medium text-gray-500">Representante Legal</p>
              <p id="detailRepresentative" class="text-gray-900">—</p>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end space-x-2 mt-6">
            <button id="editCompanyButton" data-company-id="" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-button hover:text-white hover:bg-secondary">
              Editar
            </button>
            <button id="closeDetailButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:text-white hover:bg-secondary">
              Cerrar
            </button>
          </div>
        </div>
      </div>

      <!-- Editar Empresa -->

      <div id="editCompanyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-primary">Editar Empresa</h3>
            <button id="closeEditCompanyModal" class="text-gray-400 hover:text-gray-700">
              <i class="ri-close-line text-xl"></i>
            </button>
          </div>
          <form id="editCompanyForm" class="space-y-4">
            <input type="hidden" id="editCompanyId">

            <div>
              <label for="editCompanyName" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
              <input type="text" id="editCompanyName" class="w-full px-3 py-2 border rounded-button">
            </div>
            <div>
              <label for="editCompanyAddress" class="block text-sm font-medium text-gray-700">Dirección</label>
              <input type="text" id="editCompanyAddress" class="w-full px-3 py-2 border rounded-button" placeholder="Dirección de la empresa">
            </div>
            <div>
              <label for="editCompanyPhone" class="block text-sm font-medium text-gray-700">Teléfono</label>
              <input type="text" id="editCompanyPhone" class="w-full px-3 py-2 border rounded-button" placeholder="00000000" maxlength="9">
            </div>
            <div>
              <label for="editCompanyEmail" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
              <input type="email" id="editCompanyEmail" class="w-full px-3 py-2 border rounded-button" placeholder="empresa@ejemplo.com">
            </div>
            <div>
              <label for="editCompanyNIT" class="block text-sm font-medium text-gray-700">NIT</label>
              <input type="text" id="editCompanyNIT" class="w-full px-3 py-2 border rounded-button" placeholder="0000-000000-000-0" maxlength="17">
            </div>
            <div>
              <label for="editCompanyRepresentative" class="block text-sm font-medium text-gray-700">Representante Legal</label>
              <input type="text" id="editCompanyRepresentative" class="w-full px-3 py-2 border rounded-button" placeholder="Nombre del representante legal">
            </div>

            <div class="flex justify-end space-x-2 pt-2">
              <button type="button" id="cancelEditCompany" class="px-4 py-2 text-sm bg-gray-100 rounded-button hover:text-white hover:bg-secondary">Cancelar</button>
              <button type="submit" class="px-4 py-2 text-sm bg-primary text-white rounded-button hover:text-white hover:bg-secondary">Guardar</button>
            </div>
          </form>

        </div>
      </div>



  </main>

  <script>

    document.addEventListener('DOMContentLoaded', () => {
      // Company modal functionality
      const addCompanyButton = document.getElementById('addCompanyButton');
      const addCompanyModal = document.getElementById('addCompanyModal');
      const closeAddCompanyModal = document.getElementById('closeAddCompanyModal');
      const cancelAddCompany = document.getElementById('cancelAddCompany');
      const companyForm = document.getElementById('companyForm');

      addCompanyButton?.addEventListener('click', () => addCompanyModal.classList.remove('hidden'));
      closeAddCompanyModal?.addEventListener('click', () => addCompanyModal.classList.add('hidden'));
      cancelAddCompany?.addEventListener('click', () => addCompanyModal.classList.add('hidden'));

      companyForm?.addEventListener('submit', function (e) {
        e.preventDefault();

        const data = {
          empresa: companyForm.empresa.value.trim(),
          direccion: companyForm.direccion.value.trim() || null,
          telefono: companyForm.telefono.value.trim() || null,
          correo: companyForm.correo.value.trim() || null,
          nit: companyForm.nit.value.trim() || null,
          representante_legal: companyForm.representante_legal.value.trim() || null
        };

        fetch(`${baseUrl}/empresas/create`, {
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
              throw new Error(res.error || 'Error desconocido al crear empresa');
            }

            alert('Empresa agregada exitosamente');
            addCompanyModal.classList.add('hidden');
            companyForm.reset();
            location.reload();
          })
          .catch(error => {
            alert('Error al agregar empresa: ' + error.message);
          });
      });

      // Action button event handlers
      document.addEventListener('click', function(e) {
        const target = e.target;

        // View company details
        if (target.closest('.view-company')) {
          e.preventDefault();
          const button = target.closest('.view-company');
          const companyId = button.getAttribute('data-company-id');

          fetch(`${baseUrl}/empresas/getCompany/${companyId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.empresa) {
              // Populate all detail fields
              document.getElementById('detailName').textContent = data.empresa || '—';
              document.getElementById('detailAddress').textContent = data.direccion || '—';
              document.getElementById('detailPhone').textContent = data.telefono || '—';
              document.getElementById('detailEmail').textContent = data.correo || '—';
              document.getElementById('detailNIT').textContent = data.nit || '—';
              document.getElementById('detailRepresentative').textContent = data.representante_legal || '—';

              // Set company ID for edit button
              document.getElementById('editCompanyButton').setAttribute('data-company-id', data.idempresa);
              document.getElementById('companyDetailModal').classList.remove('hidden');
            } else {
              alert('Empresa no encontrada');
            }
          })
          .catch(error => {
            alert('Error al cargar detalles de la empresa: ' + error.message);
          });
        }

        // Edit button inside view details modal
        if (target.closest('#editCompanyButton')) {
          e.preventDefault();
          const button = target.closest('#editCompanyButton');
          const companyId = button.getAttribute('data-company-id');

          // Close detail modal and open edit modal
          document.getElementById('companyDetailModal').classList.add('hidden');

          // Load company data for editing
          fetch(`${baseUrl}/empresas/getCompany/${companyId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.empresa) {
              document.getElementById('editCompanyId').value = data.idempresa;
              document.getElementById('editCompanyName').value = data.empresa;
              document.getElementById('editCompanyAddress').value = data.direccion || '';
              document.getElementById('editCompanyPhone').value = data.telefono || '';
              document.getElementById('editCompanyEmail').value = data.correo || '';
              document.getElementById('editCompanyNIT').value = data.nit || '';
              document.getElementById('editCompanyRepresentative').value = data.representante_legal || '';
              document.getElementById('editCompanyModal').classList.remove('hidden');
            } else {
              alert('Empresa no encontrada');
            }
          })
          .catch(error => {
            alert('Error al cargar datos de la empresa: ' + error.message);
          });
        }

        // Edit company
        if (target.closest('.edit-company')) {
          e.preventDefault();
          const button = target.closest('.edit-company');
          const companyId = button.getAttribute('data-company-id');

          fetch(`${baseUrl}/empresas/getCompany/${companyId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.empresa) {
              document.getElementById('editCompanyId').value = data.idempresa;
              document.getElementById('editCompanyName').value = data.empresa;
              document.getElementById('editCompanyAddress').value = data.direccion || '';
              document.getElementById('editCompanyPhone').value = data.telefono || '';
              document.getElementById('editCompanyEmail').value = data.correo || '';
              document.getElementById('editCompanyNIT').value = data.nit || '';
              document.getElementById('editCompanyRepresentative').value = data.representante_legal || '';
              document.getElementById('editCompanyModal').classList.remove('hidden');
            } else {
              alert('Empresa no encontrada');
            }
          })
          .catch(error => {
            alert('Error al cargar datos de la empresa: ' + error.message);
          });
        }

        // Delete company
        if (target.closest('.delete-company')) {
          e.preventDefault();
          const button = target.closest('.delete-company');
          const companyId = button.getAttribute('data-company-id');

          if (confirm('¿Está seguro de que desea eliminar esta empresa?')) {
            fetch(`${baseUrl}/empresas/delete/${companyId}`, {
              method: 'DELETE',
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Empresa eliminada correctamente');
                location.reload();
              } else {
                alert('Error al eliminar empresa: ' + (data.message || 'Error desconocido'));
              }
            })
            .catch(error => {
              alert('Error al eliminar empresa: ' + error.message);
            });
          }
        }
      });

      // Close modals
      document.getElementById('closeDetailModalButton')?.addEventListener('click', () => {
        document.getElementById('companyDetailModal').classList.add('hidden');
      });

      document.getElementById('closeDetailButton')?.addEventListener('click', () => {
        document.getElementById('companyDetailModal').classList.add('hidden');
      });

      document.getElementById('closeEditCompanyModal')?.addEventListener('click', () => {
        document.getElementById('editCompanyModal').classList.add('hidden');
      });

      document.getElementById('cancelEditCompany')?.addEventListener('click', () => {
        document.getElementById('editCompanyModal').classList.add('hidden');
      });

      // Edit company form submission
      document.getElementById('editCompanyForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        const companyId = document.getElementById('editCompanyId').value;

        const data = {
          empresa: document.getElementById('editCompanyName').value,
          direccion: document.getElementById('editCompanyAddress').value.trim() || null,
          telefono: document.getElementById('editCompanyPhone').value.trim() || null,
          correo: document.getElementById('editCompanyEmail').value.trim() || null,
          nit: document.getElementById('editCompanyNIT').value.trim() || null,
          representante_legal: document.getElementById('editCompanyRepresentative').value.trim() || null
        };

        fetch(`${baseUrl}/empresas/update/${companyId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(data)
        })
          .then(async response => {
            const res = await response.json();
            if (!response.ok) throw new Error(res.error || 'Error al actualizar empresa');
            alert('Empresa actualizada correctamente');
            document.getElementById('editCompanyModal').classList.add('hidden');
            location.reload();
          })
          .catch(err => {
            alert('Error al actualizar empresa: ' + err.message);
          });
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

        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
          let showRow = true;
          const nombre = row.cells[0].textContent.trim();

          if (search && !nombre.toLowerCase().includes(search)) showRow = false;

          row.style.display = showRow ? '' : 'none';
        });
      }

      document.addEventListener('DOMContentLoaded', () => {
        const inputs = ['searchInput'];
        inputs.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.addEventListener('input', filterTable);
        });

        document.getElementById('clearFilters')?.addEventListener('click', () => {
          document.getElementById('searchInput').value = '';
          filterTable();
        });

        /* Orden inicial por defecto (columna 0 Nombre ASC) */
        sortTable(0);
      });


  </script>

  <?= $this->include('partials/notification-js') ?>

</body>

</html>
