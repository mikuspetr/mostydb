<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create auditor role if it doesn't exist
        if (!Role::where('name', 'auditor')->exists()) {
            Role::create(['name' => 'auditor', 'guard_name' => 'web']);
        }

        // Insert auditor user
        DB::table('users')->insert([
            'name' => 'Auditor',
            'email' => 'auditor@mostyvsetin.cz',
            'login' => 'auditor',
            'password' => Hash::make('TajneHeslo'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Remove auditor user
        $auditorUser = \App\Models\User::where('login', 'auditor')->first();
        if ($auditorUser) {
            $auditorUser->delete();
        }

        // Remove auditor role if it exists and has no other users
        $auditorRole = Role::where('name', 'auditor')->first();
        if ($auditorRole && $auditorRole->users()->count() === 0) {
            $auditorRole->delete();
        }
    }
};
