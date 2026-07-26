#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="${1:-$PWD}"

echo "MiniILIAS Linux setup helper"
echo "Project directory: ${PROJECT_DIR}"

sudo apt update
sudo apt install -y php php-cli php-mysql php-mbstring php-xml php-curl unzip mysql-server

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer is not installed."
  echo "Install it from the official Composer instructions, then run composer install."
  exit 1
fi

cd "${PROJECT_DIR}"

cp -n .env.example .env || true
mkdir -p storage/logs
touch storage/logs/app.log
chmod -R u+rwX storage

composer install

echo
echo "Next steps:"
echo "1. Edit .env"
echo "2. Import database/schema.sql and database/seed.sql"
echo "3. Run: composer serve"
