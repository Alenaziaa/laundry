<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Orderan Selesai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layout/navbar'); ?>

<div class="container-fluid container-md mt-4 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fs-5 text-center text-sm-start">Arsip Orderan Selesai</h4>
        </div>
        <div class="card-body p-0 p-sm-3">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0" style="min-width: 900px;">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total Harga</th>
                            <th>Tanggal Selesai</th>
                            <th class="text-center">Status Pengambilan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($daftar_selesai)) : ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat orderan.</td>
                        </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($daftar_selesai as $s) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-secondary"><?= esc($s['nama_pelanggan']); ?></td>
                                <td><span class="badge bg-secondary"><?= ucwords($s['nama_layanan']); ?></span></td>
                                <td><?= $s['berat']; ?> kg</td>
                                <td class="fw-bold text-success">Rp <?= number_format($s['harga'], 0, ',', '.'); ?></td>
                                <td class="text-muted" style="font-size: 0.85rem;"><?= date('d/m/Y H:i', strtotime($s['tanggal_selesai'])); ?> WIB</td>
                                <td class="text-center">
                                    <?php if($s['status_order'] == 'selesai') : ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 fw-bold">Belum Diambil</span>
                                    <?php else: ?>
                                        <span class="badge bg-success px-3 py-2 fw-bold">Sudah Diambil</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="/layanan/detail/<?= $s['id_layanan']; ?>" class="btn btn-primary btn-sm px-3">Lihat Detail</a>
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