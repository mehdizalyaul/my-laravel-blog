<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {


            // Add polymorphic columns
            $table->morphs('likeable');

            // Add a new unique constraint for the polymorphic relationship
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            // Drop the new unique constraint
            $table->dropUnique(['user_id', 'likeable_id', 'likeable_type']);

            // Drop polymorphic columns
            $table->dropColumn(['likeable_id', 'likeable_type']);

            // Re-add `post_id` column
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            // Restore the unique constraint
            $table->unique(['user_id', 'post_id']);
        });
    }
};
