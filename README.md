# laravel

オンラインIDEのCloud9を使用した例です。
<https://c9.io/>

## Composerの使用

Composerがインストールされていることが前提やけんね。  
<https://getcomposer.org/>

`curl -sS https://getcomposer.org/installer | php`

## GitHubのクローン

コピペしたが楽かよ。  
<https://github.com/minorisol/laravel>

`git clone https://github.com/minorisol/laravel.git`

あ、Composerの更新も忘れんどきーね。

`composer update`

## ApacheのDocumentRootを変更

Cloud9やったらココば変えるとよ。

`sudo vim /etc/apache2/sites-enabled/001-cloud9.conf`  
`DocumentRoot /home/ubuntu/workspace/＜アプリ名＞/public`  
ワークスペース直下なら...  
`DocumentRoot /home/ubuntu/workspace/public`  

## MySQLの設定

既にDB用意してるんなら、ここ飛ばしてもよかばい。  
rootはどうかと思うけど、とりあえず動けばよかろーもん...

```mysql-ctl start  
mysql -u root  
create database ＜DB名＞;  
grant all on DB名.*  to root@localhost identified by '＜パスワード＞';
```

## 設定ファイル（.env）を作成

サンプルをコピーって作り～。  
`cp .env.example .env`

APP_KEYの生成はコレ一発やけん。  
`php artisan key:generate`

追加したとこだけ言っとくけん。

```...  
API_PUSH=APIKeyOfPushcrew  
API_WEATHER=APIKeyOfWeatherUnderground  
...  
MAIL_FROM_ADDRESS=null  
MAIL_FROM_NAME=null  
MAIL_PRETEND=false
```

**API_PUSH**  
プッシュ通知をしてくれる「Pushcrew」っちゅ～サイトに登録して取得するAPIキー。

**API_WEATHER**  
「Weather Underground」っちゅ～お天気サイトに登録して取得するAPIキー。

**MAIL_FROM_ADDRESS と MAIL_FROM_NAME**  
面倒くさいけん、送信元メールドレスと送信者名をココで設定しちゃろっか。

**MAIL_PRETEND**  
メールのデバッグモードみたいなやつ。  
falseだとそのまま送信。trueだとログにメールの内容を出力。

## DBにテーブル作成

コレだけ。

`php artisan migrate`

動かしてみんね。