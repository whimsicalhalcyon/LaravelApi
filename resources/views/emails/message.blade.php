<div style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Новое сообщение</h2>
    <p><strong>Тема:</strong> {{ $messageData['title'] ?? 'Без темы' }}</p>
    <p><strong>Сообщение:</strong></p>
    <p style="background: #f5f5f5; padding: 10px; border-left: 3px solid #007bff;">
        {{  $messageData['message'] }}
    </p>
</div>
