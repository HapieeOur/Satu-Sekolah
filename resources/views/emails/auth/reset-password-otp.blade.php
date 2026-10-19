<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Pemulihan Kata Sandi</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #F4F6FB; margin: 0; padding: 40px 20px; color: #1E293B;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #FFFFFF; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #E2E8F0;">
        <!-- Header -->
        <tr>
            <td style="background-color: #171B61; padding: 28px 32px; text-align: center;">
                <h1 style="color: #FFFFFF; margin: 0; font-size: 20px; font-weight: 800; letter-spacing: -0.5px;">
                    SATU-SEKOLAH
                </h1>
                <p style="color: #F4CF52; margin: 4px 0 0 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                    Platform Pendidikan Digital Terpadu
                </p>
            </td>
        </tr>

        <!-- Content Body -->
        <tr>
            <td style="padding: 32px;">
                <h2 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0;">
                    Pemulihan Kata Sandi Akun
                </h2>
                <p style="font-size: 14px; line-height: 1.6; color: #475569; margin: 0 0 20px 0;">
                    Halo <strong>{{ $userName }}</strong>,<br>
                    Kami menerima permintaan untuk mereset kata sandi akun Satu-Sekolah Anda. Gunakan kode One-Time Password (OTP) di bawah ini untuk melanjutkan:
                </p>

                <!-- OTP Code Display Box -->
                <div style="background-color: #F8FAFC; border: 2px dashed #233DFF; border-radius: 14px; padding: 20px; text-align: center; margin: 24px 0;">
                    <span style="display: block; font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;">
                        Kode OTP Anda
                    </span>
                    <span style="font-family: monospace, Courier, sans-serif; font-size: 36px; font-weight: 900; letter-spacing: 8px; color: #233DFF;">
                        {{ $otp }}
                    </span>
                    <span style="display: block; font-size: 12px; color: #94A3B8; margin-top: 8px;">
                        Berlaku selama <strong>10 menit</strong>
                    </span>
                </div>

                <div style="background-color: #FEF3C7; border-left: 4px solid #F59E0B; padding: 12px 16px; border-radius: 6px; margin: 20px 0;">
                    <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #92400E; font-weight: 600;">
                        Keamanan Akun: Jangan bagikan kode OTP ini kepada siapa pun, termasuk guru, administrator, atau pihak sekolah.
                    </p>
                </div>

                <p style="font-size: 13px; line-height: 1.5; color: #64748B; margin: 24px 0 0 0;">
                    Jika Anda tidak melakukan permintaan ini, abaikan email ini. Kata sandi akun Anda tetap aman dan tidak akan diubah tanpa kode OTP ini.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #F8FAFC; border-top: 1px solid #E2E8F0; padding: 20px 32px; text-align: center;">
                <p style="margin: 0; font-size: 11px; color: #94A3B8;">
                    Email otomatis dari Sistem Informasi Manajemen Satu-Sekolah.<br>
                    Mohon tidak membalas email ini secara langsung.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
