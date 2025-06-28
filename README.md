**目次**

- [📋 技術スタック](#-技術スタック)
- [🚀 クイックスタート](#-クイックスタート)
  - [1. 前提条件](#1-前提条件)
  - [2. プロジェクトのセットアップ](#2-プロジェクトのセットアップ)
  - [3. アクセス先](#3-アクセス先)
- [🛠️ 開発コマンド](#️-開発コマンド)
  - [基本コマンド](#基本コマンド)
  - [Docker コマンド](#docker-コマンド)
- [📁 プロジェクト構成](#-プロジェクト構成)
- [🔧 トラブルシューティング](#-トラブルシューティング)
  - [よくある問題](#よくある問題)
- [📝 データベース情報](#-データベース情報)

## 📋 技術スタック

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Vite
- **Database**: MySQL 8
- **Container**: Docker + Docker Compose
- **Development Tools**: PHPMyAdmin, MailHog

## 🚀 クイックスタート

### 1. 前提条件

以下がインストールされていることを確認してください：

- Docker Desktop
- Git

### 2. プロジェクトのセットアップ

```bash
# 1. リポジトリをクローン
git clone <repository-url>
cd path/to/

# 2. 環境ファイルの作成
cp product/.env.example product/.env

# 3. Dockerコンテナを起動
docker-compose up -d

# 4. アプリケーションコンテナに入る
docker-compose exec app bash

# 5. 依存関係のインストール
composer install
npm install

# 6. アプリケーションキーの生成
php artisan key:generate

# 7. データベースのマイグレーション
php artisan migrate

# 8. フロントエンド開発サーバーの起動
# ※ なぜか`exit`でコンテナから抜けてから`npm run dev`を実行しないと正常に反映されませんので、一旦、こちら
npm run dev
```

### 3. アクセス先

セットアップ完了後、以下の URL でアクセスできます：

| サービス         | URL                    | 説明                   |
| ---------------- | ---------------------- | ---------------------- |
| アプリケーション | http://localhost       | メインアプリケーション |
| ログイン         | http://localhost/login | ログインページ         |
| PHPMyAdmin       | http://localhost:8080  | データベース管理       |
| MailHog          | http://localhost:8025  | メール確認             |

※ログイン ID/PW は`.env`ファイルの以下の設定を参照してください：

```env
# Admin User Settings (product/.env)
ADMIN_EMAIL="***"     # ログインID（Email）
ADMIN_PASSWORD="***" # パスワード
```

## 🛠️ 開発コマンド

### 基本コマンド

```bash
# 開発サーバー起動（ホットリロード有効）
npm run dev

# 本番用ビルド
npm run build

# Artisan コマンド実行
php artisan [command]

# マイグレーション
php artisan migrate

# シーダー実行
php artisan db:seed
```

### Docker コマンド

```bash
# コンテナ起動
docker-compose up -d

# コンテナ停止
docker-compose down

# ログ確認
docker-compose logs -f [service-name]

# コンテナ内でコマンド実行
docker-compose exec app [command]
```

## 📁 プロジェクト構成

```
/
├── docker-compose.yml          # Docker構成
├── infra/                      # インフラ設定
│   └── docker/                 # Dockerファイル群
├── product/                    # Laravelアプリケーション
│   ├── app/                    # アプリケーションコード
│   ├── database/               # マイグレーション・シーダー
│   ├── public/                 # 公開ファイル
│   ├── resources/              # ビュー・アセット
│   └── routes/                 # ルート定義
└── README.md
```

## 🔧 トラブルシューティング

### よくある問題

**1. ポートが既に使用されている**

```bash
# 使用中のポートを確認
lsof -i :80
lsof -i :3306
```

**2. npm install エラー**

```bash
# node_modules を削除してから再インストール
rm -rf node_modules package-lock.json
npm install
```

## 📝 データベース情報

- **ホスト**: localhost
- **ポート**: 3306
- **データベース名**: db_base
- **ユーザー名**: db_user
- **パスワード**: secret
