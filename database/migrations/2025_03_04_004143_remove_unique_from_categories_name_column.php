<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique('categories_name_unique');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Add the unique constraint back if you want to roll back the migration
            $table->unique('name');
        });
    }

};
