<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Kunjungan Puskesmas
    </title>


    <style>

        @page {
            margin: 25px 30px;
        }


        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }


        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }


        .header h2 {
            margin: 0;
            font-size: 18px;
        }


        .header h3 {
            margin: 3px 0;
            font-size: 15px;
        }


        .header p {
            margin: 2px 0;
            font-size: 10px;
        }


        /*
        |--------------------------------------------------------------------------
        | Judul
        |--------------------------------------------------------------------------
        */

        .judul {
            text-align: center;
            margin-bottom: 15px;
        }


        .judul h3 {
            margin: 0;
            font-size: 15px;
        }


        .periode {
            margin-top: 5px;
            font-size: 11px;
        }


        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        .summary {
            width: 100%;
            margin-bottom: 15px;
        }


        .summary-box {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }


        .summary-title {
            font-size: 10px;
        }


        .summary-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 3px;
        }


        /*
        |--------------------------------------------------------------------------
        | Tabel
        |--------------------------------------------------------------------------
        */

        table {
            width: 100%;
            border-collapse: collapse;
        }


        th,
        td {
            border: 1px solid #333;
            padding: 5px;
        }


        th {
            background-color: #eeeeee;
            text-align: center;
        }


        .center {
            text-align: center;
        }


        /*
        |--------------------------------------------------------------------------
        | Rekap Poli
        |--------------------------------------------------------------------------
        */

        .rekap-title {
            font-weight: bold;
            margin-bottom: 5px;
        }


        .rekap-table {
            width: 45%;
            margin-bottom: 20px;
        }


        /*
        |--------------------------------------------------------------------------
        | Tanda tangan
        |--------------------------------------------------------------------------
        */

        .signature {
            width: 100%;
            margin-top: 35px;
        }


        .signature td {
            border: none;
            text-align: center;
        }


        .signature-space {
            height: 55px;
        }

    </style>

</head>


<body>


    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="header">

        <h2>
            PEMERINTAH KABUPATEN AGAM
        </h2>

        <h3>
            PUSKESMAS TIKU
        </h3>

        <p>
            Kecamatan Tanjung Mutiara, Kabupaten Agam
        </p>

        <p>
            Laporan Pelayanan Kesehatan
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- JUDUL --}}
    {{-- ========================================================= --}}

    <div class="judul">

        <h3>
            LAPORAN KUNJUNGAN PASIEN
        </h3>


        <div class="periode">

            Periode:

            @if($tanggalMulai && $tanggalSelesai)

                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}

                s/d

                {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}

            @elseif($tanggalMulai)

                Mulai
                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') }}

            @elseif($tanggalSelesai)

                Sampai
                {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d-m-Y') }}

            @else

                Semua Data

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TOTAL KUNJUNGAN --}}
    {{-- ========================================================= --}}

    <table class="summary">

        <tr>

            <td class="summary-box">

                <div class="summary-title">
                    TOTAL KUNJUNGAN
                </div>

                <div class="summary-value">
                    {{ $totalKunjungan }}
                </div>

            </td>

        </tr>

    </table>


    {{-- ========================================================= --}}
    {{-- REKAP POLI --}}
    {{-- ========================================================= --}}

    <div class="rekap-title">

        REKAP KUNJUNGAN BERDASARKAN POLI

    </div>


    <table class="rekap-table">

        <thead>

            <tr>

                <th>
                    No
                </th>

                <th>
                    Nama Poli
                </th>

                <th>
                    Jumlah Kunjungan
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($rekapPoli as $namaPoli => $total)

                <tr>

                    <td class="center">

                        {{ $loop->iteration }}

                    </td>

                    <td>

                        {{ $namaPoli }}

                    </td>

                    <td class="center">

                        {{ $total }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="3"
                        class="center"
                    >

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- DETAIL --}}
    {{-- ========================================================= --}}

    <div class="rekap-title">

        DETAIL KUNJUNGAN PASIEN

    </div>


    <table>

        <thead>

            <tr>

                <th width="4%">
                    No
                </th>

                <th width="10%">
                    Tanggal
                </th>

                <th width="17%">
                    Nama Pasien
                </th>

                <th width="14%">
                    Poli
                </th>

                <th width="17%">
                    Dokter
                </th>

                <th width="18%">
                    Diagnosa
                </th>

                <th width="20%">
                    Tindakan
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($laporans as $laporan)

                <tr>

                    <td class="center">

                        {{ $loop->iteration }}

                    </td>


                    <td class="center">

                        {{ $laporan->created_at
                            ->format('d-m-Y') }}

                    </td>


                    <td>

                        {{ $laporan->pasien->nama_pasien
                            ?? $laporan->nama_pasien }}

                    </td>


                    <td>

                        {{ $laporan->antrian->poli->nama_poli
                            ?? '-' }}

                    </td>


                    <td>

                        {{ $laporan->dokter->nama_dokter
                            ?? '-' }}

                    </td>


                    <td>

                        {{ $laporan->diagnosa_akhir
                            ?? '-' }}

                    </td>


                    <td>

                        {{ $laporan->tindakan
                            ?? '-' }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="center"
                    >

                        Tidak ada data laporan.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- ========================================================= --}}
    {{-- TANDA TANGAN --}}
    {{-- ========================================================= --}}

    <table class="signature">

        <tr>

            <td width="65%"></td>

            <td width="35%">

                Tiku,
                {{ now()->format('d-m-Y') }}

                <br>

                Kepala Puskesmas

                <div class="signature-space"></div>

                <strong>
                    (........................................)
                </strong>

            </td>

        </tr>

    </table>


</body>

</html>