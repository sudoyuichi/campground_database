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

<h1>ユーザ詳細修正ページ</h1>
{if $smarty.session.isLogin}
    <form action="userDetail.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mode" value="updateUserDetail">
        <table border="1">
            <tr>
                <td><label for="nick_name">ニックネーム<span style="color: red;">*</span></label></td>
                <td><input type="text" id="nick_name" name="nick_name" value="{$smarty.session.user_data.nick_name}" required></td>
            </tr>
            <tr>
                <td><label for="birthdate">生年月日</label></td>
                <td><input type="date" id="birthdate" name="birthdate" value="{$smarty.session.user_data.birthdate}" required></td>
            </tr>
            <tr>
                <td><label for="residence_prefecture">居住都道府県</label></td>
                <td><input type="text" id="residence_prefecture" name="residence_prefecture" value="{$smarty.session.user_data.residence_prefecture}"></td>
            </tr>
            <tr>
                <td><label for="twitter_url">Twitter URL</label></td>
                <td><input type="text" id="twitter_url" name="twitter_url" value="{$smarty.session.user_data.twitter_url}"></td>
            </tr>
            <tr>
                <td><label for="instagram_url">Instagram URL</label></td>
                <td><input type="text" id="instagram_url" name="instagram_url" value="{$smarty.session.user_data.instagram_url}"></td>
            </tr>
            <tr>
                <td><label for="youtube_channel_url">YouTubeチャンネル URL</label></td>
                <td><input type="text" id="youtube_channel_url" name="youtube_channel_url" value="{$smarty.session.user_data.youtube_channel_url}"></td>
            </tr>
            <tr>
                <td><label for="blog_url">ブログ URL</label></td>
                <td><input type="text" id="blog_url" name="blog_url" value="{$smarty.session.user_data.blog_url}"></td>
            </tr>
            <tr>
                <td><label for="icon_url">アイコン</label></td>
                <td>
                    {if $smarty.session.user_data.icon_url}
                        <img src="{$smarty.session.user_data.icon_url}" alt="アイコン画像" width="250" height="250">
                    {else}
                        <p>画像なし</p>
                    {/if}
                    <br>
                    <input type="file" id="icon_url" name="icon_url" value="{$smarty.session.user_data.icon_url}">
                </td>
            </tr>
            <tr>
                <td><label for="profile_image_url">プロフィール画像</label></td>
                <td>
                    {if $smarty.session.user_data.profile_image_url}
                        <img src="{$smarty.session.user_data.profile_image_url}" alt="プロフィール画像" width="500" height="500">
                    {else}
                        <p>画像なし</p>
                    {/if}
                    <br>
                    <input type="file" id="profile_image_url" name="profile_image_url" value="{$smarty.session.user_data.profile_image_url}">
                </td>
            </tr>
            <tr>
                <td><label for="self_introduction">自己紹介</label></td>
                <td><textarea id="self_introduction" name="self_introduction">{$smarty.session.user_data.self_introduction}</textarea></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="更新">
    </form>

    <a href=main.php?>メインページはこちら</a>
    <a href=userDetail.php?mode=showUserDetail>登録した詳細情報を見る</a>
    <a href=auth.php?mode=logout>ログアウト</a>
{/if}
</body>
</html>
