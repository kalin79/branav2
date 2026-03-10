<!DOCTYPE html>
<html>

<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #333333;text-align:center;">Nuevo Mensaje de Contacto</h2>

        <p style="color: #555555; line-height: 1.5;">Has recibido un nuevo mensaje desde el formulario de contacto.</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Nombre / Apellidos:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">{{ $contacto->nombre_apellidos }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Correo:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">{{ $contacto->correo }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Nro Celular:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">{{ $contacto->nro_celular ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Asunto:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">{{ $contacto->asunto ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Mensaje:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">
                    <p style="white-space: pre-wrap; margin:0;">{{ $contacto->mensaje }}</p>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Aceptó TyC:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;">{{ $contacto->tyc ? 'Sí' : 'No' }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; color: #999999; font-size: 12px;text-align:center;">Este correo se generó de manera
            automática.</p>
    </div>
</body>

</html>