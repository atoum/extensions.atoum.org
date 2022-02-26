.PHONY: build build_assets build_website

build:
	make build_assets
	make build_website

build_assets: vendor
	./vendor/bin/robo build

build_website: vendor
	./vendor/bin/sculpin generate

vendor: composer.phar
	php composer.phar install

composer.phar:
	$(eval EXPECTED_SIGNATURE = "$(shell wget -q -O - https://composer.github.io/installer.sig)")
	$(eval ACTUAL_SIGNATURE = "$(shell php -r "copy('https://getcomposer.org/installer', 'composer-setup.php'); echo hash_file('SHA384', 'composer-setup.php');")")
	@if [ "$(EXPECTED_SIGNATURE)" != "$(ACTUAL_SIGNATURE)" ]; then echo "Invalid signature"; exit 1; fi
	php composer-setup.php --version=2.2.7
	rm composer-setup.php
