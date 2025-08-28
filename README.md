<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Kanto-Rikoka

このリポジトリは **Laravel 12 + Vue 3** をベースにしたアプリケーションプロジェクトです。  
開発環境は **Docker + Laravel Sail** を利用しています。

---

## 開発環境の起動方法

Docker がインストールされていれば以下のコマンドで環境を起動できます。

```bash
# コンテナを起動
make up

# コンテナを停止
make down
```

make コマンドを使わない場合は以下を直接実行してください。

```
./vendor/bin/sail up -d
./vendor/bin/sail down
```

初回セットアップ

```
# 依存関係のインストール
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# 環境変数ファイルをコピー
cp .env.example .env

# アプリケーションキーを生成
./vendor/bin/sail artisan key:generate

# マイグレーション実行
./vendor/bin/sail artisan migrate
```

### フロントエンド開発

Vite を利用しており、以下のコマンドで開発用サーバーを起動します。

```
./vendor/bin/sail npm run dev
```
本番ビルドを行う場合は以下を利用してください。
```
./vendor/bin/sail npm run build
```

## 利用サービス (Sail)

PHP 8.x
Laravel 12.x
Vue 3.x
Vite
MySQL 8.x (ホストポート: 3307)

## よく使うコマンド

```
# コンテナ起動
make up

# コンテナ停止
make down

# npm ビルド（開発）
make npm-dev

# npm ビルド（本番）
make npm-build

# artisan migrate
make migrate
```

## 備考

ホストから MySQL に接続する場合は 127.0.0.1:3307 を使用してください。

Laravel コンテナ内からは DB_HOST=mysql, DB_PORT=3306 を利用します。

.env に FORWARD_DB_PORT=3307 を設定済みです。

