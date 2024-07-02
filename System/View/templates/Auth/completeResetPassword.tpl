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

<h1>パスワード再設定</h1>
    <form action="auth.php" method="post">
        <input type="hidden" name="mode" value="re-register">
        <input type="hidden" name="uuid" value="{$smarty.session.reset_uuid}">
        <label for="new_password">新しいパスワード:</label>
        <input type="password" name="new_password" id="new_password" required>
        <br>
        <label for="confirm_new_password">新しいパスワード（確認用に再度）:</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password" required>
        <br>
        <button type="submit">パスワードを再登録</button>
    </form>
    <a href="auth.php">ログインはこちらへ</a>
</body>
</html>