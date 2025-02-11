<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi Pembelian</h2>
    <p>No Transaksi: {{ $pembelian->no_transaksi }}</p>
    <p>Tanggal: {{ $pembelian->tgl_transaksi }}</p>
    <p>No Invoice: {{ $pembelian->no_invoice }}</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pembelian->barang->nama }}</td>
                <td>{{ $pembelian->jumlah }}</td>
                <td>Rp{{ number_format($pembelian->harga, 2, ',', '.') }}</td>
                <td>Rp{{ number_format($pembelian->jumlah * $pembelian->harga, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
