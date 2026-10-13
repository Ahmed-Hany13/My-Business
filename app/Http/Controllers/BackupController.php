<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    public function download()
    {
        set_time_limit(0);

        $database = DB::getDatabaseName();
        $filename = 'backup-' . $database . '-' . now()->format('Y-m-d_H-i-s') . '.sql';

        return response()->streamDownload(function () use ($database) {
            echo "-- Backup of database `{$database}`\n";
            echo "-- Generated at " . now()->toDateTimeString() . "\n\n";
            echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

            $tables = collect(DB::select('SHOW FULL TABLES WHERE Table_type = "BASE TABLE"'))
                ->map(fn ($row) => array_values((array) $row)[0]);

            foreach ($tables as $table) {
                // هيكل الجدول
                $create = (array) DB::select("SHOW CREATE TABLE `{$table}`")[0];
                echo "DROP TABLE IF EXISTS `{$table}`;\n";
                echo $create['Create Table'] . ";\n\n";

                // البيانات على دفعات عشان الذاكرة
                DB::table($table)->orderByRaw('1')->chunk(500, function ($rows) use ($table) {
                    foreach ($rows as $row) {
                        $values = collect((array) $row)->map(function ($v) {
                            if (is_null($v)) {
                                return 'NULL';
                            }
                            return DB::getPdo()->quote((string) $v);
                        })->implode(', ');

                        echo "INSERT INTO `{$table}` VALUES ({$values});\n";
                    }
                });

                echo "\n";
            }

            echo "SET FOREIGN_KEY_CHECKS=1;\n";
        }, $filename, ['Content-Type' => 'application/sql']);
    }
}
