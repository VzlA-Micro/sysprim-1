CREATE TABLE `company_respaldo` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RIF` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_catastral` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opening_date` date DEFAULT NULL,
  `lat` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_employees` int(11) DEFAULT NULL,
  `sector` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parish_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `company_respaldo`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `company_respaldo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `company_respaldo` (`name`, `RIF`, `code_catastral`, `license`, `opening_date`, `lat`, `lng`, `address`, `number_employees`, `sector`, `phone`, `image`, `parish_id`, `status`, `created_at`, `updated_at`) VALUES
('INTEGRAL DIESEL SYSTEMS C.A.', 'J316431630', '00000000000000001111', 'L000014114', NULL, '10.052489662047043', '-69.33931969250284', 'CALLE 26 E/AV.LIB. Y CARR.1 GALP. N° 3 Z. IND. I', 41, 'OESTE', '+584244544747', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-11-25 11:28:42'),
('M2A INGENIERIA, C.A.', 'J295683189', '00000000000000000000', 'L000010751', NULL, '10.06459331583379', '-69.28414106369019', 'AV. MADRID CON AV. LOS LEONES EDIF. CENTRO EMPRESARIAL PLAZA', 0, 'ESTE', '+584269358516', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-11-25 12:21:44'),
('AF INGENIEROS CIVILES Y ASOC. S.C.', 'J316114287', '00000000000000000000', 'L000012905', NULL, '10.06459331583379', '-69.28413033485413', 'AV. MADRID CON AV. LOS LEONES EDIF. CENTRO EMPRESARIAL PLAZA', 1, 'ESTE', '+584269352442', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-11-25 12:23:49'),
('ALIMENTOS JUANDA, C.A. (SUCURSAL)', 'J315889609', '00000000000000000000', 'A000012662', NULL, '10.072600526784852', '-69.32707786560059', 'CARR. 18 ESQUINACALLE 25 EDIF. LA LOGIA PB.', 1, 'NORTE', '+584165539754', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-02 08:33:45'),
('FRIOLANDIA 2021, C.A', 'J404951890', '00000000000000000000', 'A000014153', NULL, '10.053723651364749', '-69.34290315788417', 'AV. FUERZA ARMADAS ESQ.CLL 53 N°52.118BRR', 1, 'CENTRO', '+584169511409', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-02 09:44:33'),
('MAQUINARIAS Y BOMBAS LARA, C.A.', 'J404109099', '02150052030000000000', 'L000017859', '2019-10-31', '10.05697412657056', '-69.36941782993301', 'AV. FLORENCIO JIMENEZ KM. 2 CALLE 7  ENTRE CARRERAS 7 Y 8 N°', 1, 'NORTE', '+582512668290', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-02 11:41:44'),
('AGROALIMENTOS SAN GABRIEL 2013, C.A.', 'J403861951', '00000000000000000000', 'L000022444', NULL, '10.06148119514114', '-69.36655675784141', 'CALLE 11 CON CARRERA 27 Y 28 N°28-11', 5, 'OESTE', '+584262326197', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-02 12:22:23'),
('MATTE COLORS PARIS, C.A.', 'J410164140', '00000000000000000000', 'A000014763', NULL, '10.066165704833269', '-69.31515890008166', 'CARRERA 19. ESQ. CALLE 24 N° 1-B-B-.', 1, 'NORTE', '+584265532227', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-02 14:08:08'),
('REPROLARA, C.A.', 'J0085029168', '620403', 'L01100350', NULL, '10.065439673861745', '-69.31709669588224', 'CALLE 26 ENTRE 18 Y 19. EDIF. 26LCB', 1, 'NORTE', '+584262318979', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-02 14:12:37'),
('SUMINISTRO HIDRAUL PORTUGUESA, C.A.', 'J0085359605', '02150052022000000000', 'L313399', NULL, '10.055548087138142', '-69.36911574230464', 'FLORENCIO JIMENEZ KM.2 CALLE 7 ENTRE CARRERAS 7 Y 8 NRO 7-78', 1, 'OESTE', '+584262314457', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-02 14:27:13'),
('MAQUINARIAS Y EQUIPOS LARA C.A. MAE', 'J0085059296', '04040087003001000000', 'L1129314', NULL, '10.058278121459933', '-69.36982815932225', 'AV. FLORENCIO JIMENEZ CALLE 7 ENTRE CARRERAS 7 Y 8 NRO 7-78', 1, 'OESTE', '+58426428632', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-02 14:34:34'),
('RECICLAJE IMPORT DE VENEZUELA 2014 C.A.', 'J405370700', '621026', 'L000018871', NULL, '10.046593004156362', '-69.39880228055699', 'AV. FLORENCIO JIMENEZ KM.9 SEC. LA CONCORDIA', 1, 'OESTE', '+584245907194', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-02 14:45:31'),
('AGROPECUARIA BRIMAR, C.A.(OFIC.ADM)', 'J407278657', '00000000000000000000', 'L000020928', NULL, '10.060775952424015', '-69.29422789260298', 'CARRERA 3 Y 4 CALLE 6 URB. NUEVA SEGOVIA N°3-72', 1, 'ESTE', '+584262524690', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-05 10:28:32'),
('INVERSIONES PECOSBILL, C.A. (OFC.ADM)', 'J403041547', '00000000000000000000', 'L000020014', NULL, '10.058322419870969', '-69.2895471445454', 'CARRERA 3 Y 4 CALLE 6 URB. NUEVA SEGOVIA', 1, 'ESTE', '+584264166100', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-05 10:34:09'),
('INVERSIONES LA VARA, C.A.', 'J5316709639', '09201098040000000000', 'L000011633', NULL, '10.171520382135474', '-69.31232396271594', 'VIA INTERCOMUNAL BQTO-DUACA KM14', 1, 'NORTE', '+584268480797', NULL, 9, NULL, '2019-09-14 00:00:00', '2019-12-05 10:52:01'),
('FARMACIA F.U.L,C.A.', 'J307223073', '00000000000000000000', 'L317287', NULL, '10.06872534589436', '-69.31921055209523', 'CARR. 22 CON CALLE 28, EDIF BLANCA LOC. Nº 1', 1, 'CENTRO', '+584262314542', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-05 10:58:52'),
('ADUANERA NUEVA SEGOVIA', 'J10929130', '00000000000000000000', '03058610', NULL, '10.06382096887456', '-69.29539214597469', 'URB. NUEVA SEGOVIA', 1, 'ESTE', '+584262329512', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-05 11:23:56'),
('PUNTO BOLSA, C.A(OFIC.ADMIN.DE MAYOR)', 'J299597996', '00000000000000000000', 'L000015077', NULL, '10.070096645101062', '-69.30698876039901', 'CARRERA 22 ESQUINA CALLE 15', 1, 'CENTRO', '+584262522214', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-05 13:30:24'),
('SILENCIADORES LARA SILACA, C.A.', 'J314743384', '00000000000000000000', 'L000006765', NULL, '10.056108917641756', '-69.37420914854238', 'AV. FLORENCIO JIMENEZ ENTRE 10 Y 11 # 10-78 PUEBLO NUEVO', 1, 'OESTE', '+584262667555', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-06 09:00:58'),
('AUTO PINTURAS LA 52, C.A.', 'J403168679', '00000000000000000000', 'L000018553', NULL, '10.054161695452047', '-69.34194148371193', 'AV. FUERZAS ARMADAS ESQUINA CALLE 52 N° 52-9', 1, 'CENTRO', '+584264463542', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 10:15:36'),
('ALMACENES LA OFERTA C.A.', 'J40730695', '00000000000000000000', 'L00327578', NULL, '10.066730059258918', '-69.31627743730519', 'AV. 20 ENTRE 25Y26', 1, 'CENTRO', '+584262315124', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 10:23:03'),
('COMERCIALIADORA LAVA C.A.', 'J315455307', '01102012001000000000', 'L000004851', NULL, '10.068275831448348', '-69.30366099665139', 'AV. 20 ESQ. CALLE 12 EDIF. C.', 1, 'CENTRO', '+584262679680', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 11:08:45'),
('HOTEL CARDENAL C.A', 'J085135502', '00000000000000000000', 'L0015689-9', NULL, '10.074608939664538', '-69.30456221888039', 'AV VENEZUELA ENTRE CALLES 12 Y 13 ZONA ESTE DE BARQUISIMETO', 1, 'CENTRO', '+584262517256', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 11:12:21'),
('COMERCIAL VIVERES EL ROCIO C.A.', 'J307849509', '00000000000000000000', 'L318011', NULL, '10.068386569561762', '-69.39336496258352', 'AV.MOYETONES ENTRE 1 Y 2 MERCADO MAYORISTA LOCAL 2B-4 ZONA I', 1, 'OESTE', '+584145050674', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-06 11:18:01'),
('LABORATORIO BIOMEDI, C.A', 'J405280603', '00000000000000000000', 'A000014366', NULL, '10.054288464328117', '-69.36314166376565', 'CLL.1 / CARR.3 Y 4 AV.LA SALLE BARRIO ANDRES ELOY BLANCO.-', 1, 'OESTE', '+584145050052', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-06 11:21:25'),
('LIBRERIA Y PAPELERIA LA ROTARIA CA', 'J316389596', '00000000000000000000', 'L000006112', NULL, '10.060263457778985', '-69.3550478246782', 'AV.ROTARIA CON CARRERA 16 CASA S/N SECTOR OESTE BARQUISIMETO', 1, 'CENTRO', '+584145659242', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 11:38:09'),
('CHARCUT.PIZZERIA BURGUER DEL OESTE, C.A.', 'J404906150', '00000000000000000000', 'L000019170', NULL, '10.055861986966733', '-69.36759164176749', 'CALLE 6 ENTRE CARRERAS Y 4 Y 5 CASA Nº 4A-58 BARRIO PUEBLO N', 1, 'NORTE', '+584262311786', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-06 11:41:58'),
('GLOBAL MEDICAL ERC, C.A. (OFIC.ADM)', 'J404445137', '00000000000000000000', 'L000017856', NULL, '10.059113020815753', '-69.34984470204398', 'CALLE 58 ENTRE CARRERAS 14 Y 15 N°14-29', 1, 'CENTRO', '+584166501138', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 11:53:31'),
('ORANGE, C.A', 'J306763252', '01122030230000000000', 'L319613', NULL, '10.06636356557494', '-69.31468246226211', 'AV. 20 ENTRE 23 Y 24 C.C BOULV.CENTER LC.C-1,C-2,C-3', 1, 'CENTRO', '+584165014543', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-06 12:59:42');
('GARCIA VARIEDADES JBI 2015 F.P', 'V189985068', '00000000000000000000', 'A000016146', NULL, '10.121421726554235', '-69.34740736817241', 'CALLE 4Y5 CASA SIN NRO. SEC. ROMULO GALLEGOS. CARORITA ABAJO', 1, 'NORTE', '+584262522214', NULL, 9, NULL, '2019-09-14 00:00:00', '2019-12-12 08:58:14'),
('INTOCA DE VENEZUELA,C.A.', 'J305394431', '00000000000000000000', 'L315987', NULL, '10.071692962466948', '-69.32016316317936', 'CARRERA 25 ENTRE CALLES 28 Y 29 LOCAL 28-57', 1, 'CENTRO', '+584262314696', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-12 09:02:13'),
('DISEÑADORES Y DECORAD.(DECODIPA)', 'V034569335', '00000000000000000000', 'L01014419', NULL, '10.122643901654925', '-69.30775639019936', 'AV. INTERCOMUNAL BARQUISIMETO DUACA KM. 9 EL CUJÍ BARQUISIME', 1, 'NORTE', '+584267182343', NULL, 9, NULL, '2019-09-14 00:00:00', '2019-12-12 09:30:43'),
('CONSTRUCTORA SAMBIL, C.A.', 'J0000082766', '01070056012000000000', 'L000007008', NULL, '10.071839955921794', '-69.29326057434082', 'AV. VENEZUELA C.C SAMBIL', 1, 'ESTE', '+584145506600', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-12 10:32:49'),
('INVERSIONES AGRICOLAS DON CHEO 2014, C.A.', 'J405665190', '00000000000000000000', 'A000016130', NULL, '10.063368073371345', '-69.28382603643462', 'CALLE EL ROSAL, BARRIO EL UJANO SEC. 11 LAS CLAVELLINAS', 1, 'ESTE', '+584145190624', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-12 10:42:06'),
('AMELIA M (LICORERÍA JAYO RON)', 'V041957588', '09201098017000000000', 'L317520', NULL, '10.10552337679389', '-69.33565270940039', 'AV. CRISTOBAL C.VIA VERITAS EL CUJÍ', 1, 'NORTE', '+584165509933', NULL, 9, NULL, '2019-09-14 00:00:00', '2019-12-12 11:37:05'),
('ZAMBRANO REP.  Z V C.A.', 'J304463960', '00000000000000000000', 'L000004311', NULL, '10.069465462240437', '-69.37221040278644', 'AV. L/IND. CRUCE CALLE 4 . A. ELOY B. C.S.M. L. 3', 1, 'NORTE', '+584145251298', NULL, 4, NULL, '2019-09-14 00:00:00', '2019-12-12 12:56:42'),
('RANCHO TREVOL CALCIO 1, C.A.', 'J294052649', '00000000000000000000', 'L000008673', NULL, '10.086656271352513', '-69.32714572402614', 'CARRERA 2 ENTRE CALLES 3Y4. NRO-15AB', 1, 'NORTE', '+584262731474', NULL, 4, NULL, '2019-09-14 00:00:00', '2019-12-12 13:56:20'),
('MADEIRA LIDO, C.A.', 'J412636766', '00000000000000000000', 'A000015914', NULL, '10.072446434902902', '-69.31783739111398', 'AV. VZLA A/ ARG.BRAC. 7 AV CRISPUL BENITEZ/HOTEL LIDO BOUTIQ.', 1, 'NORTE', '+584145013069', NULL, 1, NULL, '2019-09-14 00:00:00', '2019-12-13 09:39:48'),
('QUINCALLA EL LLANERITO', 'V059540927', '00000000000000000000', 'L0108419-7', NULL, '10.112677193316525', '-69.34096538141807', 'AV VIA DUACA. CALLE 1 ENTRE CARRERAS 1-2 Y 3. CASA N° 100. S', 1, 'NORTE', '+584262730711', NULL, 9, NULL, '2019-09-14 00:00:00', '2019-12-13 10:18:09'),
('ALJON SUMINISTROS, C.A.', 'J312343520', '01121624005000000000', 'L000002481', NULL, '10.06305546408615', '-69.31550130819232', 'CARR. 16 ENTRE CALLES 24Y25. C.C PROFESIONAL', 1, 'CENTRO', '+584166560216', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:17:14'),
('ADMINISTRA BIENES SAAP, C.A.', 'J085301542', '02022028010010000000', 'L311256', NULL, '10.066874488843052', '-69.31975034071729', 'AV. 20 ENTRE 28 Y 29.EDIF. SAAP. PISO 1. OFIC 212.BARQUISIME', 1, 'CENTRO', '+584241571448', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:20:38'),
('METALDECK, C.A.', 'J412569546', '00000000000000000000', 'A000015756', NULL, '10.074119497983835', '-69.30508426022288', 'AV. VZLA CON ESQ. CALLE 13 NRO 1', 1, 'CENTRO', '+584245236739', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:24:51'),
('MULTISERVICIOS CURARIGUA 2008, C.A.', 'J295857950', '02012036004000000000', 'L000011248', NULL, '10.065169274135485', '-69.32696839284557', 'CARR. 19 ESQ. CALLE 36', 1, 'CENTRO', '+584245107845', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:28:01'),
('TRIANIA ALVARADO(LAS GUARITAS STYLE) F.P', 'V167962200', '02025004000000000000', 'L000017848', NULL, '10.06700645977329', '-69.31541545316577', 'CALLE 25 ENTRE AV 20 Y CRR 19 C.C SIGLO 20 LOCAL K', 1, 'CENTRO', '+584264484533', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:32:36'),
('VIVIANNY\'S', C.A.', 'J298653400', '02032829001000000000', 'L000022880', NULL, '10.074547040897441', '-69.3227669444343', 'CARRE. 28 ENTRE CALLES 30Y31. LOCAL NRO 30-90', 1, 'CENTRO', '+584161245806', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:36:07'),
('REPUESTOS Y SERVICIOS JJ CAR\'S', C.A.', 'J312204923', '01102915020000000000', 'L000017390', NULL, '10.075462731472328', '-69.30791263921344', 'CARR. 28 ENTRE CALLES 15Y16. NRO 15-47', 1, 'CENTRO', '+584145662398', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:39:22'),
('SUKKA\'S', 'C.A'.', 'J407951521', '00000000000000000000', 'A000015948', NULL, '10.0626495829471', '-69.36546564102173', 'AV. FLORENCIO JIMENEZ Y AV. LA SALLE. C.C. METROPOLIS NVL AGUA', 1, 'OESTE', '+584262332690', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-13 12:48:36'),
('TOTALSALUD S.A.', 'J314723995', '02011726020000000000', 'RF00000041', NULL, '10.06406450589773', '-69.31723824243085', 'CARRERA 17 ESQUINA CALLE 26 EDIFICIO CENTRO PLAZA PISO PB LO', 0, 'CENTRO', '+584262504400', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 12:52:40'),
('REDOESTE C.A.', 'J0302687632', '02080055022000000000', 'L313383', NULL, '10.055913582749735', '-69.34124152247892', 'CARR. 13 ENTRE CALLES 51Y52', 1, 'CENTRO', '+584265050674', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 13:31:19'),
('RODECAS INSUMOS,C.A.(OFIC.ADM)', 'J317691156', '01092110013000000000', 'L000013967', NULL, '10.069314518156295', '-69.30208478352688', 'CARRERA 21 ENTRE CALLES 10-11 NRO 10-46', 1, 'CENTRO', '+584268080513', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 13:35:59'),
('SUBURI LARA, C.A.', 'J401241271', '01122218015000000000', 'L000017115', NULL, '10.06527666988566', '-69.31019169256683', 'CALLE 19 ENTRE CARRERAS 21 Y 22 Nº 21-95', 1, 'CENTRO', '+584264177022', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 13:38:11'),
('LICORERIA Y ABASTO LOS EVIES C.A.', 'J0310659125', '02190044007000000000', 'L000001693', NULL, '10.031728900766545', '-69.39515264673668', 'BARRIO CERRITO BLANCO VEREDA 21 ENTRE 3Y5 NOR. 12-52', 1, 'OESTE', '+584262522214', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-13 13:44:18'),
('RELEVEN C.A.', 'J041942827', '01102427014001001000', 'L00002389', NULL, '10.070286742762145', '-69.3090705292642', 'AV. VARGAS ENTRE CALLES 23Y24  EDIFICIO ANTHONY', 1, 'CENTRO', '+584262679242', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-13 13:50:31');
('INVERKING KONG DE VENEZUELA, C.A.', 'J400105080', '02090031033000000000', 'L000022171', '2019-12-12', '10.048451527106744', '-69.34652924537659', 'CARRERA 6 CON CALLE 58 Y 59 NRO 58-60', 1, 'CENTRO', '+582514424806', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-16 11:30:06'),
('FARMACIA DE PAVIA, C.A.', 'J412183621', '00000000000000000000', 'A000016069', '2019-12-13', '10.102931724440966', '-69.43876019258505', 'AV, PRINCIPAL DE PAVIA. KM 10', 1, 'OESTE', '+584168665095', NULL, 2, NULL, '2019-09-14 00:00:00', '2019-12-16 11:48:02'),
('DISTRIBUIDORA LEON CUEROS, C.A.', 'J311555480', '00000000000000000000', 'A000013451', '2019-12-13', '10.067776941253626', '-69.32529448598711', 'CALLE 31 ETRE CARRERAS 21Y22. NRO21-39', 1, 'CENTRO', '+582512670989', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-16 11:51:59'),
('COMERCIAL FASHION 2008, C.A.', 'J294932916', '00000000000000000000', 'A000015981', '2008-12-19', '10.066225145173512', '-69.32743177157289', 'AV. 20 ENTRE CALLES 36Y37.', 1, 'CENTRO', '+582512670979', NULL, 3, NULL, '2019-09-14 00:00:00', '2019-12-16 12:03:49'),
('CEPROALARM, C.A.', 'J075338081', '03070023010057000000', 'L319484', '2019-12-11', '10.068924417668384', '-69.2837655544281', 'AV. LOS LEONES C. EMPRESARIAL BQTO, PISO 5 OF.5-6', 1, 'ESTE', '+582512009100', NULL, 8, NULL, '2019-09-14 00:00:00', '2019-12-16 13:19:40');

