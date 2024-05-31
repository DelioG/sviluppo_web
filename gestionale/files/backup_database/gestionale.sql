-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 26, 2024 alle 10:22
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionale`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `distribuzione_famiglia`
--

CREATE TABLE `distribuzione_famiglia` (
  `id_distribuzione` bigint(20) NOT NULL,
  `id_famiglia` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `distribuzioni`
--

CREATE TABLE `distribuzioni` (
  `id` bigint(20) NOT NULL,
  `data_distribuzione` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `distribuzioni`
--

INSERT INTO `distribuzioni` (`id`, `data_distribuzione`) VALUES
(1, '2024-05-01'),
(2, '2024-05-02'),
(3, '2024-05-03'),
(4, '2024-05-04'),
(5, '2024-05-05'),
(6, '2024-05-06'),
(7, '2024-05-07'),
(8, '2024-05-08'),
(9, '2024-05-09'),
(10, '2024-05-10'),
(11, '2024-05-11'),
(12, '2024-05-12'),
(13, '2024-05-13'),
(14, '2024-05-14'),
(15, '2024-05-15'),
(16, '2024-05-16'),
(17, '2024-05-17');

-- --------------------------------------------------------

--
-- Struttura della tabella `famiglie`
--

CREATE TABLE `famiglie` (
  `id` bigint(20) NOT NULL,
  `numero_fascicolo` bigint(20) NOT NULL,
  `note` varchar(256) NOT NULL,
  `numero_componenti_totali` int(11) NOT NULL,
  `numero_componenti_minorenni` int(11) NOT NULL,
  `id_referente` bigint(20) NOT NULL,
  `id_zona` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `famiglie`
--

INSERT INTO `famiglie` (`id`, `numero_fascicolo`, `note`, `numero_componenti_totali`, `numero_componenti_minorenni`, `id_referente`, `id_zona`) VALUES
(1, 1, 'Note famiglia 1', 4, 2, 1, 1),
(2, 2, 'Note famiglia 2', 3, 1, 2, 2),
(3, 3, 'Note famiglia 3', 5, 3, 3, 3),
(4, 4, 'Note famiglia 4', 6, 2, 4, 4),
(5, 5, 'Note famiglia 5', 7, 4, 5, 5),
(6, 6, 'Note famiglia 6', 8, 2, 6, 6),
(7, 7, 'Note famiglia 7', 3, 1, 7, 7),
(8, 8, 'Note famiglia 8', 4, 2, 8, 8),
(9, 9, 'Note famiglia 9', 5, 1, 9, 9),
(10, 10, 'Note famiglia 10', 6, 3, 10, 10),
(11, 11, 'Note famiglia 11', 7, 4, 11, 1),
(12, 12, 'Note famiglia 12', 8, 2, 12, 2),
(13, 13, 'Note famiglia 13', 3, 1, 13, 3),
(14, 14, 'Note famiglia 14', 4, 2, 14, 4),
(15, 15, 'Note famiglia 15', 5, 1, 15, 5),
(16, 16, 'Note famiglia 16', 6, 3, 16, 6),
(17, 17, 'Note famiglia 17', 7, 4, 17, 7),
(18, 18, 'Note famiglia 18', 8, 2, 18, 8),
(19, 19, 'Note famiglia 19', 3, 1, 19, 9),
(20, 20, 'Note famiglia 20', 4, 2, 20, 10),
(21, 21, 'Note famiglia 21', 5, 3, 21, 1),
(22, 22, 'Note famiglia 22', 6, 2, 22, 2),
(23, 23, 'Note famiglia 23', 7, 4, 23, 3),
(24, 24, 'Note famiglia 24', 8, 2, 24, 4),
(25, 25, 'Note famiglia 25', 3, 1, 25, 5),
(26, 26, 'Note famiglia 26', 4, 2, 26, 6),
(27, 27, 'Note famiglia 27', 5, 3, 27, 7),
(28, 28, 'Note famiglia 28', 6, 2, 28, 8),
(29, 29, 'Note famiglia 29', 7, 4, 29, 9),
(30, 30, 'Note famiglia 30', 8, 2, 30, 10),
(31, 31, 'Note famiglia 31', 3, 1, 31, 1),
(32, 32, 'Note famiglia 32', 4, 2, 32, 2),
(33, 33, 'Note famiglia 33', 5, 3, 33, 3),
(34, 34, 'Note famiglia 34', 6, 2, 34, 4),
(35, 35, 'Note famiglia 35', 7, 4, 35, 5),
(36, 36, 'Note famiglia 36', 8, 2, 36, 6),
(37, 37, 'Note famiglia 37', 3, 1, 37, 7),
(38, 38, 'Note famiglia 38', 4, 2, 38, 8),
(39, 39, 'Note famiglia 39', 5, 3, 39, 9),
(40, 40, 'Note famiglia 40', 6, 2, 40, 10),
(41, 41, 'Note famiglia 41', 7, 4, 41, 1),
(42, 42, 'Note famiglia 42', 8, 2, 42, 2),
(43, 43, 'Note famiglia 43', 3, 1, 43, 3),
(44, 44, 'Note famiglia 44', 4, 2, 44, 4),
(45, 45, 'Note famiglia 45', 5, 1, 45, 5),
(46, 46, 'Note famiglia 46', 6, 3, 46, 6),
(47, 47, 'Note famiglia 47', 7, 4, 47, 7),
(48, 48, 'Note famiglia 48', 8, 2, 48, 8),
(49, 49, 'Note famiglia 49', 3, 1, 49, 9),
(50, 50, 'Note famiglia 50', 4, 2, 50, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti`
--

CREATE TABLE `prodotti` (
  `id` bigint(20) NOT NULL,
  `data_scadenza` date NOT NULL,
  `lotto` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti`
--

INSERT INTO `prodotti` (`id`, `data_scadenza`, `lotto`, `nome`, `quantita`) VALUES
(1, '2024-06-30', 'ABC123', 'Tonno', 100000),
(2, '2024-07-15', 'DEF456', 'Carne in scatola', 50),
(3, '2024-08-20', 'GHI789', 'Prosciutto', 200),
(4, '2024-09-10', 'JKL012', 'Provolone', 80),
(5, '2024-10-05', 'MNO345', 'Finocchiona', 150),
(6, '2024-11-12', 'PQR678', 'Biscotti per l\'infanzia', 120),
(7, '2024-12-25', 'STU901', 'Spaghetti', 90),
(8, '2025-01-30', 'VWX234', 'Sedani Rigati', 180),
(9, '2025-02-18', 'YZA567', 'Sedani', 60),
(10, '2025-03-22', 'BCD890', 'Riso', 70),
(11, '2025-04-05', 'EFG123', 'Dolcream', 110),
(12, '2025-05-08', 'HIJ456', 'Miscela di Caffè', 130),
(13, '2025-06-17', 'KLM789', 'Succo di Frutta Pesca', 140),
(14, '2025-07-30', 'NOP012', 'Succo di Frutta Albicocca', 100),
(15, '2025-08-14', 'QRS345', 'Succo di Frutta Mela', 75),
(16, '2025-09-20', 'TUV678', 'Succo di Frutta Pera', 95),
(17, '2025-10-25', 'WXY901', 'Succo di Frutta Ace', 120),
(18, '2025-11-30', 'ZAB234', 'Cacao in polvere', 85),
(19, '2025-12-15', 'CDE567', 'Olio di semi di girasole', 160),
(20, '2026-01-28', 'FGH890', 'Olio d\'oliva', 200),
(21, '2026-02-10', 'IJK123', 'Latte', 180),
(22, '2026-03-17', 'LMN456', 'Pomodoro', 150),
(23, '2026-04-20', 'OPQ789', 'Fagioli in Scatola', 110),
(24, '2026-05-05', 'RST012', 'Ceci in Scatola', 130),
(25, '2026-06-08', 'UVW345', 'Lenticchie in Scatola', 170);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_distribuzione`
--

CREATE TABLE `prodotto_distribuzione` (
  `id_prodotto` bigint(20) NOT NULL,
  `id_distribuzione` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `referenti`
--

CREATE TABLE `referenti` (
  `id` bigint(20) NOT NULL,
  `cellulare` varchar(15) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `referenti`
--

INSERT INTO `referenti` (`id`, `cellulare`, `cognome`, `nome`) VALUES
(1, '3331234567', 'Rossi', 'Mario'),
(2, '3332345678', 'Bianchi', 'Luigi'),
(3, '3333456789', 'Verdi', 'Paolo'),
(4, '3334567890', 'Russo', 'Giovanni'),
(5, '3335678901', 'Ferrari', 'Maria'),
(6, '3336789012', 'Esposito', 'Anna'),
(7, '3337890123', 'Bianco', 'Antonio'),
(8, '3338901234', 'Romano', 'Giuseppe'),
(9, '3339012345', 'Colombo', 'Roberto'),
(10, '3330123456', 'Ricci', 'Francesco'),
(11, '3331123456', 'Marino', 'Lucia'),
(12, '3332123456', 'Greco', 'Marco'),
(13, '3333123456', 'Bruno', 'Giulia'),
(14, '3334123456', 'Conti', 'Martina'),
(15, '3335123456', 'De Luca', 'Alessandro'),
(16, '3336123456', 'Moretti', 'Laura'),
(17, '3337123456', 'Galli', 'Paola'),
(18, '3338123456', 'Barbieri', 'Davide'),
(19, '3339123456', 'Fontana', 'Simone'),
(20, '3330223456', 'Santoro', 'Elena'),
(21, '3331223456', 'Mazza', 'Federico'),
(22, '3332223456', 'Gallo', 'Sara'),
(23, '3333223456', 'Villa', 'Chiara'),
(24, '3334223456', 'Leone', 'Lorenzo'),
(25, '3335223456', 'Costa', 'Elisa'),
(26, '3336223456', 'Giordano', 'Fabio'),
(27, '3337223456', 'Rizzo', 'Valentina'),
(28, '3338223456', 'Lombardi', 'Luca'),
(29, '3339223456', 'Barone', 'Serena'),
(30, '3330333456', 'Monti', 'Giacomo'),
(31, '3331333456', 'Serra', 'Silvia'),
(32, '3332333456', 'Caputo', 'Cristian'),
(33, '3333333456', 'Ferrara', 'Nicole'),
(34, '3334333456', 'Sanna', 'Alessia'),
(35, '3335333456', 'Testa', 'Valeria'),
(36, '3336333456', 'Pellegrini', 'Roberta'),
(37, '3337333456', 'Caruso', 'Erika'),
(38, '3338333456', 'Farina', 'Gabriele'),
(39, '3339333456', 'Gatti', 'Elisabetta'),
(40, '3330443456', 'Marini', 'Ludovica'),
(41, '3331443456', 'Vitali', 'Filippo'),
(42, '3332443456', 'Ferri', 'Rosa'),
(43, '3333443456', 'DAngelo', 'Matteo'),
(44, '3334443456', 'Mancini', 'Angela'),
(45, '3335443456', 'Palmieri', 'Cinzia'),
(46, '3336443456', 'Longo', 'Salvatore'),
(47, '3337443456', 'Fusco', 'Anna'),
(48, '3338443456', 'Gentile', 'Caterina'),
(49, '3339443456', 'Carbone', 'Fabrizio'),
(50, '3330553456', 'Martini', 'Giorgio');

-- --------------------------------------------------------

--
-- Struttura della tabella `zone`
--

CREATE TABLE `zone` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `zone`
--

INSERT INTO `zone` (`id`, `nome`) VALUES
(1, 'Zona A'),
(2, 'Zona B'),
(3, 'Zona C'),
(4, 'Zona D'),
(5, 'Zona E'),
(6, 'Zona F'),
(7, 'Zona G'),
(8, 'Zona H'),
(9, 'Zona I'),
(10, 'Zona J');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `distribuzione_famiglia`
--
ALTER TABLE `distribuzione_famiglia`
  ADD KEY `fk_famiglia_distribuzione` (`id_famiglia`),
  ADD KEY `fk_distribuzione_famiglia` (`id_distribuzione`);

--
-- Indici per le tabelle `distribuzioni`
--
ALTER TABLE `distribuzioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `famiglie`
--
ALTER TABLE `famiglie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_famiglia_zona` (`id_zona`),
  ADD KEY `fk_famiglia_referente` (`id_referente`);

--
-- Indici per le tabelle `prodotti`
--
ALTER TABLE `prodotti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `prodotto_distribuzione`
--
ALTER TABLE `prodotto_distribuzione`
  ADD KEY `fk_prodotto_distribuzione` (`id_prodotto`),
  ADD KEY `fk_distribuzione_prodotto` (`id_distribuzione`);

--
-- Indici per le tabelle `referenti`
--
ALTER TABLE `referenti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `distribuzioni`
--
ALTER TABLE `distribuzioni`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `famiglie`
--
ALTER TABLE `famiglie`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `prodotti`
--
ALTER TABLE `prodotti`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `referenti`
--
ALTER TABLE `referenti`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `zone`
--
ALTER TABLE `zone`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `distribuzione_famiglia`
--
ALTER TABLE `distribuzione_famiglia`
  ADD CONSTRAINT `fk_distribuzione_famiglia` FOREIGN KEY (`id_distribuzione`) REFERENCES `distribuzioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_famiglia_distribuzione` FOREIGN KEY (`id_famiglia`) REFERENCES `famiglie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `famiglie`
--
ALTER TABLE `famiglie`
  ADD CONSTRAINT `fk_famiglia_referente` FOREIGN KEY (`id_referente`) REFERENCES `referenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_famiglia_zona` FOREIGN KEY (`id_zona`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `prodotto_distribuzione`
--
ALTER TABLE `prodotto_distribuzione`
  ADD CONSTRAINT `fk_distribuzione_prodotto` FOREIGN KEY (`id_distribuzione`) REFERENCES `prodotti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prodotto_distribuzione` FOREIGN KEY (`id_prodotto`) REFERENCES `distribuzioni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
