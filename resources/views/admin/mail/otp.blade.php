{{-- resources/views/admin/mail/otp.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification</title>
</head>
<body style="margin:0; padding:0; background-color:#f3eeee; font-family: Georgia, 'Times New Roman', serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3eeee; padding: 40px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 500px; background-color:#ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color:#7A1220; padding: 32px 24px;">
                            <img src="{{ asset('images/logo/amani-h.png') }}" alt="Amani Store" style="display:block ; filter:brightness(0) invert(100%); height: 35px;">
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px 32px 24px 32px;">
                            <p style="margin:0 0 8px 0; font-size:14px; color:#9ca3af;">Bonjour {{ $name }},</p>
                            <h1 style="margin:0 0 16px 0; font-size:20px; color:#1f2937;">Votre code de vérification</h1>
                            <p style="margin:0 0 28px 0; font-size:14px; line-height:1.6; color:#6b7280;">
                                Utilisez le code ci-dessous pour vous connecter à votre espace administrateur Amani Store.
                                Ce code expirera dans <strong style="color:#374151;">10 minutes</strong>.
                            </p>
                        </td>
                    </tr>

                    {{-- OTP Code block --}}
                    <tr>
                        <td align="center" style="padding: 0 32px 32px 32px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    @foreach (str_split($otp) as $digit)
                                        <td style="width:44px; height:52px; background-color:#faf5f5; border:1.5px solid #7A1220; border-radius:8px; text-align:center; vertical-align:middle; font-size:22px; font-weight:bold; color:#7A1220; margin: 0 4px;">
                                            {{ $digit }}
                                        </td>
                                        @if(!$loop->last)
                                            <td style="width:6px;"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Warning --}}
                    <tr>
                        <td style="padding: 0 32px 32px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fef9e7; border-radius: 10px;">
                                <tr>
                                    <td style="padding: 14px 16px; font-size:13px; color:#92400e; line-height:1.5;">
                                        ⚠️ Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail ou contactez votre administrateur.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding: 0 32px;">
                            <div style="border-top: 1px solid #e5e7eb;"></div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding: 24px 32px 32px 32px;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">
                                Envoyé à {{ $email }} &middot; © {{ date('Y') }} Amani Store
                            </p>
                            <p style="margin:6px 0 0 0; font-size:12px; color:#9ca3af;">
                                Tous droits réservés.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>