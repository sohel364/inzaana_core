mkdir bdrepo
cd ~/bdrepo/
git clone https://github.com/sohel364/inzaana_core
cd inzaana_core/
git pull
composer self-update
composer update
cd ~/public_html/
cp -R ../bdrepo/inzaana_core/inzaana_cms/ inzaana_cms/
php artisan migrate --seed

