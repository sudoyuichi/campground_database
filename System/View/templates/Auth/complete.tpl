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

<h1>ユーザ登録完了ページ</h1>

    {$errorMsg}
    {if $result}
        <p>こちらのURLをクリックするとユーザ登録完了</p>
        {$checkUrl}
    {/if}
</body>
</html>