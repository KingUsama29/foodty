<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password FoodTY</title>
</head>

<body style="margin:0;padding:0;background:#f3f5f9;font-family:Arial,Helvetica,sans-serif;">
    <div style="max-width:640px;margin:0 auto;padding:28px 16px;">
        <!-- Card -->
        <div style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(15,23,42,.08);">
            <div style="padding:26px 26px 18px 26px;border-bottom:1px solid #eef2f7;">
                <div
                    style="display:inline-block;padding:6px 10px;border-radius:999px;background:#eef2ff;color:#3730a3;font-size:12px;font-weight:700;">
                    RESET PASSWORD
                </div>

                <h1 style="margin:14px 0 8px 0;font-size:22px;line-height:1.3;color:#0f172a;">
                    Halo, {{ $name }} 👋
                </h1>

                <p style="margin:0;color:#334155;font-size:14px;line-height:1.7;">
                    Kami menerima permintaan untuk mereset password akun FoodTY kamu.
                    Klik tombol di bawah untuk membuat password baru.
                </p>
            </div>

            <div style="padding:22px 26px 26px 26px;">
                <!-- Button -->
                <div style="text-align:center;margin:18px 0 18px 0;">
                    <a href="{{ $url }}"
                        style="display:inline-block;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;text-decoration:none;
                    padding:12px 18px;border-radius:12px;font-weight:700;font-size:14px;">
                        Reset Password
                    </a>
                </div>

                <p style="margin:0;color:#64748b;font-size:13px;line-height:1.7;text-align:center;">
                    Link ini akan kedaluwarsa dalam <strong>{{ $expire }} menit</strong>.
                </p>

                <!-- Divider -->
                <div style="height:1px;background:#eef2f7;margin:20px 0;"></div>

                <!-- Fallback link -->
                <p style="margin:0;color:#334155;font-size:13px;line-height:1.7;">
                    Kalau tombol di atas tidak bisa diklik, copy link ini ke browser:
                </p>
                <p style="margin:10px 0 0 0;font-size:12px;line-height:1.6;word-break:break-all;">
                    <a href="{{ $url }}" style="color:#2563eb;text-decoration:none;">{{ $url }}</a>
                </p>

                <!-- Security note -->
                <div
                    style="margin-top:18px;padding:14px 14px;border-radius:12px;background:#f8fafc;border:1px solid #eef2f7;">
                    <p style="margin:0;color:#475569;font-size:12.5px;line-height:1.6;">
                        Kalau kamu tidak merasa meminta reset password, abaikan email ini. Akun kamu tetap aman.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align:center;margin-top:14px;color:#94a3b8;font-size:12px;line-height:1.6;">
            <div style="margin-top:8px;">
                © {{ date('Y') }} FoodTY — Platform penyaluran bantuan pangan.
            </div>
        </div>
    </div>
</body>

</html>
