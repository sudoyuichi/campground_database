<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テストページ</title>
    <link rel="stylesheet" href="./css/layout.css">
    <script src="./js/main.js" defer></script>
</head>
<body>

<h1>テストページ</h1>

<p>テストデータ:</p>
<ul>
  {foreach $db_status as $user}
    <p> メールアドレス: {$user.email}</p>
  {/foreach}
</ul>


</body>
</html>
