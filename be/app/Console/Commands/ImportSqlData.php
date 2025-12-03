<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSqlData extends Command
{
    protected $signature = 'db:import-sql {file}';
    protected $description = 'Import SQL file data into database';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $this->info('Reading SQL file...');
        $sql = File::get($filePath);

        $this->info('Parsing SQL statements...');

        // Remove comments and split by semicolons
        $sql = preg_replace('/--.*$/m', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);

        // Split statements
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            fn($stmt) => !empty($stmt) &&
                        !preg_match('/^(SET|START|COMMIT|\/\*|CREATE TABLE|ALTER TABLE|DROP TABLE)/i', $stmt)
        );

        $this->info('Disabling foreign key checks...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $imported = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar(count($statements));
        $bar->start();

        foreach ($statements as $statement) {
            try {
                if (preg_match('/^INSERT INTO/i', trim($statement))) {
                    DB::statement($statement);
                    $imported++;
                }
                $bar->advance();
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->warn("Failed to execute statement: " . substr($statement, 0, 100) . '...');
                $this->error($e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Enabling foreign key checks...');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info("Import completed!");
        $this->line("Imported: {$imported} statements");

        if ($failed > 0) {
            $this->warn("Failed: {$failed} statements");
        }

        return 0;
    }
}
