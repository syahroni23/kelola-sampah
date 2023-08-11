<?php
require "../../config/autoloads.php";
require "../../vendor/tcpdf/tcpdf.php";
require '../../vendor/phpoffice/vendor/autoload.php';
require "../../vendor/excelreader/excel_reader2.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

call_user_func($_POST['function'], $conn);

function exportData($conn) {
	$form = $_POST;

	if($form['jenis'] == "excel") {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

		$spreadsheet = $reader->load("../format_excel/export/laporan-biaya-penarikan.xls");

		$sheet = $spreadsheet->getActiveSheet();

		$style_col = [
			'font' => ['bold' => true],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
			]
		];

		$style_row = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			],
			'borders' => [
				'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
				'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
			]
		];

		$index = 6;

		if($form['kategori_filter'] == "Pilihan Otomatis") {

			if($form['pilihan'] == "Hari Ini") {
				$tanggal = date('Y-m-d');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Kemarin") {
				$tanggal = date('Y-m-d', strtotime(date('Y-m-d') . "-1 day"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "7 Hari Terakhir") {
				$tanggal_akhir = date('Y-m-d');
				$tanggal_awal = date('Y-m-d', strtotime($tanggal_akhir . "-7 day"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal_awal))) . " - " . formatDateIndonesia(date('d F Y', strtotime($tanggal_akhir)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Bulan Ini") {
				$tanggal = date('Y-m');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('F Y', strtotime(date('Y-m-d'))));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Bulan Kemarin") {
				$tanggal = date('Y-m', strtotime(date('Y-m-d') . "-1 month"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('F Y', strtotime(date('Y-m-d') . "-1 month")));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Tahun Ini") {
				$tanggal = date('Y');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Tahun Kemarin") {
				$tanggal = date('Y', strtotime(date('Y-m-d') . "-1 year"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y', strtotime(date('Y-m-d') . "-1 year")));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Semua") {
				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' ORDER BY t_biaya_penarikan.kode ASC");
			}else {
				$tanggal = date('Y');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}

		}else if($form['kategori_filter'] == "Rentang Tanggal") {
			$split_periode = explode(" - ", $form['periode']);
			$tanggal_awal = date('Y-m-d', strtotime($split_periode[0]));
			$tanggal_akhir = date('Y-m-d', strtotime($split_periode[1]));

			$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($split_periode[0]))) . " - " . formatDateIndonesia(date('d F Y', strtotime($split_periode[1])));

			$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY t_biaya_penarikan.kode ASC");
		}else {
			$tanggal = date('Y');
			$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

			$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
		}

		$sheet->setCellValue('A2', "Periode : " . $periode_laporan);

		while($row = allRowValidateHTML(mysqli_fetch_array($query, MYSQLI_ASSOC))) {
			if($row['is_deleted'] == 0) {
				$status = "Tidak Terhapus";
			}else {
				$status = "Terhapus";
			}
			$sheet->setCellValue('A'.$index, $row['kode']);
			$sheet->setCellValue('B'.$index, formatDateIndonesia(date('d F Y', strtotime($row['tanggal']))));
			$sheet->setCellValue('C'.$index, $row['nama_pelanggan']);
            $sheet->setCellValue('D'.$index, $row['nama_petugas']);
            $sheet->setCellValue('E'.$index, $row['biaya']);
            $sheet->setCellValue('F'.$index, $row['status']);
			$sheet->setCellValue('G'.$index, $status);
			$sheet->setCellValue('H'.$index, formatDateIndonesia(date('d F Y, H:i', strtotime($row['created_at']))));

            $index++;
		}

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$spreadsheet->getProperties()
		->setCreator("Kelola Sampah V2")
		->setTitle("Laporan Biaya Penarikan")
		->setCompany("Kelola Sampah V2")
		->setSubject("Data Laporan");

		$spreadsheet->getProperties()->setDescription('Data Laporan Biaya Penarikan Periode ' . $periode_laporan);

		$spreadsheet->getProperties()->setKeywords("excel, laporan biaya penarikan")
		->setCategory("Master");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="laporan_biaya_penarikan_'.date('Ymd').'.xls"');
		header('Cache-Control: max-age=0');

		$writer = new Xls($spreadsheet);
		$writer->save('php://output');
	}else {

		if($form['kategori_filter'] == "Pilihan Otomatis") {

			if($form['pilihan'] == "Hari Ini") {
				$tanggal = date('Y-m-d');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Kemarin") {
				$tanggal = date('Y-m-d', strtotime(date('Y-m-d') . "-1 day"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "7 Hari Terakhir") {
				$tanggal_akhir = date('Y-m-d');
				$tanggal_awal = date('Y-m-d', strtotime($tanggal_akhir . "-7 day"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($tanggal_awal))) . " - " . formatDateIndonesia(date('d F Y', strtotime($tanggal_akhir)));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Bulan Ini") {
				$tanggal = date('Y-m');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('F Y', strtotime(date('Y-m-d'))));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Bulan Kemarin") {
				$tanggal = date('Y-m', strtotime(date('Y-m-d') . "-1 month"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('F Y', strtotime(date('Y-m-d') . "-1 month")));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Tahun Ini") {
				$tanggal = date('Y');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Tahun Kemarin") {
				$tanggal = date('Y', strtotime(date('Y-m-d') . "-1 year"));
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y', strtotime(date('Y-m-d') . "-1 year")));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}else if($form['pilihan'] == "Semua") {
				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' ORDER BY t_biaya_penarikan.kode ASC");
			}else {
				$tanggal = date('Y');
				$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

				$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
			}

		}else if($form['kategori_filter'] == "Rentang Tanggal") {
			$split_periode = explode(" - ", $form['periode']);
			$tanggal_awal = date('Y-m-d', strtotime($split_periode[0]));
			$tanggal_akhir = date('Y-m-d', strtotime($split_periode[1]));

			$periode_laporan = "Periode : " . formatDateIndonesia(date('d F Y', strtotime($split_periode[0]))) . " - " . formatDateIndonesia(date('d F Y', strtotime($split_periode[1])));

			$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY t_biaya_penarikan.kode ASC");
		}else {
			$tanggal = date('Y');
			$periode_laporan = "Periode : " . formatDateIndonesia(date('Y'));

			$query = mysqli_query($conn, "SELECT t_biaya_penarikan.*, m_pelanggan.nama AS nama_pelanggan, m_petugas.nama AS nama_petugas FROM t_biaya_penarikan LEFT JOIN t_penarikan_sampah ON t_biaya_penarikan.t_penarikan_sampah_id = t_penarikan_sampah.id LEFT JOIN m_pelanggan ON t_penarikan_sampah.m_pelanggan_id = m_pelanggan.id LEFT JOIN m_petugas ON t_penarikan_sampah.m_petugas_id = m_petugas.id WHERE t_biaya_penarikan.is_deleted = '0' AND t_biaya_penarikan.created_at LIKE '$tanggal%' ORDER BY t_biaya_penarikan.kode ASC");
		}

		class MYPDF extends TCPDF {
			public function Header() {
				$this->Image('@'.file_get_contents('../../assets/img/default/kop.png'), 17.5, 2, 175);
				$this->SetFont('times', 'B', 20);
				$style = ['width' => 0.35, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => [0, 0, 0]];
				$this->SetLineStyle($style);
				$this->SetY(38);
				$this->Line(PDF_MARGIN_LEFT, $this->getY(), $this->getPageWidth() - PDF_MARGIN_LEFT, $this->getY());
				$this->Ln();
				$this->SetTopMargin(40);
			}

			public function Footer() {
				$this->SetFont('times', '', 11);
				$this->WriteHTML('© Kelola Sampah V2', true, false, false, false, 'L');
			}
		}

		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Kelola Sampah V2');
		$pdf->SetTitle('Laporan Biaya Penarikan');
		$pdf->SetSubject('Data Laporan Biaya Penarikan');
		$pdf->SetKeywords('pdf, laporan biaya penarikan, biaya penarikan');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 19.9);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('times', 'B', 20);
		$pdf->AddPage();

		$text = <<<EOD
		LAPORAN BIAYA PENARIKAN
		EOD;

		$pdf->Write(0, $text, '', 0, 'C', true, 0, false, false, 0);
		$pdf->SetFont('times', '', 11);
		$pdf->setY(51.3);

		$content1 = '';
		$content1 .= '<br><br><b>'.$periode_laporan.'</b><br><table style="width: 100%;" border="1" cellpading="5" cellspacing="0">
		<thead>
		<tr style="font-size: 12px;">
		<td style="width: 5%;" align="center">No</td>
		<td style="width: 13%;" align="left">Kode</td>
		<td style="width: 13%;" align="left">Tanggal</td>
		<td style="width: 27%;" align="left">Pelanggan</td>
		<td style="width: 27%;" align="left">Petugas</td>
        <td style="width: 15%;" align="right">Biaya</td>
		</tr>
		</thead>
		<tbody>';

		$no = 1;
		while($row = allRowValidateHTML(mysqli_fetch_array($query, MYSQLI_ASSOC))) {
			$content1 .= '<tr style="font-size:12px;" nobr="true">
			<td style="width: 5%;" align="center">'.$no++.'</td>
			<td style="width: 13%;" align="left">'.$row['kode'].'</td>
			<td style="width: 13%;" align="left">'.formatDateIndonesia(date('d M Y', strtotime($row['tanggal']))).'</td>
            <td style="width: 27%;" align="left">'.$row['nama_pelanggan'].'</td>
            <td style="width: 27%;" align="left">'.$row['nama_petugas'].'</td>
			<td style="width: 15%;" align="right">Rp. '.number_format($row['biaya']).'</td>
			</tr>';
		}

		$content1 .= '</tbody>
		</table>';

		$pdf->writeHTML($content1, true, false, true, false, '');

		$content2 = '
		<br><br><br><br>
		<table style="width: 100%;" border="0" cellpadding="2" cellspacing="0" nobr="true">
		<tr style="text-align: center;">
		<td style="width: 50%;"></td>
		<td style="width: 50%; text-align:center;">
		<table border="0">
		<tr>
		<td>Handil Bakti, '.formatDateIndonesia(date('d F Y')).'</td>
		</tr>
		<tr>
		<td>Kelola Sampah V2</td>
		</tr>
		<tr>
		<td></td>
		</tr>
		<tr>
		<td></td>
		</tr>
		<tr>
		<td></td>
		</tr>
		<tr>
		<td></td>
		</tr>
		<tr>
		<td></td>
		</tr>
		<tr>
		<td>( . . . . . . . . . . . . . . . . . . .)</td>
		</tr>
		<tr>
		<td>Administrator</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';

		$pdf->writeHTML($content2, true, false, false, false, '');

		$pdf->lastPage();

		$pdf->Output('laporan_biaya_penarikan_'.date('Ymd').'.pdf', 'D');
	}
}
?>