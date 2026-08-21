<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan Tamu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; background: #fff; padding: 28px; }

        /* HEADER */
        .header { text-align: center; border-bottom: 2px solid #111; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { font-size: 17px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .header p  { font-size: 12px; color: #555; margin-top: 4px; }

        /* INFO */
        .info { font-size: 12px; color: #555; margin-bottom: 16px; }

        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #1d4ed8;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 9px;
            border: 1px solid #1e40af;
            text-align: left;
        }
        tbody td {
            font-size: 11.5px;
            padding: 8px 9px;
            border: 1px solid #d1d5db;
            vertical-align: top;
            color: #1e293b;
        }
        tbody tr:nth-child(even) td { background: #f8fafc; }

        .col-no    { width: 28px; text-align: center; color: #94a3b8; font-weight: bold; }
        .col-id    { font-family: monospace; color: #2563eb; font-size: 10.5px; white-space: nowrap; }
        .col-waktu { color: #64748b; white-space: nowrap; font-size: 11px; }
        .col-nama  { font-weight: bold; }
        .col-ttd   { text-align: center; width: 90px; }
        .col-ttd img { max-height: 46px; max-width: 82px; object-fit: contain; }

        /* FOOTER */
        .footer { margin-top: 22px; font-size: 11px; color: #888; border-top: 1px solid #e2e8f0; padding-top: 10px; }

        @media print {
            body { padding: 0; }
            thead th { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            tbody tr:nth-child(even) td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h1>SMK TI Muhammadiyah Cikampek</h1>
        <p>Laporan Data Kunjungan Tamu &mdash; Buku Tamu Digital MUTU</p>
    </div>

    <!-- INFO -->
    <div class="info">
        Dicetak: {{ now()->format('d/m/Y H:i') }} WIB &nbsp;&bull;&nbsp; Total: {{ count($visits) }} kunjungan
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Tanggal & Waktu</th>
                <th>Kategori</th>
                <th>Nama Lengkap</th>
                <th>Asal Instansi</th>
                <th>Tujuan</th>
                <th>Keperluan</th>
                <th>No WA</th>
                <th>Email</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $index => $visit)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td class="col-id">{{ $visit->id_kunjungan }}</td>
                <td class="col-waktu">{{ $visit->created_at->format('d/m/Y') }}<br>{{ $visit->created_at->format('H:i') }} WIB</td>
                <td>{{ $visit->kategori }}</td>
                <td class="col-nama">{{ $visit->nama_lengkap }}</td>
                <td>{{ $visit->asal_instansi }}</td>
                <td>{{ $visit->tujuan_bertemu }}</td>
                <td>{{ $visit->keperluan }}</td>
                <td>{{ $visit->no_telepon ?? '-' }}</td>
                <td>{{ $visit->email ?? '-' }}</td>
                <td class="col-ttd">
                    @if($visit->signature)
                        <img src="{{ $visit->signature }}" alt="TTD">
                    @else
                        <span style="color:#ccc; font-style:italic;">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        SMK TI Muhammadiyah Cikampek &bull; Buku Tamu Digital MUTU &bull; {{ now()->format('d/m/Y H:i:s') }} WIB
    </div>

    @if(isset($print_pdf) && $print_pdf)
    <script>window.onload = function() { window.print(); }</script>
    @endif

</body>
</html>
