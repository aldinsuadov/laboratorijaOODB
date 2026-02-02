<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('result_files', function (Blueprint $table) {
            $table->string('original_name')->after('file_path');
            $table->string('mime')->nullable()->after('original_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('result_files', function (Blueprint $table) {
            $table->dropColumn(['original_name', 'mime']);
        });
    }
};
