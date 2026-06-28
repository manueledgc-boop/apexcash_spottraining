<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'ApexCash' }}</title>
</head>
<body style="margin:0; padding:0; background:#07110d; font-family:Arial, Helvetica, sans-serif; color:#ffffff;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#07110d; padding:32px 12px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:620px; background:#0f241b; border:1px solid #1f3b2e; border-radius:18px; overflow:hidden;">

                <tr>
                    <td align="center" style="padding:34px 28px 18px;">
                        <div style="font-size:26px; font-weight:800; letter-spacing:1px; color:#22e58b;">
                            APEXCASH
                        </div>
                        <div style="font-size:14px; color:#b7c8bf; margin-top:6px;">
                            Poker Decision Training
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 34px 34px;">
                        @yield('content')
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 34px; border-top:1px solid #244536; text-align:center; color:#9fb2a8; font-size:13px;">
                        <div style="font-weight:700; color:#ffffff; margin-bottom:8px;">
                            ApexCash Trainer
                        </div>

                        <div style="margin-bottom:12px;">
                            Entrena. Analiza. Mejora.
                        </div>

                        <div style="color:#6f8177;">
                            © {{ date('Y') }} ApexCash · apexcashtrainer.com
                        </div>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>