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

<h1>メインページ</h1>

{if isset($smarty.session.name)}
    <h2>ようこそ, {$smarty.session.name}様!</h2>
{else}
    <!-- ログインしていない場合の処理 -->
    <p>You are not logged in.</p>
{/if}

</body>
</html>