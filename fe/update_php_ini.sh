#!/bin/zsh

# ================================================================
# PHP.INI Configuration Update Script
# ================================================================

PHP_INI_PATH="/usr/local/etc/php/8.4/php.ini"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_PATH="${PHP_INI_PATH}.backup.${TIMESTAMP}"

echo "================================================"
echo "PHP.INI Configuration Update Script"
echo "================================================"
echo ""
echo "File location: ${PHP_INI_PATH}"
echo ""
echo "This script will:"
echo "1. Backup current php.ini"
echo "2. Update upload limits to maximum values"
echo ""

# ------------------------------------------------
# Backup original php.ini
# ------------------------------------------------
echo "Creating backup..."
if sudo cp "${PHP_INI_PATH}" "${BACKUP_PATH}"; then
  echo "✅ Backup created: ${BACKUP_PATH}"
else
  echo "❌ Failed to create backup. Check file path and permissions."
  exit 1
fi
echo ""

# ------------------------------------------------
# Update configuration values
# ------------------------------------------------
echo "Updating php.ini settings..."

function update_or_append() {
  local key="$1"
  local value="$2"
  local file="$3"

  # Update if key exists
  if grep -q "^${key}" "${file}"; then
    sudo sed -i'.tmp' "s/^${key}.*/${key} = ${value}/" "${file}"
  else
    echo "${key} = ${value}" | sudo tee -a "${file}" > /dev/null
  fi
}

update_or_append "upload_max_filesize" "500M" "${PHP_INI_PATH}"
update_or_append "post_max_size" "550M" "${PHP_INI_PATH}"
update_or_append "memory_limit" "1024M" "${PHP_INI_PATH}"
update_or_append "max_execution_time" "600" "${PHP_INI_PATH}"
update_or_append "max_input_time" "600" "${PHP_INI_PATH}"
update_or_append "max_file_uploads" "50" "${PHP_INI_PATH}"

# Hapus file sementara dari sed
sudo rm -f "${PHP_INI_PATH}.tmp"

echo ""
echo "================================================"
echo "✅ Configuration updated successfully!"
echo "================================================"
echo ""
echo "New settings:"
echo "  upload_max_filesize = 500M"
echo "  post_max_size = 550M"
echo "  memory_limit = 1024M"
echo "  max_execution_time = 600"
echo "  max_input_time = 600"
echo "  max_file_uploads = 50"
echo ""
echo "IMPORTANT: Restart your PHP/web server:"
echo "  - Laravel Valet: valet restart"
echo "  - PHP-FPM: sudo brew services restart php@8.4"
echo "  - Apache: sudo apachectl restart"
echo ""
echo "================================================"
echo "Done!"
echo "================================================"
echo ""
