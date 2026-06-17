<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Laundry CI4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layout/navbar'); ?>

<div class="container-fluid container-md mt-4 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 py-3">
            <h4 class="mb-0 fs-5 text-center text-sm-start">Daftar Order Laundry</h4>
            <a href="/layanan/tambah" class="btn btn-light btn-sm fw-bold">+ Tambah Order</a>
        </div>
        <div class="card-body p-0 p-sm-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0" style="min-width: 800px;">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total Harga</th>
                            <th>Estimasi Waktu</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($daftar_layanan)) : ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data order laundry.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($daftar_layanan as $l) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-secondary"><?= esc($l['nama_pelanggan']); ?></td>
                                <td><span class="badge bg-secondary"><?= ucwords($l['nama_layanan']); ?></span></td>
                                <td><?= $l['berat']; ?> kg</td>
                                <td class="fw-bold text-success">Rp <?= number_format($l['harga'], 0, ',', '.'); ?></td>
                                <td><span class="badge bg-info text-dark"><?= $l['estimasi_waktu']; ?></span></td>
                                <td class="text-muted" style="font-size: 0.9rem;"><?= date('d/m/Y H:i', strtotime($l['tanggal_submit'])); ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="/layanan/detail/<?= $l['id_layanan']; ?>" class="btn btn-primary btn-sm px-3">Detail</a>
                                        
                                        <a href="/layanan/edit/<?= $l['id_layanan']; ?>" class="btn btn-warning btn-sm px-3">Edit</a>
                                        <a href="/layanan/hapus/<?= $l['id_layanan']; ?>" class="btn btn-danger btn-sm px-2" onclick="return confirm('Yakin dihapus?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>