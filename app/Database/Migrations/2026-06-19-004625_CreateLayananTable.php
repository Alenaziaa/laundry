<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayananTable extends Migration
{
    public function up()
    {
        // 1. DEFINISIKAN SEMUA KOLOM DARI NOL
        $this->forge->addField([
            'id_layanan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_pelanggan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_layanan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'berat' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'estimasi_waktu' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'status_order' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'diproses',
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_diambil' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_submit' => [
                'type'    => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        // 2. ATUR PRIMARY KEY
        $this->forge->addKey('id_layanan', true);

        // 3. EKSEKUSI PEMBUATAN TABEL
        $this->forge->createTable('layanan');
    }

    public function down()
    {
        // Perintah jika melakukan rollback (pembatalan migration)
        $this->forge->dropTable('layanan');
    }
}