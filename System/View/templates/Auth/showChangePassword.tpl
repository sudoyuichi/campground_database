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

<h1>パスワード変更ページ</h1>
{if $smarty.session.isLogin}
    <p><font color="red">{$errorMsg}</font></p>
    <form action="auth.php" method="post" >
        <label for="email">登録済メールアドレス:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <input type="hidden" name="mode" value="changePassword">
        <label for="current_password">現在のパスワード:</label>
        <input type="password" name="current_password" id="current_password" required>
        <br>
        <label for="new_password">新しいパスワード:</label>
        <input type="password" name="new_password" id="new_password" maxlength="8" required>
        <br>
        <label for="confirm_new_password">新しいパスワード（確認用に再度）:</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password" maxlength="8" required>
        <br>
        <button type="submit">パスワードを変更</button>
    </form>
    <br>
    <a href=userDetail.php?mode=showUserDetail>詳細情報へ戻る</a><br>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
