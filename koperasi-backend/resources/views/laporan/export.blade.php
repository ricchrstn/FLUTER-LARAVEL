<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <p>Tanggal Export: {{ now()->format('d/m/Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Anggota</th>
                <th>Jenis</th>
                <th class="text-right">Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $transaksi->anggota->user->name }}</td>
                <td>{{ $transaksi->jenis }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                <td>{{ $transaksi->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('jumlah'), 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html> 