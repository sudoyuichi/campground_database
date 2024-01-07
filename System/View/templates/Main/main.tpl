<!DOCTYPE html>
<html lang="ja">
{include file="../common/head.tpl"}
<body>

<h1>メインページ</h1>

<h2>ようこそ, {$smarty.session.name}様!</h2>
<p>どのようにアクセスしても、この画面が表示されてしまうのはNG</p>
<a href=auth.php?mode=logout>ログアウト</a>

</body>
</html>
