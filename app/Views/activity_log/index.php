<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI Renta Total - Registro de Actividad</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
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
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <?= $this->include('partials/header') ?>

    <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Registro de Actividad</h2>
                <p class="text-gray-600 mt-1">Historial completo de cambios en el sistema</p>
            </div>
            <div class="mt-4 md:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>
            </div>
        </div>

        <!-- Filtro de fechas -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtrar por Fecha</h3>
            <form method="GET" action="<?= base_url('activity-log') ?>" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Inicio</label>
                    <input type="date" id="start_date" name="start_date"
                           value="<?= esc($start_date ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div class="flex-1">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha Fin</label>
                    <input type="date" id="end_date" name="end_date"
                           value="<?= esc($end_date ?? '') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-button hover:bg-primaryb transition-colors">
                        <i class="ri-search-line mr-2"></i>Filtrar
                    </button>
                    <a href="<?= base_url('activity-log') ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-button hover:bg-gray-200 transition-colors">
                        <i class="ri-refresh-line mr-2"></i>Limpiar
                    </a>
                    <?php if (!empty($activities)): ?>
                        <a href="<?= base_url('activity-log/export-csv') . (!empty($start_date) || !empty($end_date) ? '?' . http_build_query(array_filter(['start_date' => $start_date, 'end_date' => $end_date])) : '') ?>"
                           class="px-4 py-2 bg-green-600 text-white rounded-button hover:bg-green-700 transition-colors">
                            <i class="ri-download-line mr-2"></i>Exportar CSV
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Log de actividades -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Historial de Actividad
                    <?php if ($start_date || $end_date): ?>
                        <span class="text-sm font-normal text-gray-600 ml-2">
                            (<?= $start_date ? 'Desde: ' . date('d/m/Y', strtotime($start_date)) : '' ?>
                            <?= $end_date ? ($start_date ? ' - ' : '') . 'Hasta: ' . date('d/m/Y', strtotime($end_date)) : '' ?>)
                        </span>
                    <?php endif; ?>
                </h3>
            </div>

            <div class="max-h-96 overflow-y-auto">
                <?php if (!empty($activities)): ?>
                    <div class="divide-y divide-gray-200">
                        <?php foreach ($activities as $activity): ?>
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <?php if ($activity['action'] === 'INSERT'): ?>
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="ri-add-circle-line text-green-600 text-lg"></i>
                                            </div>
                                        <?php elseif ($activity['action'] === 'UPDATE'): ?>
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="ri-edit-circle-line text-blue-600 text-lg"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                <i class="ri-delete-bin-line text-red-600 text-lg"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                <?= ucfirst(strtolower($activity['action'])) ?> en <?= ucfirst($activity['table_name']) ?>
                                                <span class="text-gray-500">(ID: <?= esc($activity['record_id']) ?>)</span>
                                            </h4>
                                            <span class="text-xs text-gray-500">
                                                <?= date('d/m/Y H:i:s', strtotime($activity['created_at'])) ?>
                                            </span>
                                        </div>

                                        <div class="mt-1 text-sm text-gray-600">
                                            <?php if ($activity['user_username']): ?>
                                                <span class="font-medium">Usuario:</span> <?= esc($activity['user_username']) ?>
                                            <?php else: ?>
                                                <span class="text-gray-400">Usuario desconocido</span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($activity['old_values'] || $activity['new_values']): ?>
                                            <details class="mt-3">
                                                <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-700 flex items-center">
                                                    <i class="ri-eye-line mr-1"></i>
                                                    Ver detalles de cambios
                                                </summary>
                                                <div class="mt-2 p-3 bg-gray-50 rounded-md">
                                                    <?php if ($activity['old_values']): ?>
                                                        <div class="mb-2">
                                                            <strong class="text-xs text-red-600">ANTES:</strong>
                                                            <pre class="mt-1 text-xs text-gray-700 bg-red-50 p-2 rounded overflow-x-auto whitespace-pre-wrap"><?= esc(json_encode(json_decode($activity['old_values'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($activity['new_values']): ?>
                                                        <div>
                                                            <strong class="text-xs text-green-600">DESPUÉS:</strong>
                                                            <pre class="mt-1 text-xs text-gray-700 bg-green-50 p-2 rounded overflow-x-auto whitespace-pre-wrap"><?= esc(json_encode(json_decode($activity['new_values'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </details>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="p-12 text-center">
                        <i class="ri-file-list-line text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay actividades registradas</h3>
                        <p class="text-gray-600">
                            <?php if ($start_date || $end_date): ?>
                                No se encontraron actividades en el rango de fechas seleccionado.
                            <?php else: ?>
                                Aún no se han registrado cambios en el sistema.
                            <?php endif; ?>
                        </p>
                        <?php if ($start_date || $end_date): ?>
                            <div class="mt-4">
                                <a href="<?= base_url('activity-log') ?>" class="text-primary hover:text-primaryb font-medium">
                                    Ver todas las actividades
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($activities)): ?>
                <div class="p-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600 text-center">
                        Mostrando <?= count($activities) ?> actividades
                        <?php if ($start_date || $end_date): ?>
                            filtradas por fecha
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Actualizar el formulario al cambiar las fechas
        document.getElementById('start_date').addEventListener('change', function() {
            if (this.value && document.getElementById('end_date').value) {
                this.closest('form').submit();
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            if (this.value && document.getElementById('start_date').value) {
                this.closest('form').submit();
            }
        });
    </script>

    <?= $this->include('partials/notification-js') ?>

</body>
</html>
