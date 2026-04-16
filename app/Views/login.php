<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MI Renta Total - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0D3850',
                        secondary: '#AD2E2E'
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
<body class="min-h-screen flex items-center justify-center bg-primary">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-8">
            <img src="<?= base_url('images/logo3.png') ?>" alt="MIRentaLogo" class="h-32 mx-auto mb-2">
            <p class="text-gray-600">Sistema de manejo de inventario</p>
        </div>
    
        <?php if (session()->getFlashdata('error')):?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <?=session()->getFlashdata('error')?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('message')):?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                <?=session()->getFlashdata('message')?>
            </div>
        <?php endif;?>
        
            
        <?= form_open('/login')?>

        <div class="mb-6">
            <label for="usuario" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="ri-user-line"></i>
                </div>
                <input type="text" id="usuario" name="usuario"
                    class="pl-10 w-full h-12 px-4 py-2 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Usuario" required value="<?= old('usuario') ?>">
            </div>
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="ri-lock-line"></i>
                </div>
                <input type="password" id="password" name="password"
                    class="pl-10 w-full h-12 px-4 py-2 bg-gray-50 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="••••••••" required>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="togglePassword">
                    <i class="ri-eye-line text-gray-400"></i>
                </div>
            </div>
        </div>

        

        <button type="submit"
            class="w-full bg-primary text-white font-medium py-3 px-4 rounded-button hover:bg-primary/90 transition-all duration-200 flex items-center justify-center">
            <i class="ri-login-box-line mr-2"></i> Ingresar
        </button>

        <?= form_close() ?>

       
    </div>

    <script>
        // Visibilidad de contraseña
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
            }
        });
    </script>
</body>
</html>