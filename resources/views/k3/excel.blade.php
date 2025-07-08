<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penggunaan Obat</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Frekuensi Digunakan</th>
                <th>Terakhir Digunakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['nama_obat'] }}</td>
                    <td>{{ $row['frekuensi'] }} kali</td>
                    <td>{{ $row['terakhir_digunakan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
