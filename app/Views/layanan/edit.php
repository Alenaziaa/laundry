<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layout/navbar'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark py-3">
                    <h4 class="mb-0 fs-5">Edit Order Laundry</h4>
                </div>
                <div class="card-body p-4">
                    <form action="/layanan/update/<?= $layanan['id_layanan']; ?>" method="POST" id="form-laundry">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Atas Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control form-control-lg" value="<?= esc($layanan['nama_pelanggan']); ?>" style="font-size: 1rem;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Jenis Layanan</label>
                            <select name="nama_layanan" id="pilih-layanan" class="form-select form-select-lg" style="font-size: 1rem;" required>
                                <option value="cuci + lipat" <?= ($layanan['nama_layanan'] == 'cuci + lipat') ? 'selected' : ''; ?>>Cuci + Lipat</option>
                                <option value="cuci + setrika" <?= ($layanan['nama_layanan'] == 'cuci + setrika') ? 'selected' : ''; ?>>Cuci + Setrika</option>
                                <option value="laundry kilat" <?= ($layanan['nama_layanan'] == 'laundry kilat') ? 'selected' : ''; ?>>Laundry Kilat</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Berat Pakaian</label>
                            <div class="input-group input-group-lg">
                                <input type="number" name="berat" id="input-berat" step="0.01" min="0.1" class="form-control" value="<?= $layanan['berat']; ?>" style="font-size: 1rem;" required>
                                <span class="input-group-text" style="font-size: 1rem;">kg</span>
                            </div>
                            <small id="note-kilat" class="text-danger fw-bold mt-1" style="display: <?= ($layanan['nama_layanan'] == 'laundry kilat') ? 'block' : 'none'; ?>;">*Khusus Laundry Kilat, maksimal berat adalah 30 kg!</small>
                        </div>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                            <a href="/layanan" class="btn btn-secondary order-2 order-sm-1">Kembali</a>
                            <button type="submit" class="btn btn-warning text-dark fw-bold order-1 order-sm-2 px-4">Perbarui Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const pilihLayanan = document.getElementById('pilih-layanan');
    const inputBerat = document.getElementById('input-berat');
    const noteKilat = document.getElementById('note-kilat');
    const formLaundry = document.getElementById('form-laundry');

    pilihLayanan.addEventListener('change', function() {
        if (this.value === 'laundry kilat') {
            noteKilat.style.display = 'block';
        } else {
            noteKilat.style.display = 'none';
            inputBerat.setCustomValidity('');
        }
    });

    formLaundry.addEventListener('submit', function(event) {
        if (pilihLayanan.value === 'laundry kilat' && parseFloat(inputBerat.value) > 30) {
            inputBerat.setCustomValidity('Maksimal berat untuk Laundry Kilat adalah 30 kg!');
            inputBerat.reportValidity();
            event.preventDefault();
        } else {
            inputBerat.setCustomValidity('');
        }
    });

    inputBerat.addEventListener('input', function() {
        inputBerat.setCustomValidity('');
    });
</script>
</body>
</html>