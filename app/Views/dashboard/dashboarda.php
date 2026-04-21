<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI Renta Total - Dashboard</title>
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
                        secondary: '#AD2E2E',
                        accent: '#3A86FF'
                    },
                    borderRadius: {
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .nav-btn {
            transition: all 0.3s ease;
        }
        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<script src="<?= base_url('js/user-modal.js') ?>"></script>

<body class="bg-gray-50">

  <!-- Header -->
    <?= $this->include('partials/header') ?>

    <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">M.I Renta Total</h2>            
            </div>
            <div class="mt-4 md:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>
            </div>
        </div>

    <!-- Seccion de inventario -->
    <section id="inventory-section" class="gap-6 mb-8 scroll-mt-20">
        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-accent pb-2 inline-block">Inventario</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Valor Total del Inventario</h3>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-primary">
                        <i class="ri-money-dollar-circle-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white">$<?= number_format($stats['inventory_value'] ?? 0, 0) ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['inventory_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['inventory_change'] ?? 0) >= 0 ? 'up' : 'down' ?>-s-line"></i>
                        <?= abs($stats['inventory_change'] ?? 0) ?>%
                    </span>
                </div>
                 <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="<?= base_url('motocicletas') ?>" class="text-white/80 hover:text-white text-sm flex items-center">
                        Ver detalles <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Motocicletas disponibles</h3>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <i class="ri-motorbike-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['available_motorcycles'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['motorcycles_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['motorcycles_change'] ?? 0) >= 0 ? 'up' : 'down' ?>-s-line"></i>
                        <?= abs($stats['motorcycles_change'] ?? 0) ?>%
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="<?= base_url('motocicletas') ?>" class="text-white/80 hover:text-white text-sm flex items-center">
                        Administrar inventario <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Alertas de inventario</h3>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                        <i class="ri-alert-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['low_inventory_alerts'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['alerts_change'] ?? 0) >= 0 ? 'text-red-600' : 'text-green-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['alerts_change'] ?? 0) >= 0 ? 'up' : 'down' ?>-s-line"></i>
                        <?= abs($stats['alerts_change'] ?? 0) ?>%
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="<?= base_url('motocicletas') ?>" class="text-white/80 hover:text-white text-sm flex items-center">
                        Revisar alertas <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Seccion de rentas -->

    <section id="rentals-section" class="mb-8 scroll-mt-20">
        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-primary pb-2 inline-block">Rentas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Motocicletas en leasing</h3>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                        <i class="ri-key-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['rented_motorcycles'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['rented_change'] ?? 0) >= 0 ? 'text-red-600' : 'text-green-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['rented_change'] ?? 0) >= 0 ? 'down' : 'up' ?>-s-line"></i>
                        <?= abs($stats['rented_change'] ?? 0) ?>%
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="<?= base_url('rentas') ?>" class="text-white/80 hover:text-white text-sm flex items-center">
                        Ver rentas activas <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Servicios pendientes</h3>
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                        <i class="ri-tools-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['pending_services'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['pending_change'] ?? 0) >= 0 ? 'text-red-600' : 'text-green-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['pending_change'] ?? 0) >= 0 ? 'down' : 'up' ?>-s-line"></i>
                        <?= abs($stats['pending_change'] ?? 0) ?>%
                    </span>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="<?= base_url('servicios') ?>" class="text-white/80 hover:text-white text-sm flex items-center">
                        Gestionar servicios <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

        <!-- Acciones rapidas -->

        <div class="mb-16">
            <h3 class="text-xl font-bold text-gray-900 mb-8">Acciones rápidas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?= base_url('rentas') ?>" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-accent transition-all flex flex-col items-center text-center">
                    <div class="bg-blue-100 p-3 rounded-full mb-3">
                        <i class="ri-add-circle-line text-blue-600 text-2xl"></i>
                    </div>
                    <span class="font-medium text-gray-800">Nueva renta</span>
                </a>

                <button id="addUserButton"
                
                class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-purple-600 transition-all flex flex-col items-center text-center">
                    <div class="bg-purple-100 p-3 rounded-full mb-3">
                        <i class="ri-user-add-line text-purple-600 text-2xl"></i>
                    </div>
                    <span class="font-medium text-gray-800">Agregar usuario</span>
                
                </button>

                

                <!-- Agregar usuario -->
        <div id="addUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Agregar Nuevo Usuario</h3>
            <button id="closeModalButton" class="text-gray-500 hover:text-gray-700">
                <i class="ri-close-line ri-lg"></i>
            </button>
            </div>
            <div class="p-6">
            <form id="userForm">
                <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" id="name" name="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div class="mb-4">
                <label for="usuario" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                <input type="text" id="usuario" name="usuario"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" id="password" name="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                
                <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" id="email" name="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div class="mb-4">
                <label for="dui" class="block text-sm font-medium text-gray-700 mb-1">DUI</label>
                <input type="text" id="dui" name="dui"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>

                <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="estado" name="estado"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>                
                </select>
                </div>


                <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                <select id="role" name="role"
                    class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                    <option value="Administrador">Administrador</option>
                    <option value="Jefatura">Jefatura</option>
                    <option value="Operativo">Operativo</option>
                    <option value="Visualizador">Visualizador</option>
                </select>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                <button type="button" id="cancelAddUser"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:text-white hover:bg-secondary">Cancelar</button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-button hover:text-white hover:bg-secondary">Guardar
                    Usuario</button>
                </div>
            </form>
            </div>
        </div>
        </div>

            <button id="AddMotorcycleButton" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-green-600 transition-all flex flex-col items-center text-center cursor-pointer">
                <div class="bg-green-100 p-3 rounded-full mb-3">
                    <i class="ri-add-box-line text-green-600 text-2xl"></i>
                </div>
                <span class="font-medium text-gray-800">Agregar moto</span>
            </button>

            <!-- Modal para agregar motocicleta -->

           <div id="addMotorcycleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-primary">Agregar Nueva Motocicleta</h3>
            <button id="closeAddMotorcycleModal" class="text-gray-400 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form id="motorcycleForm" class="space-y-4">
            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                <label for="motivo_ingreso" class="block text-sm font-bold text-gray-700 mb-1">
                    <i class="ri-question-line mr-1"></i>¿Motivo del Ingreso?
                </label>
                <select id="motivo_ingreso" name="motivo_ingreso" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none">
                    <option value="NUEVO">✨ Nueva Flota (Crecimiento)</option>
                    <option value="RENOVACION">🔄 Renovación (Reemplazo)</option>
                    <option value="REPOSICION">🛡️ Reposición (Siniestro)</option>
                </select>
                <div id="container_moto_anterior" class="mt-3 hidden transition-all duration-300">
                <label for="placa_anterior" class="block text-sm font-medium text-secondary mb-1">
                    ¿Qué moto sale de la flota?
                </label>
                <input type="text" list="lista_motos" id="placa_anterior" name="placa_anterior" 
                    class="w-full px-3 py-2 border border-secondary/30 bg-white rounded-button focus:ring-secondary focus:outline-none" 
                placeholder="Escribe Placa...">
    
                <datalist id="lista_motos">
                <?php if (!empty($motocicletas)): foreach ($motocicletas as $moto): ?>
                    <option value="<?= esc($moto['placa']) ?>">
                <?= esc($moto['nombre_marca'] . ' ' . $moto['modelo']) ?>
                    </option>
                <?php endforeach; endif; ?>
                        </datalist>
                </div>
                
            </div>

            <div>
                <label for="placa" class="block text-sm font-medium text-gray-700 mb-1">Placa (Nueva)</label>
                <input type="text" id="placa" name="placa" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="marca" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                    <select id="marca" name="marca" class="w-full px-3 py-2 border border-gray-300 rounded-button" required>
                        <option value="">Seleccione...</option>
                        <?php if (!empty($marca)): foreach ($marca as $m): ?>
                            <option value="<?= esc($m['idmarca']) ?>"><?= esc($m['marca']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div>
                    <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                    <input type="text" id="modelo" name="modelo" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="anio" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                    <input type="number" id="anio" name="anio" class="w-full px-3 py-2 border border-gray-300 rounded-button" min="1900" max="<?= date('Y') + 1 ?>" required>
                </div>
                <div>
                    <label for="chasis" class="block text-sm font-medium text-gray-700 mb-1">Chasis</label>
                    <input type="text" id="chasis" name="chasis" class="w-full px-3 py-2 border border-gray-300 rounded-button focus:ring-primary focus:outline-none" required>
                </div>
            </div>

            <div>
                <label for="idagencia" class="block text-sm font-medium text-gray-700 mb-1">Agencia</label>
                <select id="idagencia" name="idagencia" class="w-full px-3 py-2 border border-gray-300 rounded-button">
                    <option value="">Seleccione...</option>
                    <?php if (!empty($agencia)): foreach ($agencia as $a): ?>
                        <option value="<?= esc($a['idagencia']) ?>"><?= esc($a['agencia']) ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <input type="hidden" id="idestado" name="idestado" value="1"> <input type="hidden" id="creadopor" name="creadopor" value="<?= esc($logged_in_user_id ?? '') ?>">

            <div class="flex justify-end space-x-2 pt-2 border-t">
                <button type="button" id="cancelAddMotorcycle" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-button hover:bg-gray-200">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-button hover:bg-secondary">Guardar</button>
            </div>
        </form>
    </div>
</div>


            <a href="<?=base_url('/reportes')?>" class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-yellow-600 transition-all flex flex-col items-center text-center">
                <div class="bg-yellow-100 p-3 rounded-full mb-3">
                    <i class="ri-file-chart-line text-yellow-600 text-2xl"></i>
                </div>
                <span class="font-medium text-gray-800">Generar reporte</span>
            </a>
        </div>
    </div>

    <!-- Activity Log Section -->
    <section id="activity-log-section" class="mb-16 scroll-mt-20">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900 border-b-2 border-secondary pb-2 inline-block">Registro de Actividad</h3>
            <a href="<?= base_url('activity-log') ?>" class="text-primary hover:text-primaryb font-medium flex items-center">
                <i class="ri-external-link-line mr-2"></i>Ver todas las actividades
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="space-y-4 max-h-96 overflow-y-auto">
                <?php if (!empty($recent_activities)): ?>
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="flex items-start space-x-3 p-3 border-l-4 bg-gray-50 rounded-r-lg <?php
                            if ($activity['action'] === 'INSERT') echo 'border-green-500';
                            elseif ($activity['action'] === 'UPDATE') echo 'border-blue-500';
                            else echo 'border-red-500';
                        ?>">
                            <div class="flex-shrink-0">
                                <?php if ($activity['action'] === 'INSERT'): ?>
                                    <i class="ri-add-circle-line text-green-600 text-lg"></i>
                                <?php elseif ($activity['action'] === 'UPDATE'): ?>
                                    <i class="ri-edit-circle-line text-blue-600 text-lg"></i>
                                <?php else: ?>
                                    <i class="ri-delete-bin-line text-red-600 text-lg"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    <?= ucfirst(strtolower($activity['action'])) ?> en <?= ucfirst($activity['table_name']) ?>
                                    <span class="text-gray-500">(ID: <?= esc($activity['record_id']) ?>)</span>
                                </p>
                                <p class="text-xs text-gray-600">
                                    <?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?>
                                    <?php if ($activity['user_username']): ?>
                                        - Usuario: <?= esc($activity['user_username']) ?>
                                    <?php endif; ?>
                                </p>
                                <?php if ($activity['old_values'] || $activity['new_values']): ?>
                                    <details class="mt-2">
                                        <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700">Ver detalles</summary>
                                        <div class="mt-1 text-xs text-gray-600">
                                            <?php if ($activity['old_values']): ?>
                                                <div class="mb-1">
                                                    <strong>Antes:</strong>
                                                    <pre class="bg-red-50 p-1 rounded text-xs overflow-x-auto"><?= esc(json_encode(json_decode($activity['old_values'], true), JSON_PRETTY_PRINT)) ?></pre>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($activity['new_values']): ?>
                                                <div>
                                                    <strong>Después:</strong>
                                                    <pre class="bg-green-50 p-1 rounded text-xs overflow-x-auto"><?= esc(json_encode(json_decode($activity['new_values'], true), JSON_PRETTY_PRINT)) ?></pre>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </details>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="ri-file-list-line text-4xl mb-2"></i>
                        <p>No hay actividades recientes para mostrar.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Customers Section -->
    <!-- <section id="customers-section" class="mb-16 scroll-mt-20">
        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-secondary pb-2 inline-block">Clientes</h3>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-medium">Clientes registrados</h4>                   
                </div>
                <div class="bg-secondary/10 p-3 rounded-full">
                    <i class="ri-group-line text-secondary text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="/clientes" class="text-secondary hover:text-red-700 text-sm flex items-center">
                    Administrar clientes <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div>
        </div>
    </section> --> 

    <!-- Reports Section -->
    <!-- <section id="reports-section" class="mb-16 scroll-mt-20">
        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-secondary pb-2 inline-block">Reportes</h3>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-medium">Generar reportes</h4>
                    <p class="text-gray-600">Visualiza el rendimiento de tu negocio</p>
                </div>
                <div class="bg-grayb p-3 rounded-full">
                    <i class="ri-file-chart-line text-primary text-2xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="/reportes" class="text-secondary hover:text-red-700 text-sm flex items-center">
                    Ver reportes disponibles <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div>
        </div>
    </section>-->

</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
const resetMotorcycleForm = () => {
    if (motorcycleForm) {
        motorcycleForm.reset(); // Limpia los inputs de texto
        
        // Forzar el valor de Motivo de Ingreso a 'NUEVO'
        if (motivoSelect) {
            motivoSelect.value = 'NUEVO';
        }
        
        // Ocultar el contenedor de la moto anterior
        if (containerAnterior) {
            containerAnterior.classList.add('hidden');
        }
        
        // Quitar la obligatoriedad del campo placa anterior
        if (inputPlacaAnterior) {
            inputPlacaAnterior.required = false;
            inputPlacaAnterior.value = '';
        }
    }
};

        // --- Funciones de Ayuda (Helpers) ---
        const showModal = (modalElement) => {
            if (modalElement) { // Verifica si el elemento existe antes de manipularlo
                modalElement.classList.remove('hidden');
            }
        };
        const hideModal = (modalElement) => {
            if (modalElement) { // Verifica si el elemento existe antes de manipularlo
                modalElement.classList.add('hidden');
            }
        };
        const showAlert = (message, isError = false) => {
            alert(message);
        };

        // --- Lógica para la Modal de AGREGAR USUARIO ---
        const addUserButton = document.getElementById('addUserButton');
        const addUserModal = document.getElementById('addUserModal');
        const closeModalButton = document.getElementById('closeModalButton');
        const cancelAddUser = document.getElementById('cancelAddUser');
        const userForm = document.getElementById('userForm'); // Solo una definición

        if (addUserButton && addUserModal) {
            addUserButton.addEventListener('click', function () {
                showModal(addUserModal);
                userForm?.reset(); // Limpiar formulario al abrir
            });
        }

        if (closeModalButton && addUserModal) {
            closeModalButton.addEventListener('click', function () {
                hideModal(addUserModal);
                userForm?.reset(); // Limpiar formulario al cerrar
            });
        }

        if (cancelAddUser && addUserModal) {
            cancelAddUser.addEventListener('click', function () {
                hideModal(addUserModal);
                userForm?.reset(); // Limpiar formulario al cancelar
            });
        }

        // Listener para el submit del formulario de usuario
        if (userForm) { // Asegúrate de que el formulario exista
            userForm.addEventListener('submit', function (e) {
                e.preventDefault();

                // Validaciones básicas antes de enviar
                if (!this.checkValidity()) {
                    showAlert('Por favor, completa todos los campos requeridos para el usuario.', true);
                    return;
                }

                const data = {
                    name: document.getElementById('name').value.trim(),
                    usuario: document.getElementById('usuario').value.trim(),
                    password: document.getElementById('password').value,
                    email: document.getElementById('email').value.trim(),
                    dui: document.getElementById('dui').value.trim(),
                    estado: document.getElementById('estado').value,
                    role: document.getElementById('role').value
                };

                fetch(`${baseUrl}/usuarios/ajax-add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(response => {
                    if (response.status === 'ok') {
                        showAlert('Usuario agregado correctamente');
                        userForm.reset();
                        hideModal(addUserModal); // Usar hideModal
                    } else {
                        showAlert(response.error || 'Error al agregar usuario.', true);
                    }
                })
                .catch(err => {
                    console.error('Error de red o servidor:', err);
                    showAlert('Error al enviar los datos del usuario.', true);
                });
            });
        }

        // --- Lógica para la Modal de AGREGAR MOTOCICLETA ---
        const addMotorcycleModal = document.getElementById('addMotorcycleModal');
        const dashboardAddMotorcycleButton = document.getElementById('AddMotorcycleButton');
        const closeAddMotorcycleModal = document.getElementById('closeAddMotorcycleModal');
        const cancelAddMotorcycle = document.getElementById('cancelAddMotorcycle');
        const motorcycleForm = document.getElementById('motorcycleForm');
        const motivoSelect = document.getElementById('motivo_ingreso');
        const containerAnterior = document.getElementById('container_moto_anterior');
        const inputPlacaAnterior = document.getElementById('placa_anterior');
        // Listener para abrir la modal con el botón del dashboard
        if (dashboardAddMotorcycleButton && addMotorcycleModal) {
            dashboardAddMotorcycleButton.addEventListener('click', () => {
                showModal(addMotorcycleModal);
                motorcycleForm?.reset(); // Limpiar formulario al abrir
            });
        }
        if (motivoSelect) {
    motivoSelect.addEventListener('change', function() {
        if (this.value === 'NUEVO') {
            containerAnterior.classList.add('hidden');
            inputPlacaAnterior.required = false;
        } else {
            containerAnterior.classList.remove('hidden');
            inputPlacaAnterior.required = true;
        }
    });
}       

        // Listeners para cerrar/cancelar la modal
        if (closeAddMotorcycleModal) {
    closeAddMotorcycleModal.addEventListener('click', () => {
        hideModal(addMotorcycleModal);
        resetMotorcycleForm(); // <--- Agregado
    });
}

// Al hacer clic en el botón "Cancelar"
if (cancelAddMotorcycle) {
    cancelAddMotorcycle.addEventListener('click', () => {
        hideModal(addMotorcycleModal);
        resetMotorcycleForm(); // <--- Agregado
    });
}

// Al hacer clic fuera del modal (fondo oscuro)
if (addMotorcycleModal) {
    addMotorcycleModal.addEventListener('click', (event) => {
        if (event.target === addMotorcycleModal) {
            hideModal(addMotorcycleModal);
            resetMotorcycleForm(); // <--- Agregado
        }
    });
}


        // Listener para el envío del formulario de motocicleta
        if (motorcycleForm) {
    motorcycleForm.addEventListener('submit', async function (e) {
    e.preventDefault();

        if (!this.checkValidity()) {
            showAlert('Por favor, completa los campos requeridos.', true);
            return;
        }
        const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="ri-loader-line animate-spin"></i> Guardando...';

        // CAPTURA DE DATOS CORREGIDA
        const data = {
        motivo_ingreso: document.getElementById('motivo_ingreso').value,
        placa_anterior: document.getElementById('placa_anterior').value || null,
        placa: document.getElementById('placa').value.trim(),
        marca: document.getElementById('marca').value,
        modelo: document.getElementById('modelo').value.trim(),
        anio: document.getElementById('anio').value,
        chasis: document.getElementById('chasis').value.trim(), // CAMPO OBLIGATORIO
        idestado: 1, // Por defecto Disponible
        creado_por: document.getElementById('creadopor').value,
        idagencia: document.getElementById('idagencia').value || null
    };

        try {
            const response = await fetch(`${baseUrl}/motocicletas/createViaAjax`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        });

        const res = await response.json();

        if (response.ok) {
            alert('✅ ¡Éxito! Motocicleta registrada.');
            location.reload(); 
        } else {
            // Mostrar el error específico que viene del servidor (ej: "Placa duplicada")
            const errorMsg = res.messages ? Object.values(res.messages)[0] : (res.error || 'Error desconocido');
            alert('❌ Error: ' + errorMsg);
        }
            
        } catch (error) {
            alert('❌ Error de conexión al servidor.');
        }
        finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Guardar';
        }
    });
}

        // --- Lógica para el Scroll Suave ---
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

    }); // Cierre de DOMContentLoaded
</script>

<?= $this->include('partials/notification-js') ?>

</body>
</html>

</body>
</html>
