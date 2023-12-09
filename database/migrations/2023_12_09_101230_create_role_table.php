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
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id');
            $table->enum('name', ['admin', 'seller', 'user']);
        });

        DB::table('roles')->insert([
           [ 
            'id' => 1,
            'name' => 'admin',
            ],
           [ 
            'id' => 2,
            'name' => 'seller',
            ],
           [ 
            'id' => 3,
            'name' => 'user',
            ],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
