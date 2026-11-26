<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (! Schema::hasColumn('appointments', 'zoom_join_url')) {
                $table->string('zoom_join_url')->nullable()->after('zoom_meeting_link');
            }

            if (! Schema::hasColumn('appointments', 'zoom_start_url')) {
                $table->string('zoom_start_url')->nullable()->after('zoom_join_url');
            }

            if (! Schema::hasColumn('appointments', 'zoom_meeting_id')) {
                $table->string('zoom_meeting_id')->nullable()->after('zoom_start_url');
            }
        });

        DB::table('appointments')->where('status', 'confirmed')->update(['status' => 'accepted']);
        DB::table('appointments')->where('status', 'cancelled')->update(['status' => 'rejected']);
        DB::table('appointments')
            ->whereNotIn('status', ['pending', 'accepted', 'rejected', 'completed'])
            ->update(['status' => 'pending']);

        if (Schema::hasColumn('appointments', 'zoom_meeting_link')) {
            DB::table('appointments')
                ->whereNull('zoom_join_url')
                ->whereNotNull('zoom_meeting_link')
                ->update(['zoom_join_url' => DB::raw('zoom_meeting_link')]);
        }

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending','accepted','rejected','completed') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(255) NOT NULL DEFAULT 'pending'");
        }

        Schema::table('appointments', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('appointments', 'zoom_join_url')) {
                $columns[] = 'zoom_join_url';
            }

            if (Schema::hasColumn('appointments', 'zoom_start_url')) {
                $columns[] = 'zoom_start_url';
            }

            if (Schema::hasColumn('appointments', 'zoom_meeting_id')) {
                $columns[] = 'zoom_meeting_id';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
