<!-- Header -->
<header class="bg-primary shadow-sm fixed top-0 left-0 right-0 z-50">
    <div class="flex items-center justify-between px-6 py-1">

        <div class="flex items-center">
            <img src="<?= base_url('images/logow.png')?>" alt="MIRentaLogo" class="h-10 max-h-10 mr-4">
            <nav class="hidden md:flex items-center space-x-1">

            <a href="dashboarda"
            class="flex items-center px-3 py-2 text-sm font-medium text-white bg-secondary rounded">
                <div class="w-5 h-5 flex items-center justify-center mr-1.5">
                    <i class="ri-dashboard-line"></i>
                </div>
                Panel de Control
            </a>
            </nav>
        </div>


        <div class="flex items-center space-x-4">

            <div class="relative group">
                <button class="flex items-center px-3 py-2 text-sm font-medium text-white hover:text-white hover:bg-secondary rounded whitespace-nowrap !rounded-button">
                    <div class="flex items-center mr-1.5">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-group-line"></i>
                        </div>
                        Gestión
                    </div>
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </button> 
                <div class="absolute left-0 mt-2 w-48 bg-white rounded shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="<?= base_url('usuarios')?>"  class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-user-line"></i>
                        </div>
                        Usuarios
                    </a>
                    <a href="<?= base_url('clientes') ?>" class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-user-star-line"></i>
                        </div>
                        Clientes
                    </a>
                    <a href="<?= base_url('empresas') ?>" class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-building-line"></i>
                        </div>
                        Empresas
                    </a>
                </div>
            </div>

            <div class="relative group">
                <button class="flex items-center px-3 py-2 text-sm font-medium text-white hover:text-white hover:bg-secondary rounded whitespace-nowrap !rounded-button">
                    <div class="flex items-center mr-1.5">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-motorbike-line"></i>
                        </div>
                        Motocicletas
                    </div>
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </button>
                <div class="absolute left-0 mt-2 w-48 bg-white rounded shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="<?= base_url('motocicletas') ?>" class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-motorbike-line"></i>
                        </div>
                        Ver Motocicletas
                    </a>
                    <a href="<?= base_url('servicios') ?>" class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-tools-line"></i>
                        </div>
                        Servicios
                    </a>
                    <a href="<?= base_url('rentas') ?>" class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-calendar-check-line"></i>
                        </div>
                        Rentas
                    </a>
                </div>
            </div>

            <div class="relative group">
                <button>
                    <a href="<?= base_url('reportes') ?>"
                    class="flex items-center px-3 py-2 text-sm font-medium text-white hover:text-white hover:bg-secondary rounded whitespace-nowrap !rounded-button">
                        <div class="w-5 h-5 flex items-center justify-center mr-1.5">
                            <i class="ri-bar-chart-line"></i>
                        </div>
                        Reportes
                    </a>
                </button>
            </div>
<!--
            <div class="relative group">
                <button>
                    <a href="<?= base_url('cotizador') ?>"
                       class="flex items-center px-3 py-2 text-sm font-medium text-white hover:text-white hover:bg-secondary rounded whitespace-nowrap">
                        <div class="w-5 h-5 flex items-center justify-center mr-1.5">
                            <i class="ri-calculator-line"></i>
                        </div>
                        Cotizador
                    </a>
                </button>
            </div>-->

            <div class="relative">
                <button id="notificationButton" class="relative p-1 text-white hover:text-secondary focus:outline-none">
                    <div class="w-6 h-6 flex items-center justify-center">
                        <i class="ri-notification-3-line"></i>
                    </div>
                    <span id="notificationBadge" class="hidden absolute -top-1 -right-1 h-5 w-5 bg-red-500 rounded-full text-xs text-white flex items-center justify-center font-bold">0</span>
                </button>

                <!-- Notification Dropdown -->
                <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible transition-all duration-200 z-50 max-h-96 overflow-hidden" style="z-index: 9999;">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-primary">Notificaciones</h3>
                        <p class="text-xs text-gray-500">Actividades recientes del sistema</p>
                    </div>
                    <div id="notificationList" class="overflow-y-auto max-h-64 p-2">
                        <!-- Notifications will be loaded here -->
                        <div class="text-center py-4 text-gray-500 text-sm">
                            <i class="ri-notification-off-line text-2xl mb-2"></i>
                            <p>No hay notificaciones</p>
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-200 text-center">
                        <a href="<?= base_url('activity-log') ?>" class="text-xs text-primary hover:text-secondary mr-4">Ver registro de actividad</a>
                        <a href="<?= base_url('rentas') ?>" class="text-xs text-primary hover:text-secondary">Ver rentas</a>
                    </div>
                </div>
            </div>

            <div class="relative group">
                <button class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-white">
                        <i class="ri-user-line"></i>
                    </div>
                    <span class="text-sm font-medium text-white hidden md:block">
                        <?php
                        $session = session();
                        echo esc($session->get('nombre') ?: 'Invitado');
                        ?>
                    </span>
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-arrow-down-s-line" style="color: white;"></i>
                    </div>
                </button>
                <div
                    class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">

                    <a href="<?= base_url('profile') ?>"
                        class="flex items-center px-4 py-2 text-sm text-primary hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-user-settings-line"></i>
                        </div>
                        Perfil
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>

                    <a href="<?= base_url('logout') ?>" class="flex items-center px-4 py-2 text-sm text-red-600 hover:text-white hover:bg-secondary">
                        <div class="w-4 h-4 flex items-center justify-center mr-2">
                            <i class="ri-logout-box-r-line"></i>
                        </div>
                        Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="md:hidden px-4 pb-4">
        <button id="mobileMenuButton"
            class="flex items-center px-3 py-2 border border-gray-300 rounded text-grayb hover:text-primary hover:border-primary whitespace-nowrap !rounded-button">
            <div class="w-5 h-5 flex items-center justify-center mr-1">
                <i class="ri-menu-line"></i>
            </div>
            Menu
        </button>
    </div>
    <div id="mobileMenu" class="hidden md:hidden px-4 pb-4">
        <nav class="flex flex-col space-y-2">
            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-primary bg-blue-50 rounded">
                <div class="w-5 h-5 flex items-center justify-center mr-1.5">
                    <i class="ri-dashboard-line"></i>
                </div>
                Dashboard
            </a>
            <div class="mobile-dropdown">
                <button
                    class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium text-primary hover:text-white hover:bg-secondary rounded whitespace-nowrap !rounded-button">
                    <div class="flex items-center">
                        <div class="w-5 h-5 flex items-center justify-center mr-1.5">
                            <i class="ri-motorbike-line"></i>
                        </div>
                        Products
                    </div>
                    <div class="w-4 h-4 flex items-center justify-center">
                        <i class="ri-arrow-down-s-line"></i>
                    </div>
                </button>
                <div class="hidden pl-8 mt-1 space-y-1">
                    <a href="#"
                        class="block px-3 py-2 text-sm text-primary hover:text-white hover:bg-secondary rounded">Catalog</a>
                    <a href="#"
                        class="block px-3 py-2 text-sm text-primary hover:text-white hover:bg-secondary rounded">Categories</a>
                    <a href="#"
                        class="block px-3 py-2 text-sm text-primary hover:text-white hover:bg-secondary rounded">New
                        Listing</a>
                </div>
            </div>
        </nav>
    </div>
</header>