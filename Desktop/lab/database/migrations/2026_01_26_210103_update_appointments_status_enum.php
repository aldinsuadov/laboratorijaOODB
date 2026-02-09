<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            // MySQL doesn't support changing ENUM directly, so we need to alter the column
            DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('scheduled', 'cancelled', 'done') DEFAULT 'scheduled'");
        } elseif ($driver === 'pgsql') {
            // PostgreSQL: Drop old constraint and create new one
            DB::statement("ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check");
            DB::statement("ALTER TABLE appointments ADD CONSTRAINT appointments_status_check CHECK (status IN ('scheduled', 'cancelled', 'done'))");
            DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'scheduled'");
        } else {
            // For SQLite and other databases, use Schema builder
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('status')->default('scheduled')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending'");
        } elseif ($driver === 'pgsql') {
            // PostgreSQL: Drop new constraint and restore old one
            DB::statement("ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check");
            DB::statement("ALTER TABLE appointments ADD CONSTRAINT appointments_status_check CHECK (status IN ('pending', 'completed', 'cancelled'))");
            DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'pending'");
        } else {
            // For SQLite and other databases
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
        }
    }
};
