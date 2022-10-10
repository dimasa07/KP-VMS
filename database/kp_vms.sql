/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.24-MariaDB : Database - kp_vms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kp_vms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `kp_vms`;

/*Table structure for table `akun` */

DROP TABLE IF EXISTS `buku_tamu`;
DROP TABLE IF EXISTS `permintaan_bertamu`;
DROP TABLE IF EXISTS `tamu`;
DROP TABLE IF EXISTS `pegawai`;
DROP TABLE IF EXISTS `akun`;



CREATE TABLE `akun` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('TAMU','ADMIN','FRONT OFFICE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akun_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `tamu` */



CREATE TABLE `tamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tamu_nik_unique` (`nik`),
  KEY `tamu_id_akun_foreign` (`id_akun`),
  CONSTRAINT `tamu_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `pegawai` */



CREATE TABLE `pegawai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawai_nip_unique` (`nip`),
  KEY `pegawai_id_akun_foreign` (`id_akun`),
  CONSTRAINT `pegawai_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `permintaan_bertamu` */



CREATE TABLE `permintaan_bertamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tamu` int(10) unsigned NOT NULL,
  `id_admin` int(10) unsigned DEFAULT NULL,
  `id_pegawai` int(10) unsigned NOT NULL,
  `keperluan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_bertamu` datetime DEFAULT NULL,
  `waktu_pengiriman` datetime DEFAULT NULL,
  `waktu_pemeriksaan` datetime DEFAULT NULL,
  `status` enum('BELUM DIPERIKSA','DISETUJUI','DITOLAK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM DIPERIKSA',
  `pesan_ditolak` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_bertamu_id_tamu_foreign` (`id_tamu`),
  KEY `permintaan_bertamu_id_admin_foreign` (`id_admin`),
  KEY `permintaan_bertamu_id_pegawai_foreign` (`id_pegawai`),
  CONSTRAINT `permintaan_bertamu_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permintaan_bertamu_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permintaan_bertamu_id_tamu_foreign` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/*Table structure for table `buku_tamu` */



CREATE TABLE `buku_tamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_front_office` int(10) unsigned NOT NULL,
  `id_permintaan` int(10) unsigned NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `buku_tamu_id_permintaan_unique` (`id_permintaan`),
  KEY `buku_tamu_id_front_office_foreign` (`id_front_office`),
  CONSTRAINT `buku_tamu_id_front_office_foreign` FOREIGN KEY (`id_front_office`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `buku_tamu_id_permintaan_foreign` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_bertamu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/*Data for the table `akun` */

insert  into `akun`(`id`,`role`,`username`,`password`) values 
(1,'ADMIN','admin','admin'),
(2,'FRONT OFFICE','frontoffice','frontoffice'),
(3,'TAMU','tamu','tamu'),
(4,'TAMU','tamu2','tamu2'),
(5,'TAMU','tamu3','tamu3'),
(6,'TAMU','tamu4','tamu4'),
(7,'TAMU','tamu5','tamu5'),
(8,'ADMIN','admin2','admin2'),
(9,'ADMIN','admin3','admin3'),
(10,'ADMIN','admin4','admin4'),
(11,'ADMIN','admin5','admin5'),
(12,'FRONT OFFICE','frontoffice2','frontoffice2'),
(14,'FRONT OFFICE','frontoffice3','frontoffice3'),
(15,'FRONT OFFICE','frontoffice4','frontoffice4'),
(16,'FRONT OFFICE','frontoffice5','frontoffice5');

/*Data for the table `tamu` */

insert  into `tamu`(`id`,`nik`,`nama`,`no_telepon`,`email`,`alamat`,`id_akun`) values 
(1,'10001','TAMU 1','081234561001','tamu@gmail.com',NULL,3),
(2,'10002','TAMU 2','0891289221','tam','Dago',4),
(3,'10003','TAMU 3','08989189212','tamu3@gmail.com','Soreang',5),
(4,'10004','TAMU 4','08989282222','tamu4@gmail.com','Dago',6),
(5,'10005','TAMU 5','08999121221','tamu5@gmail.com','Cibiru',7);

/*Data for the table `pegawai` */

insert  into `pegawai`(`id`,`nip`,`nama`,`no_telepon`,`email`,`jabatan`,`alamat`,`id_akun`) values 
(1,'1','Admin Diskominfo','081234567891','admin@gmail.com',NULL,NULL,1),
(2,'101','FO Diskominfo','081234567101','fo@gmail.com',NULL,NULL,2),
(3,'1001','Pegawai 1','081234510001','pegawai@gmail.com',NULL,NULL,NULL),
(4,'1002','Pegawai 2','081234510002','pegawai2@gmail.com',NULL,NULL,NULL),
(5,'1003','Pegawai 3','081234510003','pegawai3@gmail.com',NULL,NULL,NULL),
(6,'2','Admin 2','0818911331','admin2@gmail.com',NULL,NULL,8),
(7,'3','Admin 3','018198313','admin3@gmail.com',NULL,NULL,9),
(8,'4','Admin 4','0813133333','admin4@gmail.com',NULL,NULL,10),
(9,'5','Admin 5','0839283333','admin5@gmail.com',NULL,NULL,11),
(10,'102','Front Office 2','0812131323','fo2@gmail.com',NULL,NULL,12),
(11,'103','Front Office 3','0812123333','fo3@gmail.com',NULL,NULL,14),
(12,'104','Front Office 4','0839492222','fo4@gmail.com',NULL,NULL,15),
(13,'105','Front Office 5','0833444444','fo5@gmail.com',NULL,NULL,16);

/*Data for the table `permintaan_bertamu` */

insert  into `permintaan_bertamu`(`id`,`id_tamu`,`id_admin`,`id_pegawai`,`keperluan`,`waktu_bertamu`,`waktu_pengiriman`,`waktu_pemeriksaan`,`status`,`pesan_ditolak`) values 
(1,1,1,3,'Al','2022-10-07 15:07:37','2022-10-07 10:44:01','2022-10-08 22:42:53','DISETUJUI',NULL),
(2,2,2,5,'Testing','2022-10-08 13:05:49','2022-10-08 13:05:54','2022-10-08 13:05:59','BELUM DIPERIKSA',NULL),
(4,3,3,4,'Laporan','2022-10-08 13:06:44','2022-10-08 13:06:48','2022-10-09 01:42:07','BELUM DIPERIKSA',NULL),
(5,4,4,5,'Wawancara','2022-10-08 15:36:02','2022-10-08 15:36:05','2022-10-09 01:40:49','BELUM DIPERIKSA',NULL),
(7,5,5,6,'Penelitian','2022-09-27 10:10:10','2022-10-08 22:51:40','2022-10-09 01:21:28','BELUM DIPERIKSA','a'),
(8,2,1,7,'Penelitian','2022-09-27 10:10:10','2022-10-08 22:51:45','2022-10-09 01:39:04','DITOLAK',NULL);

/*Data for the table `buku_tamu` */

insert  into `buku_tamu`(`id`,`id_front_office`,`id_permintaan`,`check_in`,`check_out`) values 
(1,1,1,'2022-10-08 09:59:59','2022-10-08 10:00:02'),
(2,11,4,'2022-10-09 07:47:35','2022-10-07 07:47:38'),
(3,12,2,'2022-10-11 07:47:59','2022-10-14 07:48:04'),
(7,13,5,'2022-10-06 07:48:14','2022-10-14 07:48:21');