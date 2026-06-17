<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LayananModel;

class Layanan extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        // Hanya mengambil orderan yang statusnya masih 'diproses'
        $data['daftar_layanan'] = $this->layananModel->where('status_order', 'diproses')->findAll();
        return view('layanan/index', $data);
    }

    public function tambah()
    {
        return view('layanan/tambah');
    }

    // FUNGSI UNTUK MENGHITUNG HARGA & WAKTU
    private function hitungKalkulasi($layanan, $berat)
    {
        $berat_hitung = $berat; 

        // Aturan minimal 1 kg diterapkan HANYA pada berat_hitung
        if ($berat_hitung < 1) {
            $berat_hitung = 1;
        }

        $harga_per_kg = 0;
        $satuan_waktu = '';
        $waktu_minimal = 0; // Menentukan waktu dasar/minimal layanan

        // Tentukan tarif, satuan, dan waktu minimal berdasarkan jenis layanan
        if ($layanan == "cuci + lipat") {
            $harga_per_kg = 5000;
            $satuan_waktu = "Hari";
            $waktu_minimal = 1; // Minimal 1 hari
        } elseif ($layanan == "cuci + setrika") {
            $harga_per_kg = 7000;
            $satuan_waktu = "Hari";
            $waktu_minimal = 2; // Minimal 2 hari
        } elseif ($layanan == "laundry kilat") {
            $harga_per_kg = 15000;
            $satuan_waktu = "Jam";
            $waktu_minimal = 1; // Minimal 1 jam
        }

        // 1. HITUNG TOTAL HARGA
        $harga_mentah = $berat_hitung * $harga_per_kg;
        $harga_final = ceil($harga_mentah / 500) * 500; // Pembulatan ke atas kelipatan 500

        // 2. HITUNG ESTIMASI WAKTU (Sistem Kelipatan 15 kg)
        // Fungsi ceil($berat_hitung / 15) akan menghasilkan angka 1 untuk berat 0-15 kg, angka 2 untuk 15.01-30 kg, dst.
        $faktor_kelipatan = ceil($berat_hitung / 15);
        
        // Rumus Baru: Waktu Minimal + (Faktor Kelipatan - 1)
        // Jadi jika berat <= 15kg, maka: Waktu Minimal + (1 - 1) = Waktu Minimal (Tetap)
        // Jika berat > 15kg (misal 20kg), maka: Waktu Minimal + (2 - 1) = Waktu Minimal + 1 hari/jam
        $total_waktu = $waktu_minimal + ($faktor_kelipatan - 1);

        $estimasi_waktu = $total_waktu . " " . $satuan_waktu;

        return [
            'harga' => $harga_final,
            'estimasi_waktu' => $estimasi_waktu,
            'berat_real' => $berat
        ];
    }

    public function simpan()
    {
        $layanan = $this->request->getPost('nama_layanan');
        $berat_input = (float) $this->request->getPost('berat');

        // LOGIKA VALIDASI: Cek jika layanan kilat dan berat lebih dari 30 kg
        if ($layanan == "laundry kilat" && $berat_input > 30) {
            // Tampilkan pesan error berbentuk alert teks di layar browser
            echo "<script>
                    alert('Gagal Simpan! Untuk Layanan Laundry Kilat maksimal berat adalah 30 kg.');
                    window.history.back();
                </script>";
            exit;
        }

        // Jalankan kalkulator logika jika lolos validasi
        $kalkulasi = $this->hitungKalkulasi($layanan, $berat_input);

        $this->layananModel->save([
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'nama_layanan'   => $layanan,
            'berat'          => $kalkulasi['berat_real'],
            'harga'          => $kalkulasi['harga'],
            'estimasi_waktu' => $kalkulasi['estimasi_waktu'],
            // Tanggal otomatis terisi oleh database lewat CURRENT_TIMESTAMP
        ]);

        return redirect()->to('/layanan');
    }

    public function edit($id)
    {
        $data['layanan'] = $this->layananModel->find($id);
        return view('layanan/edit', $data);
    }

    public function update($id)
    {
        $layanan = $this->request->getPost('nama_layanan');
        $berat_input = (float) $this->request->getPost('berat');

        // LOGIKA VALIDASI: Cek saat proses edit data
        if ($layanan == "laundry kilat" && $berat_input > 30) {
            echo "<script>
                    alert('Gagal Update! Untuk Layanan Laundry Kilat maksimal berat adalah 30 kg.');
                    window.history.back();
                </script>";
            exit;
        }

        $kalkulasi = $this->hitungKalkulasi($layanan, $berat_input);

        $this->layananModel->update($id, [
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'nama_layanan'   => $layanan,
            'berat'          => $kalkulasi['berat_real'],
            'harga'          => $kalkulasi['harga'],
            'estimasi_waktu' => $kalkulasi['estimasi_waktu'],
        ]);

        return redirect()->to('/layanan');
    }

    public function hapus($id)
    {
        $this->layananModel->delete($id);
        return redirect()->to('/layanan');
    }

    // DETAIL: Menampilkan nota detail order laundry
    public function detail($id)
    {
        $order = $this->layananModel->find($id);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Order tidak ditemukan!");
        }

        // --- HITUNG DEADLINE SELESAI ---
        $tanggal_masuk = $order['tanggal_submit'];
        $estimasi = $order['estimasi_waktu']; 
        $pecah = explode(' ', $estimasi);
        $angka_waktu = $pecah[0]; 
        $satuan_waktu = strtolower($pecah[1]); 

        if ($satuan_waktu == 'hari') {
            $hitung_deadline = strtotime("+$angka_waktu day", strtotime($tanggal_masuk));
        } else {
            $hitung_deadline = strtotime("+$angka_waktu hour", strtotime($tanggal_masuk));
        }
        
        $data['deadline_selesai'] = date('d-m-Y H:i', $hitung_deadline) . ' WIB';

        // --- LOGIKA ANALISIS KETEPATAN WAKTU (JIKA SUDAH SELESAI) ---
        $data['analisis_waktu'] = '';
        if ($order['status_order'] == 'selesai') {
            $waktu_selesai_asli = strtotime($order['tanggal_selesai']);
            
            // Hitung selisih detik antara waktu selesai aktual dengan target deadline
            $selisih_detik = $waktu_selesai_asli - $hitung_deadline;

            if ($selisih_detik > 0) {
                // OVER / TERLAMBAT
                $jarak_menit = ceil($selisih_detik / 60);
                if ($jarak_menit >= 60) {
                    $jarak_jam = floor($jarak_menit / 60);
                    $sisa_menit = $jarak_menit % 60;
                    $data['analisis_waktu'] = "🔴 Terlambat / Over ($jarak_jam Jam $sisa_menit Menit)";
                } else {
                    $data['analisis_waktu'] = "🔴 Terlambat / Over ($jarak_menit Menit)";
                }
            } else {
                // TEPAT WAKTU / LEBIH CEPAT
                $selisih_cepat = abs($selisih_detik);
                $jarak_menit = floor($selisih_cepat / 60);
                if ($jarak_menit >= 60) {
                    $jarak_jam = floor($jarak_menit / 60);
                    $data['analisis_waktu'] = "🟢 Tepat Waktu / Lebih Cepat ($jarak_jam Jam Selesai Sebelum Deadline)";
                } else {
                    $data['analisis_waktu'] = "🟢 Tepat Waktu / Lebih Cepat ($jarak_menit Menit Sebelum Deadline)";
                }
            }
        }

        // --- LOGIKA MEMECAH KOMPONEN LAYANAN ---
        $komponen = [];
        switch ($order['nama_layanan']) {
            case 'cuci + lipat': $komponen = ['Cuci', 'Lipat']; break;
            case 'cuci + setrika': $komponen = ['Cuci', 'Setrika']; break;
            case 'laundry kilat': $komponen = ['Cuci', 'Setrika', 'Cepat']; break;
            default: $komponen = ['Proses Standar']; break;
        }

        $data['order'] = $order;
        $data['komponen_layanan'] = $komponen;

        return view('layanan/detail', $data);
    }

    public function riwayat()
    {
        // Mengambil data yang statusnya selesai ATAU diambil
        $data['daftar_selesai'] = $this->layananModel->whereIn('status_order', ['selesai', 'diambil'])->findAll();
        return view('layanan/riwayat', $data);
    }

    public function selesaikan($id)
    {
        // Update status menjadi selesai dan isi tanggal_selesai dengan waktu sekarang
        $this->layananModel->update($id, [
            'status_order'    => 'selesai',
            'tanggal_selesai' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/layanan/riwayat');
    }

    public function diambil($id)
    {
        // Update status menjadi diambil dan catat tanggal pengambilan saat ini
        $this->layananModel->update($id, [
            'status_order'    => 'diambil',
            'tanggal_diambil' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/layanan/riwayat');
    }
}