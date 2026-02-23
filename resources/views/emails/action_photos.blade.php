<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nieuwe actie-inzending</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #334155; background-color: #f1f5f9;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9;">
        <tr>
            <td style="padding: 32px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width: 560px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding: 24px 28px; background: linear-gradient(135deg, #b45309 0%, #d97706 100%);">
                            <h1 style="margin: 0; font-size: 20px; font-weight: 700; color: #ffffff; letter-spacing: -0.02em;">
                                Nieuwe actie-inzending
                            </h1>
                            <p style="margin: 6px 0 0; font-size: 14px; color: rgba(255,255,255,0.9);">
                                Olijfboom van Licht
                            </p>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="padding: 28px;">
                            <p style="margin: 0 0 20px; font-size: 14px; color: #64748b;">
                                Er is een nieuwe inzending met actie en foto&#39;s binnengekomen via de website.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 6px 12px; background-color: #f8fafc; font-size: 12px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Naam
                                    </td>
                                    <td style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
                                        {{ $data['name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 12px; background-color: #f8fafc; font-size: 12px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        E-mailadres
                                    </td>
                                    <td style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
                                        <a href="mailto:{{ $data['email'] }}" style="color: #b45309; text-decoration: none;">{{ $data['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 12px; background-color: #f8fafc; font-size: 12px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Telefoonnummer
                                    </td>
                                    <td style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
                                        {{ $data['phone'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 12px; background-color: #f8fafc; font-size: 12px; font-weight: 600; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Team / actie
                                    </td>
                                    <td style="padding: 10px 14px; border-bottom: 1px solid #e2e8f0;">
                                        {{ $data['team_name'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 12px; background-color: #f8fafc; font-size: 12px; font-weight: 600; color: #64748b;">
                                        Foto&#39;s
                                    </td>
                                    <td style="padding: 10px 14px;">
                                        {{ $photoCount }} {{ $photoCount === 1 ? 'foto' : 'foto\'s' }} als bijlage bij deze mail
                                    </td>
                                </tr>
                            </table>

                            @if (!empty($data['message']))
                                <p style="margin: 20px 0 0; font-size: 12px; font-weight: 600; color: #64748b;">Beschrijving</p>
                                <div style="margin-top: 8px; padding: 14px; background-color: #f8fafc; border-radius: 8px; border-left: 4px solid #b45309;">
                                    <p style="margin: 0; font-size: 14px; color: #334155; white-space: pre-wrap;">{{ $data['message'] }}</p>
                                </div>
                            @endif
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="padding: 16px 28px; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
                            Verzonden via het contactformulier op de website Olijfboom van Licht.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
