-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 25. Agustus 2015 jam 10:51
-- Versi Server: 5.1.37
-- Versi PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `notaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_default_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `biaya_default_pekerjaan` (
  `id_detail` int(10) NOT NULL,
  `id_pekerjaan` tinyint(3) NOT NULL,
  `biaya_default` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `biaya_default_pekerjaan`
--

INSERT INTO `biaya_default_pekerjaan` (`id_detail`, `id_pekerjaan`, `biaya_default`) VALUES
(3201, 32, 70000),
(1602, 16, 75000),
(905, 9, 2500000),
(906, 9, 250000),
(1601, 16, 55000),
(1613, 16, 275000),
(1001, 10, 350000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_detail_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `biaya_detail_pekerjaan` (
  `id_berkas` int(10) NOT NULL,
  `id_detail` int(10) NOT NULL,
  `biaya_pekerjaan` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `biaya_detail_pekerjaan`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya_titip`
--

CREATE TABLE IF NOT EXISTS `biaya_titip` (
  `id_titip` int(10) NOT NULL AUTO_INCREMENT,
  `id_berkas` int(10) NOT NULL,
  `tgl_titip` date NOT NULL,
  `biaya_titip` int(20) NOT NULL,
  PRIMARY KEY (`id_titip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `biaya_titip`
--

INSERT INTO `biaya_titip` (`id_titip`, `id_berkas`, `tgl_titip`, `biaya_titip`) VALUES
(1, 2, '2015-07-01', 8000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `detail_pekerjaan` (
  `id_detail` int(10) NOT NULL,
  `id_pekerjaan` tinyint(3) NOT NULL,
  `langkah_pekerjaan` varchar(50) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_pekerjaan` (`id_pekerjaan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_pekerjaan`
--

INSERT INTO `detail_pekerjaan` (`id_detail`, `id_pekerjaan`, `langkah_pekerjaan`) VALUES
(1610, 16, 'Bayar Pajak SSB'),
(1611, 16, 'Bayar Pajak SSP'),
(1602, 16, 'Zona Nilai Tanah'),
(1601, 16, 'Cek Sertipikat'),
(902, 9, 'Pembuatan Akta Pendirian'),
(1612, 16, 'Masuk Balik Nama'),
(1605, 16, 'PNBP'),
(1001, 10, 'Pendaftaran Nama Yayasan'),
(1613, 16, 'Ambil Sertipikat'),
(5401, 54, 'Pendaftaran CV'),
(901, 9, 'Pendaftaran Nama PT'),
(5402, 54, 'Pembuatan Akta Pendirian'),
(5403, 54, 'Pembuatan NPWP Perusahaan'),
(5404, 54, 'Pembuatan SIUP'),
(903, 9, 'Pembuatan NPWP Direktur'),
(904, 9, 'Pembuatan NPWP Perusahaan'),
(905, 9, 'Penerbitan SK'),
(906, 9, 'Pembuatan SIUP TDP');

-- --------------------------------------------------------

--
-- Struktur dari tabel `instansi`
--

CREATE TABLE IF NOT EXISTS `instansi` (
  `id_berkas` int(10) NOT NULL,
  `nama_instansi` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `instansi`
--

INSERT INTO `instansi` (`id_berkas`, `nama_instansi`) VALUES
(1, 'PT Madikarya Jasa'),
(2, 'PT Ichsan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `jenis_pekerjaan` (
  `id_pekerjaan` tinyint(3) NOT NULL AUTO_INCREMENT,
  `nama_pekerjaan` varchar(50) NOT NULL,
  `jenis_akta` varchar(50) NOT NULL DEFAULT '-',
  `jenis_aktor` varchar(10) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_pekerjaan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data untuk tabel `jenis_pekerjaan`
--

INSERT INTO `jenis_pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`, `jenis_akta`, `jenis_aktor`, `hapus`) VALUES
(16, 'Balik Nama Jual Beli', 'Akta Jual Beli', 'PPAT', 0),
(54, 'Pembuatan CV', 'Akta Pendirian', 'Notaris', 0),
(25, 'Balik Nama Hibah', 'Akta Hibah', 'PPAT', 0),
(9, 'Pembuatan PT', 'Akta Pendirian', 'Notaris', 0),
(10, 'Lembaga', 'Akta Pendirian', 'Notaris', 0),
(12, 'Peningkatan Hak', '-', 'PPAT', 0),
(26, 'Balik Nama Turun Waris', '-', 'PPAT', 0),
(27, 'Akta Pembagian Hak Bersama', 'Akta Pembagian Hak Bersama', 'PPAT', 0),
(32, 'Kuasa Jual', 'Akta Kuasa Jual', 'Notaris', 0),
(1, 'Roya', '-', 'PPAT', 0),
(40, 'Legalisir', '-', 'Notaris', 0),
(55, 'Lalala', '-', 'Notaris', 1),
(56, 'Pensertifikatan Letter D', '-', 'PPAT', 0),
(57, 'Pensertifikatan Tanah Negara', '-', 'PPAT', 0),
(58, 'Perubahan Anggaran Dasar CV', 'Akta Masuk dan Keluar Perseroan dan Perubahan Angg', 'Notaris', 0),
(59, 'Perubahan Anggaran Dasar PT', 'Akta Perubahan Anggaran Dasar Perusahaan', 'Notaris', 0),
(60, 'Berita Acara Rapat Umum Pemegang Saham', 'Akta Berita Acara Rapat Umum Pemegang Saham', 'Notaris', 0),
(61, 'Jual Beli Saham Perusahaan', 'Akta Jual Beli Saham', 'Notaris', 0),
(62, 'Warmerking', '-', 'Notaris', 0),
(63, 'Pembubaran PT', '-', 'Notaris', 0),
(64, 'Pembubaran CV', '-', 'Notaris', 0),
(65, 'Perjanjian', 'Akta Perjanjian', 'Notaris', 0),
(66, 'Kuasa Menjual', 'Akta Kuasa Menjual', 'Notaris', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE IF NOT EXISTS `pekerjaan` (
  `id_berkas` int(10) NOT NULL AUTO_INCREMENT,
  `tgl_masuk_pekerjaan` date NOT NULL,
  `tgl_diterima_pekerjaan` date NOT NULL,
  `tgl_selesai_pekerjaan` date NOT NULL,
  `biaya_kerja` int(20) DEFAULT NULL,
  `biaya_klien` int(20) DEFAULT NULL,
  `lokasi_penyimpanan` varchar(20) DEFAULT NULL,
  `id_pekerjaan` tinyint(3) NOT NULL,
  `id_user` tinyint(2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_berkas`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_berkas`, `tgl_masuk_pekerjaan`, `tgl_diterima_pekerjaan`, `tgl_selesai_pekerjaan`, `biaya_kerja`, `biaya_klien`, `lokasi_penyimpanan`, `id_pekerjaan`, `id_user`, `status`, `hapus`) VALUES
(1, '2015-06-30', '2015-06-30', '2015-06-30', 2750000, 8000000, 'A01', 9, 33, 2, 0),
(2, '2015-07-01', '2015-07-01', '2015-07-01', 2750000, 8000000, 'A01', 9, 31, 3, 0),
(3, '2015-07-01', '2015-07-01', '0000-00-00', 405000, 5000000, 'C01', 16, 31, 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemohon`
--

CREATE TABLE IF NOT EXISTS `pemohon` (
  `id_pemohon` varchar(16) NOT NULL,
  `nama_pemohon` varchar(30) NOT NULL,
  `jalan` varchar(50) NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `kelurahan` varchar(30) NOT NULL,
  `kecamatan` varchar(20) NOT NULL,
  `kota` varchar(20) NOT NULL,
  `provinsi` varchar(20) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_pemohon`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pemohon`
--

INSERT INTO `pemohon` (`id_pemohon`, `nama_pemohon`, `jalan`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `provinsi`, `hp`, `email`, `hapus`) VALUES
('331239871238912', 'Faraj Fauzi Bashobih Peter', 'Pertanahan Asri 4 12', '1', '1', 'Semarang Timur', 'Ketuban Perahu', 'Semarang', 'Jawa Tengah', '089519563721', 'ichanadhiim@gmail.com', 0),
('3301231823987129', 'Tri Nor Ahfandi', 'Jalan Rak Mutu 3', '1', '12', 'Sambitrasi', 'Semarang Barat', 'Semarang', 'Jawa Tengah', '089624973784', 'ndut@gmail.com', 0),
('3309128312938199', 'Mustafah Najib', 'Jl Asemelahu Raya 2 Gang 3', '1', '12', 'Gunung Pati', 'Sukorejo', 'Kota Semarang', 'Jawa Tengah', '085641144889', 'inoksykesstyles@gmail.com', 0),
('3391827319283718', 'Muhammad Barokkah', 'Jomblang II Raya no 15', '1', '1', 'Aloevera', 'Semarang Barat', 'Kota Semarang', 'Jawa Tengah', '081123190912', 'h4iteam@gmail.com', 1),
('3309123812398712', 'Hendy Cahya Lesmana', 'Perum Taman Kradenan Asri E No 1', '1', '2', 'Gunung Pati', 'Sukorejo', 'Kota Semarang', 'Jawa Tengah', '085641144889', 'h4iteam@gmail.com', 0),
('33012837198237', 'Shabiul Qobil', 'Jendral Sudirman 3 no 12', '1', '2', 'Sukorejo', 'Sambitrasi', 'Semarang', 'Jawa Tengah', '085640772292', 'ichanadhiim@gmail.com', 0),
('3309127381236001', 'Wa Ebod', 'Wawadukanan Raya 2', '1', '2', 'Gunung Pati', 'Sukorejo', 'Semarang', 'Jawa Tengah', '085224578828', 'ichanadhiim@gmail.com', 0),
('3301011130919920', 'M Ichsan Adhiim', 'Perum Taman Kradenan Asri E No 1', '1', '1', 'Sukorejo', 'Gunung Pati', 'Semarang', 'Jawa Tengah', '089519563721', 'ichanadhiim@gmail.com', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_tambahan`
--

CREATE TABLE IF NOT EXISTS `pengeluaran_tambahan` (
  `id_pengeluaran` tinyint(4) NOT NULL AUTO_INCREMENT,
  `tgl_pengeluaran` date NOT NULL,
  `nominal_pengeluaran` int(10) NOT NULL,
  `ket_pengeluaran` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data untuk tabel `pengeluaran_tambahan`
--

INSERT INTO `pengeluaran_tambahan` (`id_pengeluaran`, `tgl_pengeluaran`, `nominal_pengeluaran`, `ket_pengeluaran`) VALUES
(20, '2015-06-30', 8500000, 'Bayar Kontrakan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_biaya_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `status_biaya_pekerjaan` (
  `id_berkas` int(10) NOT NULL,
  `id_detail` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `biaya_bayar` int(10) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `biarkan` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_biaya_pekerjaan`
--

INSERT INTO `status_biaya_pekerjaan` (`id_berkas`, `id_detail`, `status`, `biaya_bayar`, `tgl_bayar`, `biarkan`) VALUES
(1, 905, 1, 3500000, '2015-06-30', 1),
(1, 906, 0, 0, '0000-00-00', 0),
(2, 905, 0, 0, '0000-00-00', 0),
(2, 906, 0, 0, '0000-00-00', 0),
(3, 1602, 0, 0, '0000-00-00', 0),
(3, 1601, 0, 0, '0000-00-00', 0),
(3, 1613, 0, 0, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_detail_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `status_detail_pekerjaan` (
  `id_berkas` int(10) NOT NULL,
  `id_detail` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_detail_pekerjaan`
--

INSERT INTO `status_detail_pekerjaan` (`id_berkas`, `id_detail`, `status`) VALUES
(1, 901, 1),
(1, 902, 1),
(1, 903, 1),
(1, 904, 1),
(1, 905, 1),
(1, 906, 1),
(2, 901, 1),
(2, 902, 1),
(2, 903, 1),
(2, 904, 1),
(2, 905, 1),
(2, 906, 1),
(3, 1601, 0),
(3, 1602, 0),
(3, 1605, 0),
(3, 1610, 0),
(3, 1611, 0),
(3, 1612, 0),
(3, 1613, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_pemohon`
--

CREATE TABLE IF NOT EXISTS `status_pemohon` (
  `id_berkas` int(10) NOT NULL,
  `id_pemohon` varchar(16) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_pemohon`
--

INSERT INTO `status_pemohon` (`id_berkas`, `id_pemohon`, `status`) VALUES
(1, '3301011130919920', 'pemohon'),
(2, '3301011130919920', 'pemohon'),
(3, '3301011130919920', 'penjual'),
(3, '33012837198237', 'pembeli');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_syarat_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `status_syarat_pekerjaan` (
  `id_berkas` int(10) NOT NULL,
  `id_syarat` int(10) NOT NULL,
  `id_ket` tinyint(3) DEFAULT NULL,
  `keterangan` varchar(30) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_syarat_pekerjaan`
--

INSERT INTO `status_syarat_pekerjaan` (`id_berkas`, `id_syarat`, `id_ket`, `keterangan`, `status`) VALUES
(1, 907, 1, 'PT Madikarya Jasa', 1),
(1, 908, 2, 'a.n Mujito', 1),
(1, 908, 3, 'a.n Fastabiq', 1),
(1, 909, 4, 'a.n M Ichsan Adhiim', 1),
(1, 910, 5, 'a.n M Ichsan Adhiim', 1),
(1, 911, 6, 'a.n M Ichsan Adhiim', 1),
(1, 912, 7, '', 1),
(1, 913, 8, '', 1),
(1, 914, 9, '', 1),
(1, 915, 10, '', 1),
(2, 907, 1, 'PT Ichsan', 1),
(2, 908, 2, 'Pendiri A', 1),
(2, 908, 3, 'Pendiri B', 1),
(2, 909, 4, '', 1),
(2, 910, 5, '', 1),
(2, 911, 6, '', 1),
(2, 912, 7, '', 1),
(2, 913, 8, '', 1),
(2, 914, 9, '', 1),
(2, 915, 10, '', 1),
(3, 1601, 1, 'a.n M Ichsan Adhiim', 0),
(3, 1603, 2, 'HM 001', 0),
(3, 1601, 3, 'a.n Shabiul Qobil', 0),
(3, 1606, 4, '', 0),
(3, 1605, 5, '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_tanah`
--

CREATE TABLE IF NOT EXISTS `status_tanah` (
  `id_berkas` int(10) NOT NULL,
  `id_tanah` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status_tanah`
--

INSERT INTO `status_tanah` (`id_berkas`, `id_tanah`) VALUES
(3, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `syarat_pkj`
--

CREATE TABLE IF NOT EXISTS `syarat_pkj` (
  `id_syarat` int(10) NOT NULL,
  `id_pekerjaan` tinyint(3) NOT NULL,
  `syarat` varchar(50) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_syarat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `syarat_pkj`
--

INSERT INTO `syarat_pkj` (`id_syarat`, `id_pekerjaan`, `syarat`, `hapus`) VALUES
(1601, 16, 'Fotokopi KTP', 0),
(101, 1, 'Fotokopi KTP', 0),
(1603, 16, 'Fotokopi Sertipikat', 0),
(102, 1, 'Fotokopi Slip Gaji', 0),
(103, 1, 'Fotokopi Ijazah', 0),
(1604, 16, 'fotokopi KK', 0),
(1605, 16, 'Asli Sertipikat', 0),
(1606, 16, 'Asli SPPT PBB Tahun Terakhir', 0),
(1607, 16, 'Fotokopi SPPT PBB Tahun Terakhir', 0),
(5401, 54, 'Fotokopi KTP', 0),
(5402, 54, 'Fotokopi KK', 0),
(5403, 54, 'NPWP Pengurus', 0),
(5404, 54, 'Fotokopi PBB th terakhir', 0),
(907, 9, 'Nama Perusahaan', 0),
(908, 9, 'Fc. KTP Para Pendiri', 0),
(909, 9, 'Fc. KK Direktur', 0),
(910, 9, 'NPWP Direktur', 0),
(911, 9, 'Pas Foto Direktur 4x6 (2 lembar)', 0),
(912, 9, 'Surat Keterangan Domisili Perusahaan ', 0),
(913, 9, 'Fc PBB tahun terakhir Perusahaan', 0),
(914, 9, 'Fc. Bukti Kepemilikan Tempat Usaha', 0),
(915, 9, 'Denah lokasi tempat usaha', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanah`
--

CREATE TABLE IF NOT EXISTS `tanah` (
  `id_tanah` int(10) NOT NULL AUTO_INCREMENT,
  `id_pemegang_hak` varchar(16) NOT NULL,
  `no_hak` varchar(15) NOT NULL,
  `jenis_hak` varchar(10) NOT NULL,
  `jalan` varchar(100) NOT NULL,
  `rt` varchar(3) NOT NULL,
  `rw` varchar(3) NOT NULL,
  `kelurahan` varchar(30) NOT NULL,
  `kecamatan` varchar(20) NOT NULL,
  `kota` varchar(20) NOT NULL,
  `provinsi` varchar(20) NOT NULL,
  `luas_tanah` int(10) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_tanah`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `tanah`
--

INSERT INTO `tanah` (`id_tanah`, `id_pemegang_hak`, `no_hak`, `jenis_hak`, `jalan`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `provinsi`, `luas_tanah`, `hapus`) VALUES
(11, '331239871238912', 'HM 151', 'Hak Milik', 'Jl Kemesraan 3 no 12', '2', '1', 'Semarang Barat', 'Situgintung', 'Semarang', 'Jawa Tengah', 250, 0),
(10, '331239871238912', 'HM761', 'Hak Milik', 'Jl Maerasari No 22', '1', '2', 'Tembalang', 'Tembalang', 'Semarang', 'Jawa Tengah', 550, 0),
(8, '3391827319283718', 'HM 131', 'Hak Milik', 'Jomblang II Raya no 15', '1', '1', 'Semarang Barat', 'Aloevera', 'Kota Semarang', 'Jawa Tengah', 1200, 0),
(9, '3309123812398712', 'HM132', 'Hak Milik', 'Meteseh Barat 3 no 5', '1', '1', 'Sukorejo', 'Sambitrasi', 'Kota Semarang', 'Jawa Tengah', 2500, 1),
(12, '3301011130919920', 'HM 151', 'Hak Milik', 'Perum Taman Kradenan Asri E No 1', '1', '1', 'Gunung Pati', 'Sukorejo', 'Semarang', 'Jawa Tengah', 1500, 0),
(13, '3309127381236001', 'HM 123', 'Hak Milik', 'Wawadukanan Raya 2', '1', '2', 'Gunung Pati', 'Sukorejo', 'Semarang', 'Jawa Tengah', 500, 0),
(14, '3301011130919920', 'HM 001', 'Hak Milik', 'Jalan Merdeka 1 No 2', '1', '2', 'Semarang Selatan', 'Tembalang', 'Semarang', 'Jawa Tengah', 500, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` tinyint(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hak_akses` tinyint(1) NOT NULL,
  `hapus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `hak_akses`, `hapus`) VALUES
(32, 'staff2', '827ccb0eea8a706c4c34a16891f84e7b', 'ichanadhiim@gmail.com', 2, 0),
(17, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'ichanadhiim@gmail.com', 1, 0),
(12, 'staffkhusus', '827ccb0eea8a706c4c34a16891f84e7b', 'ichanadhiim@gmail.com', 3, 0),
(29, 'staff', '827ccb0eea8a706c4c34a16891f84e7b', 'ichanadhiim@gmail.com', 2, 0),
(31, 'notaris', '96f73166fc658b9489e45c4deb35c4de', 'ichanadhiim@gmail.com', 0, 0),
(33, 'ichan', '827ccb0eea8a706c4c34a16891f84e7b', 'ichanadhiim@gmail.com', 2, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewkerja`
--
CREATE TABLE IF NOT EXISTS `viewkerja` (
`id_pekerjaan` tinyint(3)
,`nama_pekerjaan` varchar(50)
,`id_detail` int(10)
,`langkah_pekerjaan` varchar(50)
,`biaya_default` int(10)
,`hapus` tinyint(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewpkmasuk`
--
CREATE TABLE IF NOT EXISTS `viewpkmasuk` (
`id_berkas` int(10)
,`tgl_masuk_pekerjaan` date
,`tgl_diterima_pekerjaan` date
,`tgl_selesai_pekerjaan` date
,`biaya_klien` int(20)
,`biaya_titip` decimal(32,0)
,`lokasi_penyimpanan` varchar(20)
,`id_pekerjaan` tinyint(3)
,`status` tinyint(1)
,`hapus` tinyint(1)
,`nama_pekerjaan` varchar(50)
,`nama_instansi` varchar(50)
,`id_tanah` int(10)
,`no_hak` varchar(15)
,`id_user` tinyint(2)
,`username` varchar(20)
,`jenis_aktor` varchar(10)
,`id_pemohon` varchar(16)
,`id_penjual` varchar(16)
,`id_pembeli` varchar(16)
,`nama_pemohon` varchar(30)
,`nama_penjual` varchar(30)
,`nama_pembeli` varchar(30)
,`detail` bigint(21)
,`jml_detail` bigint(21)
,`syarat` bigint(21)
,`jml_syarat` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewstatbiaya`
--
CREATE TABLE IF NOT EXISTS `viewstatbiaya` (
`id_berkas` int(10)
,`id_detail` int(10)
,`status` tinyint(1)
,`biaya_bayar` int(10)
,`tgl_bayar` date
,`biarkan` tinyint(1)
,`langkah_pekerjaan` varchar(50)
,`biaya_default` int(10)
,`biaya_pekerjaan` int(10)
,`stat_pekerjaan` tinyint(1)
,`hapus_pekerjaan` tinyint(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewstatdetail`
--
CREATE TABLE IF NOT EXISTS `viewstatdetail` (
`id_berkas` int(10)
,`id_detail` int(10)
,`status` tinyint(1)
,`langkah_pekerjaan` varchar(50)
,`biaya_default` int(10)
,`biaya_pekerjaan` int(10)
,`status_biaya` tinyint(1)
,`biaya_bayar` int(10)
,`biarkan` tinyint(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewstatsyarat`
--
CREATE TABLE IF NOT EXISTS `viewstatsyarat` (
`id_berkas` int(10)
,`id_syarat` int(10)
,`id_ket` tinyint(3)
,`keterangan` varchar(30)
,`status` tinyint(1)
,`syarat` varchar(50)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtanah`
--
CREATE TABLE IF NOT EXISTS `viewtanah` (
`id_tanah` int(10)
,`nama_pemohon` varchar(30)
,`no_hak` varchar(15)
,`jenis_hak` varchar(10)
,`jalan` varchar(100)
,`rt` varchar(3)
,`rw` varchar(3)
,`kelurahan` varchar(30)
,`kecamatan` varchar(20)
,`kota` varchar(20)
,`provinsi` varchar(20)
,`luas_tanah` int(10)
,`hapus` tinyint(1)
);
-- --------------------------------------------------------

--
-- Structure for view `viewkerja`
--
DROP TABLE IF EXISTS `viewkerja`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewkerja` AS select `a`.`id_pekerjaan` AS `id_pekerjaan`,`a`.`nama_pekerjaan` AS `nama_pekerjaan`,`b`.`id_detail` AS `id_detail`,`b`.`langkah_pekerjaan` AS `langkah_pekerjaan`,`c`.`biaya_default` AS `biaya_default`,`a`.`hapus` AS `hapus` from ((`jenis_pekerjaan` `a` left join `detail_pekerjaan` `b` on((`a`.`id_pekerjaan` = `b`.`id_pekerjaan`))) left join `biaya_default_pekerjaan` `c` on((`b`.`id_detail` = `c`.`id_detail`))) order by `a`.`id_pekerjaan`;

-- --------------------------------------------------------

--
-- Structure for view `viewpkmasuk`
--
DROP TABLE IF EXISTS `viewpkmasuk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpkmasuk` AS select `a`.`id_berkas` AS `id_berkas`,`a`.`tgl_masuk_pekerjaan` AS `tgl_masuk_pekerjaan`,`a`.`tgl_diterima_pekerjaan` AS `tgl_diterima_pekerjaan`,`a`.`tgl_selesai_pekerjaan` AS `tgl_selesai_pekerjaan`,`a`.`biaya_klien` AS `biaya_klien`,(select sum(`biaya_titip`.`biaya_titip`) AS `SUM(biaya_titip)` from `biaya_titip` where (`biaya_titip`.`id_berkas` = `a`.`id_berkas`)) AS `biaya_titip`,`a`.`lokasi_penyimpanan` AS `lokasi_penyimpanan`,`a`.`id_pekerjaan` AS `id_pekerjaan`,`a`.`status` AS `status`,`a`.`hapus` AS `hapus`,`k`.`nama_pekerjaan` AS `nama_pekerjaan`,`b`.`nama_instansi` AS `nama_instansi`,`c`.`id_tanah` AS `id_tanah`,`l`.`no_hak` AS `no_hak`,`j`.`id_user` AS `id_user`,`j`.`username` AS `username`,`k`.`jenis_aktor` AS `jenis_aktor`,`d`.`id_pemohon` AS `id_pemohon`,`e`.`id_pemohon` AS `id_penjual`,`f`.`id_pemohon` AS `id_pembeli`,`g`.`nama_pemohon` AS `nama_pemohon`,`h`.`nama_pemohon` AS `nama_penjual`,`i`.`nama_pemohon` AS `nama_pembeli`,(select count(`status_detail_pekerjaan`.`status`) AS `COUNT(status)` from `status_detail_pekerjaan` where ((`status_detail_pekerjaan`.`id_berkas` = `a`.`id_berkas`) and (`status_detail_pekerjaan`.`status` = '1'))) AS `detail`,(select count(`detail_pekerjaan`.`id_detail`) AS `COUNT(id_detail)` from `detail_pekerjaan` where (`detail_pekerjaan`.`id_pekerjaan` = `a`.`id_pekerjaan`)) AS `jml_detail`,(select count(`status_syarat_pekerjaan`.`status`) AS `COUNT(status)` from `status_syarat_pekerjaan` where ((`status_syarat_pekerjaan`.`id_berkas` = `a`.`id_berkas`) and (`status_syarat_pekerjaan`.`status` = '1'))) AS `syarat`,(select count(`status_syarat_pekerjaan`.`id_syarat`) AS `COUNT(id_syarat)` from `status_syarat_pekerjaan` where (`status_syarat_pekerjaan`.`id_berkas` = `a`.`id_berkas`)) AS `jml_syarat` from (((((((((((`pekerjaan` `a` left join `instansi` `b` on((`a`.`id_berkas` = `b`.`id_berkas`))) left join `status_tanah` `c` on((`a`.`id_berkas` = `c`.`id_berkas`))) left join `status_pemohon` `d` on(((`a`.`id_berkas` = `d`.`id_berkas`) and (`d`.`status` = 'pemohon')))) left join `status_pemohon` `e` on(((`a`.`id_berkas` = `e`.`id_berkas`) and (`e`.`status` = 'penjual')))) left join `status_pemohon` `f` on(((`a`.`id_berkas` = `f`.`id_berkas`) and (`f`.`status` = 'pembeli')))) left join `pemohon` `g` on((`d`.`id_pemohon` = `g`.`id_pemohon`))) left join `pemohon` `h` on((`e`.`id_pemohon` = `h`.`id_pemohon`))) left join `pemohon` `i` on((`f`.`id_pemohon` = `i`.`id_pemohon`))) left join `user` `j` on((`a`.`id_user` = `j`.`id_user`))) left join `jenis_pekerjaan` `k` on((`a`.`id_pekerjaan` = `k`.`id_pekerjaan`))) left join `tanah` `l` on((`c`.`id_tanah` = `l`.`id_tanah`)));

-- --------------------------------------------------------

--
-- Structure for view `viewstatbiaya`
--
DROP TABLE IF EXISTS `viewstatbiaya`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewstatbiaya` AS select `a`.`id_berkas` AS `id_berkas`,`a`.`id_detail` AS `id_detail`,`a`.`status` AS `status`,`a`.`biaya_bayar` AS `biaya_bayar`,`a`.`tgl_bayar` AS `tgl_bayar`,`a`.`biarkan` AS `biarkan`,`b`.`langkah_pekerjaan` AS `langkah_pekerjaan`,`c`.`biaya_default` AS `biaya_default`,`d`.`biaya_pekerjaan` AS `biaya_pekerjaan`,`e`.`status` AS `stat_pekerjaan`,`e`.`hapus` AS `hapus_pekerjaan` from ((((`status_biaya_pekerjaan` `a` left join `detail_pekerjaan` `b` on((`a`.`id_detail` = `b`.`id_detail`))) left join `biaya_default_pekerjaan` `c` on((`a`.`id_detail` = `c`.`id_detail`))) left join `biaya_detail_pekerjaan` `d` on(((`a`.`id_berkas` = `d`.`id_berkas`) and (`a`.`id_detail` = `d`.`id_detail`)))) left join `pekerjaan` `e` on((`a`.`id_berkas` = `e`.`id_berkas`)));

-- --------------------------------------------------------

--
-- Structure for view `viewstatdetail`
--
DROP TABLE IF EXISTS `viewstatdetail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewstatdetail` AS select `a`.`id_berkas` AS `id_berkas`,`a`.`id_detail` AS `id_detail`,`a`.`status` AS `status`,`b`.`langkah_pekerjaan` AS `langkah_pekerjaan`,`c`.`biaya_default` AS `biaya_default`,`d`.`biaya_pekerjaan` AS `biaya_pekerjaan`,`e`.`status` AS `status_biaya`,`e`.`biaya_bayar` AS `biaya_bayar`,`e`.`biarkan` AS `biarkan` from ((((`status_detail_pekerjaan` `a` left join `detail_pekerjaan` `b` on((`a`.`id_detail` = `b`.`id_detail`))) left join `biaya_default_pekerjaan` `c` on((`a`.`id_detail` = `c`.`id_detail`))) left join `biaya_detail_pekerjaan` `d` on(((`a`.`id_berkas` = `d`.`id_berkas`) and (`a`.`id_detail` = `d`.`id_detail`)))) left join `status_biaya_pekerjaan` `e` on(((`a`.`id_berkas` = `e`.`id_berkas`) and (`a`.`id_detail` = `e`.`id_detail`)))) order by `a`.`id_berkas`;

-- --------------------------------------------------------

--
-- Structure for view `viewstatsyarat`
--
DROP TABLE IF EXISTS `viewstatsyarat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewstatsyarat` AS select `a`.`id_berkas` AS `id_berkas`,`a`.`id_syarat` AS `id_syarat`,`a`.`id_ket` AS `id_ket`,`a`.`keterangan` AS `keterangan`,`a`.`status` AS `status`,`b`.`syarat` AS `syarat` from (`status_syarat_pekerjaan` `a` left join `syarat_pkj` `b` on((`a`.`id_syarat` = `b`.`id_syarat`)));

-- --------------------------------------------------------

--
-- Structure for view `viewtanah`
--
DROP TABLE IF EXISTS `viewtanah`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtanah` AS select `a`.`id_tanah` AS `id_tanah`,`b`.`nama_pemohon` AS `nama_pemohon`,`a`.`no_hak` AS `no_hak`,`a`.`jenis_hak` AS `jenis_hak`,`a`.`jalan` AS `jalan`,`a`.`rt` AS `rt`,`a`.`rw` AS `rw`,`a`.`kelurahan` AS `kelurahan`,`a`.`kecamatan` AS `kecamatan`,`a`.`kota` AS `kota`,`a`.`provinsi` AS `provinsi`,`a`.`luas_tanah` AS `luas_tanah`,`a`.`hapus` AS `hapus` from (`tanah` `a` left join `pemohon` `b` on((`a`.`id_pemegang_hak` = `b`.`id_pemohon`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
