-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 15, 2018 at 01:00 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ricibo-prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `APP_TEST`
--

CREATE TABLE IF NOT EXISTS `APP_TEST` (
`ID` int(11) NOT NULL,
  `cel` varchar(14) DEFAULT NULL,
  `gps_x` double DEFAULT NULL,
  `gps_y` double DEFAULT NULL,
  `data_ins` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APERTURA`
--

CREATE TABLE IF NOT EXISTS `TB_APERTURA` (
`ID_APERTURE` int(11) NOT NULL,
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_NEG_ASS` int(11) DEFAULT NULL,
  `GIORNO_SETTIMANA` int(11) DEFAULT NULL,
  `ORA1_APER` time DEFAULT NULL,
  `ORA1_CHIU` time DEFAULT NULL,
  `ORA2_APER` time DEFAULT NULL,
  `ORA2_CHIU` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APER_EXTRA`
--

CREATE TABLE IF NOT EXISTS `TB_APER_EXTRA` (
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_NEG_ASS` int(11) NOT NULL,
  `GIORNO_CHIUSURA` date DEFAULT NULL,
  `ORA1_INIZIO` time DEFAULT NULL,
  `ORA1_FINE` time DEFAULT NULL,
  `ORA2_INIZIO` time DEFAULT NULL,
  `ORA2_FINE` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_CONSEGNA`
--

CREATE TABLE IF NOT EXISTS `TB_APP_CONSEGNA` (
`ID_DONAZIONE` int(11) NOT NULL,
  `ID_NEG` int(11) NOT NULL,
  `ID_ASS` int(11) NOT NULL,
  `QTA` int(11) NOT NULL,
  `TIPO` varchar(20) NOT NULL,
  `CELL` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_DONAZIONE`
--

CREATE TABLE IF NOT EXISTS `TB_APP_DONAZIONE` (
`ID_DONAZIONE` int(11) NOT NULL,
  `ID_NEG` int(11) NOT NULL,
  `QTA` int(11) NOT NULL,
  `TIPO` varchar(20) NOT NULL,
  `CELL` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_DOWNLOAD`
--

CREATE TABLE IF NOT EXISTS `TB_APP_DOWNLOAD` (
`ID_DOWNLOAD` int(11) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `ID_VERSIONE` int(11) NOT NULL,
  `DATA_DOWN` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_RICEVUTO`
--

CREATE TABLE IF NOT EXISTS `TB_APP_RICEVUTO` (
`ID_DONAZIONE` int(11) NOT NULL,
  `ID_NEG` int(11) NOT NULL,
  `ID_ASS` int(11) NOT NULL,
  `QTA` int(11) NOT NULL,
  `TIPO` varchar(20) NOT NULL,
  `CELL` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_RITIRO`
--

CREATE TABLE IF NOT EXISTS `TB_APP_RITIRO` (
`ID_DONAZIONE` int(11) NOT NULL,
  `ID_NEG` int(11) NOT NULL,
  `ID_ASS` int(11) NOT NULL,
  `QTA` int(11) DEFAULT NULL,
  `TIPO` varchar(20) DEFAULT NULL,
  `CELL` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_APP_VERSIONI`
--

CREATE TABLE IF NOT EXISTS `TB_APP_VERSIONI` (
`ID_VERSIONE` int(11) NOT NULL,
  `VERSIONE` int(11) NOT NULL,
  `DESCRIZIONE` varchar(512) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TB_APP_VERSIONI`
--

INSERT INTO `TB_APP_VERSIONI` (`ID_VERSIONE`, `VERSIONE`, `DESCRIZIONE`) VALUES
(2, 2, 'Versione solo per i volontari con controllo prossimita'''' negozio.'),
(3, 3, 'Versione solo per i volontari che filtra l''area di servizio');

-- --------------------------------------------------------

--
-- Table structure for table `TB_AREA`
--

CREATE TABLE IF NOT EXISTS `TB_AREA` (
`ID_AREA` int(11) NOT NULL,
  `ASSOC_SIGLA` varchar(6) DEFAULT NULL,
  `ASSOC_NOME` varchar(50) DEFAULT NULL,
  `COMUNE` varchar(30) DEFAULT NULL,
  `PROV` varchar(2) DEFAULT NULL,
  `CAP` varchar(5) DEFAULT NULL,
  `NAZIONE` varchar(30) DEFAULT NULL,
  `DESCR` varchar(2040) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TB_AREA`
--

INSERT INTO `TB_AREA` (`ID_AREA`, `ASSOC_SIGLA`, `ASSOC_NOME`, `COMUNE`, `PROV`, `CAP`, `NAZIONE`, `DESCR`) VALUES
(1, 'CSV', 'Centro Servizi al Volontariato di Monza e Brianza', 'Provincia di Monza', 'MB', '20900', 'Italia', 'Servizio attivato dal CSV per il territorio della provincia di Monza'),
(2, 'CSV', 'Centro Servizi al Volontariato', 'Italia', 'IT', '00039', 'Italia', 'Servizio per tutto il territorio italiano.</BR>Per raccogliere le adesioni e far partire il servizio appena una associazione voglia attivarlo.');

-- --------------------------------------------------------

--
-- Table structure for table `TB_CELLULARI`
--

CREATE TABLE IF NOT EXISTS `TB_CELLULARI` (
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_PERSONA` int(11) DEFAULT NULL,
  `CELL` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_CHIUSURA`
--

CREATE TABLE IF NOT EXISTS `TB_CHIUSURA` (
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_NEG_ASS` int(11) NOT NULL,
  `GIORNO_CHIUSURA` date DEFAULT NULL,
  `ORA_INIZIO` time DEFAULT NULL,
  `ORA_FINE` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_MAIL`
--

CREATE TABLE IF NOT EXISTS `TB_MAIL` (
  `ID_USER` int(11) NOT NULL,
  `ID_AREA` int(11) DEFAULT NULL,
  `MAIL` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_MAIL_INVIATE`
--

CREATE TABLE IF NOT EXISTS `TB_MAIL_INVIATE` (
`ID_MAIL` int(11) NOT NULL,
  `FLAG_SPEDITA` char(1) DEFAULT NULL,
  `MITTENTE` varchar(50) DEFAULT NULL,
  `DESTINATARIO` varchar(50) DEFAULT NULL,
  `SOGGETTO` varchar(100) DEFAULT NULL,
  `TESTO` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;


-- --------------------------------------------------------

--
-- Table structure for table `TB_NEG_ASS`
--

CREATE TABLE IF NOT EXISTS `TB_NEG_ASS` (
`ID_NEG_ASS` int(11) NOT NULL,
  `ID_AREA` int(11) DEFAULT NULL,
  `FLAG_AREA_NEG_ASS` char(1) DEFAULT NULL,
  `FLAG_NEG_PRI_SEC` char(1) DEFAULT NULL,
  `NOME` varchar(50) DEFAULT NULL,
  `P_IVA` varchar(11) DEFAULT NULL,
  `INDIRIZZO_SEDE` varchar(50) DEFAULT NULL,
  `CAP_SEDE` varchar(5) DEFAULT NULL,
  `COMUNE_SEDE` varchar(30) DEFAULT NULL,
  `PROV_SEDE` varchar(2) DEFAULT NULL,
  `STATO_SEDE` varchar(30) DEFAULT NULL,
  `TELEFONO_STRUTTURA` varchar(14) DEFAULT NULL,
  `GPS_X` double DEFAULT NULL,
  `GPS_Y` double DEFAULT NULL,
  `MAIL` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TB_NEG_ASS`
--

INSERT INTO `TB_NEG_ASS` (`ID_NEG_ASS`, `ID_AREA`, `FLAG_AREA_NEG_ASS`, `FLAG_NEG_PRI_SEC`, `NOME`, `P_IVA`, `INDIRIZZO_SEDE`, `CAP_SEDE`, `COMUNE_SEDE`, `PROV_SEDE`, `STATO_SEDE`, `TELEFONO_STRUTTURA`, `GPS_X`, `GPS_Y`, `MAIL`) VALUES
(1, 1, 'N', 'P', 'Ristorante', 'P_IVA', 'Via Borgazzi Gerolamo, 58', '20900', 'Monza', 'MB', 'ITALIA', 'tel', 45.568514, 9.263677, 'mail'),
(2, 1, 'A', 'P', 'ITI P. Hensemberger', 'P_IVA', 'Via Giovanni Berchet, 2', '20900', 'Monza', 'MB', 'ITALIA', 'tel', 45.58086, 9.264257, 'mail'),
(3, 2, '', 'P', '', '', '', '', '', '', 'Italia', '', 12.1212, 34.3434, '');

-- --------------------------------------------------------

--
-- Table structure for table `TB_NEG_ASS_ALIM`
--

CREATE TABLE IF NOT EXISTS `TB_NEG_ASS_ALIM` (
  `ID_NEG_ASS` int(11) NOT NULL,
  `ID_ALIMENTO` int(11) NOT NULL,
  `MAX_QTA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_PERMESSI`
--

CREATE TABLE IF NOT EXISTS `TB_PERMESSI` (
  `ID_PERMESSO` int(11) NOT NULL,
  `DESCR` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TB_PERMESSI`
--

INSERT INTO `TB_PERMESSI` (`ID_PERMESSO`, `DESCR`) VALUES
(1, 'Admin'),
(2, 'Progr'),
(3, 'Resp Area'),
(4, 'Utente');

-- --------------------------------------------------------

--
-- Table structure for table `TB_PERSONA`
--

CREATE TABLE IF NOT EXISTS `TB_PERSONA` (
`ID_PERSONA` int(11) NOT NULL,
  `ID_AREA` int(11) DEFAULT NULL,
  `FLAG_PRI_SEC` char(1) DEFAULT NULL,
  `NOME` varchar(30) DEFAULT NULL,
  `COGNOME` varchar(30) DEFAULT NULL,
  `DATA_NASCITA` date DEFAULT NULL,
  `STATO_NASCITA` varchar(30) DEFAULT NULL,
  `COMUNE_NASCITA` varchar(30) DEFAULT NULL,
  `STATO_DOM` varchar(30) DEFAULT NULL,
  `PROV_DOM` varchar(2) DEFAULT NULL,
  `COMUNE_DOM` varchar(30) DEFAULT NULL,
  `CAP_DOM` varchar(5) DEFAULT NULL,
  `STATO_LAV` varchar(30) DEFAULT NULL,
  `PROV_LAV` varchar(2) DEFAULT NULL,
  `COMUNE_LAV` varchar(30) DEFAULT NULL,
  `CAP_LAV` varchar(5) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;


-- --------------------------------------------------------

--
-- Table structure for table `TB_PERS_NEG_ASS`
--

CREATE TABLE IF NOT EXISTS `TB_PERS_NEG_ASS` (
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_NEG_ASS` int(11) DEFAULT NULL,
  `ID_PERSONA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TB_TIPO_ALIM`
--

CREATE TABLE IF NOT EXISTS `TB_TIPO_ALIM` (
`ID_ALIMENTO` int(11) NOT NULL,
  `NOME` varchar(30) DEFAULT NULL,
  `ID_UNITA_MISURA` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TB_TIPO_ALIM`
--

INSERT INTO `TB_TIPO_ALIM` (`ID_ALIMENTO`, `NOME`, `ID_UNITA_MISURA`) VALUES
(1, 'panetteria', 1);

-- --------------------------------------------------------

--
-- Table structure for table `TB_UNITA_MISURA`
--

CREATE TABLE IF NOT EXISTS `TB_UNITA_MISURA` (
`ID_UNITA_MISURA` int(11) NOT NULL,
  `NOME_MISURA` varchar(10) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TB_UNITA_MISURA`
--

INSERT INTO `TB_UNITA_MISURA` (`ID_UNITA_MISURA`, `NOME_MISURA`) VALUES
(1, 'KG'),
(2, 'Litri');

-- --------------------------------------------------------

--
-- Table structure for table `TB_USER`
--

CREATE TABLE IF NOT EXISTS `TB_USER` (
`ID_USER` int(11) NOT NULL,
  `ID_AREA` int(11) DEFAULT NULL,
  `ID_PERSONA` int(11) DEFAULT NULL,
  `ID_PERMESSO` int(11) DEFAULT NULL,
  `FLAG_PERSONA` char(1) DEFAULT NULL,
  `USER` varchar(12) DEFAULT NULL,
  `PWD` varchar(12) DEFAULT NULL,
  `FLAG_REG` char(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_VETTORI`
--

CREATE TABLE IF NOT EXISTS `TB_VETTORI` (
`ID_VETTORE` int(11) NOT NULL,
  `ID_AREA` varchar(15) DEFAULT NULL,
  `ID_PERSONA` varchar(20) DEFAULT NULL,
  `FLAG_ONLINE` char(1) DEFAULT NULL,
  `GPS_X` double DEFAULT NULL,
  `GPS_Y` double DEFAULT NULL,
  `ID_VEICOLO` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `APP_TEST`
--
ALTER TABLE `APP_TEST`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TB_APERTURA`
--
ALTER TABLE `TB_APERTURA`
 ADD PRIMARY KEY (`ID_APERTURE`);

--
-- Indexes for table `TB_APER_EXTRA`
--
ALTER TABLE `TB_APER_EXTRA`
 ADD PRIMARY KEY (`ID_NEG_ASS`);

--
-- Indexes for table `TB_APP_CONSEGNA`
--
ALTER TABLE `TB_APP_CONSEGNA`
 ADD PRIMARY KEY (`ID_DONAZIONE`);

--
-- Indexes for table `TB_APP_DONAZIONE`
--
ALTER TABLE `TB_APP_DONAZIONE`
 ADD PRIMARY KEY (`ID_DONAZIONE`);

--
-- Indexes for table `TB_APP_DOWNLOAD`
--
ALTER TABLE `TB_APP_DOWNLOAD`
 ADD PRIMARY KEY (`ID_DOWNLOAD`);

--
-- Indexes for table `TB_APP_RICEVUTO`
--
ALTER TABLE `TB_APP_RICEVUTO`
 ADD PRIMARY KEY (`ID_DONAZIONE`);

--
-- Indexes for table `TB_APP_RITIRO`
--
ALTER TABLE `TB_APP_RITIRO`
 ADD PRIMARY KEY (`ID_DONAZIONE`);

--
-- Indexes for table `TB_APP_VERSIONI`
--
ALTER TABLE `TB_APP_VERSIONI`
 ADD PRIMARY KEY (`ID_VERSIONE`);

--
-- Indexes for table `TB_AREA`
--
ALTER TABLE `TB_AREA`
 ADD PRIMARY KEY (`ID_AREA`);

--
-- Indexes for table `TB_CHIUSURA`
--
ALTER TABLE `TB_CHIUSURA`
 ADD PRIMARY KEY (`ID_NEG_ASS`);

--
-- Indexes for table `TB_MAIL_INVIATE`
--
ALTER TABLE `TB_MAIL_INVIATE`
 ADD PRIMARY KEY (`ID_MAIL`);

--
-- Indexes for table `TB_NEG_ASS`
--
ALTER TABLE `TB_NEG_ASS`
 ADD PRIMARY KEY (`ID_NEG_ASS`);

--
-- Indexes for table `TB_PERMESSI`
--
ALTER TABLE `TB_PERMESSI`
 ADD PRIMARY KEY (`ID_PERMESSO`);

--
-- Indexes for table `TB_PERSONA`
--
ALTER TABLE `TB_PERSONA`
 ADD PRIMARY KEY (`ID_PERSONA`);

--
-- Indexes for table `TB_TIPO_ALIM`
--
ALTER TABLE `TB_TIPO_ALIM`
 ADD PRIMARY KEY (`ID_ALIMENTO`);

--
-- Indexes for table `TB_UNITA_MISURA`
--
ALTER TABLE `TB_UNITA_MISURA`
 ADD PRIMARY KEY (`ID_UNITA_MISURA`);

--
-- Indexes for table `TB_USER`
--
ALTER TABLE `TB_USER`
 ADD PRIMARY KEY (`ID_USER`);

--
-- Indexes for table `TB_VETTORI`
--
ALTER TABLE `TB_VETTORI`
 ADD PRIMARY KEY (`ID_VETTORE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APP_TEST`
--
ALTER TABLE `APP_TEST`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APERTURA`
--
ALTER TABLE `TB_APERTURA`
MODIFY `ID_APERTURE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APP_CONSEGNA`
--
ALTER TABLE `TB_APP_CONSEGNA`
MODIFY `ID_DONAZIONE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APP_DONAZIONE`
--
ALTER TABLE `TB_APP_DONAZIONE`
MODIFY `ID_DONAZIONE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APP_DOWNLOAD`
--
ALTER TABLE `TB_APP_DOWNLOAD`
MODIFY `ID_DOWNLOAD` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `TB_APP_RICEVUTO`
--
ALTER TABLE `TB_APP_RICEVUTO`
MODIFY `ID_DONAZIONE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APP_RITIRO`
--
ALTER TABLE `TB_APP_RITIRO`
MODIFY `ID_DONAZIONE` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TB_APP_VERSIONI`
--
ALTER TABLE `TB_APP_VERSIONI`
MODIFY `ID_VERSIONE` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `TB_AREA`
--
ALTER TABLE `TB_AREA`
MODIFY `ID_AREA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `TB_MAIL_INVIATE`
--
ALTER TABLE `TB_MAIL_INVIATE`
MODIFY `ID_MAIL` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `TB_NEG_ASS`
--
ALTER TABLE `TB_NEG_ASS`
MODIFY `ID_NEG_ASS` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `TB_PERSONA`
--
ALTER TABLE `TB_PERSONA`
MODIFY `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `TB_TIPO_ALIM`
--
ALTER TABLE `TB_TIPO_ALIM`
MODIFY `ID_ALIMENTO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `TB_UNITA_MISURA`
--
ALTER TABLE `TB_UNITA_MISURA`
MODIFY `ID_UNITA_MISURA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `TB_USER`
--
ALTER TABLE `TB_USER`
MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `TB_VETTORI`
--
ALTER TABLE `TB_VETTORI`
MODIFY `ID_VETTORE` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
