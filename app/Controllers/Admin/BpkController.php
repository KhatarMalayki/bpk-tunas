<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Terbilang;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Borders;

class BpkController extends BaseController
{
    public function request()
    {
        $data = [
            'title' => 'Data BPK',
            'data_bpk' => $this->dbBpk->findAll(),
        ];

        return view('admin/bpk/request', $data);
    }

    public function index()
    {
        $data = [
            'title' => 'Data BPK',
            'data_bpk' => $this->dbBpk->findAll(),
        ];

        return view('admin/bpk/index', $data);
    }

    public function reject()
    {
        if ($this->request->isAJAX()) {
            $no_bpk = $this->request->getVar('no_bpk');
            $data_bpk = $this->dbBpk->where('no_bpk', $no_bpk)->first();
            $this->dbBpk->update($data_bpk->no_bpk, ['status' => 'Rejected']);
            $result = [
                'success' => 'Form Telah Ditolak',
            ];
            echo json_encode($result);
        } else {
            exit('No direct script access allowed');
        }
    }

    public function approve()
    {
        if ($this->request->isAJAX()) {
            $no_bpk = $this->request->getVar('no_bpk');
            $data_bpk = $this->dbBpk->where('no_bpk', $no_bpk)->first();
            $this->dbBpk->update($data_bpk->no_bpk, ['status' => 'Approved']);
            $result = [
                'success' => 'Form Telah Disetujui',
            ];
            echo json_encode($result);
        } else {
            exit('No direct script access allowed');
        }
    }

    public function update($no_bpk)
    {
        $uang = $this->request->getPost('jmlh_uang');
        $data_bpk = $this->dbBpk->where('no_bpk', $no_bpk)->first();
        $this->dbBpk->update($data_bpk->no_bpk, ['jmlh_uang' => $uang]);
        return redirect()->to('bpk-detail/' . base64_encode($data_bpk->no_bpk))->with('success', 'Jumlah Uang Telah Diupdate');
    }

    public function detail($no_bpk)
    {

        // Enkripsi $no_bpk sebelum digunakan dalam URL
        $dencrypt_no_bpk = base64_decode($no_bpk);
        $data_bpk = $this->dbBpk->where('no_bpk', $dencrypt_no_bpk)->first();
        $bucket = $this->storage->bucket('ktr-bucket');
        $qr = 'qr-codeImg/' . $data_bpk->qr_code;
        $objectName = $bucket->object($qr);
        $object = $bucket->object($data_bpk->file);
        $data = [
            'title' => 'Detail BPK',
            'data_bpk' => $data_bpk,
            'signedUrl' => $object->signedUrl(time() + 3600),
            'qrUrl' => $objectName->signedUrl(time() + 3600)
        ];
        return view('admin/bpk/detail', $data);
    }

    public function generatePdf($no_bpk)
    {
        // Mengambil id barang dari URL
        // $no_bpk = $this->request->uri->getSegment(3);
        if ($this->request->isAJAX()) {
            // Menampilkan data pengeluaran
            $pengeluaran = $this->dbBpk->where('no_bpk', $no_bpk)->get()->getRow();

            // Jika data tidak ditemukan, tampilkan halaman error yang lebih spesifik
            if (empty($pengeluaran)) {
                return view('error', ['message' => 'Data pengeluaran dengan nomor BPK ' . $no_bpk . ' tidak ditemukan']);
            }
            $bucketName = 'ktr-bucket'; // Ganti dengan nama bucket Anda
            $folderName = 'qr-codeImg'; // Nama folder di dalam bucket
            $objectName = $folderName . '/' . $pengeluaran->qr_code; // Path objek dengan folder
            $expiration = new \DateTime('+1 hour'); // URL akan kadaluwarsa dalam 1 jam
            $signedUrl = $this->storage->bucket($bucketName)->object($objectName)->signedUrl($expiration);
            // unduh gambar secara lokal
            // $qrCodeImgPath = WRITEPATH . 'uploads/' . $pengeluaran->qr_code;
            // file_put_contents($qrCodeImgPath, file_get_contents($signedUrl));
            // dd($signedUrl);


            $created_at = date('d F Y', strtotime($pengeluaran->created_at));
            // Format uang dengan titik dan koma
            $uang_sejumlah = number_format($pengeluaran->jmlh_uang, 0, ',', '.');
            // Inisialisasi konten HTML
            $content = '<h2 style="text-align: center; margin-top: 50px; margin-bottom: 50px;">BUKTI PENGELUARAN KAS</h2>';
            $content .= '<table style="margin-left: 50px;">';
            $content .= '<tr><td style="width: 200px;">Diserahkan kepada</td><td style="width: 10px;">:</td><td>' . $pengeluaran->nama_user . '</td></tr>';
            $content .= '<tr><td>NIK</td><td>:</td><td>' . $pengeluaran->nik . '</td></tr>';
            $content .= '<tr><td>Uang sejumlah</td><td>:</td><td>Rp.' . $uang_sejumlah . ',-</td></tr>';
            $content .= '<tr><td>Untuk keperluan</td><td>:</td><td>" ' . $pengeluaran->for_kprln . ' "</td></tr>';
            $content .= '</table>';
            $content .= '<p style="margin-left: 50px;"><em>" ' . ucwords(Terbilang::terbilang($pengeluaran->jmlh_uang)) . 'Rupiah "</em></p>';
            $content .= '<table style="margin-left: 50px;">
            <tr>
                <td>
                    <img src="data:image/png;base64,' . base64_encode(file_get_contents($signedUrl)) . '" alt="qr-code"  style="width: 100px;"><br>
                    ' . $pengeluaran->no_bpk . '
                </td>
                <td>
                <div style="margin-left: 450px;">Cikarang, ' . $created_at . '</div>
                <div style="margin-left: 450px;">PENERIMA</div><br>
                    <br>
                    <br>
                    <div style="margin-left: 450px;">' . $pengeluaran->nama_user . '</div>
                </td>
            </tr> 
        </table>';

            // dd($pengeluaran->qr_code);
            // Write HTML content to PDF
            // unlink($qrCodeImgPath);
            return $content;
        }
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'No BPK');
        $sheet->setCellValue('C1', 'Nama User');
        $sheet->setCellValue('D1', 'Jumlah Uang');
        $sheet->setCellValue('E1', 'Keperluan');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Tanggal Input');
        $sheet->setCellValue('H1', 'Tanggal Approved/Reject');

        // Atur huruf menjadi tebal (bold) dan di tengah pada sel A1 sampai H1
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        // Atur warna latar belakang kuning pada sel A1 sampai H1
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');

        // Tambahkan filter
        $sheet->setAutoFilter('A1:H1');

        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');

        // Buat query untuk mengambil data berdasarkan rentang tanggal
        $dataBpk = $this->dbBpk->where('updated_at >=', $start_date)
            ->where('updated_at <=', $end_date)
            ->findAll();
        $no = 1;
        $start = 2;
        foreach ($dataBpk as $data) {
            if ($data->status !== 'In-Process') {
                $sheet->setCellValue('A' . $start, $no++)->getColumnDimension('A')->setAutoSize(true);
                $sheet->setCellValue('B' . $start, $data->no_bpk)->getColumnDimension('B')->setAutoSize(true);
                $sheet->setCellValue('C' . $start, $data->nama_user)->getColumnDimension('C')->setAutoSize(true);
                $sheet->setCellValue('D' . $start, 'Rp. ' . number_format($data->jmlh_uang, 0, ',', '.'))->getColumnDimension('D')->setAutoSize(true);
                $sheet->setCellValue('E' . $start, $data->for_kprln)->getColumnDimension('E')->setAutoSize(true);
                $sheet->setCellValue('F' . $start, $data->status)->getColumnDimension('F')->setAutoSize(true);
                $sheet->setCellValue('G' . $start, $data->created_at)->getColumnDimension('G')->setAutoSize(true);
                $sheet->setCellValue('H' . $start, $data->updated_at)->getColumnDimension('H')->setAutoSize(true);
                $start++;
            }
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ];

        $border = $start - 1;
        $sheet->getStyle('A1:H' . $border)->applyFromArray($styleArray);

        $writer = new Xlsx($spreadsheet);
        $writer->save('Data BPK.xlsx');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data BPK.xlsx"');
        header('Cache-Control: max-age=0');
        readfile('Data BPK.xlsx');
        unlink('Data BPK.xlsx');
        exit;
    }
}
