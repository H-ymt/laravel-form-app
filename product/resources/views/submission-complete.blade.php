<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full text-center">
        <h1 class="text-3xl font-bold text-blue-400 mb-4">ENTRY</h1>
        <p class="text-lg text-gray-700 mb-6">登録が完了致しました。</p>
        <a href="{{ route('admin.dashboard') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">戻る</a>
    </div>
</body>

</html>
