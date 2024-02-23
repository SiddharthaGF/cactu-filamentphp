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
        Schema::table('children', function (Blueprint $table) {
            $table->text('physical_description');
            $table->text('aspirations');
            $table->text('personality');
            $table->text('skills')->nullable();
            $table->text('likes')->nullable();
            $table->text('dislikes')->nullable();
            $table->text('signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('physical_description');
            $table->dropColumn('aspirations');
            $table->dropColumn('personality');
            $table->dropColumn('skills');
            $table->dropColumn('likes');
            $table->dropColumn('dislikes');
            $table->dropColumn('signature');
        });
    }
};
