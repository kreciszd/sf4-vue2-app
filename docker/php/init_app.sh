#!/bin/bash

# Skrypt uruchamiany podczas kazdego uruchomienia kontenera PHP:
cd ../../

# Instalacja zaleznosci
composer install

# Czyszczenie cache
php bin/console cache:clear
