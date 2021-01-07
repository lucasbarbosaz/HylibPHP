-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.10-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela crazzy_ohabbo.cms_settings
CREATE TABLE IF NOT EXISTS `cms_settings` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `hotelname` varchar(255) NOT NULL DEFAULT 'Habbo',
  `site` varchar(255) NOT NULL DEFAULT 'http://localhost/',
  `host` varchar(30) DEFAULT NULL,
  `port` int(10) DEFAULT NULL,
  `external_variables` text,
  `external_override_variables` text,
  `external_flash_texts` text,
  `external_flash_override_texts` text,
  `figuredata` text,
  `figuremap` text,
  `furnidata` text,
  `flash_client_url` text,
  `productdata` text,
  `avatarimage` varchar(255) NOT NULL DEFAULT 'http://www.habbo.fr/habbo-imaging/',
  `maintenance` set('enabled','disabled') NOT NULL DEFAULT 'disabled',
  `facebook` text NOT NULL,
  `twitter` text NOT NULL,
  `discord` text NOT NULL,
  `application` text,
  `recaptcha` varchar(255) NOT NULL,
  `credits` varchar(255) NOT NULL DEFAULT '5000',
  `diamonds` int(11) NOT NULL DEFAULT '0',
  `duckets` int(11) NOT NULL DEFAULT '0',
  `motto` text,
  `rank` int(11) NOT NULL DEFAULT '1',
  `figure` varchar(300) DEFAULT NULL,
  `cms_name` text,
  `cms_version` text,
  `cms_developers` text,
  `force_room` enum('0','1') NOT NULL DEFAULT '0',
  `force_room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela crazzy_ohabbo.cms_settings: 1 rows
/*!40000 ALTER TABLE `cms_settings` DISABLE KEYS */;
INSERT INTO `cms_settings` (`id`, `hotelname`, `site`, `host`, `port`, `external_variables`, `external_override_variables`, `external_flash_texts`, `external_flash_override_texts`, `figuredata`, `figuremap`, `furnidata`, `flash_client_url`, `productdata`, `avatarimage`, `maintenance`, `facebook`, `twitter`, `discord`, `application`, `recaptcha`, `credits`, `diamonds`, `duckets`, `motto`, `rank`, `figure`, `cms_name`, `cms_version`, `cms_developers`, `force_room`, `force_room_id`) VALUES
	(1, 'Lella', 'http://localhost', '127.0.0.1', 30000, '', '', '', '', '', '', '', '', '', 'https://habbo.city/habbo-imaging/avatarimage?', 'disabled', 'https://www.facebook.com/oHabboPTBR', 'https://twitter.com/', 'https://discord.gg/mVQJGU9', '', '', '999999', 0, 0, 'LELLA.ORG', 1, 'ea-990000128-153640-153640.wa-990000069-94-85.ch-877-81-1408.hd-180-1.ha-990000132-63-153640.he-990000148-153640.sh-987462842-81.ca-990000126-153640-153640.fa-990000146-153640.hr-990000131-39-158639.lg-275-81.cc-987462858-153638', 'Hylib', '0.0.3', 'Wake, Laxus e Dut', '0', 14);
/*!40000 ALTER TABLE `cms_settings` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
