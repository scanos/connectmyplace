PHP files image upload using JS PHP and imagemagick
to install imagemagick on a pi
https://imagemagick.org/script/install-source.php
1623  sudo git clone https://github.com/ImageMagick/ImageMagick.git ImageMagick-7.1.0
$ cd ImageMagick-7.1.0
$ ./configure
$ make
sudo make install
sudo ldconfig /usr/local/lib
Finally, verify the ImageMagick install worked properly, type
sudo /usr/local/bin/convert logo: logo.gif
