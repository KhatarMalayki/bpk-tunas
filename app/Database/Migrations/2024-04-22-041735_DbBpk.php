<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DbBpk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
            'jmlh_uang' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'for_kprln' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'voucher' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'gate_pass' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'surat_tugas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'compliment' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'bastk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'frm_kndrn_pgnti' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'form_service' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'prnth_krj_bngkl' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'frm_stms_by' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ntln_mtng' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tnd_trm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('db_bpk');
    }

    public function down()
    {
        $this->forge->dropTable('db_bpk');
    }
}
