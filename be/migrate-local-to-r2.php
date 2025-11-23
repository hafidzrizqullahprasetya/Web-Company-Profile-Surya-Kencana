<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "📦 Migrating Local Files to R2...\n\n";

$folders = ['products', 'ourClients', 'company-histories', 'heroes', 'logos'];
$totalFiles = 0;
$migratedFiles = 0;
$errors = [];

foreach ($folders as $folder) {
    echo "📂 Checking folder: {$folder}/\n";

    // Get all files from local storage
    if (!Storage::disk('public')->exists($folder)) {
        echo "   ⚠️  Folder doesn't exist locally, skipping...\n\n";
        continue;
    }

    $files = Storage::disk('public')->allFiles($folder);

    if (empty($files)) {
        echo "   📭 No files found\n\n";
        continue;
    }

    echo "   📊 Found " . count($files) . " files\n";
    $totalFiles += count($files);

    foreach ($files as $file) {
        try {
            // Check if already exists in R2
            if (Storage::disk('r2')->exists($file)) {
                echo "   ⏭️  Skip (already exists): {$file}\n";
                $migratedFiles++;
                continue;
            }

            // Get file content from local
            $content = Storage::disk('public')->get($file);

            // Upload to R2
            Storage::disk('r2')->put($file, $content);

            echo "   ✅ Migrated: {$file}\n";
            $migratedFiles++;

        } catch (\Exception $e) {
            echo "   ❌ Error migrating {$file}: " . $e->getMessage() . "\n";
            $errors[] = $file;
        }
    }

    echo "\n";
}

echo "=" . str_repeat("=", 60) . "\n";
echo "📊 Migration Summary:\n";
echo "   Total Files Found: {$totalFiles}\n";
echo "   Successfully Migrated: {$migratedFiles}\n";
echo "   Errors: " . count($errors) . "\n";

if (!empty($errors)) {
    echo "\n❌ Failed Files:\n";
    foreach ($errors as $error) {
        echo "   - {$error}\n";
    }
}

echo "\n✨ Migration completed!\n\n";
echo "📌 Next Steps:\n";
echo "   1. Refresh your web application\n";
echo "   2. Images should now load from R2\n";
echo "   3. Both local and R2 now have the same files\n";
