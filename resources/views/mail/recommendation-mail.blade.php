<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>

<body style="font-family: Arial, sans-serif; direction: rtl; text-align: right;">

    <h2>{{ $title }}</h2>

    <p style="white-space: pre-line;">
        {!! nl2br(e($body)) !!}
    </p>

    <hr>
    <small>هذه رسالة توصية مرسلة من النظام تلقائيًا.</small>
</body>

</html>
