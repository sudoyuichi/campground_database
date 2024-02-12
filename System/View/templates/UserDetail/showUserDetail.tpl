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

<h1>ユーザ詳細確認ページ</h1>
{if $smarty.session.isLogin}
    <table border="1">
        <tr>
            <th>ニックネーム</th>
            <th>誕生日</th>
            <th>居住都道府県</th>
            <th>Twitter</th>
            <th>Instagram</th>
            <th>YouTube</th>
            <th>ブログ</th>
            <th>アイコン画像</th>
            <th>プロフィール画像</th>
            <th>自己紹介</th>
        </tr>
        <tr>
            <td>{$smarty.session.user_data.nick_name}</td>
            <td>{$smarty.session.user_data.birthdate}</td>
            <td>{$smarty.session.user_data.residence_prefecture}</td>
            <td>{$smarty.session.user_data.twitter_url}</td>
            <td>{$smarty.session.user_data.instagram_url}</td>
            <td>{$smarty.session.user_data.youtube_channel_url}</td>
            <td>{$smarty.session.user_data.blog_url}</td>
            <td>
                {if $smarty.session.user_data.icon_url}
                    <img src="{$smarty.session.user_data.icon_url}" alt="アイコン画像"　width="250" height="250">
                {else}
                    画像なし
                {/if}
            </td>
            <td>
                {if $smarty.session.user_data.profile_image_url}
                    <img src="{$smarty.session.user_data.profile_image_url}" alt="プロフィール画像"　width="500" height="500">
                {else}
                    画像なし
                {/if}
            </td>
            <td>{$smarty.session.user_data.self_introduction}</td>
        </tr>
    </table>
    <br>    
    <a href=main.php?>メインページはこちら</a>
    <a href=userDetail.php?mode=showModifyUserDetail>詳細情報の修正はこちら</a>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
