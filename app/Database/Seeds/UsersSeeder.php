<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $db        = db_connect();

        try {
            $adminData = [
                'username' => 'admin',
                'email'    => 'admin@codepoint.com',
                'password' => 'Admin@123',
                'active'   => true,
            ];

            $adminData['password_hash'] = Password::hash($adminData['password']) ;
            unset($adminData['password']);

            $adminId = $userModel->insert($adminData);

            echo "Admin user ID: $adminId\n";

            $db->table('auth_groups_users')->insert([
                'group_id' => 1,
                'user_id'  => $adminId,
            ]);

            $userData = [
                'username' => 'user',
                'email'    => 'user@codepoint.com',
                'password' => 'User@123',
                'active'   => true,
            ];

            $userData['password_hash'] =  Password::hash($userData['password']);
            unset($userData['password']);

            $userId = $userModel->insert($userData);

            $db->table('auth_groups_users')->insert([
                'group_id' => 2,
                'user_id'  => $userId,
            ]);

            echo "Users seeded successfully.\n";
        } catch (\Exception $e) {
            log_message('error', 'Failed to seed users: ' . $e->getMessage());
            echo "Failed to seed users: " . $e->getMessage() . "\n";
        }
    }
}
