-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2026 at 02:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Modemai`
--

-- --------------------------------------------------------

--
-- Table structure for table `Informacija`
--

CREATE TABLE `Informacija` (
  `Id` int(11) NOT NULL,
  `Moketojo_kodas` varchar(15) NOT NULL,
  `Strukturinis_padalinis` varchar(30) NOT NULL,
  `Pareigos` varchar(30) NOT NULL,
  `Vardas_pavarde` varchar(100) NOT NULL,
  `Telefono_nr` varchar(30) NOT NULL,
  `IP` varchar(30) NOT NULL,
  `ICCID` varchar(40) NOT NULL,
  `M_parasas` tinyint(1) NOT NULL,
  `Pastaba` text NOT NULL,
  `Modemas` varchar(60) NOT NULL,
  `Teritorija_Id` int(11) NOT NULL,
  `Teikejas` enum('Bitė','Tele2','Telia','Pildyk','Labas','Ežys') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Teritorija`
--

CREATE TABLE `Teritorija` (
  `Id` int(11) NOT NULL,
  `Teritorinis_padalinis` varchar(100) NOT NULL,
  `Adresas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Teritorija`
--

INSERT INTO `Teritorija` (`Id`, `Teritorinis_padalinis`, `Adresas`) VALUES
(1, 'Vilnius', 'Švitrigailos g. 18'),
(2, 'Kaunas', 'Nemuno g. 2-1'),
(3, 'Šiauliai', 'J. Basanavičiaus g. 89'),
(4, 'Klaipėda', 'Trilapio g. 12'),
(5, 'Panevėžys', 'Ramygalos g. 14 ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Informacija`
--
ALTER TABLE `Informacija`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Teritorija_Id` (`Teritorija_Id`);

--
-- Indexes for table `Teritorija`
--
ALTER TABLE `Teritorija`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Informacija`
--
ALTER TABLE `Informacija`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Teritorija`
--
ALTER TABLE `Teritorija`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Informacija`
--
ALTER TABLE `Informacija`
  ADD CONSTRAINT `fk_Informacija_Teritorija` FOREIGN KEY (`Teritorija_Id`) REFERENCES `Teritorija` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
