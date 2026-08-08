<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Aspirasi Diupdate</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.025);
            border: 1px solid #f1f5f9;
        }
        .header {
            background-color: #2563eb;
            padding: 32px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 32px;
        }
        .greeting {
            font-size: 16px;
            line-height: 24px;
            margin-bottom: 24px;
        }
        .status-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .status-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .status-value {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .status-diajukan { color: #d97706; }
        .status-diproses { color: #2563eb; }
        .status-selesai { color: #16a34a; }
        .status-ditolak { color: #dc2626; }
        
        .aspiration-details {
            border-top: 1px solid #e2e8f0;
            padding-top: 16px;
        }
        .detail-row {
            margin-bottom: 12px;
            font-size: 14px;
        }
        .detail-label {
            color: #64748b;
            font-weight: 500;
        }
        .detail-val {
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Update Aspirasi SiPras</h1>
        </div>
        <div class="content">
            <p class="greeting">Halo <strong>{{ $aspiration->user->name }}</strong>,</p>
            <p>Status untuk aspirasi yang Anda ajukan telah diperbarui oleh Admin.</p>
            
            <div class="status-card">
                <div class="status-title">Status Terbaru</div>
                <div class="status-value status-{{ $aspiration->status }}">
                    {{ $aspiration->status_label }}
                </div>
                
                <div class="aspiration-details">
                    <div class="detail-row">
                        <span class="detail-label">Judul:</span>
                        <span class="detail-val">{{ $aspiration->judul }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Lokasi:</span>
                        <span class="detail-val">{{ $aspiration->lokasi }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Pengajuan:</span>
                        <span class="detail-val">{{ $aspiration->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 32px;">
                <a href="{{ route('aspirations.show', $aspiration) }}" class="btn">Lihat Detail Aspirasi</a>
            </div>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem SiPras.</p>
            <p>&copy; {{ date('Y') }} SiPras - Sistem Pelaporan Aspirasi Siswa.</p>
        </div>
    </div>
</body>
</html>
