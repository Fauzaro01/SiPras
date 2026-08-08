<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Export Aspirasi - PDF</title>
    <style>
        body {font-family: DejaVu Sans, sans-serif; color: #333;}
        h2 {text-align: center; margin-top: 0;}
        table {width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}
        th {background-color: #f5f5f5;}
    </style>
</head>
<body>
    <h2>Daftar Aspirasi - {{ now()->format('d M Y H:i') }}</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Pelapor (NIS)</th>
                <th>Status</th>
                <th>Prioritas</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aspirations as $aspiration)
                <tr>
                    <td>{{ $aspiration->id }}</td>
                    <td>{{ $aspiration->judul }}</td>
                    <td>{{ $aspiration->deskripsi }}</td>
                    <td>{{ $aspiration->lokasi }}</td>
                    <td>{{ $aspiration->category->nama ?? '-' }}</td>
                    <td>{{ $aspiration->user->name ?? '-' }} ({{ $aspiration->user->nis ?? '-' }})</td>
                    <td>{{ $aspiration->status_label ?? $aspiration->status }}</td>
                    <td>{{ $aspiration->priority_label ?? $aspiration->priority }}</td>
                    <td>{{ $aspiration->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
