# Cara install
versi **Laravel** saat ini : 5.8
### requirement install laravel
 -  PHP >= 7.1.3
-   BCMath PHP Extension
-   Ctype PHP Extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

## Install Git
`sudo apt install git`
## Install composer
- Download file instalan composer
`php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
- Pengecekan file hash (opsional)
`php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"`
- Jalankan instalan composer
`php composer-setup.php`
- Hapus file instalan composer
`php -r "unlink('composer-setup.php');"`
## Install 
- Buat root directory install laravel
`mkdir /var/www/html/esurat`
- Masuk ke direktori yang telah dibuat
`cd /var/www/html/esurat`
- Inisialisasi repository local git `root directory`
`git init`
- Tambahkan repository ini
`git remote add origin https://github.com/andrewyohanes123/esurat-laravel`
- Pull repository
`git pull origin master`
- Jalankan script instalasi
`./install.sh` 

## Konfigurasi
Buka file `.env` untuk mengkonfigurasi database aplikasi.
[Dokumentasi konfigurasi Laravel](https://laravel.com/docs/5.8/configuration#environment-configuration)
## Troubleshooting
Jika file `install.sh` tidak dapat dieksekusi maka ketikkan perintah
`chmod -x ./install.sh`