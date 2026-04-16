<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();

        $data = [
            'nombre' => 'Admin User',
            'user' => 'admin',
            'Password' => password_hash('admin123', PASSWORD_DEFAULT),
            'correo' => 'admin@example.com',
            'estado' => 1,
            'rol' => 'admin',
            'dui' => '123456789'
        ];

        $model->insert($data);
    }
}