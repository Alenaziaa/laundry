<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order #<?= $order['id_layanan']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layout/navbar'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            
            <div class="mb-3">
                <a href="/layanan" class="btn btn-secondary btn-sm shadow-sm">&larr; Kembali ke Daftar</a>
            </div>

            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-dark text-white p-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div>
                        <h5 class="mb-1 text-primary fw-bold">NOTA DIGITAL LAUNDRY</h5>
                        <small class="text-muted">ID Order: #<?= $order['id_layanan']; ?></small>
                    </div>
                    <div class="text-end">
                        <?php if($order['status_order'] == 'diproses') : ?>
                            <a href="/layanan/selesaikan/<?= $order['id_layanan']; ?>" class="btn btn-success fw-bold" onclick="return confirm('Selesaikan orderan ini?')">✓ Selesaikan Orderan</a>
                        <?php elseif($order['status_order'] == 'selesai') : ?>
                            <a href="/layanan/diambil/<?= $order['id_layanan']; ?>" class="btn btn-info fw-bold text-dark" onclick="return confirm('Tandai bahwa pakaian sudah diambil pelanggan?')">📦 Set Telah Diambil</a>
                        <?php else: ?>
                            <span class="badge bg-secondary p-2 fs-6">Selesai & Diambil</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-3 border-bottom pb-3 mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Nama Pelanggan:</small>
                            <span class="fw-bold text-secondary fs-5"><?= esc($order['nama_pelanggan']); ?></span>
                        </div>
                        <div class="col-6 text-sm-end">
                            <small class="text-muted d-block">Tanggal Masuk:</small>
                            <span class="fw-semibold"><?= date('d F Y H:i', strtotime($order['tanggal_submit'])); ?> WIB</span>
                        </div>
                    </div>

                    <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size: 0.85rem; letter-spacing: 1px;">Rincian Fisik & Biaya</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle bg-white">
                            <thead class="table-light">
                                <tr>
                                    <th>Kategori Layanan</th>
                                    <th class="text-center">Berat Timbangan</th>
                                    <th class="text-end">Total Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-capitalize"><?= $order['nama_layanan']; ?></td>
                                    <td class="text-center fw-bold"><?= $order['berat']; ?> kg</td>
                                    <td class="text-end fw-bold text-success fs-5">Rp <?= number_format($order['harga'], 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="fw-bold text-uppercase text-muted mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Alur Kerja Layanan:</h6>
                    <div class="card bg-light border-0 p-3 mb-4 rounded-3">
                        <ul class="mb-0 ps-3 text-secondary">
                            <?php foreach($komponen_layanan as $item) : ?>
                                <li class="mb-1 fw-medium"><?= $item; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="row g-3 bg-warning bg-opacity-10 border border-warning rounded-3 p-3 m-0">
                        <div class="col-sm-6">
                            <small class="text-warning-emphasis d-block fw-semibold">Durasi Kerja Sistem:</small>
                            <span class="badge bg-warning text-dark px-3 py-2 fw-bold mt-1"><?= $order['estimasi_waktu']; ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-warning-emphasis d-block fw-semibold">Target Estimasi Selesai (Deadline):</small>
                            <span class="text-danger fw-bold d-block mt-1 fs-5"><?= $deadline_selesai; ?></span>
                        </div>
                        
                        <?php if($order['status_order'] == 'selesai' || $order['status_order'] == 'diambil') : ?>
                            <div class="col-12 border-top pt-2 mt-2">
                                <small class="text-dark d-block fw-semibold">Status Performa Ketepatan Waktu:</small>
                                <span class="fw-bold fs-5 d-block mt-1"><?= $analisis_waktu; ?></span>
                                <small class="text-muted">Selesai pada: <?= date('d/m/Y H:i', strtotime($order['tanggal_selesai'])); ?> WIB</small>
                            </div>
                        <?php endif; ?> 
                    </div>

                    <?php if($order['status_order'] == 'diambil' && $order['tanggal_diambil'] != null) : ?>
                            <div class="alert alert-secondary d-flex justify-content-between align-items-center m-0 mt-3 border-0">
                                <span class="fw-semibold text-secondary">📦 Pakaian Telah Diambil Pada:</span>
                                <span class="fw-bold text-dark"><?= date('d/m/Y H:i', strtotime($order['tanggal_diambil'])); ?> WIB</span>
                            </div>
                        <?php endif; ?>

                </div>
                
                <div class="card-footer bg-light text-center py-3 text-muted" style="font-size: 0.85rem;">
                    Terima kasih telah mempercayakan pakaian Anda di ✨ Cia Laundry!
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>