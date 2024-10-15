-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  ven. 08 jan. 2021 à 14:14
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `stocks`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `Article_code` varchar(10) NOT NULL,
  `Article_designation` varchar(100) NOT NULL,
  `Article_PUHT` float NOT NULL,
  `Article_Qte` smallint(6) NOT NULL,
  `unite` varchar(11) CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `qtemin` int(11) NOT NULL,
  PRIMARY KEY (`Article_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`Article_code`, `Article_designation`, `Article_PUHT`, `Article_Qte`, `unite`, `qtemin`) VALUES
('22', 'Véhicule', 5800, 100, 'Pièce', 5),
('34', 'Tuyaux', 6, 170, 'Pièce', 9),
('44', 'Savon', 10, 140, 'Carton', 6);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `Client_num` int(11) NOT NULL AUTO_INCREMENT,
  `Client_civilite` varchar(10) NOT NULL,
  `Client_nom` varchar(50) NOT NULL,
  `Client_prenom` varchar(50) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telephone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `adresse` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `reseausocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`Client_num`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`Client_num`, `Client_civilite`, `Client_nom`, `Client_prenom`, `email`, `telephone`, `adresse`, `reseausocial`) VALUES
(4, 'Madame', 'Yvettes', 'Papine', 'yv@gmail.com', '+243 999669665', 'Q.Matonge', 'facebook:yvetspa, twiter:@yvettes'),
(5, 'Monsieur', 'Imani', 'Kambere', 'ima@gmail.com', '+243 971542541', 'Beni, Quartier Tamende,avenue mbeo ', NULL),
(6, 'Madame', 'Noela', 'Kapela', 'kap@gmail.com', '+243 972147589', 'Q.Kalinda', NULL),
(8, 'Mademoisel', 'Nadine', 'Kavira', 'Nad@yahoo.fr', '896523415', 'Q.Matonge', '@nadtwiter'),
(9, 'Madame', 'Pella', 'Claudia', 'pel@gmail.com', '998214578', 'Beni/Kalinda', 'clapel'),
(10, 'Madame', 'Pella', 'Claudia', 'pel@gmail.com', '998214578', 'Beni/Kalinda', 'clapel'),
(11, 'Mademoisel', 'Cecile', 'Mia', 'cem@gmail.com', '892541232', 'Beni/Tamende', '@cecil');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `Com_num` int(11) NOT NULL AUTO_INCREMENT,
  `Com_client` int(11) NOT NULL,
  `Com_date` date NOT NULL,
  `Com_montant` float NOT NULL,
  `com_monnaie` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Com_num`),
  KEY `Com_client` (`Com_client`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`Com_num`, `Com_client`, `Com_date`, `Com_montant`, `com_monnaie`) VALUES
(136, 4, '2021-01-03', 110, '$'),
(137, 4, '2021-01-03', 61.5, '$'),
(138, 8, '2021-01-05', 195, '$');

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `id_depense` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `montant` float NOT NULL,
  `monnaie` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_depense` date NOT NULL,
  PRIMARY KEY (`id_depense`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`id_depense`, `motif`, `montant`, `monnaie`, `date_depense`) VALUES
(138, 'Paie facture 127', 100, '$', '2021-01-07');

-- --------------------------------------------------------

--
-- Structure de la table `detail`
--

DROP TABLE IF EXISTS `detail`;
CREATE TABLE IF NOT EXISTS `detail` (
  `Detail_num` int(11) NOT NULL AUTO_INCREMENT,
  `Detail_com` int(11) NOT NULL,
  `Detail_ref` varchar(10) NOT NULL,
  `Detail_qte` smallint(6) NOT NULL,
  `unitevent` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `puht` float NOT NULL,
  `detail_monnaie` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Detail_num`),
  KEY `Detail_ref` (`Detail_ref`),
  KEY `detail_ibfk_2` (`Detail_com`),
  KEY `unitevent` (`unitevent`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `detail`
--

INSERT INTO `detail` (`Detail_num`, `Detail_com`, `Detail_ref`, `Detail_qte`, `unitevent`, `puht`, `detail_monnaie`) VALUES
(219, 136, '34', 10, 'Pièce', 11, '$'),
(220, 137, '44', 5, 'Carton', 12.3, '$'),
(223, 138, '44', 15, 'Carton', 13, '$');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `id_entreprise` int(11) NOT NULL AUTO_INCREMENT,
  `nom_entreprise` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `adresse` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `identite_nationale` int(11) NOT NULL,
  `Telephone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `emailentreprise` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reseausocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `logo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_entreprise`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id_entreprise`, `nom_entreprise`, `adresse`, `identite_nationale`, `Telephone`, `emailentreprise`, `reseausocial`, `logo`) VALUES
(1, 'ENTREPRISE NAME', 'Beni/Q.Matongue/Avenue n2', 12365458, '+243 9904523685 ou 895632141', '+243 9904523685 ou 895632141', 'papet', 'Désert.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `entre_stock`
--

DROP TABLE IF EXISTS `entre_stock`;
CREATE TABLE IF NOT EXISTS `entre_stock` (
  `id_entre` int(11) NOT NULL AUTO_INCREMENT,
  `id_fournisseur` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `numero_facture` int(11) NOT NULL,
  `quantite_entre` int(11) NOT NULL,
  `unite` int(11) NOT NULL,
  `puht` float NOT NULL,
  `monnaie` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_entre` date NOT NULL,
  `observation` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_entre`),
  KEY `id_fournisseur` (`id_fournisseur`),
  KEY `id_article` (`id_article`),
  KEY `unite` (`unite`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entre_stock`
--

INSERT INTO `entre_stock` (`id_entre`, `id_fournisseur`, `id_article`, `numero_facture`, `quantite_entre`, `unite`, `puht`, `monnaie`, `date_entre`, `observation`) VALUES
(125, 1, 44, 10, 40, 2, 10, '$', '2021-01-02', 'Correct'),
(127, 2, 44, 120, 120, 2, 11, '$', '2021-01-02', 'ok'),
(128, 3, 34, 1474, 180, 7, 6, '$', '2021-01-02', 'Tout est bon'),
(129, 2, 22, 120, 100, 7, 5800, '$', '2021-01-06', 'Tout est bon');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `idf` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `telephone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `reseausocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`idf`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Table enregistrant les fournisseurs';

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`idf`, `civilite`, `nom`, `prenom`, `email`, `telephone`, `adresse`, `reseausocial`) VALUES
(1, 'Monsieur', 'Paluku', 'Gilbert', 'palu@gmail.com', '+243 895623145', 'Q.Kalinda', 'gilbertpal'),
(2, 'Madame', 'Sondi', 'Gisele', 'gisel@gmail.com', '+243 996532320', 'Q.Tamende', 'Sondi gilbert'),
(3, 'Mademoisel', 'Psy', 'Katerine', 'pkate@gmail.com', '+243 9965323203', 'Q.Malepe', 'Katerine P'),
(4, 'Madame', 'Mwissa', 'Jorgine', 'mwi@gmail.com', '+243 991524789', 'Beni/Kasanga', 'mwis');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `numerofacture` int(11) NOT NULL,
  `date_paiement` date NOT NULL,
  `montant_a_paye` float NOT NULL,
  `montant_paye` float NOT NULL,
  `reste` float NOT NULL,
  `monnaie` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sommede` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `numerofacture` (`numerofacture`)
) ENGINE=InnoDB AUTO_INCREMENT=283 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id_paiement`, `numerofacture`, `date_paiement`, `montant_a_paye`, `montant_paye`, `reste`, `monnaie`, `sommede`) VALUES
(277, 136, '2021-01-04', 110, 110, 0, '$', 'Somme de cent soixante-séise dollars en raison de paiement de la facture numéro 136'),
(279, 137, '2021-01-04', 61.5, 55, 6.5, '$', ''),
(280, 137, '2021-01-05', 61.5, 6, 0.5, '$', ''),
(281, 137, '2021-01-05', 61.5, 0.5, 0, '$', ''),
(282, 138, '2021-01-06', 195, 195, 0, '$', '');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `ref_produit` int(11) NOT NULL AUTO_INCREMENT,
  `designation_produit` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qte_min` int(11) NOT NULL,
  `tva` int(11) NOT NULL,
  `marque` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ref_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`ref_produit`, `designation_produit`, `qte_min`, `tva`, `marque`) VALUES
(12, 'Thermos', 5, 0, 'Fabrique en Belgique'),
(13, 'Ampoulea', 11, 0, 'Fabriqué en Allemagne'),
(14, 'Lampe', 10, 0, 'Fabriqué en Tanzanie'),
(15, 'Ordinateur', 15, 0, 'Fabriqué en Russie'),
(16, 'Malettes', 10, 0, 'Fabriqué en Uganda'),
(17, 'Téléphonedr', 10, 0, 'Fabriqué en Chine'),
(18, 'Papier duplicateur', 8, 0, 'Fabriqué en RDC'),
(19, 'Prise électrique', 10, 0, 'Fabriqué en Inde'),
(20, 'Radio', 11, 0, 'Fabriqué en France'),
(22, 'Véhicule', 5, 0, 'FAbriqué en Pologne'),
(34, 'Tuyaux', 9, 0, 'made in Russia'),
(44, 'Savon', 6, 0, 'Made in DRC'),
(45, 'Chaise roulante', 8, 0, 'Made in China'),
(46, 'Poste téléviseur', 10, 0, 'fabriqué en Corée du Nord');

-- --------------------------------------------------------

--
-- Structure de la table `temp`
--

DROP TABLE IF EXISTS `temp`;
CREATE TABLE IF NOT EXISTS `temp` (
  `Temp_ref` varchar(10) NOT NULL,
  `Temp_qte` int(11) NOT NULL,
  `Temp_designation` varchar(100) NOT NULL,
  `Temp_PUHT` float NOT NULL,
  `Temp_THT` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `unite_mesure`
--

DROP TABLE IF EXISTS `unite_mesure`;
CREATE TABLE IF NOT EXISTS `unite_mesure` (
  `id_unite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_unite`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Table enregistrant les unités de mesure';

--
-- Déchargement des données de la table `unite_mesure`
--

INSERT INTO `unite_mesure` (`id_unite`, `libelle`) VALUES
(2, 'Carton'),
(5, 'Sac'),
(7, 'Pièce'),
(8, 'Bidon');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `iduser` int(4) NOT NULL AUTO_INCREMENT,
  `logins` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usertelephone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `userreseausocio` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `useradresse` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `roles` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `etat` int(1) NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Table enregistrant les utilisateurs de l''application';

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`iduser`, `logins`, `email`, `usertelephone`, `userreseausocio`, `useradresse`, `roles`, `etat`, `pwd`) VALUES
(6, 'admin', 'ADMIN@GMAIL.COM', '', '', '', 'ADMIN', 1, '12345'),
(8, 'celeste', 'celes@gmail.com', '', '', '', 'VISITEUR', 1, '123456'),
(10, 'tumba', 'rjtumba@gmail.com', '', '', '', 'caissier', 1, 'rj000'),
(18, 'habi', 'hab@gmail.com', '', '', '', 'Travailleur', 1, '99999'),
(29, 'Pierre', 'piere@gmail.com', '', '', '', 'vendeur', 1, '000000');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`Com_client`) REFERENCES `clients` (`Client_num`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `detail_ibfk_1` FOREIGN KEY (`Detail_com`) REFERENCES `commandes` (`Com_num`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_ibfk_2` FOREIGN KEY (`Detail_ref`) REFERENCES `articles` (`Article_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `entre_stock`
--
ALTER TABLE `entre_stock`
  ADD CONSTRAINT `entre_stock_ibfk_1` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`idf`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entre_stock_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `produits` (`ref_produit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entre_stock_ibfk_3` FOREIGN KEY (`unite`) REFERENCES `unite_mesure` (`id_unite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`numerofacture`) REFERENCES `commandes` (`Com_num`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
