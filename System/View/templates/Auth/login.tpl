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

<h1>ユーザログインページ</h1>
    {$errorMsg}
    <form action="auth.php" method="post">
        <input type="hidden" name="mode" value="login">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
    </form>

    <form action="auth.php" method="post">
        <input type="hidden" name="mode" value="entry">
        <button type="submit">ユーザ登録へ</button>
    </form>
    <br>
    <a href=auth.php?mode=showResetPassword>パスワードを忘れた方はこちら</a><br>

</body>
</html>