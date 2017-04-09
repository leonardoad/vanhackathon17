CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `loginuser` varchar(25) DEFAULT NULL,
  `nomecompleto` varchar(35) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `datasenha` date DEFAULT NULL,
  `tipo` varchar(7) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senhaemail` varchar(50) DEFAULT NULL,
  `assinaturaemail` longtext,
  `smtp` varchar(255) DEFAULT NULL,
  `porta` varchar(3) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL,
  `ativo` char(1) DEFAULT NULL,
  `excluivel` char(1) DEFAULT NULL,
  `editavel` char(1) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `idexterno` varchar(15) DEFAULT NULL,
  `dificuldade` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `paginainicial` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario_loginuser_key` (`loginuser`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

alter table usuario 
add telephone varchar(25);

alter table usuario 
add isEducator tinyint(1);

alter table usuario 
drop isEducator;

alter table usuario 
drop role;

INSERT INTO `permissao` (`id_permissao`, `id_processo`, `ver`, `inserir`, `excluir`, `editar`, `id_usuario`) VALUES(67, 15, 'S', 'S', NULL, 'S', 3),(66, 14, 'S', 'S', 'S', 'S', 3),(65, 3, 'S', 'S', 'S', 'S', 3),(64, 14, 'S', 'S', 'S', 'S', 2),(63, 3, 'S', 'S', 'S', 'S', 2),(62, 3, 'S', NULL, NULL, NULL, 34),(61, 3, 'S', 'S', 'S', 'S', 33);  

INSERT INTO `processo` (`id_processo`, `nome`, `descricao`, `controladores`) VALUES(3, 'PROC_CAD_LaL', 'Lunch and Learn', 'course, bookedcourse, index'),(15, 'CHANGE_REALDATE', 'Change de Confimed Date', NULL),(14, 'PROC_CAD_BOOKING', 'Booking a Lunch', 'bookedcourse, index, course');

ALTER TABLE `course` ADD `photo` VARCHAR(200) NULL AFTER `audience_max`;

ALTER TABLE `usuario` ADD `photo` VARCHAR(200) NULL  ;