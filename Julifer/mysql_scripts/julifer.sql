
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL auto_increment,
  `nif` text,
  `nombre` text,
  `apellidos` text,
  `direccion` text,
  `localidad` text,
  `provincia` text,
  `codpostal` text,
  `telefono` text,
  `correoelectronico` text,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL auto_increment,
  `matricula` text,
  `marca` text,
  `modelo` text,
  `color` text,
  `km` text,
  `numerobastidor` text,
  `idcliente` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `empresas`;
CREATE TABLE `empresas` (
  `id` int(11) NOT NULL auto_increment,
  `nif` text,
  `nombre` text,
  `direccion` text,
  `localidad` text,
  `provincia` text,
  `codpostal` text,
  `telefono` text,
  `fax` text,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `id` int(11) NOT NULL auto_increment,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `tipo` varchar(12) NOT NULL default '',
  `numero` double default 0,
  `idvehiculo` text,
  `mecanica` text,
  `totalmecanica` double default 0,
  `descuentomecanica` double default 0,
  `pintura` text,
  `totalpintura` double default 0,
  `descuentopintura` double default 0,
  `pagado` double default 0,
  `franquicia` double default 0,
  `cuenta` text,
   UNIQUE KEY id (`id`), 
   PRIMARY KEY  (`tipo`, `numero`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `materialFacturados`;
CREATE TABLE `materialFacturados` (
  `id` int(11) NOT NULL auto_increment,
  `idfactura` int(11),
  `material` text,
  `cantidad` double,
  `precio` double,
  `descuento` double,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `materiales`;
CREATE TABLE `materiales` (
  `id` int(11) NOT NULL auto_increment,
  `descripcion` text,
  `preciounitario` double ,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `usuarios`;
	CREATE TABLE `usuarios` (
	`id` int NOT NULL auto_increment,
	`username` varchar(20) NOT NULL default '',
	`password` char(32) binary NOT NULL default '',
	`session` char(32) binary NOT NULL default '',
	`ip` varchar(15) binary NOT NULL default '',
	PRIMARY KEY (`id`),
	UNIQUE KEY username (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO `clientes` VALUES (7,'11234567N','Alejandro','Perez Nonao','C/ Luis Piernas 34, 4º D','Madrid','Madrid','20017','755 66 43 23','aperez@telco.es'),(8,'32844234F','Jaime','Berlanga','Avda de los poblados 103, Bajo C','Madrid','Madrid','28012','765 32 11 32','minoico@gmail.com');
INSERT INTO `vehiculos` VALUES (7,'M-3256-PG','Talbot','Horizon','Blanco','250000','NMK_3453_56','7'),(8,'0763 HJV','Mercedes','Vito 1.9D','Rojo','120000','NMK_3453_57','7');
INSERT INTO `materiales` VALUES (7,'Aceite sintetico 3l',23.45),(8,'Neumatico Pirelli 16\"',120.15);


