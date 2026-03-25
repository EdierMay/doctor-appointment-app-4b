<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 20px; color: #333; font-size: 14px; }
        .container { border: 1px solid #ddd; padding: 30px; border-radius: 8px; max-width: 800px; margin: auto; }
        .header { text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { max-height: 80px; margin-bottom: 15px; }
        .header h1 { color: #0056b3; margin: 0; font-size: 26px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 15px; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .content { line-height: 1.6; }
        .greeting { font-size: 16px; margin-bottom: 20px; color: #222; }
        
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th, .details-table td { padding: 14px 15px; border-bottom: 1px solid #eee; text-align: left; }
        .details-table th { width: 35%; background-color: #f8f9fa; color: #555; font-weight: bold; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        .details-table td { color: #222; font-size: 15px; font-weight: bold; }
        .details-table tr:nth-child(even) th, .details-table tr:nth-child(even) td { background-color: #fcfcfc; }
        
        .footer-note { background-color: #e9f2fb; border-left: 4px solid #0056b3; padding: 15px; margin-bottom: 30px; border-radius: 0 4px 4px 0; color: #004085; font-size: 13px; line-height: 1.5; }
        
        .footer { text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        .footer p { margin: 3px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- @if(file_exists(public_path('images/Manjaro-logo.svg.png')))
                <img src="{{ public_path('images/Manjaro-logo.svg.png') }}" class="logo" alt="Logo Clínica">
            @endif --}}
            <h1>Clínica Médica</h1>
            <p>Comprobante Oficial de Cita</p>
        </div>

        <div class="content">
            <p class="greeting">Estimado/a <strong>{{ $appointment->patient->user->name ?? 'Paciente' }}</strong>,</p>
            <p>Tu cita médica ha sido agendada con éxito. A continuación, te presentamos los detalles de la misma:</p>

            <table class="details-table">
                <tr>
                    <th>Especialista</th>
                    <td>Dr/Dra. {{ $appointment->doctor->user->name ?? 'Doctor' }}</td>
                </tr>
                <tr>
                    <th>Fecha de Cita</th>
                    <td>{{ \Carbon\Carbon::parse($appointment->date)->locale('es')->translatedFormat('l, d \d\e F \d\e Y') }}</td>
                </tr>
                <tr>
                    <th>Horario</th>
                    <td>De {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} a {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }} hrs</td>
                </tr>
                <tr>
                    <th>Motivo de Consulta</th>
                    <td>{{ ucfirst($appointment->reason) }}</td>
                </tr>
            </table>
            
            <div class="footer-note">
                <strong>Importante:</strong> Por favor, preséntate en la clínica con al menos 10 minutos de anticipación a tu cita. En caso de no poder asistir, te pedimos de favor cancelar o reprogramar tu cita con antelación para poder otorgarle el espacio a otro paciente.
            </div>
        </div>

        <div class="footer">
            <p>Este documento es un comprobante oficial generado automáticamente el {{ now()->locale('es')->translatedFormat('d \d\e F \d\e Y, \a \l\a\s H:i') }} hrs.</p>
            <p>Por favor, no respondas a este correo automatizado.</p>
        </div>
    </div>
</body>
</html>