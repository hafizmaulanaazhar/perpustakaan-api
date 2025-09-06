<!DOCTYPE html>
<html>

<head>
    <title>Konfirmasi Peminjaman Buku</title>
</head>

<body>
    <h2>Konfirmasi Peminjaman Buku</h2>

    <p>Halo {{ $user->name }},</p>

    <p>Berikut adalah detail peminjaman buku Anda:</p>

    <table>
        <tr>
            <td><strong>Judul Buku</strong></td>
            <td>: {{ $book->title }}</td>
        </tr>
        <tr>
            <td><strong>Penulis</strong></td>
            <td>: {{ $book->author }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Pinjam</strong></td>
            <td>: {{ $loan->loan_date->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Batas Pengembalian</strong></td>
            <td>: {{ $loan->due_date->format('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>ISBN</strong></td>
            <td>: {{ $book->isbn }}</td>
        </tr>
    </table>

    <p>Silakan kembalikan buku sebelum tanggal jatuh tempo untuk menghindari denda.</p>

    <br>
    <p>Terima kasih,</p>
    <p><strong>Perpustakaan Digital</strong></p>
</body>

</html>