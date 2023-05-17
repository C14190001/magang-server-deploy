-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 06:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magang-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'a', '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(5) NOT NULL,
  `updated?` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `updated?`) VALUES
(1, 1),
(2, 1),
(3, 0),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `client_apps`
--

CREATE TABLE `client_apps` (
  `id` int(5) NOT NULL,
  `apps` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_apps`
--

INSERT INTO `client_apps` (`id`, `apps`) VALUES
(1, '7-Zip 22.01 (x64)/Avast Free Antivirus/Microsoft Visual C++ 2022 X64 Minimum Runtime - 14.34.31938/Microsoft .NET Framework 4.8/VMware Tools/Microsoft Visual C++ 2022 X64 Additional Runtime - 14.34.31938/Microsoft .NET Framework 4.8/'),
(2, '7-Zip 22.01 (x64)/Audacity 3.2.5/FFmpeg 5.0.0 for Audacity - x86_64/Git/PPSSPP/Microsoft Office LTSC Professional Plus 2021 - en-us/Unity Hub 3.4.1/XAMPP/Microsoft.NET.Sdk.MacCatalyst.Manifest-7.0.100 (x64)/Python 3.8.13 Development Libraries (64-bit)/Microsoft .NET AppHost Pack - 6.0.16 (x64)/Microsoft Visual C++ 2022 X64 Minimum Runtime - 14.34.31938/Windows SDK DirectX x64 Remote/Microsoft.NET.Workload.Mono.Toolchain.net7.Manifest (x64)/Microsoft ASP.NET Core 6.0.16 Shared Framework (x64)/Microsoft Windows Desktop Runtime - 7.0.5 (x64)/MySQL Server 8.0/Microsoft ASP.NET Core 7.0.5 Targeting Pack (x64)/Microsoft.NET.Workload.Mono.Toolchain.net6.Manifest (x64)/Microsoft.NET.Sdk.iOS.Manifest-7.0.100 (x64)/Microsoft .NET AppHost Pack - 6.0.16 (x64_arm)/Microsoft.NET.Workload.Emscripten.net6.Manifest (x64)/Application Verifier x64 External Package/Microsoft.NET.Sdk.macOS.Manifest-7.0.100 (x64)/Microsoft .NET Targeting Pack - 7.0.5 (x64)/vs_devenx64vmsi/vs_Graphics_Singletonx64/Microsoft .NET AppHost Pack - 6.0.16 (x64_arm64)/Microsoft.NET.Sdk.Android.Manifest-7.0.100 (x64)/Microsoft System CLR Types for SQL Server 2019/Microsoft.NET.Sdk.tvOS.Manifest-7.0.100 (x64)/Windows App Certification Kit Native Components/Microsoft Visual Studio Installer/MySQL Connector C++ 1.1.11/Microsoft ASP.NET Core 6.0.16 Targeting Pack (x64)/Microsoft .NET AppHost Pack - 7.0.5 (x64_arm64)/Microsoft .NET Runtime - 7.0.5 (x64)/VS JIT Debugger/Microsoft Visual C++ 2022 X64 Additional Runtime - 14.34.31938/Microsoft Windows Desktop Runtime - 6.0.16 (x64)/Microsoft .NET 6.0 Templates 7.0.203 (x64)/Universal CRT Tools x64/Python 3.8.13 Standard Library (64-bit)/Microsoft Update Health Tools/Microsoft .NET AppHost Pack - 7.0.5 (x64)/Python 3.8.13 Executables (64-bit)/Office 16 Click-to-Run Licensing Component/Office 16 Click-to-Run Extensibility Component/Microsoft Visual C++ 2013 x64 Additional Runtime - 12.0.21005/Microsoft Visual C++ 2022 X64 Debug Runtime - 14.34.31938/Microsoft .NET AppHost Pack - 7.0.5 (x64_x86)/Microsoft .NET Targeting Pack - 6.0.16 (x64)/Microsoft .NET Standard Targeting Pack - 2.1.0 (x64)/Microsoft Visual C++ 2013 x64 Minimum Runtime - 12.0.21005/Microsoft .NET 7.0 Templates 7.0.203 (x64)/Python 3.8.13 pip Bootstrap (64-bit)/Microsoft .NET AppHost Pack - 7.0.5 (x64_arm)/NVIDIA Graphics Driver 531.61/NVIDIA PhysX System Software 9.21.0713/NVIDIA Install Application/Microsoft .NET Host FX Resolver - 7.0.5 (x64)/Microsoft.NET.Workload.Emscripten.net7.Manifest (x64)/SyncTrayzor (x64) version 1.1.29.0/Python 3.8.13 Documentation (64-bit)/Microsoft .NET Runtime - 6.0.16 (x64)/Microsoft .NET Toolset 7.0.203 (x64)/VS Script Debugging Common/vs_communityx64msi/Microsoft Windows Desktop Targeting Pack - 7.0.5 (x64)/Microsoft .NET Host - 7.0.5 (x64)/Python 3.8.13 Add to Path (64-bit)/Python 3.8.13 Core Interpreter (64-bit)/Microsoft ASP.NET Core 7.0.5 Shared Framework (x64)/Python 3.8.13 Test Suite (64-bit)/Microsoft .NET SDK 7.0.203 (x64) from Visual Studio/Microsoft Visual C++ 2010  x64 Redistributable - 10.0.30319/vs_minshellinteropx64msi/Microsoft Windows Desktop Targeting Pack - 6.0.16 (x64)/VMware Player/Microsoft .NET AppHost Pack - 6.0.16 (x64_x86)/Microsoft.NET.Sdk.Maui.Manifest-7.0.100 (x64)/icecap_collection_x64/vs_minshellx64msi/Python 3.8.13 Utility Scripts (64-bit)/IntelliTraceProfilerProxy/Epic Games Launcher Prerequisites (x64)/Python 3.8.13 Tcl/Tk Support (64-bit)/DiagnosticsHub_CollectionService/'),
(4, 'Oracle VM VirtualBox Guest Additions 7.0.8/Microsoft .NET Framework 4.7.2/Microsoft Visual C++ 2022 X64 Minimum Runtime - 14.34.31938/Microsoft Visual C++ 2022 X64 Additional Runtime - 14.34.31938/Microsoft .NET Framework 4.7.2/'),
(5, 'Oracle VM VirtualBox Guest Additions 7.0.8/Microsoft .NET Framework 4.7.2/Microsoft Visual C++ 2022 X64 Minimum Runtime - 14.34.31938/Microsoft Visual C++ 2022 X64 Additional Runtime - 14.34.31938/Microsoft .NET Framework 4.7.2/'),
(6, 'Oracle VM VirtualBox Guest Additions 7.0.8/Microsoft .NET Framework 4.7.2/Microsoft Visual C++ 2022 X64 Minimum Runtime - 14.34.31938/Microsoft Visual C++ 2022 X64 Additional Runtime - 14.34.31938/Microsoft .NET Framework 4.7.2/');

-- --------------------------------------------------------

--
-- Table structure for table `client_specs`
--

CREATE TABLE `client_specs` (
  `id` int(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `cpu` varchar(50) NOT NULL,
  `i-gpu` varchar(30) NOT NULL,
  `e-gpu` varchar(30) NOT NULL DEFAULT 'N/A',
  `ram` int(5) NOT NULL,
  `memory` int(5) NOT NULL,
  `ip` varchar(150) NOT NULL,
  `mac` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_specs`
--

INSERT INTO `client_specs` (`id`, `name`, `cpu`, `i-gpu`, `e-gpu`, `ram`, `memory`, `ip`, `mac`) VALUES
(1, 'WINDOWS7VM-PC', 'Intel(R) Core(TM) i7-8750H CPU @ 2.20GHz', 'VMware SVGA 3D', 'N/A', 2, 29, '192.168.17.128/', '00-50-56-EB-3A-E1/00-0C-29-2E-B5-1E/00-00-00-00-00-00-00-E0/00-00-00-00-00-00-00-E0/'),
(2, 'DESKTOP-DHMSR2T', 'Intel(R) Core(TM) i7-8750H CPU @ 2.20GHz', 'Intel(R) UHD Graphics 630', 'NVIDIA GeForce GTX 1050', 16, 715, '192.168.47.1/192.168.17.1/192.168.18.5/', '00-D8-61-03-B8-67/DC-8B-28-82-F0-C4/DE-8B-28-82-F0-C3/00-50-56-C0-00-01/00-50-56-C0-00-08/DC-8B-28-82-F0-C3/DC-8B-28-82-F0-C7/'),
(4, 'WIN7-PC', 'Intel(R) Core(TM) i7-8750H CPU @ 2.20GHz', 'VirtualBox Graphics Adapter (W', 'N/A', 0, 19, '10.0.2.15/', '08-00-27-E8-58-4E/00-00-00-00-00-00-00-E0/'),
(5, 'WIN7-PC-1', 'Intel(R) Core(TM) i7-8750H CPU @ 2.20GHz', 'VirtualBox Graphics Adapter (W', 'N/A', 0, 19, '10.0.2.15/', '08-00-27-E8-58-4E/00-00-00-00-00-00-00-E0/'),
(6, 'WIN7-PC-2', 'Intel(R) Core(TM) i7-8750H CPU @ 2.20GHz', 'VirtualBox Graphics Adapter (W', 'N/A', 0, 19, '10.0.2.15/', '08-00-27-BC-27-8F/00-00-00-00-00-00-00-E0/');

-- --------------------------------------------------------

--
-- Table structure for table `client_status`
--

CREATE TABLE `client_status` (
  `id` int(5) NOT NULL,
  `status` varchar(15) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_status`
--

INSERT INTO `client_status` (`id`, `status`, `date_time`) VALUES
(1, 'ON', '2023-04-14 22:04:32'),
(1, 'OFF', '2023-04-14 22:05:32'),
(1, 'ON', '2023-04-17 20:08:13'),
(1, 'OFF', '2023-04-17 20:22:28'),
(1, 'ON', '2023-04-18 17:11:52'),
(1, 'OFF', '2023-04-18 17:24:41'),
(1, 'ON', '2023-04-18 17:28:16'),
(1, 'OFF', '2023-04-18 18:07:29'),
(2, 'ON', '2023-04-04 19:59:37'),
(2, 'ON', '2023-04-04 20:00:59'),
(2, 'ON', '2023-04-04 20:01:38'),
(2, 'ON', '2023-04-19 11:36:16'),
(2, 'ON', '2023-04-19 11:36:34'),
(2, 'ON', '2023-04-19 11:37:44'),
(2, 'ON', '2023-04-19 11:46:18'),
(1, 'ON', '2023-04-19 12:35:31'),
(1, 'ON', '2023-04-19 12:38:12'),
(1, 'ON', '2023-04-19 12:39:10'),
(1, 'ON', '2023-04-19 12:42:16'),
(1, 'ON', '2023-04-19 12:42:57'),
(1, 'ON', '2023-04-19 12:45:53'),
(1, 'ON', '2023-04-19 12:46:21'),
(1, 'OFF', '2023-04-19 12:48:44'),
(2, 'ON', '2023-04-19 12:49:47'),
(1, 'ON', '2023-04-19 12:51:42'),
(1, 'ON', '2023-04-19 12:52:40'),
(1, 'ON', '2023-04-19 12:52:59'),
(2, 'OFF', '2023-04-19 12:55:43'),
(1, 'OFF', '2023-04-19 13:13:31'),
(2, 'ON', '2023-04-19 14:33:49'),
(2, 'OFF', '2023-04-19 14:35:26'),
(1, 'OFF', '2023-04-27 08:41:31'),
(1, 'ON', '2023-04-27 08:43:06'),
(1, 'OFF', '2023-04-27 08:50:34'),
(2, 'ON', '2023-05-02 15:12:11'),
(1, 'OFF', '2023-05-02 15:12:44'),
(1, 'ON', '2023-05-02 15:13:40'),
(1, 'OFF', '2023-05-02 15:13:51'),
(1, 'ON', '2023-05-02 15:25:48'),
(1, 'OFF', '2023-05-02 15:30:24'),
(1, 'ON', '2023-05-02 15:30:33'),
(1, 'OFF', '2023-05-02 15:30:44'),
(1, 'ON', '2023-05-02 15:31:03'),
(1, 'OFF', '2023-05-02 15:34:50'),
(1, 'ON', '2023-05-02 15:34:59'),
(2, 'OFF', '2023-05-02 16:25:16'),
(2, 'ON', '2023-05-08 13:19:29'),
(2, 'ON', '2023-05-08 13:19:44'),
(2, 'ON', '2023-05-08 13:21:53'),
(2, 'OFF', '2023-05-08 13:47:58'),
(1, 'OFF', '2023-05-08 13:48:17'),
(1, 'Disconnected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:32'),
(1, 'Connected', '2023-05-08 13:49:32'),
(1, 'Connected', '2023-05-08 13:49:32'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:33'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'Connected', '2023-05-08 13:49:34'),
(1, 'OFF', '2023-05-08 13:57:45'),
(1, 'ON', '2023-05-08 14:00:01'),
(1, 'OFF', '2023-05-08 14:14:22'),
(1, 'ON', '2023-05-08 14:14:58'),
(1, 'OFF', '2023-05-08 14:15:45'),
(1, 'ON', '2023-05-08 14:16:56'),
(1, 'OFF', '2023-05-08 14:18:48'),
(4, 'ON', '2023-05-08 18:00:47'),
(4, 'OFF', '2023-05-08 18:02:29'),
(4, 'ON', '2023-05-08 18:02:46'),
(4, 'OFF', '2023-05-08 18:03:14'),
(4, 'ON', '2023-05-08 18:32:53'),
(4, 'OFF', '2023-05-08 18:35:26'),
(5, 'ON', '2023-05-08 18:40:13'),
(6, 'ON', '2023-05-08 18:41:00'),
(6, 'OFF', '2023-05-08 18:42:22'),
(5, 'OFF', '2023-05-08 18:42:38'),
(5, 'ON', '2023-05-08 18:43:36'),
(5, 'OFF', '2023-05-08 18:44:27'),
(5, 'ON', '2023-05-08 18:44:45'),
(5, 'OFF', '2023-05-08 18:45:17'),
(6, 'ON', '2023-05-08 18:45:42'),
(6, 'OFF', '2023-05-08 18:46:27'),
(6, 'ON', '2023-05-08 18:46:44'),
(6, 'OFF', '2023-05-08 18:47:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_apps`
--
ALTER TABLE `client_apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_specs`
--
ALTER TABLE `client_specs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
