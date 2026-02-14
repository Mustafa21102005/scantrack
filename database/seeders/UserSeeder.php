<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'lecturer']);
        Role::firstOrCreate(['name' => 'student']);

        // Create admin
        $this->createUser('Admin User', 'admin@gmail.com', 'admin');

        // Create a specific lecturer
        $this->createUser('Lecturer User', 'lecturer@gmail.com', 'lecturer');

        // Create a specific student
        $this->createUser('Student User', 'student@gmail.com', 'student');

        // Create additional lecturers
        User::factory(2)->create()->each(function ($user) {
            $this->assignRole($user, 'lecturer');
        });

        // Create additional students
        User::factory(5)->create()->each(function ($user) {
            $this->assignRole($user, 'student');
        });
    }

    /**
     * Creates a user with the given name, email and role.
     *
     * @param string $name
     * @param string $email
     * @param string $role
     */
    private function createUser($name, $email, $role)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $this->assignRole($user, $role);
    }

    /**
     * Assigns the given role to the given user.
     *
     * @param User $user
     * @param string $role
     */
    private function assignRole(User $user, string $role): void
    {
        $user->assignRole($role);
    }
}
