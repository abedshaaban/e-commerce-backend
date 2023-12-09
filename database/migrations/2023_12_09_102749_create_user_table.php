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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid()->default(DB::raw('(UUID())'));
            $table->string('email');
            $table->string('password');
            $table->string('f_name')->nullable();
            $table->string('l_name')->nullable();
            $table->foreignId('role_id')
            ->default(3)
            ->references('id')
            ->on('roles')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
 
