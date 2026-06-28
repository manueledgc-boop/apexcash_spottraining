@extends('emails.layout', ['title' => 'Confirma tu correo electrónico'])

@section('content')

<h1 style="margin:0 0 18px; font-size:28px; line-height:1.2; color:#ffffff;">
    Confirma tu correo electrónico
</h1>

<p style="font-size:16px; line-height:1.6; color:#dce8e2; margin:0 0 16px;">
    Hola,
</p>

<p style="font-size:16px; line-height:1.6; color:#dce8e2; margin:0 0 16px;">
    Gracias por registrarte en <strong style="color:#22e58b;">ApexCash</strong>.
</p>

<p style="font-size:16px; line-height:1.6; color:#dce8e2; margin:0 0 26px;">
    Ya casi estás listo para comenzar tu entrenamiento. Para activar tu cuenta, confirma tu dirección de correo electrónico haciendo clic en el botón inferior.
</p>

<table cellpadding="0" cellspacing="0" align="center" style="margin:30px auto;">
    <tr>
        <td align="center" bgcolor="#22c970" style="border-radius:10px;">
            <a href="{{ $url }}"
               style="display:inline-block; padding:15px 28px; color:#06110c; font-size:16px; font-weight:800; text-decoration:none;">
                Activar mi cuenta
            </a>
        </td>
    </tr>
</table>

<p style="font-size:14px; line-height:1.6; color:#9fb2a8; margin:24px 0 0;">
    Si no has creado una cuenta en ApexCash, puedes ignorar este mensaje.
</p>

<p style="font-size:13px; line-height:1.6; color:#6f8177; margin:24px 0 0;">
    Si el botón no funciona, copia y pega este enlace en tu navegador:
</p>

<p style="font-size:12px; line-height:1.5; word-break:break-all; color:#22e58b; margin:8px 0 0;">
    {{ $url }}
</p>

@endsection