<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name'        => 'admin',
                'description' => 'Administrator role',
            ],
            [
                'name'        => 'user',
                'description' => 'Regular user role',
            ],
        ];

        $this->db->table('auth_groups')->insertBatch($roles);
    }
}
