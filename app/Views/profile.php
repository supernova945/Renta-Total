<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MI Renta Total - Perfil</title>
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
            background-color: #AD2E2E;
        }
    </style>
</head>

<body class="bg-gray-50">

  <?= $this->include('partials/header') ?>

    <main class="pt-24 pb-12 px-4 md:px-6 max-w-4xl mx-auto">
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

        <?php if (session()->has('errors')) : ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                
                <ul class="list-disc list-inside">
                    <?php foreach (session('errors') as $error) : ?>
                        <li><?php echo esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Mi Perfil</h1>
            <div class="flex items-center space-x-2">
                <div class="mt-4 md:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                    <span class="text-sm text-gray-700 font-medium"><?= date('d/m/Y') ?></span>
                </div>
            </div>
        </div>

        <!-- Profile Header Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-8">
                <div class="w-24 h-24 bg-gradient-to-br from-primary to-primaryb rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                    <?php echo strtoupper(substr($user['nombre'] ?? 'U', 0, 1)); ?>
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        <?php echo esc($user['nombre'] ?? 'Usuario'); ?>
                    </h2>
                    <p class="text-lg text-gray-600 mb-1">
                        <?php echo esc($user['correo'] ?? 'usuario@ejemplo.com'); ?>
                    </p>
                    <div class="flex items-center justify-center md:justify-start space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary/10 text-primary">
                            <i class="ri-shield-user-line mr-1"></i>
                            <?php echo esc($user['rol'] ?? 'Usuario'); ?>
                        </span>
                        <span class="text-sm text-gray-500">
                            <i class="ri-calendar-line mr-1"></i>
                            Miembro desde <?php echo date('M Y', strtotime($user['created_at'] ?? 'now')); ?>
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button type="button" id="editProfileButton"
                            class="bg-primary text-white px-6 py-3 rounded-button hover:bg-primaryb transition-all duration-200 flex items-center shadow-sm">
                        <i class="ri-edit-line mr-2"></i>
                        Editar Perfil
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Information Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Información Personal -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="ri-user-line mr-2 text-primary"></i>
                    Información Personal
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Nombre Completo</span>
                        <span class="text-sm text-gray-900"><?php echo esc($user['nombre'] ?? 'No especificado'); ?></span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Correo Electrónico</span>
                        <span class="text-sm text-gray-900"><?php echo esc($user['correo'] ?? 'No especificado'); ?></span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">DUI</span>
                        <span class="text-sm text-gray-900"><?php echo esc($user['dui'] ?? 'No especificado'); ?></span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Usuario</span>
                        <span class="text-sm text-gray-900"><?php echo esc($user['user'] ?? 'No especificado'); ?></span>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm font-medium text-gray-600">Última Actualización</span>
                        <span class="text-sm text-gray-900"><?php echo $user['updated_at'] ? date('d/m/Y H:i', strtotime($user['updated_at'])) : 'Nunca'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Configuración de Seguridad -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="ri-lock-line mr-2 text-primary"></i>
                    Seguridad
                </h3>
                <form action="<?= base_url('/profile/change-password') ?>" method="post" class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña Actual
                        </label>
                        <input type="password" id="current_password" name="current_password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Ingresa tu contraseña actual">
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva Contraseña
                        </label>
                        <input type="password" id="new_password" name="new_password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Ingresa tu nueva contraseña">
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Nueva Contraseña
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Confirma tu nueva contraseña">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full bg-secondary text-white px-4 py-2 rounded-button hover:bg-red-700 transition-all duration-200 flex items-center justify-center">
                            <i class="ri-key-line mr-2"></i>
                            Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>

            <!-- Configuración de Notificaciones
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="ri-notification-3-line mr-2 text-primary"></i>
                    Notificaciones
                </h3>
                <div class="space-y-5">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Notificaciones por Email</h4>
                            <p class="text-sm text-gray-500 mt-1">Recibe actualizaciones por correo</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Alertas de Inventario</h4>
                            <p class="text-sm text-gray-500 mt-1">Notificaciones sobre bajo inventario</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">Recordatorios de Mantenimiento</h4>
                            <p class="text-sm text-gray-500 mt-1">Notificaciones sobre mantenimientos</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/25 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
                    -->
        <!-- Recent Activity Section 
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="ri-time-line mr-2 text-primary"></i>
                Actividad Reciente
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <i class="ri-login-circle-line"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Inicio de sesión exitoso</p>
                        <p class="text-xs text-gray-500">Hace 2 horas</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <i class="ri-user-settings-line"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Perfil actualizado</p>
                        <p class="text-xs text-gray-500">Hace 1 día</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3 p-4 bg-purple-50 rounded-lg">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                        <i class="ri-motorbike-line"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">Nueva motocicleta registrada</p>
                        <p class="text-xs text-gray-500">Hace 3 días</p>
                    </div>
                </div>
            </div>
        </div>
                        -->
        <!-- Edit Profile Modal - Exact copy from usuarios view -->
        <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-primary">Editar Perfil</h3>
                    <button id="closeEditUserModal" class="text-gray-400 hover:text-gray-700">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                <form id="editUserForm" class="space-y-4">
                    <div>
                        <label for="editNombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="editNombre" class="w-full px-3 py-2 border rounded-button">
                    </div>

                    <div>
                        <label for="editUsuario" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <input type="text" id="editUsuario" class="w-full px-3 py-2 border rounded-button">
                    </div>

                    <div>
                        <label for="editCorreo" class="block text-sm font-medium text-gray-700">Correo</label>
                        <input type="email" id="editCorreo" class="w-full px-3 py-2 border rounded-button">
                    </div>

                    <div>
                        <label for="editDui" class="block text-sm font-medium text-gray-700">DUI</label>
                        <input type="text" id="editDui" class="w-full px-3 py-2 border rounded-button" placeholder="00000000-0">
                    </div>

                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" id="cancelEditUser" class="px-4 py-2 text-sm bg-gray-100 rounded-button hover:text-white hover:bg-secondary">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-primary text-white rounded-button hover:text-white hover:bg-secondary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

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
                }}
            );
        });

        // Profile edit modal functionality
        function initializeProfileEdit() {
            const editProfileButton = document.getElementById('editProfileButton');
            const editUserModal = document.getElementById('editUserModal');
            const editUserForm = document.getElementById('editUserForm');

            if (!editProfileButton || !editUserModal) {
                return;
            }

            // Remove any existing event listeners
            const newButton = editProfileButton.cloneNode(true);
            editProfileButton.parentNode.replaceChild(newButton, editProfileButton);

            // Add click event listener
            newButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Get user data from the displayed profile information (similar to usuarios approach)
                const nameElement = document.querySelector('h2.text-2xl.font-bold.text-gray-900');
                const emailElement = document.querySelector('p.text-lg.text-gray-600');
                const profileRows = document.querySelectorAll('.space-y-4 > div');

                let nombre = '', correo = '', dui = '', user = '';

                // Get name from header
                if (nameElement) {
                    nombre = nameElement.textContent.trim();
                }

                // Get email from header
                if (emailElement) {
                    correo = emailElement.textContent.trim();
                }

                // Get DUI and username from profile rows
                profileRows.forEach(row => {
                    const labelElement = row.querySelector('span.text-sm.font-medium.text-gray-600');
                    const valueElement = row.querySelector('span.text-sm.text-gray-900');

                    if (labelElement && valueElement) {
                        const label = labelElement.textContent.trim();
                        const value = valueElement.textContent.trim();

                        if (label === 'DUI') {
                            dui = value === 'No especificado' ? '' : value;
                        } else if (label === 'Usuario') {
                            user = value === 'No especificado' ? '' : value;
                        }
                    }
                });

                // Pre-fill form with current user data
                const nombreField = document.getElementById('editNombre');
                const correoField = document.getElementById('editCorreo');
                const duiField = document.getElementById('editDui');
                const usuarioField = document.getElementById('editUsuario');

                if (nombreField) nombreField.value = nombre;
                if (correoField) correoField.value = correo;
                if (duiField) duiField.value = dui;
                if (usuarioField) usuarioField.value = user;

                // Show modal
                if (editUserModal) {
                    editUserModal.classList.remove('hidden');
                }
            });
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeProfileEdit);
        } else {
            initializeProfileEdit();
        }

        // Close modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const closeEditUserModal = document.getElementById('closeEditUserModal');
            const cancelEditUser = document.getElementById('cancelEditUser');
            const editUserModal = document.getElementById('editUserModal');
            const editUserForm = document.getElementById('editUserForm');

            if (cancelEditUser && editUserModal) {
                cancelEditUser.addEventListener('click', function() {
                    editUserModal.classList.add('hidden');
                });
            }

            if (closeEditUserModal && editUserModal) {
                closeEditUserModal.addEventListener('click', function() {
                    editUserModal.classList.add('hidden');
                });
            }

            // Close modal when clicking outside
            if (editUserModal) {
                editUserModal.addEventListener('click', function(event) {
                    if (event.target === editUserModal) {
                        editUserModal.classList.add('hidden');
                    }
                });
            }

            // Form submission
            if (editUserForm) {
                editUserForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const data = {
                        nombre: document.getElementById('editNombre')?.value || '',
                        user: document.getElementById('editUsuario')?.value || '',
                        correo: document.getElementById('editCorreo')?.value || '',
                        dui: document.getElementById('editDui')?.value || ''
                    };

                    fetch(`${baseUrl}/profile/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(data)
                    })
                        .then(async response => {
                            const res = await response.json();
                            if (!response.ok) throw new Error(res.error || 'Error al actualizar perfil');
                            alert('Perfil actualizado correctamente');
                            if (editUserModal) {
                                editUserModal.classList.add('hidden');
                            }
                            location.reload();
                        })
                        .catch(err => alert(err.message));
                });
            }
        });
    </script>

    <?= $this->include('partials/notification-js') ?>

</body>

</html>
