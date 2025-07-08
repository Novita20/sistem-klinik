<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Penggunaan Obat</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h2>Laporan Penggunaan Obat</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Frekuensi Digunakan</th>
                <th>Terakhir Digunakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_obat'] }}</td>
                    <td>{{ $item['frekuensi'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['terakhir_digunakan'])->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
