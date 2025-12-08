<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'assign:admin {email}';
    protected $description = 'Assign admin role to a user by email';

    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($role);

        $this->info("Admin role assigned to {$user->email}");
    }
}
