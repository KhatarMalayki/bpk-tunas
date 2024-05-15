<?php namespace App\Libraries;
// use CodeIgniter\Language\Language;
use PharIo\Manifest\Library;

class Terbilang extends Library
{
    public static function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $terbilang = "";
        if ($angka < 12) {
            $terbilang = " " . $huruf[$angka];
        } elseif ($angka < 20) {
            $terbilang = self::terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            $terbilang = self::terbilang($angka / 10) . " Puluh" . self::terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = " Seratus" . self::terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = self::terbilang($angka / 100) . " Ratus" . self::terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = " Seribu" . self::terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = self::terbilang($angka / 1000) . " Ribu" . self::terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = self::terbilang($angka / 1000000) . " Juta" . self::terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = self::terbilang($angka / 1000000000) . " Milyar" . self::terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $terbilang = self::terbilang($angka / 1000000000000) . " Trilyun" . self::terbilang($angka % 1000000000000);
        }
        return $terbilang;
    }
}
