<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40" lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if gte mso 9]>
    <xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
    <x:Name>Data Kunjungan</x:Name>
    <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
    </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>
    <![endif]-->
    <style>
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }

        /* Header rows */
        .row-instansi td {
            font-size: 14pt;
            font-weight: bold;
            color: #1D4ED8;
            border: none;
        }
        .row-subtitle td {
            font-size: 10pt;
            color: #64748B;
            border: none;
        }
        .row-empty td { border: none; }

        /* Column header */
        .row-colheader td {
            background-color: #1D4ED8;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 10pt;
            border: 1px solid #1E40AF;
            padding: 6px 8px;
            text-align: center;
        }

        /* Data rows */
        .row-data td {
            border: 1px solid #CBD5E1;
            padding: 5px 8px;
            font-size: 10pt;
            vertical-align: top;
        }
        .row-data-alt td {
            background-color: #F1F5F9;
            border: 1px solid #CBD5E1;
            padding: 5px 8px;
            font-size: 10pt;
            vertical-align: top;
        }

        /* Specific cells */
        .cell-no     { text-align: center; color: #94A3B8; font-weight: bold; }
        .cell-id     { color: #2563EB; font-weight: bold; font-family: Courier New, monospace; }
        .cell-nama   { font-weight: bold; }
        .cell-waktu  { color: #475569; }
        .cell-ttd    { text-align: center; color: #10B981; font-weight: bold; }
        .cell-nottd  { text-align: center; color: #CBD5E1; }

        /* Footer rows */
        .row-footer td { border: none; font-size: 9pt; color: #94A3B8; padding-top: 4px; }
        .row-total td {
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            font-weight: bold;
            font-size: 10pt;
            padding: 5px 8px;
            color: #1E293B;
        }
    </style>
</head>
<body>
<table>
    {{-- HEADER --}}
    <tr class="row-instansi">
        <td colspan="12">SMK TI MUHAMMADIYAH CIKAMPEK</td>
    </tr>
    <tr class="row-subtitle">
        <td colspan="12">Laporan Data Kunjungan Tamu &mdash; Buku Tamu Digital MUTU</td>
    </tr>
    <tr class="row-subtitle">
        <td colspan="12">Dicetak: {{ now()->format('d/m/Y H:i') }} WIB &nbsp;|&nbsp; Total Data: {{ count($visits) }} kunjungan</td>
    </tr>
    <tr class="row-empty"><td colspan="12"></td></tr>

    {{-- COLUMN HEADERS --}}
    <tr class="row-colheader">
        <td>No</td>
        <td>ID Kunjungan</td>
        <td>Tanggal</td>
        <td>Waktu</td>
        <td>Kategori</td>
        <td>Nama Lengkap</td>
        <td>Asal Instansi / Alamat</td>
        <td>Tujuan Bertemu</td>
        <td>Keperluan</td>
        <td>No WhatsApp</td>
        <td>Email</td>
        <td>Pertanyaan Tambahan</td>
        <td>Tanda Tangan</td>
    </tr>

    {{-- DATA ROWS --}}
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
            $rowClass = ($index % 2 === 0) ? 'row-data' : 'row-data-alt';
        @endphp
        <tr class="{{ $rowClass }}">
            <td class="cell-no">{{ $index + 1 }}</td>
            <td class="cell-id">{{ $visit->id_kunjungan }}</td>
            <td class="cell-waktu">{{ $visit->created_at->format('d/m/Y') }}</td>
            <td class="cell-waktu">{{ $visit->created_at->format('H:i') }}</td>
            <td>{{ $visit->kategori }}</td>
            <td class="cell-nama">{{ $visit->nama_lengkap }}</td>
            <td>{{ $visit->asal_instansi }}</td>
            <td>{{ $visit->tujuan_bertemu }}</td>
            <td>{{ $visit->keperluan }}</td>
            <td>{{ $visit->no_telepon ?? '-' }}</td>
            <td>{{ $visit->email ?? '-' }}</td>
            <td>{{ $customAnswersText ?: '-' }}</td>
            <td class="{{ $visit->signature ? 'cell-ttd' : 'cell-nottd' }}">
                {{ $visit->signature ? '✔ Ada' : '-' }}
            </td>
        </tr>
    @endforeach

    {{-- TOTAL ROW --}}
    <tr class="row-total">
        <td colspan="4">TOTAL</td>
        <td colspan="9">{{ count($visits) }} kunjungan tercatat</td>
    </tr>

    <tr class="row-empty"><td colspan="13"></td></tr>

    {{-- FOOTER --}}
    <tr class="row-footer">
        <td colspan="13">Dokumen ini digenerate otomatis oleh sistem Buku Tamu Digital MUTU &mdash; SMK TI Muhammadiyah Cikampek</td>
    </tr>
    <tr class="row-footer">
        <td colspan="13">*) Kolom "Tanda Tangan" menampilkan status ketersediaan tanda tangan. Lihat detail di aplikasi untuk melihat gambar tanda tangan.</td>
    </tr>
</table>
</body>
</html>
