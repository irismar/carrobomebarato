CREATE SCHEMA `tabela_fipe` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

CREATE TABLE `anos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_bin NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codigo_modelo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `codigo_marca` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) COLLATE utf8_bin NOT NULL,
  `marca` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `modelo` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `ano` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `combustivel` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `tipo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `sigla_combustivel` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `referencia` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `codigo_ano` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `codigo_modelo` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `codigo_marca` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SELECT * FROM tabela_fipe.modelos;