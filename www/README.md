PHP files image upload using JS PHP and imagemagick
to install imagemagick on a pi
https://imagemagick.org/script/install-source.php

make sure paths are right for executing imagemagick functions from shell_exec
for example locate mogifry by typing sudo find / -name mogrify
/usr/local/bin/mogrify
then ensure that PATH environment is set accordingly in 3-upload.php
pi@pimqtt:/var/www/html/todo $ sudo grep "/usr" *.php
3-upload.php:putenv('PATH=/usr/bin/');


sudo git clone https://github.com/ImageMagick/ImageMagick.git ImageMagick-7.1.0
$ cd ImageMagick-7.1.0
$ ./configure
$ make
sudo make install
sudo ldconfig /usr/local/lib
Finally, verify the ImageMagick install worked properly, type
sudo /usr/local/bin/convert logo: logo.gif
