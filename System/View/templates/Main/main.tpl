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

{if isset($smarty.session.isLogin)}
    <!-- 利用者の同意や登録状態をチェック -->
    {if !$smarty.session.privacyPolicy}
        <script>
            window.location.href = 'userDetail.php';
        </script>
    {elseif !$smarty.session.termsOfService}
        <script>
            window.location.href = 'userDetail.php';
        </script>
    {elseif !$smarty.session.completedToUserDetailRegistration}
        <script>
            window.location.href = 'userDetail.php';
        </script>
    {else}
        <h2>ようこそ, {$smarty.session.name}様!</h2>
    {/if}
{/if}

<a href=auth.php?mode=logout>ログアウト</a>

</body>
</html>
