<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Restablece tu contraseña - Squashplash</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #e0f7fa; padding: 20px; color: #004d40;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        
        <div style="text-align: center;">
            <h2 class="text-info mb-4"><strong style="color: #007bb5;">Squash<span style="color:#0d6efd">Plash</span></strong></h2>
            <h2 style="color: #007bb5;">¿Olvidaste tu contraseña?</h2>
        </div>

        <p>Hola <strong>{{ $user->name }}</strong>,</p>

        <p>Recibimos una solicitud para restablecer tu contraseña en <strong>Squashplash</strong>, la mejor experiencia en albercas, natación y diversión acuática.</p>

        <p>Para restablecerla, haz clic en el botón de abajo:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background-color: #00bcd4; color: white; padding: 14px 24px; text-decoration: none; border-radius: 8px; font-size: 16px;">
                🌊 Restablecer contraseña
            </a>
        </div>

        <p>Este enlace expirará en 60 minutos.</p>

        <p>Si no realizaste esta solicitud, puedes ignorar este mensaje. Tu cuenta estará segura.</p>

        <hr style="margin-top: 30px;">

        <p style="font-size: 13px; color: #777;">Atentamente,<br>El equipo de <strong>Squashplash</strong></p>
        <p style="font-size: 12px; color: #999;">¡Nos encanta ayudarte a nadar en seguridad digital!</p>
    </div>

</body>
</html>
