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

<h1>パスワードリセット</h1>

    <form action="auth.php" method="post" >
        <input type="hidden" name="mode" value="resetPassword">
        <label for="email">登録済メールアドレス:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <button type="submit">パスワードをリセットする</button>
    </form>
    <br>
    <a href="auth.php">ログイン画面へ戻る</a>
</body>
</html>
