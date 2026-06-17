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
        Schema::table('users', function (Blueprint $table) {
            $table-> enum('role', ['admin', 'staff', 'scanner']) //enum column type - role - only accepts these 3 string val nothing else.
                    -> default('staff') //new users are staff unless specified
                    ->after('email'); //place this colum after email column
                    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
