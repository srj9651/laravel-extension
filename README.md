
# Laravel Extension Pack

## 機能

* アドオン機能の追加
	* 次期リリースバージョンLaravel5.0に対応しています。
	* Laravel5.0のディレクトリ構造を複製するイメージで使うことができます。
	* パッケージに独自の名前空間(PSR-4)を一つ持たせることができます。
	* Laravel4のパッケージとして扱えます。
		* config, viewの識別子の名前空間表記`{addon-name}::`が使えます。
	* アドオンの追加はディレクトリをコピーするだけ。`app/config/app.php`にコードを追加する必要はありません。

* 名前空間内でのファサード問題の解決
	* appディレクトリ下の名前空間付きクラスの中でファサードが使えます。(バックスラッシュやuse宣言不要)
	* アドオンの名前空間の中からも同じ記述方法でファサードが扱えます。

## インストール方法

`composer.json`ファイルを編集します。
行末のカンマはJSON記法に合わせて設定してください。
``` composer.json
	"require": [
		"laravel/framework": "5.*",
		...
		↓追加する
		"laravel-plus/extension": "2.*"
	],
```

以下のコマンドを実行して、Laravel Extension Packをセットアップしてください。
```
$ composer update

もしくは、

$ php composer.phar update
```

`app/config/app.config`ファイルを編集します。
``` app/config/app.config
	'providers' => [
		↓追加する
		'LaravelPlus\Extension\ServiceProvider',
		...
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		...
	],
```

アドオン設定ファイルをインストールします。
`app/config/addon.php`を生成したい時に、いつでも使えます。
```
$ php artisan addon:setup
```

## 動作確認
サンプルとして、アドオン`wiki`を作成します。
アドオンに割り当てられる名前空間は`Wiki`です。(--namespaceオプションで指定することもできます。)
```
$ php artisan addon:make wiki
```

ルーティング設定を確認してください。
```
$ php artisan route:list
```

ローカルサーバーを立ち上げ、ブラウザで`http://localhost:8000/addons/wiki`にアクセスします。
パッケージ名が表示されれば成功です。
```
$ php artisan serve
```

## コマンド

### php artisan addon:setup
アドオン機能を有効にします。
* addonsディレクトリを作成する。
* app/config/addon.phpファイルを作成する。

### php artisan addon:make &lt;addon-name&gt; {--namespace=...} {--no-namespace}
アドオンを作成します。
* addonsディレクトリ下に、**addon-name**という名前でディレクトリを作成する。
* 以下のディレクトリ構成を作成する。
	* assets/
	* config/
		* config.php
		* addon.php
	* controllers/
		* BaseController.php
		* SampleController.php
	* lang/
		* en/
		* `Lang::getLocale()`/
	* migrations/
	* models/
	* services/
		* ServiceProvider.php
	* views/
		* sample.blade.php
	* routes.php

### php artisan addon:check
全てのアドオンをチェックします。

## ファサードの拡張
Laravel4のエイリアスローダーはグローバル名前空間にしか作用しないため、名前空間の中からファサードを扱うにはクラス名の先頭に`\`を付けなければなりません。

```
function index()
{
	return \View::make()
}
```

または、use宣言を使います。

```
use View;

...

function index()
{
	return View::make()
}
```

Laravel Extensionは、アドオン下の名前空間内に対してファサードを解決するエイリアスローダーを持っているので、Laravel公式ドキュメント記載の方法がそのまま使えます。

```
function index()
{
	return View::make()
}
```

## 起動時の動き

* アドオンディレクトリ直下の.phpファイルを全てrequireします。
* `addons/{addon-name}/config/addon.php` の `namespace`を見て、`directories`に指定された全てのディレクトリに対しPSR-4規約に基づくクラスオートロードの設定をします。

## 機能追加予定

* アドオン
	* ~~ServiceProviderの設定~~ ***完了***
	* assetsのpublish
	* migration
* ビュー
	* ビュー引数を明示的に宣言する方法とチェック機能の追加

## 著者

Fumio Furukawa (fumio.furukawa@gmail.com)

## ライセンス

MIT
