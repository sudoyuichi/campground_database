<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>キャンプ場サイト</title>
    <link rel="stylesheet" href="./css/layout.css">
    <script src="./js/main.js" defer></script>
</head>
<body>
    <h1>ユーザ仮登録ページ</h1>
    {$errorMsg}
    {if $result}
        <p>ご登録のメールアドレスに本登録を完了するためのメールを送信いたしました。<br>
           送信されたメールには、本登録を行うためのURLが記載されています。<br>
           URLをクリックして登録手続きを30分以内に完了させてください。<br>
           30分を過ぎると、URLは無効となり、再度仮登録から行う必要があります。<br>
           URLをクリックすると登録が完了画面が表示されます。<br>
        </p>        
        <h2>メール送信内容</h2>
        <p>メールタイトル：「キャンログ」本登録確認メール<br>
           メール送信元: [定数のシステムインフォメーション用アドレス]<br>
           メール送信先:[登録されたユーザーのメールアドレス]<br>
           本文：<br>
           「キャンログ」への登録ありがとうございます。現在、登録は仮登録の状態です。<br>
           本登録を完了するには、以下のURLをクリックしてください。<br>
           このURLは送信から30分以内にのみ有効です。<br>
           30分を過ぎると、URLは無効となり、再度仮登録から行う必要があります。<br>
           このメールに心当たりがない場合は、このメールを破棄してください。<br>
           本登録の期限：[{$timeLimit}]<br>
           URL : <a href={$checkUrl}>{$checkUrl}</a><br>
           ※ 仮登録された情報は30分で無効となります。
        </p>
    {/if}
</body>
</html>