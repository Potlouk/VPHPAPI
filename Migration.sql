SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
CREATE TABLE `Predmety` (
  `id` int NOT NULL,
  `nazev` varchar(32) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Studenti` (
  `id` int NOT NULL,
  `jmeno` varchar(255) NOT NULL,
  `prijmeni` varchar(255) NOT NULL,
  `trida` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Studenti_Predmety` (
  `Studenti_id` int NOT NULL,
  `Predmety_id` int NOT NULL,
  `poznamka` text,
  `zapsano` date DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Studenti_Znamky` (
  `id` int NOT NULL,
  `Predmety_id` int NOT NULL,
  `Znamky_id` int DEFAULT NULL,
  `Studenti_id` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Tridy` (
  `id` int NOT NULL,
  `nazev` varchar(32) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Ucitele` (
  `id` int NOT NULL,
  `jmeno` text NOT NULL,
  `trida_Id` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Uzivatele` (
  `id` int NOT NULL,
  `jmeno` text NOT NULL,
  `heslo` text NOT NULL,
  `Studenti_Id` int DEFAULT NULL,
  `Ucitele_Id` int DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
INSERT INTO `Uzivatele` (
    `id`,
    `jmeno`,
    `heslo`,
    `Studenti_Id`,
    `Ucitele_Id`
  )
VALUES (
    1,
    'admin',
    '$2y$10$wk2TTP3R8NSa33fE52p3L.zBjsRlkMvVLb2e/MigQ4U5ndGvMbKEK',
    NULL,
    NULL
  );
CREATE TABLE `Uzivatele_Tokeny` (
  `token` varchar(32) NOT NULL,
  `Uzivatele_Id` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
CREATE TABLE `Znamky` (
  `id` int NOT NULL,
  `znamka` tinyint DEFAULT NULL,
  `poznamka` varchar(32) NOT NULL,
  `zapsano` date NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
ALTER TABLE `Predmety`
ADD PRIMARY KEY (`id`);
ALTER TABLE `Studenti`
ADD PRIMARY KEY (`id`),
  ADD KEY `student_trida` (`trida`);
ALTER TABLE `Studenti_Predmety`
ADD KEY `Studenti_id` (`Studenti_id`, `Predmety_id`),
  ADD KEY `Studenti_Predmety_ibfk_1` (`Predmety_id`);
ALTER TABLE `Studenti_Znamky`
ADD PRIMARY KEY (`id`),
  ADD KEY `Studenti_Znamky_ibfk_3` (`Znamky_id`),
  ADD KEY `Studenti_Znamky_ibfk_4` (`Studenti_id`),
  ADD KEY `Studenti_Znamky_ibfk_5` (`Predmety_id`);
ALTER TABLE `Tridy`
ADD PRIMARY KEY (`id`);
ALTER TABLE `Ucitele`
ADD PRIMARY KEY (`id`),
  ADD KEY `trida_Id` (`trida_Id`);
ALTER TABLE `Uzivatele`
ADD PRIMARY KEY (`id`),
  ADD KEY `Studenti_Id` (`Studenti_Id`),
  ADD KEY `Ucitele_Id` (`Ucitele_Id`);
ALTER TABLE `Uzivatele_Tokeny`
ADD KEY `Uzivatele_Id` (`Uzivatele_Id`);
ALTER TABLE `Znamky`
ADD PRIMARY KEY (`id`);
ALTER TABLE `Predmety`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
ALTER TABLE `Studenti`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
ALTER TABLE `Studenti_Znamky`
MODIFY `id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `Tridy`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
ALTER TABLE `Ucitele`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
ALTER TABLE `Uzivatele`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1;
ALTER TABLE `Znamky`
MODIFY `id` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `Studenti`
ADD CONSTRAINT `student_trida` FOREIGN KEY (`trida`) REFERENCES `Tridy` (`id`);
ALTER TABLE `Studenti_Predmety`
ADD CONSTRAINT `Studenti_Predmety_ibfk_1` FOREIGN KEY (`Predmety_id`) REFERENCES `Predmety` (`id`),
  ADD CONSTRAINT `Studenti_Predmety_ibfk_2` FOREIGN KEY (`Studenti_id`) REFERENCES `Studenti` (`id`);
ALTER TABLE `Studenti_Znamky`
ADD CONSTRAINT `Studenti_Znamky_ibfk_3` FOREIGN KEY (`Znamky_id`) REFERENCES `Znamky` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `Studenti_Znamky_ibfk_4` FOREIGN KEY (`Studenti_id`) REFERENCES `Studenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Studenti_Znamky_ibfk_5` FOREIGN KEY (`Predmety_id`) REFERENCES `Predmety` (`id`) ON UPDATE RESTRICT;
ALTER TABLE `Ucitele`
ADD CONSTRAINT `Ucitele_ibfk_1` FOREIGN KEY (`trida_Id`) REFERENCES `Tridy` (`id`) ON DELETE
SET NULL;
ALTER TABLE `Uzivatele`
ADD CONSTRAINT `Uzivatele_ibfk_1` FOREIGN KEY (`Studenti_Id`) REFERENCES `Studenti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Uzivatele_ibfk_2` FOREIGN KEY (`Ucitele_Id`) REFERENCES `Ucitele` (`id`) ON DELETE CASCADE;
ALTER TABLE `Uzivatele_Tokeny`
ADD CONSTRAINT `Uzivatele_Tokeny_ibfk_1` FOREIGN KEY (`Uzivatele_Id`) REFERENCES `Uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;