<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 40px;
        }
        .header {
            text-align: center;
        }
        .content {
            margin-top: 20px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 50px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .small-text {
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('path/to/your/logo.png') }}" alt="Logo" width="80">
        <h2>PEMERINTAH KABUPATEN SUKOHARJO</h2>
        <h3>KECAMATAN BULU</h3>
        <h3>DESA KAMAL</h3>
        <p>Alamat: Jl. Raya Bulu - Sagrang Km 2.5 No. Telp, Kode Pos 57563</p>
    </div>
    
    <div class="content">
        <p>Nomor: {{ $nomor }}</p>
        <p>Yang bertanda tangan dibawah ini kami Kepala Desa Kamal Kecamatan Bulu Kabupaten Sukoharjo, Menerangkan bahwa:</p>
        <p>Nama: {{ $nama }}</p>
        <p>Tempat tanggal lahir: {{ $tempat_tanggal_lahir }}</p>
        <p>Kewarganegaraan / Agama: {{ $kewarganegaraan }}</p>
        <p>Pekerjaan: {{ $pekerjaan }}</p>
        <p>Tempat Tinggal: {{ $tempat_tinggal }}</p>
        <p>Nomor Bukti Diri: {{ $nik }}</p>
        <p>Keperluan: {{ $keperluan }}</p>
        <p>Berlaku Mulai: {{ $berlaku_mulai }} s/d Selesai</p>
        <p>Keterangan Lain-Lain: {{ $keterangan_lain }}</p>
    </div>
    
    <div class="footer">
        <p>Demikian untuk menjadikan maklum bagi yang berkepentingan.</p>
        <p>Nomor: {{ $nomor }}</p>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>
    
    <div class="signature">
        <p>Kamal, {{ $tanggal }}</p>
        <p>SEKDES DESA KAMAL</p>
        <p><strong>{{ $sekdes }}</strong></p>
        <p class="small-text">Mengetahui, Camat Bulu</p>
        <p class="small-text">……………………………</p>
    </div>
</body>
</html>
