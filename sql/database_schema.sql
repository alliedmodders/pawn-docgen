SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `pawnconstants` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Constant` text NOT NULL,
  `Comment` text NOT NULL,
  `Tags` text NOT NULL,
  `IncludeName` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pawnfiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IncludeName` varchar(32) NOT NULL,
  `Content` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `IncludeName` (`IncludeName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pawnfunctions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Function` varchar(64) NOT NULL,
  `FullFunction` text NOT NULL,
  `Type` varchar(32) NOT NULL,
  `Comment` text NOT NULL,
  `Tags` text NOT NULL,
  `IncludeName` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Function` (`Function`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;
