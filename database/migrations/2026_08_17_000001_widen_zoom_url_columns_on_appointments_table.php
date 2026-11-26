<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('zoom_meeting_link')->nullable()->change();
            $table->text('zoom_join_url')->nullable()->change();
            $table->text('zoom_start_url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('zoom_meeting_link')->nullable()->change();
            $table->string('zoom_join_url')->nullable()->change();
            $table->string('zoom_start_url')->nullable()->change();
        });
    }
};
