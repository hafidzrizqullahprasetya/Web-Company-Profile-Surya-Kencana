# 🗑️ Automated Storage Cleanup Guide

Sistem ini menyediakan **automated cleanup** untuk database records yang merujuk ke file yang sudah dihapus dari storage.

---

## 🎯 Problem yang Dipecahkan

Ketika Anda:
1. Hapus file manual dari `storage/app/public/` atau R2 bucket
2. Database masih menyimpan path ke file tersebut
3. Frontend error/broken image karena file tidak ada

**Solusi:** Automated cleanup akan mendeteksi dan membersihkan database secara otomatis!

---

## 📋 Cara Penggunaan

### 1️⃣ Manual Cleanup via Artisan Command

#### Dry Run (Preview saja, tidak ubah database)

```bash
php artisan storage:cleanup-missing --dry-run
```

Output:
```
🔍 Scanning for missing images...
   Disk: r2
   Mode: DRY RUN (no changes)

📦 Checking Products...
   ❌ Missing: products/5 - products/old-file.jpg
   ✓ Checked 10 products

✨ Cleanup Complete!
   Scanned: 10 records
   Cleaned: 0 records (dry run)
```

#### Live Cleanup (Akan update database)

```bash
php artisan storage:cleanup-missing
```

Akan **DELETE** records yang file-nya tidak ada!

#### Check Specific Disk

```bash
# Check R2 storage
php artisan storage:cleanup-missing --disk=r2

# Check local storage
php artisan storage:cleanup-missing --disk=public
```

---

### 2️⃣ Scheduled Cleanup (Otomatis via Cron)

Edit `app/Console/Kernel.php` untuk jadwal otomatis:

```php
protected function schedule(Schedule $schedule)
{
    // Cleanup setiap hari jam 2 pagi
    $schedule->command('storage:cleanup-missing')
             ->daily()
             ->at('02:00');

    // Atau setiap minggu
    $schedule->command('storage:cleanup-missing')
             ->weekly()
             ->sundays()
             ->at('03:00');
}
```

Aktifkan cron di server:

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

### 3️⃣ On-Demand Cleanup via Model

Model sudah dilengkapi dengan auto-cleanup saat generate URL (optional):

```php
// Di controller atau service
$product = Product::find(1);

// Default: tidak check file existence (performance)
$url = $product->image_url;

// Dengan file check (akan auto-cleanup jika file tidak ada)
$url = $product->buildImageUrl($product->image_path, checkExists: true);
```

**Note:** `checkExists: true` akan:
- Check apakah file exist di storage
- Jika tidak ada → set field jadi `null` di database
- Cache hasil check selama 5 menit (untuk performance)

---

## ⚙️ Konfigurasi

### Strategi Cleanup

Edit command jika ingin ubah behavior:

**Option 1: DELETE record** (default)
```php
$product->delete();
```

**Option 2: SET NULL field**
```php
$product->update(['image_path' => null]);
```

File: `app/Console/Commands/CleanupMissingImages.php:77`

### Cache Duration

File existence check di-cache selama 5 menit. Edit di:

File: `app/Traits/StorageImageTrait.php:69`

```php
return Cache::remember($cacheKey, 300, function () use ($path) {
    // 300 seconds = 5 minutes
});
```

---

## 🧪 Testing Workflow

### Test Scenario 1: Manual File Delete

1. Upload product dengan gambar
2. Hapus file manual dari R2 bucket
3. Jalankan cleanup:
   ```bash
   php artisan storage:cleanup-missing --dry-run
   ```
4. Verifikasi output menampilkan missing file
5. Jalankan live cleanup:
   ```bash
   php artisan storage:cleanup-missing
   ```
6. Check database - record harus sudah terhapus!

### Test Scenario 2: Scheduled Cleanup

1. Setup cron untuk daily cleanup
2. Hapus beberapa file manual dari storage
3. Wait 24 jam atau trigger manual:
   ```bash
   php artisan schedule:run
   ```
4. Check log: `storage/logs/laravel.log`
5. Verifikasi database sudah clean

---

## 📊 Monitoring & Logs

### Check Cleanup Logs

```bash
tail -f storage/logs/laravel.log | grep "Auto-cleaned"
```

Output:
```
[2025-11-13 12:00:00] local.INFO: Auto-cleaned missing image from products.image_path: products/old-file.jpg
```

### Manual Check File Existence

```bash
# Via tinker
php artisan tinker

>>> Storage::disk('r2')->exists('products/test.jpg')
=> false

>>> Storage::disk('public')->exists('products/test.jpg')
=> true
```

---

## 🔧 Troubleshooting

### Issue: Command Timeout

Jika database besar, increase timeout:

```php
// In CleanupMissingImages.php
public function handle()
{
    set_time_limit(600); // 10 minutes
    // ...
}
```

### Issue: Too Many Storage API Calls

Enable cache dan batch processing:

```php
// Cache file list
$files = Cache::remember('r2_files', 3600, function() {
    return Storage::disk('r2')->allFiles();
});
```

### Issue: False Positives

Jika ada lag sync antara local dan R2:

```bash
# Check both storages
php artisan storage:cleanup-missing --disk=r2
php artisan storage:cleanup-missing --disk=public
```

---

## 🚀 Best Practices

1. **Dry run first**: Selalu test dengan `--dry-run` sebelum live cleanup
2. **Schedule wisely**: Jalankan cleanup saat traffic rendah (malam hari)
3. **Monitor logs**: Check logs setelah cleanup pertama kali
4. **Backup database**: Backup sebelum cleanup besar-besaran
5. **Test recovery**: Punya backup file di case emergency restore

---

## 📝 Summary Commands

```bash
# Preview cleanup (safe)
php artisan storage:cleanup-missing --dry-run

# Execute cleanup (delete records)
php artisan storage:cleanup-missing

# Check specific disk
php artisan storage:cleanup-missing --disk=public

# View cleanup logs
tail -f storage/logs/laravel.log | grep "Auto-cleaned"
```

---

## 🎯 Next Steps

1. ✅ Test manual cleanup dengan `--dry-run`
2. ✅ Verifikasi behavior sesuai kebutuhan
3. ✅ Setup scheduled task di cron
4. ✅ Monitor logs untuk minggu pertama
5. ✅ Adjust schedule sesuai kebutuhan
