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

-- Copiando estrutura para tabela crazzy_ohabbo.cms_clients
CREATE TABLE IF NOT EXISTS `cms_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `version` enum('0','24','60') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_comments
CREATE TABLE IF NOT EXISTS `cms_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `value` text,
  `author` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_errands
CREATE TABLE IF NOT EXISTS `cms_errands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_from_id` varchar(11) DEFAULT NULL,
  `user_to_id` varchar(11) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_events
CREATE TABLE IF NOT EXISTS `cms_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL,
  `description` varchar(40) DEFAULT NULL,
  `type` enum('atividade','evento') DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `timestamp_expire` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_forms
CREATE TABLE IF NOT EXISTS `cms_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `usernames` text,
  `timestamp` int(11) DEFAULT NULL,
  `link` text,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_news
CREATE TABLE IF NOT EXISTS `cms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `category` set('Campanhas','Ofertas Especiais','Promoções','Quartos','Atualizações','Arquitetos em Ação','Administração','Atividades','Geral') NOT NULL DEFAULT 'Geral',
  `image` varchar(200) NOT NULL DEFAULT '0',
  `shortstory` varchar(999) NOT NULL,
  `longstory` text NOT NULL,
  `author_id` int(11) NOT NULL DEFAULT '1',
  `timestamp` int(11) DEFAULT NULL,
  `timestamp_expire` int(11) DEFAULT NULL,
  `form` enum('enabled','disabled','unavailable') NOT NULL DEFAULT 'disabled',
  `form_link` varchar(225) DEFAULT NULL,
  `comments` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
  `draft` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_news_like
CREATE TABLE IF NOT EXISTS `cms_news_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(255) DEFAULT NULL,
  `newsid` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_news_message
CREATE TABLE IF NOT EXISTS `cms_news_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL DEFAULT '0',
  `newsid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_post_comments
CREATE TABLE IF NOT EXISTS `cms_post_comments` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `type` enum('undefined','article','errand') NOT NULL DEFAULT 'undefined',
  `post_id` int(11) DEFAULT '0',
  `value` text,
  `author_id` int(11) DEFAULT '0',
  `to_user_id` int(11) NOT NULL DEFAULT '0',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_post_forms
CREATE TABLE IF NOT EXISTS `cms_post_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('undefined','article','radio') NOT NULL,
  `post_id` int(11) DEFAULT '0',
  `label` text,
  `user_id` int(11) DEFAULT '0',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_post_reaction
CREATE TABLE IF NOT EXISTS `cms_post_reaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('undefined','article') NOT NULL DEFAULT 'undefined',
  `post_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `state` enum('undefined','like','deslike') NOT NULL DEFAULT 'undefined',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_reactions
CREATE TABLE IF NOT EXISTS `cms_reactions` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `state` enum('0','1','2') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela crazzy_ohabbo.cms_wordfilter
CREATE TABLE IF NOT EXISTS `cms_wordfilter` (
  `word` text,
  `replacement` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
