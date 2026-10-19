<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kata Sandi Berhasil Diperbarui</title>
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
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="display: inline-block; width: 48px; height: 48px; line-height: 48px; border-radius: 50%; background-color: #DCFCE7; color: #166534; font-size: 24px; font-weight: bold;">
                        &#10003;
                    </div>
                </div>

                <h2 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0; text-align: center;">
                    Kata Sandi Berhasil Diperbarui
                </h2>
                <p style="font-size: 14px; line-height: 1.6; color: #475569; margin: 0 0 16px 0;">
                    Halo <strong>{{ $userName }}</strong>,<br>
                    Kata sandi untuk akun Satu-Sekolah Anda telah berhasil diubah dan diperbarui pada <strong>{{ $changedAt }}</strong>.
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #475569; margin: 0 0 24px 0;">
                    Kini Anda dapat masuk kembali ke portal dengan menggunakan kata sandi yang baru.
                </p>

                <div style="text-align: center; margin: 24px 0;">
                    <a href="{{ url('/login') }}" style="display: inline-block; background-color: #16646A; color: #FFFFFF; text-decoration: none; font-size: 13px; font-weight: 700; padding: 12px 28px; border-radius: 10px;">
                        Masuk ke Portal
                    </a>
                </div>

                <div style="background-color: #FEE2E2; border-left: 4px solid #EF4444; padding: 12px 16px; border-radius: 6px; margin: 24px 0 0 0;">
                    <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #991B1B; font-weight: 600;">
                        Penting: Jika Anda TIDAK merasa mengubah kata sandi Anda, akun Anda mungkin telah disusupi. Segera hubungi staf IT / Administrator sekolah kami untuk mengamankan akun Anda.
                    </p>
                </div>
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
