<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI Renta Total - Dashboard</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #AD2E2E;
        }
    </style>
</head>

<body class="bg-gray-50">

  <?= $this->include('partials/header') ?>

    <main class="pt-24 pb-12 px-4 md:px-6 max-w-7xl mx-auto">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-error-warning-line text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?= session()->getFlashdata('error') ?>
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-400 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-400" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Dismiss</span>
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-check-circle-line text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            <?= session()->getFlashdata('success') ?>
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-400 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-400" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Dismiss</span>
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('warning')): ?>
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-alert-line text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <?= session()->getFlashdata('warning') ?>
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-yellow-50 rounded-md p-1.5 text-yellow-400 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-400" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Dismiss</span>
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="ri-information-line text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <?= session()->getFlashdata('info') ?>
                        </p>
                    </div>
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" class="inline-flex bg-blue-50 rounded-md p-1.5 text-blue-400 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-400" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Dismiss</span>
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Panel de Control</h1>
            <div class="flex items-center space-x-2">
                <div class="mt-4 md:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                    <span class="text-sm text-gray-700 font-medium"><?= $current_date ?></span>
                </div>
                <!-- <button
                    class="bg-primaryb text-white px-4 py-2 rounded-button hover:bg-secondary transition-all duration-200 flex items-center whitespace-nowrap !rounded-button">
                    <div class="w-4 h-4 flex items-center justify-center mr-1.5">
                        <i class="ri-add-line"></i>
                    </div>
                    Nueva Entrada
                </button> -->
            </div>
        </div>

        <section id="space-section" class="mb-16 scroll-mt-20">
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
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
                <p class="text-sm text-gray-500 mt-1">Valor total de motocicletas</p>
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
                <p class="text-sm text-gray-500 mt-1">Disponibles para alquiler</p>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Motocicletas en renta</h3>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                        <i class="ri-key-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['rented_motorcycles'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['rented_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['rented_change'] ?? 0) >= 0 ? 'up' : 'down' ?>-s-line"></i>
                        <?= abs($stats['rented_change'] ?? 0) ?>%
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">Actualmente alquiladas</p>
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
                <p class="text-sm text-gray-500 mt-1">Motocicletas fuera de servicio</p>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Servicios activos</h3>
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                        <i class="ri-tools-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['active_services'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium <?= ($stats['services_change'] ?? 0) >= 0 ? 'text-red-600' : 'text-green-600' ?> flex items-center">
                        <i class="ri-arrow-<?= ($stats['services_change'] ?? 0) >= 0 ? 'up' : 'down' ?>-s-line"></i>
                        <?= abs($stats['services_change'] ?? 0) ?>%
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">En proceso o pendientes</p>
            </div>

            <div class="bg-primaryb p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-grayb">Total de clientes</h3>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                        <i class="ri-user-line ri-xl"></i>
                    </div>
                </div>
                <div class="flex items-end">
                    <p class="text-3xl font-bold text-white"><?= $stats['total_clients'] ?? 0 ?></p>
                    <span class="ml-2 text-sm font-medium text-green-600 flex items-center">
                        <i class="ri-arrow-up-s-line"></i>
                        0%
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">Clientes registrados</p>
            </div>
        </div>
    

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Mobile menu toggle
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', function () {
                        mobileMenu.classList.toggle('hidden');
                    });
                }
                // Mobile dropdowns
                const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
                mobileDropdowns.forEach(dropdown => {
                    const button = dropdown.querySelector('button');
                    const content = dropdown.querySelector('div');
                    if (button && content) {
                        button.addEventListener('click', function () {
                            content.classList.toggle('hidden');
                            const icon = button.querySelector('i.ri-arrow-down-s-line');
                            if (icon) {
                                icon.classList.toggle('ri-arrow-down-s-line');
                                icon.classList.toggle('ri-arrow-up-s-line');
                            }
                        });
                    }
                });
            });
        </script>

        <?= $this->include('partials/notification-js') ?>
    </main>
</body>

</html>
