<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Message</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <div style="background-color: #052e2c; padding: 20px; color: white; text-align: center;">
            <h2 style="margin: 0;">📬 رسالة جديدة</h2>
        </div>
        <div style="padding: 30px;">
            <p style="font-size: 16px; color: #333;"><strong>من:</strong> {{ $messageData['sender_name'] }}</p>
            <p style="font-size: 16px; color: #333;"><strong>الرسالة:</strong></p>
            <div
                style="background-color: #f9f9f9; padding: 15px; border-left: 5px solid #00f7ff; margin: 15px 0; color: #222;">
                {{ $messageData['body'] }}
            </div>
            <p style="font-size: 14px; color: #777;">📅 تم الإرسال بتاريخ: {{ $messageData['time'] }}</p>
        </div>
        <div style="background-color: #052e2c; text-align: center; padding: 15px;">
            <p style="margin: 0; color: #ccc; font-size: 13px;">هذه الرسالة تم إرسالها تلقائيًا من نظام الرسائل الخاص بك
            </p>
        </div>
    </div>
</body>

</html>
