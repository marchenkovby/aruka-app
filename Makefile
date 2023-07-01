CONTAINER_NAME ?= aruka-app-backend-1

docker-up:
	docker-compose up -d
	make composer-install

docker-build:
	docker-compose up -d --build
	make composer-install

docker-down:
	docker-compose down
	rm backend/composer.lock
	rm -rf backend/vendor

install:
	docker exec $(CONTAINER_NAME) php bin/install.php

sh:
	docker exec -it $(CONTAINER_NAME) sh

composer-install:
	docker exec $(CONTAINER_NAME) composer install

composer-update:
	docker exec $(CONTAINER_NAME) composer dump-autoload

composer-dump-autoload:
	docker exec -it $(CONTAINER_NAME) composer dump-autoload
