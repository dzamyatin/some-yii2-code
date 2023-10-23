#!make
include .env

dev:
	make -s cert
	@make -s authority
	make build
	make up
	ARGS=install make composer
	make migrate
up:
	docker-compose -f ./docker-compose.yml up -d --remove-orphans
	echo "\n\n\n-------------\n Ready to serve connection by `cat ./.env | grep SSL_EXTERNAL_PORT | sed --expression='s/SSL_EXTERNAL_PORT=//g'` \n-------------\n"
down:
	docker-compose -f ./docker-compose.yml down
build:
	docker-compose -f ./docker-compose.yml build
migrate:
	docker exec -ti ${PROJECT_NAME}-php-fpm sh -c "php -f yii migrate/up --interactive 0"
dphp:
	docker exec -ti ${PROJECT_NAME}-php-fpm bash
dnginx:
	docker exec -ti ${PROJECT_NAME}-nginx bash
lphp:
	docker logs -f ${PROJECT_NAME}-php-fpm
lnginx:
	docker logs -f ${PROJECT_NAME}-nginx
cert:
	openssl req -x509 -newkey rsa:4096 -keyout nginx/key.pem -out nginx/cert.pem -sha256 -days 3650 -nodes -subj "/C=XX/ST=StateName/L=CityName/O=CompanyName/OU=CompanySectionName/CN=localhost"
	echo "\n\n-------\n Add cert to authority `pwd`/nginx/cert.pem >> /etc/ssl/certs/ca-certificates.crt \n--------\n"
authority:
	sudo sh -c "rm -f /usr/local/share/ca-certificates/${PROJECT_NAME}-local*.crt | cp ./nginx/cert.pem /usr/local/share/ca-certificates/${PROJECT_NAME}-local`date +%s`.crt && update-ca-certificates"
composer:
	docker exec -ti ${PROJECT_NAME}-php-fpm sh -c "cd /user && php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\" \
&& php composer-setup.php && php -r \"unlink('composer-setup.php');\"; \
cd /www && \
php /user/composer.phar $(ARGS)"
