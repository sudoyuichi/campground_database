<!DOCTYPE html>
<html lang="ja">
{include file="../common/head.tpl"}
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
        <h2>ようこそ, {$smarty.session.nick_name}様!</h2>
    {/if}
{/if}
<p>どのようにアクセスしても、この画面が表示されてしまうのはNG</p>
<a href=auth.php?mode=logout>ログアウト</a>

</body>
</html>
