$scriptProvisionSystem = <<SCRIPT

    echo "[Update System] ..."

    add-apt-repository ppa:ondrej/php
    add-apt-repository ppa:nginx/stable

    echo "deb http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7" > /etc/apt/sources.list.d/mysql.list
    echo "deb-src http://repo.mysql.com/apt/ubuntu/ trusty mysql-5.7" >> /etc/apt/sources.list.d/mysql.list

    apt-get -y update

    apt-get install -y \
            software-properties-common \
            tmux \
            curl \
            git \
            rsync \
            lynx \
            vim \
            nano \
            wget \
            htop \
            zip \
            telnet \
            lynx \
            xvfb

SCRIPT

$scriptProvisionPhp = <<SCRIPT

    echo "[Install Php7-fpm] ..."
    apt-get install -y --force-yes \
        php7.0-fpm \
        php7.0-cli \
        php7.0-cgi \
        php7.0-json \
        php7.0-curl \
        php7.0-gd \
        php7.0-intl \
        php7.0-mysql \
        php7.0-dom \
        php7.0-sybase \
        php7.0-odbc \
        php7.0-mbstring \
        php-pgsql

        echo "[Configure /etc/php/7.0/fpm/php.ini] ..."
        sed -i 's#;date.timezone =#date.timezone = Europe/Paris#g' /etc/php/7.0/fpm/php.ini
        #sed -i 's#short_open_tag = Off#short_open_tag = On#g' /etc/php/7.0/fpm/php.ini
        sed -i 's#error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT#error_reporting = E_ALL#g' /etc/php/7.0/fpm/php.ini
        sed -i 's#display_errors = Off#display_errors = On#g' /etc/php/7.0/fpm/php.ini

        echo "[Sql Server Driver Dependency] ..."
        apt-get -y install freetds-common

        echo "[Install XDebug] ..."
        apt-get -y install php7.0-dev
        wget https://xdebug.org/files/xdebug-2.4.0.tgz
        tar -xzf xdebug-2.4.0.tgz
        cd xdebug-2.4.0
        phpize
        ./configure --enable-xdebug
        make
        cp modules/xdebug.so /usr/lib/.

        echo "[Configure XDebug for FPM] ..."
        echo 'zend_extension="/usr/lib/xdebug.so"' > /etc/php/7.0/fpm/conf.d/20-xdebug.ini
        echo 'xdebug.remote_enable=1' >> /etc/php/7.0/fpm/conf.d/20-xdebug.ini

        echo "[Configure XDebug for CLI] ..."
        echo 'zend_extension="/usr/lib/xdebug.so"' > /etc/php/7.0/cli/conf.d/20-xdebug.ini
        echo 'xdebug.remote_enable=1' >> /etc/php/7.0/cli/conf.d/20-xdebug.ini

        echo "[Clean XDebug Installation Directory] ..."
        cd ..
        rm xdebug-2.4.0.tgz
        rm -R xdebug-2.4.0/

        echo "[Restart fpm] ..."
        service php7.0-fpm restart

        echo "[Install composer] ..."
        curl -sS https://getcomposer.org/installer | php
        mv composer.phar /usr/local/bin/composer

SCRIPT

$scriptProvisionNginx = <<SCRIPT

    echo "[Install Nginx] ..."
    apt-get -y --force-yes install nginx

    echo 'server {
    listen 80 default_server;
    listen [::]:80 default_server ipv6only=on;

    server_name local.social.com;
    root /vagrant/web;

    location / {
        # try to serve file directly, fallback to app.php
        try_files $uri /app.php$is_args$args;
    }
    location ~ ^/(app_dev|config)\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }
    # PROD
    location ~ ^/app\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal;
    }

    error_log /var/log/nginx/api_error.log;
    access_log /var/log/nginx/api_access.log;
}' > /etc/nginx/sites-available/default

    sed -i 's/sendfile on/sendfile off/g' /etc/nginx/nginx.conf

    service nginx restart

SCRIPT

Vagrant.require_version ">= 1.5"

Vagrant.configure("2") do |config|

    config.vm.provider :virtualbox do |v|
        v.gui = false
        v.name = "social"
        v.customize [
            "modifyvm", :id,
            "--name", "social",
            "--memory", 1024,
            "--natdnshostresolver1", "on",
            "--cpus", 1,
        ]
    end

    config.vm.box = "ubuntu/trusty64"

    config.vm.box_url = "https://vagrantcloud.com/ubuntu/boxes/trusty64/versions/14.04/providers/virtualbox.box"

    config.vm.network :private_network, ip: "192.168.33.105"
    #config.vm.hostname = "local.social.com"
    config.ssh.forward_agent = true

    config.vm.provision :shell, inline: $scriptProvisionSystem
    config.vm.provision :shell, inline: $scriptProvisionPhp
    config.vm.provision :shell, inline: $scriptProvisionNginx
    config.vm.provision :shell, :path => "database.sh"

    config.vm.synced_folder ".", "/vagrant", create: true, group: "www-data", owner: "www-data"
end