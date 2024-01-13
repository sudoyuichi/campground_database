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

<h1>ユーザ詳細修正ページ</h1>
{if $smarty.session.isLogin}
    <p>ここにユーザ詳細の修正入力欄を表示する。</p>
    
    <a href=main.php?>メインページはこちら</a>
    <a href=userDetail.php?mode=showUserDetail>登録した詳細情報を見る</a>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
