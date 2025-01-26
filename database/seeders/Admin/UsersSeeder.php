<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getSeederData() as $row) {
            if ($row['email'] && $row['password']) {
                $user = new User();
                $user->fill($row);
                $user->save();
            }
        }
    }

    /**
     * @return array
     */
    private function getSeederData(): array
    {
        return [
            [
                'email'    => env('ADMIN_1_EMAIL'),
                'password' => env('ADMIN_1_PASS'),
            ],
            [
                'email'    => env('ADMIN_2_EMAIL'),
                'password' => env('ADMIN_2_PASS'),
            ],
        ];
    }
}
