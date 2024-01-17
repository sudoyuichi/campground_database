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

<h1>ユーザ詳細確認ページ</h1>
{if $smarty.session.isLogin}
    <p>ここにユーザ詳細情報を表示。</p>
    
    <a href=main.php?>メインページはこちら</a>
    <a href=userDetail.php?mode=showModifyUserDetail>詳細情報の修正はこちら</a>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
