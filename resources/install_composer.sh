#!/usr/bin/env bash

echo "Begin installation of composer"
wget https://getcomposer.org/installer -O composer-setup.php
php composer-setup.php
rm composer-setup.php
[[ -f /usr/bin/composer ]] && sudo rm /usr/bin/composer || true
sudo mv composer.phar /usr/bin/composer
echo "End installation of composer"
