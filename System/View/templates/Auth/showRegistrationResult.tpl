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
    <h1>ユーザ本登録ページ</h1>
    
    {if $isUuidStillAlive}
    <p>ありがとうございます！「キャンログ」への本登録が完了しました。</p>
    <p>「キャンログ」をお楽しみいただけます。</p>
    <p>ログインして、すぐに始めましょう！</p>
    <a href="auth.php">ログイン画面へ</a>
    {else}
        <p>有効期限切れです。本登録出来ませんでした。</p>
        <a href=auth.php?mode=entry>ユーザ登録へ戻る</a>
    {/if}
</body>
</html>