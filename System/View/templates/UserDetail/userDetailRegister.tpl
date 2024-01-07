<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ詳細情報登録</title>
</head>
<body>
    <h1>ユーザ詳細情報登録</h1>
    <form action="userDetail.php" method="post">
        <input type="hidden" name="mode" value="userDetailRegister">
        <label for="nick_name">ニックネーム<span style="color: red;">*</span>:</label>
        <input type="text" id="nick_name" name="nick_name" required>
        <br>
        <label for="birthdate">生年月日:</label>
        <input type="date" id="birthdate" name="birthdate" value="">
        <br>
        <label for="residence_prefecture">居住都道府県:</label>
        <input type="text" id="residence_prefecture" name="residence_prefecture" value="">
        <br>
        <label for="twitter_url">Twitter URL:</label>
        <input type="text" id="twitter_url" name="twitter_url" value="">
        <br>
        <label for="instagram_url">Instagram URL:</label>
        <input type="text" id="instagram_url" name="instagram_url" value="">
        <br>
        <label for="youtube_channel_url">YouTubeチャンネル URL:</label>
        <input type="text" id="youtube_channel_url" name="youtube_channel_url" value="">
        <br>
        <label for="blog_url">ブログ URL:</label>
        <input type="text" id="blog_url" name="blog_url" value="">
        <br>
        <label for="icon_url">アイコン URL:</label>
        <input type="text" id="icon_url" name="icon_url" value="">
        <br>
        <label for="profile_image_url">プロフィール画像 URL:</label>
        <input type="text" id="profile_image_url" name="profile_image_url" value="">
        <br>
        <label for="self_introduction">自己紹介:</label>
        <textarea id="self_introduction" name="self_introduction" value=""></textarea>
        <br>
        <input type="submit" value="登録">
    </form>
</body>
</html>
