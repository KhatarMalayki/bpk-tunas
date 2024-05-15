<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Terbilang;
use CodeIgniter\HTTP\ResponseInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
// use app\Libraries\Terbilang;


class BerandaController extends BaseController
{
    // public static function terbilang($angka)
    // {
    //     $angka = abs($angka);
    //     $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    //     $terbilang = "";
    //     if ($angka < 12) {
    //         $terbilang = " " . $huruf[$angka];
    //     } elseif ($angka < 20) {
    //         $terbilang = self::terbilang($angka - 10) . " Belas";
    //     } elseif ($angka < 100) {
    //         $terbilang = self::terbilang($angka / 10) . " Puluh" . self::terbilang($angka % 10);
    //     } elseif ($angka < 200) {
    //         $terbilang = " Seratus" . self::terbilang($angka - 100);
    //     } elseif ($angka < 1000) {
    //         $terbilang = self::terbilang($angka / 100) . " Ratus" . self::terbilang($angka % 100);
    //     } elseif ($angka < 2000) {
    //         $terbilang = " Seribu" . self::terbilang($angka - 1000);
    //     } elseif ($angka < 1000000) {
    //         $terbilang = self::terbilang($angka / 1000) . " Ribu" . self::terbilang($angka % 1000);
    //     } elseif ($angka < 1000000000) {
    //         $terbilang = self::terbilang($angka / 1000000) . " Juta" . self::terbilang($angka % 1000000);
    //     } elseif ($angka < 1000000000000) {
    //         $terbilang = self::terbilang($angka / 1000000000) . " Milyar" . self::terbilang($angka % 1000000000);
    //     } elseif ($angka < 1000000000000000) {
    //         $terbilang = self::terbilang($angka / 1000000000000) . " Trilyun" . self::terbilang($angka % 1000000000000);
    //     }
    //     return $terbilang;
    // }
    public function index()
    {
        $data = [
            'title' => 'Beranda',
            // 'data_kategori' => $this->kategoriBpk->findAll(),
            'data_bpk' => $this->dbBpk->where('no_bpk', session()->get('no_bpk'))->first()
        ];
        return view('users/beranda/index', $data);
    }

    public function status($requestId)
    {
        // Dekripsi $encryptedRequestId
        // $requestId = base64_decode($encryptedRequestId);

        // Lakukan operasi lain yang diperlukan, misalnya mengambil data dari database
        $dataBpk = $this->dbBpk->where('no_bpk', $requestId)->first();

        $data = [
            'title' => 'Status',
            'data_bpk' => $dataBpk
        ];
        return view('users/beranda/status', $data);
    }



    public function create()
    {
        // Check if the request is an AJAX request
        if ($this->request->isAJAX()) {
            // Validate form input
            if (!$this->validate([
                'nama' => 'required',
                'jmlh_uang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jumlah Uang harus diisi'
                    ]
                ],
                'for_kprln' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Info Keperluaan harus diisi',
                    ]
                ],
                'file' => [
                    'rules' => 'uploaded[file]|max_size[file,2048]|ext_in[file,pdf]',
                    'errors' => [
                        'uploaded' => 'File PDF harus diunggah.',
                        'max_size' => 'Ukuran file PDF terlalu besar. Maksimal 2MB diizinkan.',
                        'ext_in' => 'File yang diunggah harus berupa file PDF.'
                    ]
                ]
            ])) {
                // Return validation errors
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $this->validator->getErrors()
                ]);
            }


            $file_pdf = $this->request->getFile('file');
            // Check apakah ada error saat mengunggah file
            if ($file_pdf->getError() != UPLOAD_ERR_OK) {
                // Handle error saat mengunggah file
            }
            // Tentukan bucket tempat Anda ingin menyimpan gambar
            $bucket = $this->storage->bucket('ktr-bucket');
            // Ambil nama gambar
            // $nama_file = $file_pdf->getName();
            // Generate sufiks unik
            // $sufiks_unik = '_' . uniqid();

            // Tambahkan sufiks unik ke nama file
            // $nama_file_unik = $nama_file . $sufiks_unik;

            // Mendapatkan tanggal saat ini dalam format yymmdd
            $today = date("dmy");
            // Mengambil nomor urut terakhir dari database
            $last_sequence = $this->db->query("SELECT MAX(id) as id FROM db_bpk")->getRowArray()['id'] ?? 0;
            // Menambahkan satu ke nomor urut terakhir
            $sequence_number = $last_sequence + 1;
            // Format nomor urut dengan panjang 3 digit
            $sequence = str_pad($sequence_number, 3, '0', STR_PAD_LEFT);
            // Gabungkan semua komponen untuk membentuk nomor BPK yang unik
            $unique_number = $sequence . "BPK" . $today;
            // nama file pdf
            $nama_file_pdf = $unique_number . '.pdf';
            // Upload file gambar ke bucket
            $object = $bucket->upload(
                fopen($file_pdf->getRealPath(), 'r'),
                ['name' => $nama_file_pdf]
            );
            // Mendapatkan protokol
            // $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
            // Mendapatkan nama host
            // $host = $_SERVER['HTTP_HOST'];
            // Enkripsi id_barang untuk URL
            $encrypted_id = base64_encode($unique_number);
            // Menggabungkan semuanya menjadi URL lengkap
            $url = base_url() . 'bpk-detail/' . $encrypted_id;
            // dd($url);
            $data = $url;
            // Generate nama unik untuk gambar QR
            $qrCodeName = uniqid() . '.png';
            $qrCode = new \Endroid\QrCode\QrCode($data);
            // simpan qrcode sementara
            $writer = new PngWriter();
            $tempFilePath = WRITEPATH . '/' . $qrCodeName;
            $writer->write($qrCode)->saveToFile($tempFilePath);
            // upload qrcode ke bucket
            $objectName = 'qr-codeImg/' . $qrCodeName;
            $fileContents = file_get_contents($tempFilePath);
            $bucket->upload($fileContents, [
                'name' => $objectName
            ]);
            // Hapus file QR code sementara dari server lokal
            unlink($tempFilePath);

            $nama = (string) $this->request->getVar('nama');
            $this->dbBpk->insert([
                'no_bpk' => esc($unique_number),
                'nama_user' => esc($nama),
                'nik' => esc(strtoupper($this->request->getVar('search'))),
                'jmlh_uang' => esc($this->request->getVar('jmlh_uang')),
                'for_kprln' => esc($this->request->getVar('for_kprln')),
                'file' => $nama_file_pdf,
                'qr_code' => $qrCodeName,
                'status' => esc($this->request->getVar('status')),
                // 'created_at' => esc($this->request->getVar('created_at')),
            ]);
            // Ambil semua alamat email pengguna dalam grup dengan ID 2
            $groupId = 2; // ID grup yang ingin Anda cari pengguna-pengguna yang terkait dengannya
            $usersInGroup = $this->groupModel->getUsersForGroup($groupId);

            // Loop melalui setiap pengguna dalam grup
            foreach ($usersInGroup as $user) {
                // Mengakses email dari setiap pengguna dan memasukkannya ke dalam array $emails
                $emails[] = $user['email'];
            }
            // dd($emails);
            // Kirim email notifikasi kepada setiap alamat email dalam array $emails
            foreach ($emails as $email) {
                $subject = 'New Request BPK No. ' . $unique_number;
                $message = 'Halo <strong>Admin</strong>,<br><br>';
                $message .= 'Request A/n <strong>' . $this->request->getVar('nama') . '</strong>.<br>';
                $message .= 'NIK : <strong>' . strtoupper($this->request->getVar('search')) . '</strong>.<br>';
                $message .= 'Request dibuat pada : <strong>' . date('Y-m-d H:i:s') . '</strong>.<br>';
                $message .= 'Mohon di cek <strong>request</strong> tersebut pada <a href="' . $url . '">link ini</a>, terima kasih.<br><br>';
                $message .= 'Salam,<strong><br>Tim Admin</strong><br>';
                $message .= '<em>Pesan ini adalah notifikasi, harap tidak dibalas.</em>';
                // Definisikan variabel untuk alamat email balasan
                // $replyto = (string) 'N9dZr@example.com';

                $emailService = \Config\Services::email();
                $emailService->setTo($email);
                $emailService->setSubject($subject);
                $emailService->setMessage($message);
                // Tetapkan alamat email untuk balasan
                $emailService->setReplyTo($email);
                $emailService->send();
            }

            // Return success response
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Nomor Bpk Anda :<strong> ' . $unique_number . '</strong> Simpan nomor BPK anda untuk mengecek status.'
            ]);
        } else {
            // If it's not an AJAX request, redirect back
            return redirect()->back();
        }
    }

    public function search()
    {
        if (!$this->request->isAJAX()) {
            // Mengambil data JSON dari body permintaan
            $requestData = $this->request->getJSON();
            // Mengambil nilai category_name dari data JSON
            $username = $requestData->searchInput;

            // Lakukan query ke database untuk mengambil deskripsi berdasarkan nama kategori
            $email = $this->builder->where('username', $username)->get()->getResult()[0]->email;
            $fullname = $this->builder->where('username', $username)->get()->getResult()[0]->fullname;
            // Kembalikan email sebagai respons AJAX
            return $this->response->setJSON([
                'email' => $email,
                'fullname' => $fullname
            ]);
        } else {
            // If it's not an AJAX request, return a 403 Forbidden response
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Forbidden']);
        }
    }

    // Method untuk mengambil status form
    public function getStatus()
    {
        // Ambil status saat ini dari permintaan POST
        $currentBpk = $this->request->getVar('currentBpk');

        // Lakukan operasi lain yang diperlukan, misalnya mengambil data dari database
        // Ambil status data BPK dari database berdasarkan nomor BPK yang diterima
        $status = $this->dbBpk->where('no_bpk', $currentBpk)->get()->getResult()[0]->status;
        // Lakukan sesuatu sesuai dengan status yang diterima
        // Misalnya, kita akan mengembalikan status yang sama ke frontend
        // Anda dapat menyesuaikan dengan logika bisnis Anda

        // Kirim respons dalam format JSON
        return $this->response->setJSON(['status' => $status]);
    }
}
