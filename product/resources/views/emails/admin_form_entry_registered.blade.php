<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録完了のお知らせ</title>
</head>
<body>
    以下の内容で、新規登録がありましたのでお知らせいたします。<br><br>
    ------------------------------------------------------------  <br><br>
    お名前： {{ $formEntry->name }}<br>
    フリガナ： {{ $formEntry->kana_name }}<br>
    電話番号： {{ $formEntry->phone_number }}<br>
    メールアドレス {{ $formEntry->email }}<br>
    生年月日： {{ \Carbon\Carbon::parse($formEntry->birth_day)->format('Y年n月j日') }}<br>
    その他伝えたいこと：{{ $formEntry->additional_info }}<br><br>
    ------------------------------------------------------------  <br>
    ※登録内容は管理画面よりご確認ください。
</body>
</html>
