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

{if $smarty.session.isLogin}
    <h2>ようこそ, {$smarty.session.nick_name}様!</h2>
    <a href=userDetail.php?mode=showUserDetail>登録情報を見る</a>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
