<!DOCTYPE html>
<html>

<head>
    <title>Hoja de Reclamación Virtual</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-width: 700px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 8px; border: 1px solid #dddddd;">
        <h2 style="color: #00a651; text-align: center; border-bottom: 2px solid #00a651; padding-bottom: 10px;">HOJA DE
            RECLAMACIÓN VIRTUAL</h2>

        <p style="text-align: right; color: #777777;"><strong>Fecha:</strong>
            {{ $reclamacion->created_at->format('d/m/Y H:i') }}</p>

        <h3 style="background-color: #f8f8f8; padding: 10px; color: #333;">1. Identificación del consumidor reclamante
        </h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px;"><strong>Nombres:</strong></td>
                <td>{{ $reclamacion->nombres }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Apellidos:</strong></td>
                <td>{{ $reclamacion->apellidos }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Documento:</strong></td>
                <td>{{ $reclamacion->tipo_documento }} - {{ $reclamacion->nro_documento }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Celular:</strong></td>
                <td>{{ $reclamacion->nro_celular }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Email:</strong></td>
                <td>{{ $reclamacion->correo_electronico }}</td>
            </tr>
        </table>

        <h3 style="background-color: #f8f8f8; padding: 10px; color: #333; margin-top: 20px;">2. Identificación del bien
            contratado</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px; width: 30%;"><strong>Producto:</strong></td>
                <td>{{ $reclamacion->producto ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Nro. Pedido:</strong></td>
                <td>{{ $reclamacion->nro_pedido ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Descripción:</strong></td>
                <td>{{ $reclamacion->descripcion_bien ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3 style="background-color: #f8f8f8; padding: 10px; color: #333; margin-top: 20px;">3. Detalle de la
            reclamación y pedido del consumidor</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px; width: 30%;"><strong>Tipo:</strong></td>
                <td><span
                        style="text-transform: uppercase; font-weight: bold; color: {{ $reclamacion->tipo == 'reclamo' ? '#d9534f' : '#f0ad4e' }};">{{ $reclamacion->tipo }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Detalle:</strong></td>
                <td>{{ $reclamacion->detalle }}</td>
            </tr>
            <tr>
                <td style="padding: 5px;"><strong>Pedido:</strong></td>
                <td>{{ $reclamacion->pedido }}</td>
            </tr>
        </table>

        <div style="margin-top: 30px; padding: 15px; border: 1px dashed #cccccc; font-size: 11px; color: #666666;">
            <strong>Términos y Condiciones:</strong> El consumidor declaró estar de acuerdo con los Términos y
            Condiciones y la Política de Privacidad.
        </div>

        <p style="font-size: 10px; color: #999999; text-align: center; margin-top: 20px;">Este es un mensaje automático
            enviado desde el Libro de Reclamaciones Virtual.</p>
    </div>
</body>

</html>