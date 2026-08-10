<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Data Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Kunjungan Tamu</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kunjungan</th>
                <th>Tanggal & Waktu</th>
                <th>Kategori</th>
                <th>Nama Lengkap</th>
                <th>Asal Instansi / Alamat</th>
                <th>Tujuan Bertemu</th>
                <th>Keperluan</th>
                <th>No WhatsApp</th>
                <th>Email</th>
                <th>Pertanyaan Tambahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $index => $visit)
                @php
                    $customAnswersText = '';
                    if (is_array($visit->custom_answers)) {
                        $parts = [];
                        foreach ($visit->custom_answers as $qLabel => $qVal) {
                            $parts[] = "{$qLabel}: {$qVal}";
                        }
                        $customAnswersText = implode(' | ', $parts);
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $visit->id_kunjungan }}</td>
                    <td>{{ $visit->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $visit->kategori }}</td>
                    <td>{{ $visit->nama_lengkap }}</td>
                    <td>{{ $visit->asal_instansi }}</td>
                    <td>{{ $visit->tujuan_bertemu }}</td>
                    <td>{{ $visit->keperluan }}</td>
                    <td>{{ $visit->no_telepon ?? '-' }}</td>
                    <td>{{ $visit->email ?? '-' }}</td>
                    <td>{{ $customAnswersText ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($print_pdf) && $print_pdf)
    <script>
        window.onload = function() {
            window.print();
            // Optional: You could close the window after printing
            // setTimeout(function(){ window.close(); }, 1000);
        }
    </script>
    @endif
</body>
</html>
