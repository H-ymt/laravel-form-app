<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>エントリーありがとうございます</title>
</head>

<body>
    ※このメールはシステムからの自動返信です<br><br>

    エントリーいただき、誠にありがとうございます。<br>
    下記内容のエントリーを受付いたしました。<br><br>

    お仕事のご案内にあたりまして、<br>
    ぜひ「オンライン面談」にてご経験やご希望などを詳しくお聞かせいただけますでしょうか。<br>
    後ほど改めて、下記のアドレスよりご連絡いたしますので、<br>どうぞよろしくお願い致します。<br><br>

    ■メールアドレス：sample@rpms.jp<br><br>

    ────────────────────────────────<br>
    今回のお送りいただいた内容<br>
    ────────────────────────────────<br><br>

    お名前：{{ $formEntry->name }}<br>
    フリガナ：{{ $formEntry->kana_name }}<br>
    電話番号：{{ $formEntry->phone_number }}<br>
    メールアドレス：{{ $formEntry->email }}<br>
    生年月日：{{ \Carbon\Carbon::parse($formEntry->birth_day)->format('Y年n月j日') }}<br>
    その他伝えたいこと：{{ $formEntry->additional_info }}<br><br>

    ────────────────────────────────<br>
    送信元：<br>
    HP：<a href="{{ config('app.url') }}">{{ config('app.url') }}</a><br>
    ────────────────────────────────<br>
</body>

</html>
