# Docker 起動・停止
up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

restart:
	./vendor/bin/sail down && ./vendor/bin/sail up -d

# npm 系
npm-install:
	./vendor/bin/sail npm install

npm-dev:
	./vendor/bin/sail npm run dev

npm-build:
	./vendor/bin/sail npm run build

# artisan 系
migrate:
	./vendor/bin/sail artisan migrate

tinker:
	./vendor/bin/sail artisan tinker
