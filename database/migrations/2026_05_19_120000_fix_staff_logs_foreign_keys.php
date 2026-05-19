<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('staff_logs', 'user_id') && $this->columnTypeIsUuid('staff_logs', 'user_id')) {
            Schema::table('staff_logs', function (Blueprint $table) {
                if ($this->hasForeignKey('staff_logs', 'staff_logs_staff_id_foreign')) {
                    $table->dropForeign(['staff_id']);
                }
            });

            Schema::table('staff_logs', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });

            Schema::table('staff_logs', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('changes')->constrained('users')->nullOnDelete();
            });
        }

        if ($this->hasForeignKey('staff_logs', 'staff_logs_staff_id_foreign')) {
            Schema::table('staff_logs', function (Blueprint $table) {
                $table->dropForeign(['staff_id']);
            });
        }

        DB::statement('ALTER TABLE staff_logs MODIFY staff_id CHAR(36) NULL');

        Schema::table('staff_logs', function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff_logs', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
        });

        DB::statement('ALTER TABLE staff_logs MODIFY staff_id CHAR(36) NOT NULL');

        Schema::table('staff_logs', function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('staff')->cascadeOnDelete();
        });
    }

    private function hasForeignKey(string $table, string $name): bool
    {
        $database = Schema::getConnection()->getDatabaseName();

        $result = DB::select(
            'SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND CONSTRAINT_TYPE = ?',
            [$database, $table, $name, 'FOREIGN KEY']
        );

        return count($result) > 0;
    }

    private function columnTypeIsUuid(string $table, string $column): bool
    {
        $database = Schema::getConnection()->getDatabaseName();

        $result = DB::select(
            'SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?',
            [$database, $table, $column]
        );

        return isset($result[0]) && $result[0]->DATA_TYPE === 'char';
    }
};
