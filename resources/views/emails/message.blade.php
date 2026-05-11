<div style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2>Новое сообщение</h2>

    <p><strong>Тема:</strong> {{ $messageData['title'] ?? 'Без темы' }}</p>

    <p><strong>Ответ Министерства здравоохранения Нижегородской области на ваше обращение</strong></p>

    <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #0056b3; margin: 15px 0;">
        {{$messageData['message']}}
    </div>

    <p>С уважением,</p>
    <p><strong>Министерство здравоохранения Нижегородской области</strong></p>
</div>
