-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Abr-2017 às 21:32
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `vanhackathon17`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bookedcourse`
--

CREATE TABLE `bookedcourse` (
  `id_bookedcourse` bigint(20) UNSIGNED NOT NULL,
  `id_company` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `pretenddate` date NOT NULL,
  `realdate` date DEFAULT NULL,
  `bundlefood` char(1) COLLATE utf8_bin DEFAULT NULL,
  `dietaryrestriction` text COLLATE utf8_bin,
  `registerdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `bookedcourse`
--

INSERT INTO `bookedcourse` (`id_bookedcourse`, `id_company`, `id_course`, `pretenddate`, `realdate`, `bundlefood`, `dietaryrestriction`, `registerdate`) VALUES
(1, 1, 1, '2017-04-07', '2017-04-08', 'S', 'asdvasd', '2017-04-08'),
(2, 46, 2, '2017-04-27', NULL, 'S', 'asdvadsv', '2017-04-09'),
(3, 46, 2, '2017-04-27', NULL, 'S', 'asdvadsv', '2017-04-09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id_config` int(11) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `trocasenhatempo` char(1) DEFAULT NULL,
  `tempotrocasenha` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id_config`, `descricao`, `trocasenhatempo`, `tempotrocasenha`) VALUES
(1, 'Troca da Senha', 'S', 360);

-- --------------------------------------------------------

--
-- Estrutura da tabela `course`
--

CREATE TABLE `course` (
  `id_course` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(2) NOT NULL,
  `id_educator` bigint(100) NOT NULL,
  `title` varchar(200) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `registerdate` datetime DEFAULT NULL,
  `videolink` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `time` time NOT NULL,
  `setuptime` time NOT NULL,
  `cost` decimal(10,0) NOT NULL,
  `audience_min` int(11) DEFAULT NULL,
  `audience_max` int(11) DEFAULT NULL,
  `photo` varchar(200) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `course`
--

INSERT INTO `course` (`id_course`, `id_category`, `id_educator`, `title`, `description`, `registerdate`, `videolink`, `time`, `setuptime`, `cost`, `audience_min`, `audience_max`, `photo`) VALUES
(1, 1, 1, 'First Lunch n'' Learn Title', '<h3><strong>A Beginner guide to UI/UX Design</strong></h3>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas nunc nisi, scelerisque ac urna non, malesuada vehicula nulla. Nam id nisl a libero molestie accumsan. Aenean luctus velit ut sollicitudin vulputate. Curabitur ullamcorper porta ligula tempus viverra. Pellentesque a dui elementum, placerat libero non, laoreet turpis. Morbi fermentum porttitor porta. Aenean vel sollicitudin felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sed eleifend leo. Vivamus nec scelerisque sapien. Donec sit amet ex eget quam iaculis rutrum. Nulla porta turpis eget commodo pharetra. Nunc at bibendum turpis. Aenean feugiat congue leo ac porttitor. Vestibulum blandit pellentesque metus nec dignissim. Vestibulum auctor faucibus sem et laoreet.</p>\r\n<p>Morbi sollicitudin tortor arcu, quis eleifend nibh vestibulum nec. Aenean faucibus convallis ligula, ut ultricies libero feugiat at. Integer suscipit hendrerit accumsan. In vitae erat arcu. Etiam a efficitur tortor. Morbi mi eros, blandit quis enim id, euismod tempus massa. Suspendisse vehicula elit congue mi condimentum pharetra. Vestibulum ornare quam id egestas vehicula. Fusce lobortis scelerisque felis, nec varius risus rhoncus vitae.</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Pellentesque metus</li>\r\n<li>Integer suscipit</li>\r\n<li>Nam id nisl a libero</li>\r\n<li>Nulla porta turpis</li>\r\n</ul>', '2017-04-08 02:04:42', 'qp0HIF3SfI4', '01:10:00', '00:30:00', '345', 4, 9, 'Lake Tekapo, New Zealand.jpg'),
(2, 2, 1, 'Usability in Everyday', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien.', '2017-04-08 11:04:22', 'qp0HIF3SfI4', '01:45:00', '00:25:00', '122', 4, 10, '2_lnl-image-1.jpg'),
(3, 1, 35, 'Design for Presentations', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien.', '2017-04-08 15:04:08', 'qp0HIF3SfI4', '00:32:00', '00:00:00', '98', 1, 1, 'lnl-image-3.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `item`
--

CREATE TABLE `item` (
  `id_item` bigint(20) UNSIGNED NOT NULL,
  `categoria` varchar(2) COLLATE utf8_bin NOT NULL,
  `titulo` varchar(100) COLLATE utf8_bin NOT NULL,
  `texto` text COLLATE utf8_bin NOT NULL,
  `datacadastro` date DEFAULT NULL,
  `observacao` text COLLATE utf8_bin,
  `notarodape` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `item`
--

INSERT INTO `item` (`id_item`, `categoria`, `titulo`, `texto`, `datacadastro`, `observacao`, `notarodape`) VALUES
(6, '1', 'Conclusion', '<p>Foram calculadas as verbas constantes das decisÃµes judiciais demonstradas nos anexos.</p>\r\n<table style="margin-left: auto; margin-right: auto;">\r\n<thead>\r\n<tr>\r\n<th>Item</th>\r\n<th>DescriÃ§Ã£o</th>\r\n<th>Valor</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>1</td>\r\n<td>Total da Verba</td>\r\n<td>R$ 186.828,14</td>\r\n</tr>\r\n<tr>\r\n<td>2</td>\r\n<td>Valor corrigido</td>\r\n<td>R$ 199.009,26</td>\r\n</tr>\r\n<tr>\r\n<td>3</td>\r\n<td>Juros</td>\r\n<td>R$ 85.882,87</td>\r\n</tr>\r\n</tbody>\r\n<tfoot>\r\n<tr>\r\n<td colspan="">VALOR TOTAL (2+3)</td>\r\n<td>R$ 284.892,13</td>\r\n</tr>\r\n</tfoot>\r\n</table>\r\n<p>ReferÃªncia de CÃ¡lculo:</p>\r\n<ul>\r\n<li>Anexo I â€“ Resumo Geral</li>\r\n</ul>', '2016-06-17', NULL, '<p>asdvas</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `descricao` text COLLATE utf8_bin NOT NULL,
  `usuario` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `datahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_owner` int(11) DEFAULT NULL,
  `controller` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` int(11) NOT NULL,
  `act` varchar(50) COLLATE utf8_bin NOT NULL,
  `ip` varchar(70) COLLATE utf8_bin NOT NULL,
  `acao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `log`
--

INSERT INTO `log` (`id_log`, `descricao`, `usuario`, `datahora`, `id_owner`, `controller`, `tipo`, `act`, `ip`, `acao`) VALUES
(1, 'Acesso ao controlador "usuario" negado', 'User Educator Test Leo', '2017-04-08 17:33:57', NULL, 'usuario', 2, 'loadprofile', '::1', 0),
(2, 'Acesso ao controlador "lunchandlearn" negado', 'Leonardo', '2017-04-09 01:39:38', NULL, 'lunchandlearn', 2, 'id', '::1', 0),
(3, 'Acesso ao controlador "site" negado', 'Leonardo', '2017-04-09 01:40:08', NULL, 'site', 2, 'web', '::1', 0),
(4, 'Acesso ao controlador "undefined" negado', 'Coffee Shop', '2017-04-09 15:02:55', NULL, 'undefined', 2, 'btnSearchclick', '::1', 0),
(5, 'Acesso ao controlador "usuario" negado', 'Coffee Shop', '2017-04-09 15:04:29', NULL, 'usuario', 2, 'loadprofile', '::1', 0),
(6, 'Acesso ao controlador "usuario" negado', 'Coffee Shop', '2017-04-09 15:04:36', NULL, 'usuario', 2, 'loadprofile', '::1', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissao`
--

CREATE TABLE `permissao` (
  `id_permissao` int(11) NOT NULL,
  `id_processo` int(11) DEFAULT NULL,
  `ver` char(1) DEFAULT NULL,
  `inserir` char(1) DEFAULT NULL,
  `excluir` char(1) DEFAULT NULL,
  `editar` char(1) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `permissao`
--

INSERT INTO `permissao` (`id_permissao`, `id_processo`, `ver`, `inserir`, `excluir`, `editar`, `id_usuario`) VALUES
(1, 1, 'S', 'S', 'S', 'S', 1),
(71, 14, 'S', 'S', NULL, NULL, 4),
(72, 17, 'S', 'S', NULL, 'S', 3),
(69, 17, 'S', NULL, NULL, NULL, 4),
(68, 16, 'S', 'S', 'S', 'S', 2),
(67, 15, 'S', 'S', NULL, 'S', 3),
(66, 14, 'S', 'S', 'S', 'S', 3),
(65, 3, 'S', 'S', 'S', 'S', 3),
(64, 14, 'S', 'S', 'S', 'S', 2),
(63, 3, 'S', 'S', 'S', 'S', 2),
(62, 3, 'S', NULL, NULL, NULL, 34),
(61, 3, 'S', 'S', 'S', 'S', 33);

-- --------------------------------------------------------

--
-- Estrutura da tabela `processo`
--

CREATE TABLE `processo` (
  `id_processo` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `controladores` varchar(160) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `processo`
--

INSERT INTO `processo` (`id_processo`, `nome`, `descricao`, `controladores`) VALUES
(1, 'ALL', 'Acesso total ao sistema', NULL),
(3, 'PROC_CAD_LaL', 'Lunch and Learn', 'course, bookedcourse, index, usuario'),
(16, 'PROC_CAD_APPROVE_EDU', 'Approve Educators', 'index, usuario, course'),
(15, 'CHANGE_REALDATE', 'Change de Confimed Date', NULL),
(17, 'PROC_CAD_USERS', 'Users Edit', 'usuario'),
(14, 'PROC_CAD_BOOKED', 'Booked Lunch and Learn', 'bookedcourse, index, course, usuario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `review`
--

CREATE TABLE `review` (
  `id_review` bigint(20) UNSIGNED NOT NULL,
  `id_company` int(11) NOT NULL,
  `id_bookedcourse` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` text COLLATE utf8_bin,
  `registerdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `review`
--

INSERT INTO `review` (`id_review`, `id_company`, `id_bookedcourse`, `stars`, `comment`, `registerdate`) VALUES
(1, 1, 1, 4, 'asdadsvvads', '2017-04-08'),
(2, 1, 1, 5, 'asdvasdv', '2017-04-08'),
(3, 1, 1, 3, 'dsfsd dfb', '2017-04-08'),
(4, 1, 1, 1, '+-', '2017-04-08'),
(5, 1, 1, 1, 'sorry', '2017-04-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
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
  `telephone` varchar(25) DEFAULT NULL,
  `Photo` varchar(200) DEFAULT NULL,
  `approved` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `loginuser`, `nomecompleto`, `senha`, `datasenha`, `tipo`, `email`, `senhaemail`, `assinaturaemail`, `smtp`, `porta`, `grupo`, `ativo`, `excluivel`, `editavel`, `id_empresa`, `idexterno`, `dificuldade`, `trocasenhatempo`, `paginainicial`, `telephone`, `Photo`, `approved`) VALUES
(1, 'admin', 'Administrador', '28335c822634cc5f5992415058957371', '2016-12-20', 'user', 'admin', NULL, NULL, NULL, NULL, 1, 'S', 'N', 'N', 1, NULL, NULL, 'S', 'index', NULL, NULL, 'S'),
(3, NULL, 'Educator', NULL, NULL, 'grupo', NULL, NULL, NULL, NULL, NULL, NULL, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'N'),
(4, NULL, 'Company', NULL, NULL, 'grupo', NULL, NULL, NULL, NULL, NULL, NULL, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'N'),
(35, 'educator', 'Leonardo Educ', 'c49b4a011ef02de3335c26eae0cc1de3', '2017-04-09', 'user', 'e@', NULL, NULL, NULL, NULL, 3, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, 'leonardo.jpg', 'S'),
(2, NULL, 'Site admin', NULL, NULL, 'grupo', NULL, NULL, NULL, NULL, NULL, NULL, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'N'),
(41, 'qwe', 'qwe', '78a44a33b48bdae8f309a7f0ef35997b', '2017-04-08', NULL, 'qwe', NULL, NULL, NULL, NULL, 3, 'S', 'S', 'S', NULL, NULL, NULL, NULL, 'qwe', NULL, NULL, 'N'),
(42, NULL, 'asdv', '514692d426e55ea2bef726ca7a32f7a5', '2017-04-08', NULL, 'sdv', NULL, NULL, NULL, NULL, NULL, 'S', 'S', 'S', NULL, NULL, NULL, NULL, NULL, 'asdv', NULL, 'S'),
(43, 'r@', 'Romulo Ed', 'c4d6f7c01dde99b476c0d593463ae7b1', '2017-04-08', 'user', 'r@', NULL, NULL, NULL, NULL, 3, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'S'),
(45, 'adm', 'adm', '61b39b33f63122b84228019cd3023c03', NULL, 'user', 'adm', NULL, NULL, NULL, NULL, 2, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, NULL, NULL, 'S'),
(46, 'c', 'Coffee Shop', 'c49b4a011ef02de3335c26eae0cc1de3', '2017-04-09', 'user', 'c@', NULL, NULL, NULL, NULL, 4, 'S', 'S', 'S', NULL, NULL, 'null', NULL, NULL, '21313', 'lnl-video-thumbnail.jpg', 'S'),
(47, NULL, 'Corner Butequin', 'c49b4a011ef02de3335c26eae0cc1de3', '2017-04-09', 'user', 'but@', NULL, NULL, NULL, NULL, 4, 'S', 'S', 'S', NULL, NULL, '"null"', NULL, NULL, '12123', NULL, 'N'),
(48, NULL, 'company 3', 'c49b4a011ef02de3335c26eae0cc1de3', '2017-04-09', 'user', 'comp', NULL, NULL, NULL, NULL, 4, 'S', 'S', 'S', NULL, NULL, '"null"', NULL, NULL, '12113', NULL, 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookedcourse`
--
ALTER TABLE `bookedcourse`
  ADD UNIQUE KEY `id_bookedcourse` (`id_bookedcourse`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`),
  ADD UNIQUE KEY `id_laudotopico` (`id_course`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`),
  ADD UNIQUE KEY `id_laudotopico` (`id_item`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD UNIQUE KEY `id_log` (`id_log`);

--
-- Indexes for table `permissao`
--
ALTER TABLE `permissao`
  ADD PRIMARY KEY (`id_permissao`),
  ADD KEY `permissao_id_processo_fkey` (`id_processo`);

--
-- Indexes for table `processo`
--
ALTER TABLE `processo`
  ADD PRIMARY KEY (`id_processo`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD UNIQUE KEY `id_review` (`id_review`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario_loginuser_key` (`loginuser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookedcourse`
--
ALTER TABLE `bookedcourse`
  MODIFY `id_bookedcourse` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id_course` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `permissao`
--
ALTER TABLE `permissao`
  MODIFY `id_permissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `processo`
--
ALTER TABLE `processo`
  MODIFY `id_processo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;