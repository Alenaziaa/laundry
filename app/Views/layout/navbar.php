<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid container-md">
        <a class="navbar-brand fw-bold text-primary" href="/layanan">
            ✨ Cia Laundry
        </a>
        
        <button class="navbar-toggler" type="text/all" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2 pt-2 pt-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded <?= (url_is('layanan') && !url_is('layanan/riwayat')) ? 'active bg-primary text-white' : '' ?>" href="/layanan">
                        Daftar Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded <?= url_is('layanan/riwayat') ? 'active bg-success text-white' : '' ?>" href="/layanan/riwayat">
                        Orderan Selesai
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>