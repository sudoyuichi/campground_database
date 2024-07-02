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
    <h1>パスワードリセット結果</h1>
    {$errorMsg}
    {if $result}
        <p>ご登録のメールアドレスにパスワードリセットを完了するためのメールを送信いたしました。<br>
           送信されたメールには、パスワード再設定を行うためのURLが記載されています。<br>
           URLをクリックしてパスワード再設定を30分以内に完了させてください。<br>
           30分を過ぎると、URLは無効となり、再度リセットを行う必要があります。<br>
           URLをクリックするとパスワード再設定画面が表示されます。<br>
        </p>        
        <h2>メール送信内容</h2>
        <p>メールタイトル：「キャンログ」パスワードリセット<br>
           メール送信元: [定数のシステムインフォメーション用アドレス]<br>
           メール送信先:[登録されたユーザーのメールアドレス]<br>
           本文：<br>
           「キャンログ」のパスワードリセットが完了しました。 <br>
           新しいパスワードを以下のURLから登録してください。<br>
           このURLは送信から30分以内にのみ有効です。<br>
           30分を過ぎると、URLは無効となり、再度リセットを行う必要があります。<br>
           このメールに心当たりがない場合は、このメールを破棄してください。<br>
           本登録の期限：[{$timeLimit}]<br>
           URL : <a href={$checkUrl}>{$checkUrl}</a><br>
           ※ 有効期限を過ぎている場合、リンクは無効となります。
        </p>
    {/if}
</body>
</html>