<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Actions</title>
</head>
<body>
    <h1>Surat Keterangan</h1>
    <a href="{{ route('view.letter') }}" target="_blank">
        <button>View PDF</button>
    </a>
    <a href="{{ route('download.letter') }}">
        <button>Download PDF</button>
    </a>
</body>
</html>
