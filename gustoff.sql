-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2026 a las 23:43:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gustoff`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_calificacion` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `puntaje` tinyint(4) NOT NULL,
  `comentario` varchar(300) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `icono` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `icono`) VALUES
(1, 'Platos típicos', '🇧🇴'),
(2, 'Pollo', '🍗'),
(3, 'Carne de res', '🥩'),
(4, 'Pescado', '🐟'),
(5, 'Arroces', '🍚'),
(6, 'Pastas', '🍝'),
(7, 'Ensaladas', '🥗'),
(8, 'Desayunos', '🍳'),
(9, 'Postres', '🍮'),
(10, 'Vegetarianas', '🥦'),
(11, 'Snacks', '🥟'),
(12, 'Sopas', '🍲'),
(13, 'Guisos', '🥘'),
(14, 'Huevos', '🥚');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `id_usuario` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `nombre_normalizado` varchar(80) NOT NULL,
  `es_basico` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `nombre`, `nombre_normalizado`, `es_basico`) VALUES
(1, 'Carne de res', 'carne de re', 0),
(2, 'Papa', 'papa', 0),
(3, 'Arroz', 'arroz', 0),
(4, 'Huevo', 'huevo', 0),
(5, 'Tomate', 'tomate', 0),
(6, 'Cebolla', 'cebolla', 0),
(7, 'Pan rallado', 'pan rallado', 0),
(8, 'Ajo', 'ajo', 0),
(9, 'Perejil', 'perejil', 0),
(10, 'Limón', 'limon', 0),
(11, 'Sal', 'sal', 1),
(12, 'Aceite', 'aceite', 1),
(13, 'Pimienta', 'pimienta', 1),
(14, 'Comino', 'comino', 1),
(15, 'Salchicha', 'salchicha', 0),
(16, 'Locoto', 'locoto', 0),
(17, 'Mostaza', 'mostaza', 0),
(18, 'Salsa de tomate', 'salsa de tomate', 0),
(19, 'Mani', 'mani', 0),
(20, 'Zanahoria', 'zanahoria', 0),
(21, 'Arveja', 'arveja', 0),
(22, 'Fideo', 'fideo', 0),
(23, 'Agua', 'agua', 1),
(24, 'Pollo', 'pollo', 0),
(25, 'Ají amarillo', 'aji amarillo', 0),
(26, 'Carne de cerdo', 'carne de cerdo', 0),
(27, 'Mote', 'mote', 0),
(28, 'Chuño', 'chuño', 0),
(29, 'Orégano', 'oregano', 1),
(30, 'Charque', 'charque', 0),
(31, 'Platano', 'platano', 0),
(32, 'Queso', 'queso', 0),
(33, 'Salsa de soya', 'salsa de soya', 0),
(34, 'Vinagre', 'vinagre', 0),
(35, 'Carne molida', 'carne molida', 0),
(36, 'Trucha', 'trucha', 0),
(37, 'Harina', 'harina', 0),
(38, 'Lechuga', 'lechuga', 0),
(39, 'Pescado', 'pescado', 0),
(40, 'Jengibre', 'jengibre', 0),
(41, 'Leche', 'leche', 0),
(42, 'Mantequilla', 'mantequilla', 0),
(43, 'Quinua', 'quinua', 0),
(44, 'Pepino', 'pepino', 0),
(45, 'Mayonesa', 'mayonesa', 0),
(46, 'Pan', 'pan', 0),
(47, 'Azucar', 'azucar', 0),
(48, 'Miel', 'miel', 0),
(49, 'Canela', 'canela', 0),
(50, 'Choclo', 'choclo', 0),
(51, 'Anís', 'ani', 0),
(52, 'Pasa', 'pasa', 0),
(53, 'Vainilla', 'vainilla', 0),
(54, 'Chocolate', 'chocolate', 0),
(55, 'Nuez', 'nuez', 0),
(56, 'Lenteja', 'lenteja', 0),
(57, 'Yuca', 'yuca', 0),
(58, 'Zapallo', 'zapallo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasos_receta`
--

CREATE TABLE `pasos_receta` (
  `id_paso` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `numero_paso` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pasos_receta`
--

INSERT INTO `pasos_receta` (`id_paso`, `id_receta`, `numero_paso`, `descripcion`) VALUES
(1, 1, 1, 'Corta la carne en filetes y golpéalos con un mazo hasta dejarlos muy delgados. Sazona con ajo molido, sal, pimienta y comino.'),
(2, 1, 2, 'Hierve las papas con cáscara, pélalas, córtalas en rodajas y fríelas hasta que doren. Cocina el arroz con agua y una pizca de sal.'),
(3, 1, 3, 'Pasa los filetes por huevo batido y luego por pan rallado; fríelos en aceite caliente hasta que estén dorados y crocantes.'),
(4, 1, 4, 'Prepara la salsa picando tomate y cebolla en cuadritos finos con limón, sal y perejil.'),
(5, 1, 5, 'Arma el plato: arroz y papas como base, encima el filete, un huevo frito y la salsa por encima. Sirve de inmediato.'),
(6, 2, 1, 'Corta la carne en tiras o cubos y sazónala con ajo, sal, pimienta y comino. Corta las salchichas en rodajas.'),
(7, 2, 2, 'Fríe las papas en bastones hasta que queden doradas y crocantes; resérvalas.'),
(8, 2, 3, 'Sofríe la carne a fuego alto hasta que se dore, agrega la salchicha y cocina unos minutos más.'),
(9, 2, 4, 'Añade cebolla y tomate en tiras, el locoto en rodajas, mostaza y salsa de tomate; cocina 5 minutos sin que se deshagan las verduras.'),
(10, 2, 5, 'Sirve sobre las papas fritas, corona con huevos duros en rodajas y lleva a la mesa bien caliente.'),
(11, 3, 1, 'Hierve la carne en agua con sal hasta que esté tierna (unos 40 minutos). Reserva el caldo.'),
(12, 3, 2, 'Tuesta el maní, pélalo y lícualo con un poco de caldo hasta obtener una crema fina.'),
(13, 3, 3, 'Sofríe cebolla y ajo, agrega el maní licuado, comino y el caldo; cocina a fuego medio 15 minutos.'),
(14, 3, 4, 'Añade zanahoria en cubos, arvejas y papa en cubos pequeños; cuando estén casi tiernas, agrega el fideo y cocina 8 minutos más.'),
(15, 3, 5, 'Fríe papas en bastones finitos para decorar. Sirve la sopa caliente con la carne, perejil y las papas fritas encima.'),
(16, 4, 1, 'Sofríe cebolla y ajo picados con el ají amarillo y el comino hasta formar un aderezo fragante.'),
(17, 4, 2, 'Agrega el pollo en presas, sal y una taza de agua; cocina a fuego medio 25 minutos tapado.'),
(18, 4, 3, 'Añade las papas en trozos y las arvejas; cocina hasta que las papas estén tiernas y la salsa espese.'),
(19, 4, 4, 'Sirve con arroz blanco.'),
(20, 5, 1, 'Hierve el cerdo en agua con sal, cebolla entera y ajo durante 50 minutos. Retira la carne y conserva el caldo.'),
(21, 5, 2, 'Sofríe el ají amarillo con comino y orégano; agrégalo al caldo.'),
(22, 5, 3, 'Incorpora la carne y deja hervir a fuego bajo 30 minutos, hasta que el caldo espese ligeramente.'),
(23, 5, 4, 'Remoja el chuño, pélalo y hiérvelo aparte junto con el mote hasta que estén tiernos.'),
(24, 5, 5, 'Sirve el fricasé muy caliente con mote y chuño, espolvoreado con perejil picado.'),
(25, 6, 1, 'Hierve el charque unos minutos, escúrrelo y desmenúzalo bien.'),
(26, 6, 2, 'Sofríe cebolla, ajo y tomate; agrega el charque y cocina 5 minutos con comino.'),
(27, 6, 3, 'Añade el arroz, mezcla y vierte el agua con sal; cocina tapado a fuego bajo hasta que el arroz esté suelto.'),
(28, 6, 4, 'Fríe el plátano en rodajas gruesas y los huevos.'),
(29, 6, 5, 'Sirve el majadito con huevo y plátano frito al lado.'),
(30, 7, 1, 'Sofríe cebolla, ajo, ají amarillo, comino y orégano hasta que suelten su aroma.'),
(31, 7, 2, 'Agrega el pollo en presas con sal y media taza de agua; cocina tapado 30 minutos.'),
(32, 7, 3, 'Añade el chuño ya remojado y pelado, las papas y las arvejas. Cocina 20 minutos más hasta que todo esté tierno.'),
(33, 7, 4, 'Rectifica la sal y sirve con arroz blanco.'),
(34, 8, 1, 'Remoja el charque unas horas y hiérvelo hasta ablandarlo. Escúrrelo y desmenúzalo.'),
(35, 8, 2, 'Hierve el mote y las papas con sal hasta que estén tiernos.'),
(36, 8, 3, 'Dora el charque en una sartén con un poco de aceite hasta que quede crocante.'),
(37, 8, 4, 'Fríe los huevos y corta el queso en rebanadas.'),
(38, 8, 5, 'Sirve el charque con mote, papa, huevo, queso y una ensalada de cebolla y tomate picados.'),
(39, 9, 1, 'Corta la pechuga en filetes delgados y sazónalos con sal, pimienta, ajo y jugo de limón.'),
(40, 9, 2, 'Pásalos por huevo batido y luego por pan rallado, presionando para que se adhiera.'),
(41, 9, 3, 'Fríelos en aceite caliente hasta que estén dorados y bien cocidos, unos 4 minutos por lado.'),
(42, 9, 4, 'Escurre sobre papel absorbente y sirve con arroz, papas o ensalada.'),
(43, 10, 1, 'Mezcla ajo molido, jugo de limón, orégano, sal, pimienta y un chorrito de aceite; marina el pollo al menos 30 minutos.'),
(44, 10, 2, 'Pela las papas, córtalas en gajos y colócalas con la cebolla en rodajas en una fuente para horno.'),
(45, 10, 3, 'Coloca el pollo encima y hornea a 200 °C durante 50 a 60 minutos, volteando a la mitad.'),
(46, 10, 4, 'Termina con perejil picado y sirve caliente.'),
(47, 11, 1, 'Corta el pollo en tiras finas y sazónalo con sal, pimienta y ajo.'),
(48, 11, 2, 'Saltea el pollo en una sartén bien caliente hasta que dore; retíralo.'),
(49, 11, 3, 'En la misma sartén cocina la zanahoria en tiras y la cebolla 3 minutos; agrega el tomate.'),
(50, 11, 4, 'Devuelve el pollo, añade salsa de soya o limón, mezcla 2 minutos y sirve.'),
(51, 12, 1, 'Corta la carne en tiras y sazónala con sal, pimienta y comino. Corta cebolla y tomate en gajos gruesos.'),
(52, 12, 2, 'Fríe las papas en bastones hasta dorar y resérvalas. Cocina el arroz.'),
(53, 12, 3, 'Saltea la carne en sartén muy caliente en tandas pequeñas para que se dore y no se hierva.'),
(54, 12, 4, 'Agrega la cebolla, el tomate, el ají, la salsa de soya y el vinagre; saltea 2 a 3 minutos.'),
(55, 12, 5, 'Mezcla con las papas fritas, espolvorea perejil y sirve con arroz.'),
(56, 13, 1, 'Sazona los bistecs con ajo molido, sal y pimienta. Cocina el arroz y fríe las papas en bastones.'),
(57, 13, 2, 'Dora los bistecs en una sartén caliente 3 a 4 minutos por lado; en la misma sartén sofríe la cebolla en aros.'),
(58, 13, 3, 'Fríe el plátano en rodajas y los huevos.'),
(59, 13, 4, 'Sirve todo junto: arroz, bistec con cebolla, papas, plátano y huevo.'),
(60, 14, 1, 'Mezcla la carne con huevo, pan rallado, ajo picado, perejil, sal y pimienta; forma bolitas del tamaño de una nuez.'),
(61, 14, 2, 'Dora las albóndigas en aceite caliente y resérvalas.'),
(62, 14, 3, 'Sofríe cebolla, agrega el tomate picado y orégano; cocina 10 minutos hasta formar la salsa.'),
(63, 14, 4, 'Regresa las albóndigas, tapa y cocina a fuego bajo 20 minutos.'),
(64, 14, 5, 'Sirve con fideo cocido, arroz o puré.'),
(65, 15, 1, 'Limpia las truchas, sazona con sal, pimienta y jugo de limón; deja reposar 10 minutos.'),
(66, 15, 2, 'Pásalas por harina y sacude el exceso.'),
(67, 15, 3, 'Fríe en aceite bien caliente unos 5 minutos por lado hasta que la piel quede crocante.'),
(68, 15, 4, 'Sirve con papas hervidas o fritas y ensalada de lechuga y tomate.'),
(69, 16, 1, 'Corta las papas en rodajas finas y colócalas en una fuente con cebolla, sal y un chorrito de aceite; hornea 15 minutos a 200 °C.'),
(70, 16, 2, 'Sazona el pescado con ajo molido, sal, pimienta, orégano y jugo de limón.'),
(71, 16, 3, 'Coloca el pescado sobre las papas y hornea 15 a 20 minutos más, hasta que esté opaco y se desmenuce fácil.'),
(72, 16, 4, 'Termina con perejil y rodajas de limón.'),
(73, 17, 1, 'Lava el arroz y cocínalo con agua y una pizca de sal hasta que esté suelto.'),
(74, 17, 2, 'Fríe los huevos en aceite caliente hasta que la clara esté dorada.'),
(75, 17, 3, 'Sirve el arroz con el huevo encima y, si deseas, rodajas de tomate.'),
(76, 18, 1, 'Sofríe la cebolla y el ajo y dora el pollo en trozos.'),
(77, 18, 2, 'Agrega zanahoria en cubitos, arvejas, el arroz lavado y agua (el doble del arroz) con sal y comino.'),
(78, 18, 3, 'Cocina tapado a fuego bajo hasta que el arroz esté cocido y suelto.'),
(79, 19, 1, 'Cocina el arroz con anticipación y déjalo enfriar (queda más suelto).'),
(80, 19, 2, 'Prepara una tortilla fina con los huevos, córtala en tiras y resérvala.'),
(81, 19, 3, 'Saltea el pollo picado con ajo y jengibre; agrega cebolla, zanahoria en cubitos y arvejas.'),
(82, 19, 4, 'Incorpora el arroz, la salsa de soya y la tortilla; saltea a fuego alto 5 minutos, rectifica y sirve.'),
(83, 20, 1, 'Hierve los fideos en agua con sal, escúrrelos y resérvalos.'),
(84, 20, 2, 'Sofríe la cebolla y el ajo picados; agrega el tomate picado y cocina hasta formar una salsa.'),
(85, 20, 3, 'Mezcla la salsa con los fideos y sirve caliente con queso rallado.'),
(86, 21, 1, 'Sofríe cebolla, ajo y zanahoria rallada hasta que estén suaves.'),
(87, 21, 2, 'Agrega la carne molida y dórala bien, deshaciendo los grumos.'),
(88, 21, 3, 'Añade el tomate licuado, orégano, sal y pimienta; cocina a fuego bajo 30 minutos.'),
(89, 21, 4, 'Cuece los tallarines al dente, mézclalos con la salsa y sirve con queso.'),
(90, 22, 1, 'Cuece los macarrones al dente y escúrrelos.'),
(91, 22, 2, 'Derrite la mantequilla, agrega la harina y cocina 1 minuto; vierte la leche poco a poco sin dejar de mover hasta espesar.'),
(92, 22, 3, 'Añade el queso rallado, sal y pimienta hasta que se derrita.'),
(93, 22, 4, 'Mezcla con los macarrones y, si quieres, gratina 10 minutos en el horno.'),
(94, 23, 1, 'Lava bien la quinua y cuécela en agua 15 minutos; escúrrela y deja enfriar.'),
(95, 23, 2, 'Pica tomate, pepino y cebolla en cubos pequeños.'),
(96, 23, 3, 'Mezcla todo con la quinua, jugo de limón, un chorrito de aceite, sal y perejil.'),
(97, 23, 4, 'Sirve fría, con queso en cubos si deseas.'),
(98, 24, 1, 'Hierve papas y zanahorias con cáscara hasta que estén tiernas; cuece las arvejas y los huevos duros.'),
(99, 24, 2, 'Pela y corta las papas, zanahorias y huevos en cubos.'),
(100, 24, 3, 'Mezcla con la mayonesa, unas gotas de limón, sal y pimienta. Enfría antes de servir.'),
(101, 25, 1, 'Sazona el pollo y cocínalo a la plancha hasta dorar; córtalo en tiras.'),
(102, 25, 2, 'Corta el pan en cubos y tuéstalo en sartén con un poco de aceite para hacer crutones.'),
(103, 25, 3, 'Mezcla mayonesa, jugo de limón, ajo molido y queso rallado para el aderezo.'),
(104, 25, 4, 'Arma la ensalada con lechuga troceada, pollo y crutones y baña con el aderezo.'),
(105, 26, 1, 'Bate los huevos con la leche, el azúcar y una pizca de sal.'),
(106, 26, 2, 'Agrega la harina poco a poco y mezcla hasta lograr una masa lisa; incorpora la mantequilla derretida.'),
(107, 26, 3, 'Vierte un cucharón de masa en una sartén caliente ligeramente engrasada y cocina 1 a 2 minutos por lado.'),
(108, 26, 4, 'Sirve con miel, mermelada o frutas.'),
(109, 27, 1, 'Bate los huevos con la leche, la canela y una cucharada de azúcar.'),
(110, 27, 2, 'Remoja cada rebanada de pan 20 segundos por lado.'),
(111, 27, 3, 'Dóralas en mantequilla a fuego medio hasta que estén doradas.'),
(112, 27, 4, 'Espolvorea azúcar o baña con miel y sirve calientes.'),
(113, 28, 1, 'Desgrana el choclo y muélelo con un poco de agua hasta obtener una masa espesa.'),
(114, 28, 2, 'Sofríe la cebolla picada en mantequilla y mézclala con la masa, el anís, el azúcar y sal.'),
(115, 28, 3, 'Coloca una porción de masa en cada hoja de choclo con un cubo de queso en el centro; dobla y ata.'),
(116, 28, 4, 'Cocina al vapor o en una olla con poca agua 40 minutos. Sirve calientes.'),
(117, 29, 1, 'Hierve el arroz con 2 tazas de agua y la canela hasta que el agua se absorba.'),
(118, 29, 2, 'Agrega la leche y cocina a fuego bajo, moviendo con frecuencia, 25 a 30 minutos.'),
(119, 29, 3, 'Incorpora el azúcar, las pasas y la cáscara de limón; cocina 5 minutos más hasta que espese.'),
(120, 29, 4, 'Sirve tibio o frío con canela en polvo.'),
(121, 30, 1, 'Haz el caramelo derritiendo media taza de azúcar en una flanera hasta que dore; esparce por las paredes.'),
(122, 30, 2, 'Licúa la leche, los huevos, el resto del azúcar y la vainilla.'),
(123, 30, 3, 'Vierte la mezcla en la flanera y cocina a baño maría en el horno a 160 °C durante 50 minutos.'),
(124, 30, 4, 'Deja enfriar, refrigera 3 horas y desmolda.'),
(125, 31, 1, 'Derrite el chocolate con la mantequilla a baño maría y deja entibiar.'),
(126, 31, 2, 'Bate los huevos con el azúcar y mezcla con el chocolate.'),
(127, 31, 3, 'Incorpora la harina tamizada y las nueces con movimientos suaves.'),
(128, 31, 4, 'Vierte en un molde engrasado y hornea a 180 °C unos 25 minutos; el centro debe quedar húmedo.'),
(129, 32, 1, 'Cuece las lentejas hasta que estén blandas y escúrrelas bien.'),
(130, 32, 2, 'Sofríe cebolla, ajo y zanahoria rallada; mezcla con las lentejas aplastadas, el huevo, pan rallado, sal y comino.'),
(131, 32, 3, 'Forma las hamburguesas y refrigera 15 minutos.'),
(132, 32, 4, 'Dóralas en sartén con poco aceite 4 minutos por lado y sirve en pan con lechuga y tomate.'),
(133, 33, 1, 'Pela las papas y córtalas en rodajas finas.'),
(134, 33, 2, 'Calienta la leche con ajo, sal y pimienta; vierte sobre las papas en una fuente engrasada con mantequilla.'),
(135, 33, 3, 'Cubre con queso y hornea a 190 °C unos 45 minutos hasta que estén tiernas y doradas.'),
(136, 34, 1, 'Mezcla la harina con sal, azúcar y mantequilla; agrega el huevo y agua tibia hasta formar una masa suave. Deja reposar 20 minutos.'),
(137, 34, 2, 'Estira la masa fina y corta círculos.'),
(138, 34, 3, 'Rellena con queso en cubos, cierra y sella los bordes con un tenedor.'),
(139, 34, 4, 'Fríe en aceite caliente hasta dorar. Sirve calientes.'),
(140, 35, 1, 'Hierve las papas, hazlas puré y sazona con sal.'),
(141, 35, 2, 'Prepara el relleno sofriendo cebolla con la carne, comino, sal y arvejas. Cuece un huevo duro y pícalo.'),
(142, 35, 3, 'Forma una bola de puré, haz un hueco, rellena con carne y huevo, y cierra.'),
(143, 35, 4, 'Pásalas por harina y huevo batido y fríelas hasta dorar.'),
(144, 36, 1, 'Pela la yuca, hiérvela hasta que esté muy blanda y aplástala en puré mientras está caliente.'),
(145, 36, 2, 'Agrega queso rallado, mantequilla y sal; mezcla hasta tener una masa homogénea.'),
(146, 36, 3, 'Forma cilindros alrededor de palitos de brocheta.'),
(147, 36, 4, 'Dóralos en horno caliente o fríelos hasta que queden crocantes por fuera.'),
(148, 37, 1, 'Quita las semillas del locoto si no quieres que pique demasiado.'),
(149, 37, 2, 'Muele (o licúa brevemente) el tomate con el locoto hasta obtener una salsa semi-gruesa.'),
(150, 37, 3, 'Agrega sal al gusto y, si quieres, cebolla picada. Sirve de inmediato.'),
(151, 38, 1, 'Pica la cebolla, la zanahoria y la papa en cubos pequeños.'),
(152, 38, 2, 'Hierve las verduras en agua con sal durante 15 minutos.'),
(153, 38, 3, 'Agrega los fideos y cocina 8 minutos más. Sirve caliente.'),
(154, 39, 1, 'Hierve el pollo con cebolla y sal en 2 litros de agua durante 30 minutos, espumando.'),
(155, 39, 2, 'Agrega zanahoria y papa en trozos y cocina 20 minutos.'),
(156, 39, 3, 'Añade fideo (opcional) 8 minutos antes de terminar y sirve con perejil.'),
(157, 40, 1, 'Sofríe cebolla y ajo en mantequilla; agrega el zapallo y la papa en cubos.'),
(158, 40, 2, 'Cubre con agua, sal y pimienta y cocina 20 minutos hasta que todo esté blando.'),
(159, 40, 3, 'Licúa con la leche hasta obtener una crema lisa, calienta unos minutos y sirve.'),
(160, 41, 1, 'Remoja las lentejas 30 minutos y escúrrelas.'),
(161, 41, 2, 'Sofríe la cebolla y el ajo; agrega la zanahoria y la papa en cubos.'),
(162, 41, 3, 'Añade las lentejas, cubre con agua y sal, y cocina 35 minutos hasta que estén blandas.'),
(163, 42, 1, 'Corta la carne en cubos y dórala en aceite; retírala.'),
(164, 42, 2, 'Sofríe cebolla, ajo y tomate; devuelve la carne con agua, sal, pimienta y orégano.'),
(165, 42, 3, 'Cocina tapado a fuego bajo 45 minutos.'),
(166, 42, 4, 'Añade papas, zanahorias y arvejas y cocina 25 minutos más hasta que todo esté tierno.'),
(167, 43, 1, 'Pela las papas, córtalas en rodajas finas y pica la cebolla.'),
(168, 43, 2, 'Fríe las papas y la cebolla en aceite hasta que estén suaves y escúrrelas.'),
(169, 43, 3, 'Bate los huevos con sal y mézclalos con las papas.'),
(170, 43, 4, 'Cuaja la mezcla en la sartén, dale la vuelta y cocina hasta que dore por ambos lados.'),
(171, 44, 1, 'Pica la cebolla, el tomate y ralla la zanahoria.'),
(172, 44, 2, 'Bate los huevos con sal y mezcla con las verduras.'),
(173, 44, 3, 'Cuaja en una sartén con aceite por ambos lados.'),
(174, 45, 1, 'Sofríe la cebolla picada y el tomate en cubitos 3 minutos.'),
(175, 45, 2, 'Bate los huevos con sal y pimienta y viértelos en la sartén.'),
(176, 45, 3, 'Revuelve suavemente a fuego bajo hasta que cuajen pero sigan jugosos; añade queso si deseas.'),
(177, 46, 1, 'Sofríe la cebolla y el ajo picados en un poco de aceite hasta que estén transparentes.'),
(178, 46, 2, 'Agrega las papas y la zanahoria en cubos, cubre con el agua y sal; cocina 25 minutos hasta que estén blandas.'),
(179, 46, 3, 'Aplasta parte de las papas con un tenedor dentro de la olla para espesar la sopa.'),
(180, 46, 4, 'Agrega la leche, pimienta y el queso en cubos; cocina 5 minutos y sirve con perejil.'),
(181, 47, 1, 'Corta las cebollas en aros finos y cocínalas en mantequilla a fuego bajo unos 25 minutos, hasta que estén doradas y dulces.'),
(182, 47, 2, 'Espolvorea la harina, mezcla 1 minuto y agrega el agua caliente con sal y pimienta; hierve 15 minutos.'),
(183, 47, 3, 'Tuesta las rebanadas de pan.'),
(184, 47, 4, 'Sirve la sopa en tazones, coloca el pan encima con abundante queso y gratina en el horno 5 a 8 minutos.'),
(185, 48, 1, 'Lava muy bien la quinua para quitar el amargor. Si usas carne, hiérvela primero 30 minutos.'),
(186, 48, 2, 'Sofríe la cebolla con comino y agrega el agua (o el caldo de la carne).'),
(187, 48, 3, 'Añade la quinua, la papa y la zanahoria en cubos y las arvejas; cocina 25 minutos.'),
(188, 48, 4, 'Rectifica la sal y sirve con perejil picado.'),
(189, 49, 1, 'Sofríe la cebolla picada y agrega el agua con sal.'),
(190, 49, 2, 'Incorpora todas las verduras cortadas en cubos y cocina 20 minutos.'),
(191, 49, 3, 'Si quieres, agrega un puñado de fideos los últimos 8 minutos. Sirve caliente.'),
(192, 50, 1, 'Sofríe la cebolla con el ají amarillo y el orégano.'),
(193, 50, 2, 'Agrega el agua, las papas en cubos, las arvejas y el choclo desgranado; cocina 20 minutos.'),
(194, 50, 3, 'Vierte la leche y el queso en cubos; cocina a fuego bajo 5 minutos.'),
(195, 50, 4, 'Rompe los huevos uno a uno sobre la sopa y cocínalos tapados 3 a 4 minutos. Sirve de inmediato.'),
(196, 51, 1, 'Sofríe la cebolla en un poco de aceite y agrega el agua con sal.'),
(197, 51, 2, 'Cuando hierva, añade el arroz lavado, la zanahoria y la papa en cubitos y las arvejas.'),
(198, 51, 3, 'Cocina 20 minutos y sirve con perejil.'),
(199, 52, 1, 'Hierve las papas con cáscara y los huevos por 10 minutos; pélalos y córtalos en cubos o rodajas.'),
(200, 52, 2, 'Corta la cebolla en pluma fina y déjala 5 minutos en agua con sal y limón para suavizarla.'),
(201, 52, 3, 'Mezcla todo con jugo de limón, aceite, sal, pimienta y mayonesa si deseas. Decora con perejil.'),
(202, 53, 1, 'Corta la cebolla en pluma fina y lávala con agua y sal.'),
(203, 53, 2, 'Corta los tomates en gajos y el locoto en tiritas finas.'),
(204, 53, 3, 'Mezcla todo con jugo de limón, un chorrito de aceite y sal. Deja reposar 5 minutos antes de servir.'),
(205, 54, 1, 'Corta el tomate en rodajas y el queso en láminas.'),
(206, 54, 2, 'Alterna ambos en un plato y agrega la cebolla en pluma.'),
(207, 54, 3, 'Aliña con aceite, limón, sal y orégano.'),
(208, 55, 1, 'Hierve las papas con cáscara y los huevos; pélalos y córtalos en rodajas y mitades.'),
(209, 55, 2, 'Licúa el queso con el ají amarillo, la leche, un chorrito de aceite y sal hasta lograr una crema espesa.'),
(210, 55, 3, 'Sirve las papas sobre hojas de lechuga, báñalas con la salsa y decora con el huevo.'),
(211, 56, 1, 'Pela las papas, córtalas en trozos y hiérvelas con sal hasta que estén muy blandas.'),
(212, 56, 2, 'Escúrrelas y aplástalas mientras están calientes.'),
(213, 56, 3, 'Agrega la mantequilla y la leche tibia poco a poco, mezclando hasta que quede cremoso. Rectifica sal y pimienta.'),
(214, 57, 1, 'Sofríe la cebolla en pluma hasta que esté transparente; agrega el ají, el tomate picado y el orégano.'),
(215, 57, 2, 'Cocina 8 minutos hasta formar una salsa espesa y sazona con sal.'),
(216, 57, 3, 'Fríe los huevos aparte y sírvelos sobre la salsa, con arroz blanco si deseas.'),
(217, 58, 1, 'Pela las papas y córtalas en cubos pequeños; fríelas en aceite hasta que estén doradas y blandas.'),
(218, 58, 2, 'Agrega la cebolla en pluma (y el tomate si quieres) y cocina 3 minutos.'),
(219, 58, 3, 'Bate los huevos con sal y pimienta, viértelos sobre las papas y revuelve hasta que cuajen.'),
(220, 59, 1, 'Sofríe la cebolla y el tomate picados en un poco de aceite durante 3 minutos.'),
(221, 59, 2, 'Agrega los huevos batidos con sal y revuelve a fuego bajo hasta que cuajen.'),
(222, 59, 3, 'Sirve de inmediato con pan tostado.'),
(223, 60, 1, 'Pela las papas, córtalas en bastones y enjuágalas con agua fría para quitar el almidón; sécalas muy bien.'),
(224, 60, 2, 'Fríelas en aceite caliente hasta que estén doradas y crocantes.'),
(225, 60, 3, 'Escúrrelas sobre papel absorbente y sazona con sal al instante.'),
(226, 61, 1, 'Hierve los huevos 10 minutos, enfríalos, pélalos y pártelos a la mitad a lo largo.'),
(227, 61, 2, 'Retira las yemas, aplástalas con la mayonesa, la mostaza, sal y pimienta.'),
(228, 61, 3, 'Rellena las claras con la crema y decora con perejil picado.'),
(229, 62, 1, 'Corta las cebollas en rodajas gruesas y separa los aros.'),
(230, 62, 2, 'Pásalos por harina, luego por la mezcla de huevo batido con leche, sal y pimienta, y finalmente por pan rallado.'),
(231, 62, 3, 'Fríe en aceite caliente 2 a 3 minutos hasta que estén dorados. Escurre y sirve calientes.'),
(232, 63, 1, 'Remoja el pan en la leche tibia durante 10 minutos y desármalo con un tenedor.'),
(233, 63, 2, 'Bate los huevos con el azúcar y la canela y mézclalos con el pan; agrega las pasas.'),
(234, 63, 3, 'Vierte en un molde con caramelo o engrasado con mantequilla y hornea a 170 °C unos 45 minutos.'),
(235, 63, 4, 'Deja enfriar antes de desmoldar.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id_receta` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `tipo_comida` enum('desayuno','almuerzo','cena','ambos','postre','snack') NOT NULL DEFAULT 'ambos',
  `tipo_plato` enum('sopa','segundo','ensalada','desayuno','postre','snack') NOT NULL DEFAULT 'segundo',
  `dificultad` enum('facil','media','dificil') NOT NULL DEFAULT 'facil',
  `tiempo_minutos` int(11) NOT NULL,
  `porciones` int(11) NOT NULL DEFAULT 2,
  `imagen_url` varchar(255) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id_receta`, `id_categoria`, `nombre`, `descripcion`, `tipo_comida`, `tipo_plato`, `dificultad`, `tiempo_minutos`, `porciones`, `imagen_url`, `activa`, `fecha_registro`) VALUES
(1, 1, 'Silpancho cochabambino', 'El plato estrella de Cochabamba: arroz, papa, carne apanada muy delgada, huevo frito y salsa de tomate y cebolla.', 'almuerzo', 'segundo', 'media', 60, 4, 'https://www.cocina-boliviana.com/base/stock/Post/60-image/60-image_small.jpg.webp', 1, '2026-11-18 19:17:28'),
(2, 1, 'Pique macho', 'Fiesta de carne, salchicha, papas fritas, huevo, locoto y cebolla; abundante y perfecto para compartir.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://www.soysucre.info/wp-content/uploads/2016/06/Cavendish-Soy-Sucre-05.jpg', 1, '2026-11-18 19:17:28'),
(3, 1, 'Sopa de maní', 'Cremosa sopa boliviana de maní con verduras, fideo y papas fritas doradas por encima.', 'almuerzo', 'sopa', 'media', 75, 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRx0ekKB38LeTWVULMJBZ2lqWZPbWSq_9PdmV8FxVcd7PZLKT5zwrc6E7Y&s=10', 1, '2026-11-18 19:17:28'),
(4, 1, 'Picante de pollo', 'Pollo guisado en salsa de ají amarillo con papas y arvejas, acompañado de arroz.', 'almuerzo', 'segundo', 'media', 60, 4, 'https://cdn.blog.paulinacocina.net/wp-content/uploads/2025/07/picante-de-pollo-boliviano-1753434162.jpg', 1, '2026-11-18 19:17:28'),
(5, 1, 'Fricasé paceño', 'Caldo espeso y picante de cerdo con ají amarillo, mote y chuño; ideal para el fin de semana.', 'almuerzo', 'segundo', 'dificil', 120, 6, 'https://www.cocina-boliviana.com/base/stock/Recipe/fricase/fricase_web.jpg.webp', 1, '2026-11-18 19:17:28'),
(6, 1, 'Majadito de charque', 'Arroz cocinado con charque desmenuzado, acompañado de huevo frito y plátano frito.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://www.recetas.com.bo/sites/default/files/2024-09/majadito-de-yuca.jpg', 1, '2026-11-18 19:17:28'),
(7, 1, 'Sajta de pollo', 'Guiso picante de pollo en salsa de ají amarillo con papas, chuño y arvejas.', 'almuerzo', 'segundo', 'media', 70, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw3xqbI564gIPZxjF8Fp-7N__zhfHaAa_TWw9QKK7vLObiXtSgwrWjZJA1&s=10', 1, '2026-11-18 19:17:28'),
(8, 1, 'Charquekan', 'Charque dorado con mote, papa, huevo y queso: sabor tradicional del valle.', 'almuerzo', 'segundo', 'media', 55, 4, 'https://www.cocina-boliviana.com/base/stock/Recipe/charkecan/charkecan_web.jpg', 1, '2026-11-18 19:17:28'),
(9, 2, 'Milanesa de pollo', 'Filetes de pollo apanados y fritos; crocantes por fuera y jugosos por dentro.', 'almuerzo', 'segundo', 'media', 40, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-OGT1tF-gnbspCn6ZvFa_6OvE02QQ4C0XsngpqkwbHQMH9wvhhFbIdvU&s=10', 1, '2026-11-18 19:17:28'),
(10, 2, 'Pollo al horno con papas', 'Muslos de pollo marinados con ajo y limón, dorados al horno con papas.', 'almuerzo', 'segundo', 'facil', 75, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ6QodZfCwDwW8DfKn18cQtcP0RDtkm-1f2jILyS9PbMpX7Fg0QWdXKCA7H&s=10', 1, '2026-11-18 19:17:28'),
(11, 2, 'Pollo salteado con verduras', 'Pollo en tiritas salteado a fuego fuerte con verduras crujientes; listo en menos de media hora.', 'cena', 'segundo', 'facil', 25, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvtwwOfb2paYQbfQYz7DGrkYT-y7tLutlHsFQ7_ZN7QMKPMFw5Fgd9ZOj4&s=10', 1, '2026-11-18 19:17:28'),
(12, 3, 'Lomo saltado', 'Clásico saltado de carne con cebolla, tomate y papas fritas, con salsa de soya.', 'almuerzo', 'segundo', 'media', 35, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZVteeEZ2X8dfNIRRNDf1MVT0dtvu4jrAvF4S1TRzVPIRchv2OwFW4Yp8&s=10', 1, '2026-11-18 19:17:28'),
(13, 3, 'Bistec a lo pobre', 'Bistec jugoso servido con arroz, papas fritas, plátano frito y huevo.', 'almuerzo', 'segundo', 'media', 40, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLrprKw8tnR7yiDYrPCmKw4QKZGeJRKLTi_1yzNyKKwa-XuIVBik0PsTA&s=10', 1, '2026-11-18 19:17:28'),
(14, 3, 'Albóndigas en salsa de tomate', 'Albóndigas suaves de carne molida cocidas en una salsa casera de tomate.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrNraw7h9EjT-aLc4oTkvVB0UjNsVsaR3XFQMwfDwb6fgmHLhzjSOC1No&s=10', 1, '2026-11-18 19:17:28'),
(15, 4, 'Trucha frita', 'Trucha entera enharinada y frita, con papas y ensalada fresca.', 'almuerzo', 'segundo', 'facil', 30, 2, 'https://i.pinimg.com/736x/96/e8/b0/96e8b06973e482fce204872addb77b92.jpg', 1, '2026-11-18 19:17:28'),
(16, 4, 'Pescado al horno con limón', 'Filetes de pescado jugosos al horno con papas, ajo y limón.', 'cena', 'segundo', 'facil', 40, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdczP70PX5grzrlnf8KkE1nCkzNR-6iajVhURqkROMu9VcrSYrwUEe5Vwo&s=10', 1, '2026-11-18 19:17:28'),
(17, 5, 'Arroz con huevo', 'Arroz blanco con huevo frito, un clásico del día a día.', 'almuerzo', 'segundo', 'facil', 20, 2, 'https://static.vecteezy.com/system/resources/previews/015/958/819/large_2x/fried-egg-rice-breakfast-fried-egg-sunny-side-rice-on-a-plate-isolated-on-white-background-photo.jpg', 1, '2026-11-18 19:17:28'),
(18, 5, 'Arroz con pollo', 'Arroz cocido con pollo, zanahoria y arvejas.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSB5KCCz_p4ut3H3EjAFP7xUCDRvWxlpKB0gv-BZjcAk2jY5_di53Bkl9c&s=10', 1, '2026-11-18 19:17:28'),
(19, 5, 'Arroz chaufa', 'Arroz salteado estilo chifa con pollo, huevo y verduras.', 'almuerzo', 'segundo', 'media', 35, 3, 'https://i.pinimg.com/736x/e5/f3/90/e5f3905af42e3ef6b3e7a26ef3269b47.jpg', 1, '2026-11-18 19:17:28'),
(20, 6, 'Fideo con tomate', 'Fideos con salsa casera de tomate, cebolla y ajo.', 'almuerzo', 'segundo', 'facil', 25, 3, 'https://media.istockphoto.com/id/637214478/es/foto/placa-de-pasta.jpg?s=612x612&w=0&k=20&c=eYixfZfThb-ZDf8cEWIqdA1Yz7yzxz3hHZllyYGD_fM=', 1, '2026-11-18 19:17:28'),
(21, 6, 'Tallarines a la boloñesa', 'Tallarines con salsa de carne molida y tomate cocinada lentamente.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://img.magnific.com/foto-gratis/espaguetis-salsa-bolonesa-tablexa-madera_123827-22962.jpg?semt=ais_hybrid&w=740&q=80', 1, '2026-11-18 19:17:28'),
(22, 6, 'Macarrones con queso', 'Macarrones cremosos con salsa de leche y queso gratinados.', 'cena', 'segundo', 'facil', 30, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpZ-_820kPEdrRHxJD75gFtlvTl44cBnUtM6nkUMKzSz0mfSxVBlICFvU3&s=10', 1, '2026-11-18 19:17:28'),
(23, 7, 'Ensalada de quinua', 'Ensalada fresca y nutritiva de quinua con tomate, pepino y limón.', 'almuerzo', 'ensalada', 'facil', 25, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ65zD4y3DTJDebodLHIfLJKsN6GWRi_9B_V3NTWyFORlKcTQvJXB3Nwm0&s=10', 1, '2026-11-18 19:17:28'),
(24, 7, 'Ensalada rusa', 'Cremosa ensalada de papa, zanahoria, arvejas y huevo con mayonesa.', 'almuerzo', 'ensalada', 'facil', 35, 4, 'https://static.guiainfantil.com/pictures/recetas/31665-receta-de-ensaladilla-rusa-casera-para-ninos.jpg', 1, '2026-11-18 19:17:28'),
(25, 7, 'Ensalada César con pollo', 'Lechuga crujiente, pollo a la plancha, crutones y aderezo cremoso con queso.', 'cena', 'ensalada', 'media', 30, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJIwe5gHuQoF2qop7v3ZrDHO0sspg4Q_Wdndpj9HyK0Wlb9faoy3sQ6qOA&s=10', 1, '2026-11-18 19:17:28'),
(26, 8, 'Panqueques', 'Panqueques suaves y delgados, perfectos con miel, mermelada o fruta.', 'desayuno', 'desayuno', 'facil', 25, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMf-bp7ZooCoIsixUrDd9l_Q2b2ha76FDvHgLpOLYEOw&s=10', 1, '2026-11-18 19:17:28'),
(27, 8, 'Tostadas francesas', 'Pan remojado en huevo y leche con canela, dorado en la sartén.', 'desayuno', 'desayuno', 'facil', 15, 2, 'https://embed.widencdn.net/img/mccormick/l07tbd4l9q/800x800px/tostadas_a_la_francesa.jpg?crop=true&q=80&color=ffffffff&u=qwwekl', 1, '2026-11-18 19:17:28'),
(28, 8, 'Humintas', 'Masa dulce-salada de choclo con queso, envuelta en hojas y cocida al vapor.', 'desayuno', 'desayuno', 'media', 70, 6, 'https://www.recetas.com.bo/sites/default/files/2020-02/humintas-a-la-olla-0115.jpg', 1, '2026-11-18 19:17:28'),
(29, 9, 'Arroz con leche', 'Cremoso arroz con leche perfumado con canela y limón.', 'postre', 'postre', 'facil', 45, 6, 'https://img.magnific.com/foto-gratis/arroz-leche-arroz-leche-canela-tazon-sobre-mesa-madera_123827-27589.jpg?semt=ais_hybrid&w=740&q=80\r\n', 1, '2026-11-18 19:17:28'),
(30, 9, 'Flan casero', 'Flan suave de leche y huevo con caramelo, el postre de siempre.', 'postre', 'postre', 'media', 75, 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoZ26D9-hejy5H-ASKI1N_hHRaFZs3bG7RjIzS2u1d7P0tR3Ctbwzf3Os&s=10', 1, '2026-11-18 19:17:28'),
(31, 9, 'Brownie de chocolate', 'Brownies húmedos y chocolatosos con borde crujiente.', 'postre', 'postre', 'media', 45, 8, 'https://i.pinimg.com/736x/22/d0/2c/22d02c3cbb0b2ba46f0089b6c94821fa.jpg', 1, '2026-11-18 19:17:28'),
(32, 10, 'Hamburguesas de lenteja', 'Hamburguesas proteicas de lenteja, económicas y llenadoras.', 'almuerzo', 'segundo', 'media', 45, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgDvY3mwWIr7aEJfhkrFY-eTZPFMeVvuAX__HV9JLe-NS5ELKGS4ef6ug&s=10', 1, '2026-11-18 19:17:28'),
(33, 10, 'Papas gratinadas con queso', 'Papas en rodajas horneadas con crema de leche, ajo y mucho queso.', 'cena', 'segundo', 'media', 60, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQI15x2ZYpKuT7ea-opip5YRdjLL3DTCQeg89ggbGjTGpf0wR5r70rxEJw&s=10', 1, '2026-11-18 19:17:28'),
(34, 11, 'Empanadas de queso', 'Empanadas fritas rellenas de queso derretido, crujientes por fuera.', 'snack', 'snack', 'media', 50, 10, 'https://www.recetas.com.bo/sites/default/files/2020-02/empanadas-0515.jpg', 1, '2026-11-18 19:17:28'),
(35, 11, 'Relleno de papa', 'Bolitas de puré de papa rellenas de carne y huevo, fritas hasta quedar doradas.', 'snack', 'snack', 'media', 60, 6, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoBweO1WgXmHSFcq7cb7f8HHotVz171Sq-sF-hOBPtZA&s=10', 1, '2026-11-18 19:17:28'),
(36, 11, 'Sonso de yuca', 'Masa de yuca con queso, asada o frita en brocheta: típica del oriente boliviano.', 'snack', 'snack', 'facil', 40, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJCACWu_XHfurWejrqlCUlM8BF3uWfLXtgGEUH_XTmLrtnuRfh515VHKM&s=10', 1, '2026-11-18 19:17:28'),
(37, 11, 'Llajua', 'Salsa picante boliviana de tomate y locoto, infaltable en la mesa.', 'snack', 'snack', 'facil', 10, 6, 'https://www.cocina-boliviana.com/base/stock/Recipe/llajua/llajua_web.jpg.webp', 1, '2026-11-18 19:17:28'),
(38, 12, 'Sopa de fideo', 'Sopa liviana con papa, zanahoria y fideo.', 'cena', 'sopa', 'facil', 35, 4, 'https://thecheekychickpea.com/wp-content/uploads/2018/12/sopa-de-fideo-1.jpg', 1, '2026-11-18 19:17:28'),
(39, 12, 'Caldo de pollo', 'Caldo reconfortante de pollo con verduras, ideal para días fríos.', 'cena', 'sopa', 'facil', 60, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoe3ENo1na83xB_BoosLw3RC1ZpsT_r4gZFvsAdqsNRA&s=10', 1, '2026-11-18 19:17:28'),
(40, 12, 'Crema de zapallo', 'Crema aterciopelada de zapallo con un toque de ajo.', 'cena', 'sopa', 'facil', 40, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxLP57EhY-1XvvPuXCVWKUEo68USNogxmkOrlvqQgwdRtkIRZJaJwOrxg6&s=10', 1, '2026-11-18 19:17:28'),
(41, 13, 'Guiso de lentejas', 'Lentejas con papa y verduras, nutritivo y económico.', 'almuerzo', 'segundo', 'media', 50, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKvExKiTbiV0kaqqbtp5DPxi-Swt1LQAEqqH_eyiURJ0WbXbMvr8lW1eLx&s=10', 1, '2026-11-18 19:17:28'),
(42, 13, 'Estofado de carne con papas', 'Carne tierna cocida lentamente con papas, zanahoria y arvejas.', 'almuerzo', 'segundo', 'media', 90, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2BY3GvfiAkzaqJB0blQ5Mf-lHu9Scqf-otvY8JJqPvvltRV3z1KePjyrS&s=10', 1, '2026-11-18 19:17:28'),
(43, 14, 'Tortilla de papa', 'Tortilla casera de papa y cebolla, ideal para una cena rápida.', 'cena', 'segundo', 'facil', 25, 2, 'https://media.elgourmet.com/recetas/cover_kvh73gs5ar_tortilla.jpg', 1, '2026-11-18 19:17:28'),
(44, 14, 'Tortilla de verduras', 'Tortilla de huevo con zanahoria, cebolla y tomate.', 'cena', 'segundo', 'facil', 15, 2, 'https://i.blogs.es/d67d88/tortilla-de-verduras/840_560.jpg', 1, '2026-11-18 19:17:28'),
(45, 14, 'Huevos revueltos con tomate', 'Huevos revueltos suaves con tomate y cebolla, listos en 10 minutos.', 'desayuno', 'desayuno', 'facil', 10, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwAc6FUJXH52uPAfGsMx8t7yR9b21pvpel22QA70TdH6t-IoG8J8M_cYDa&s=10', 1, '2026-11-18 19:17:28'),
(46, 12, 'Sopa de papa', 'Sopa espesa y suave de papa con zanahoria y un toque de leche; ideal para días fríos.', 'almuerzo', 'sopa', 'facil', 40, 4, 'https://www.cocina-boliviana.com/base/stock/Recipe/caldo-de-papas-y-huevos/caldo-de-papas-y-huevos_web.jpg', 1, '2026-11-18 19:17:28'),
(47, 12, 'Sopa de cebolla gratinada', 'Sopa de cebolla caramelizada con pan tostado y queso gratinado.', 'cena', 'sopa', 'media', 55, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTD_uJ7OxBXEDd249Xx9-1nmFjUmoKR9ZVOYVYMnS9zQWzw2fINGyJcMBg&s=10', 1, '2026-11-18 19:17:28'),
(48, 12, 'Sopa de quinua', 'Sopa nutritiva del altiplano con quinua, papa y verduras.', 'almuerzo', 'sopa', 'facil', 45, 5, 'https://www.recetasnestle.com.ec/sites/default/files/srh_recipes/1c7c9902781c62ebd24ea257fd5a6271.jpg', 1, '2026-11-18 19:17:28'),
(49, 12, 'Sopa de verduras', 'Sopa ligera con papa, zapallo, zanahoria y arvejas.', 'cena', 'sopa', 'facil', 40, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLZ0WglYX4IGgdJNmgUjV9UZI1779rhJDUroKaCLbl1wkZqRFWRkzktA0t&s=10', 1, '2026-11-18 19:17:28'),
(50, 12, 'Chupe de papa con huevo y queso', 'Sopa cremosa de papa, leche, queso y huevo escalfado, con un toque de ají amarillo.', 'almuerzo', 'sopa', 'media', 45, 4, 'https://recetascocinaperuana.com/wp-content/uploads/2025/08/chupe-de-papas.jpg\r\n', 1, '2026-11-18 19:17:28'),
(51, 12, 'Sopa de arroz', 'Sopa casera de arroz con verduras, económica y reconfortante.', 'cena', 'sopa', 'facil', 35, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSpJOFkBGnqucuS8ga51HtOnMgGdhkZKRAtVJHzow0YqL00KtAT96ZRhRc0&s=10', 1, '2026-11-18 19:17:28'),
(52, 7, 'Ensalada de papa y huevo', 'Papas cocidas, huevo duro y cebolla aliñados con limón; sencilla y llenadora.', 'almuerzo', 'ensalada', 'facil', 30, 4, 'https://conave.org/wp-content/uploads/2020/05/ensalada-de-papa-con-huevo.jpg', 1, '2026-11-18 19:17:28'),
(53, 7, 'Ensalada criolla', 'La clásica ensalada de tomate y cebolla con limón, perfecta para acompañar carnes.', 'almuerzo', 'ensalada', 'facil', 10, 4, 'https://perudelights.com/wp-content/uploads/2011/06/SALSA-CRIOLLA-LISTA1-1024x7681-1024x768.jpg', 1, '2026-11-18 19:17:28'),
(54, 7, 'Ensalada de tomate y queso', 'Tomate fresco con queso, cebolla y orégano.', 'cena', 'ensalada', 'facil', 10, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdi-qkYUsdiKfM3JQrTNkYfMvSHny8XiRTSYEZFZgwIj-CGqzh37bAsBjz&s=10', 1, '2026-11-18 19:17:28'),
(55, 10, 'Papa a la huancaína', 'Papas cocidas bañadas en una cremosa salsa de queso y ají amarillo, con huevo duro.', 'almuerzo', 'segundo', 'media', 40, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTq0jl3CnsphTk44PJjx073EuKbGk95mp5rnMAjgHLdc8h81M-bk0AWnEZW&s=10', 1, '2026-11-18 19:17:28'),
(56, 10, 'Puré de papa', 'Puré suave y cremoso, el acompañante perfecto de carnes y milanesas.', 'almuerzo', 'segundo', 'facil', 30, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT33Q3nx650iMKyRelyNcqvDpF3bDfvvG2-fEOmPc0nZ53shoSGZoBD538&s=10\r\n', 1, '2026-11-18 19:17:28'),
(57, 14, 'Huevos a la criolla', 'Huevos fritos sobre una salsa criolla de cebolla, tomate y ají.', 'almuerzo', 'segundo', 'facil', 20, 2, 'https://comedera.com/wp-content/uploads/sites/9/2022/11/Huevos-rotos-PG_HC170520002.jpg', 1, '2026-11-18 19:17:28'),
(58, 14, 'Revuelto de papa con huevo y cebolla', 'Papas doradas con cebolla y huevo revuelto: un segundo rápido con lo básico de la cocina.', 'almuerzo', 'segundo', 'facil', 25, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLZ2h8qliLNsjcNB0mAfNEaf1I_tszNbeW4zzBMiWo2Y7aIXikOrNN39Er&s=10', 1, '2026-11-18 19:17:28'),
(59, 8, 'Huevos pericos', 'Huevos revueltos con tomate, cebolla y ají: el desayuno más rápido y sabroso.', 'desayuno', 'desayuno', 'facil', 10, 2, 'https://cdn.bolivia.com/gastronomia/2017/07/10/huevos-pericos-colombianos-3033.jpg', 1, '2026-11-18 19:17:28'),
(60, 11, 'Papas fritas caseras', 'Papas doradas y crocantes, hechas en casa con solo tres ingredientes.', 'snack', 'snack', 'facil', 25, 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpRmYt47I51PqvU1CLyx8tEWnEa4aL-ftqre33QN44qYRT2aRlBBE0Pak&s=10', 1, '2026-11-18 19:17:28'),
(61, 11, 'Huevos rellenos', 'Huevos duros rellenos con una crema de yema y mayonesa.', 'snack', 'snack', 'facil', 25, 4, 'https://i.blogs.es/f0d1b8/huevos_rellenos/1200_900.jpg', 1, '2026-11-18 19:17:28'),
(62, 11, 'Aros de cebolla', 'Aros de cebolla apanados y fritos, crujientes por fuera y tiernos por dentro.', 'snack', 'snack', 'media', 30, 4, 'https://granvita.com/wp-content/uploads/2021/10/receta-de-aros-de-ceblla-en-horno.jpg', 1, '2026-11-18 19:17:28'),
(63, 9, 'Budín de pan', 'Postre casero que aprovecha el pan duro, con leche, huevo y canela.', 'postre', 'postre', 'media', 60, 6, 'https://hileret.com.ar/app/uploads/2021/02/cocinar-en-casa-budin-de-pan.jpg', 1, '2026-11-18 19:17:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_ingredientes`
--

CREATE TABLE `receta_ingredientes` (
  `id` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(8,2) DEFAULT NULL,
  `unidad` varchar(30) DEFAULT NULL,
  `opcional` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `receta_ingredientes`
--

INSERT INTO `receta_ingredientes` (`id`, `id_receta`, `id_ingrediente`, `cantidad`, `unidad`, `opcional`) VALUES
(1, 1, 1, 600.00, 'g', 0),
(2, 1, 2, 4.00, 'unidades', 0),
(3, 1, 3, 2.00, 'tazas', 0),
(4, 1, 4, 4.00, 'unidades', 0),
(5, 1, 5, 2.00, 'unidades', 0),
(6, 1, 6, 2.00, 'unidades', 0),
(7, 1, 7, 1.00, 'taza', 0),
(8, 1, 8, 2.00, 'dientes', 0),
(9, 1, 9, 2.00, 'cucharadas', 1),
(10, 1, 10, 1.00, 'unidad', 0),
(11, 1, 11, NULL, 'al gusto', 0),
(12, 1, 12, NULL, 'para freír', 0),
(13, 1, 13, NULL, 'al gusto', 0),
(14, 1, 14, NULL, 'al gusto', 0),
(15, 2, 1, 500.00, 'g', 0),
(16, 2, 15, 4.00, 'unidades', 0),
(17, 2, 2, 5.00, 'unidades', 0),
(18, 2, 6, 2.00, 'unidades', 0),
(19, 2, 5, 2.00, 'unidades', 0),
(20, 2, 16, 2.00, 'unidades', 0),
(21, 2, 4, 3.00, 'unidades', 0),
(22, 2, 8, 2.00, 'dientes', 0),
(23, 2, 17, 1.00, 'cucharada', 1),
(24, 2, 18, 3.00, 'cucharadas', 1),
(25, 2, 11, NULL, 'al gusto', 0),
(26, 2, 12, NULL, 'para freír', 0),
(27, 2, 13, NULL, 'al gusto', 0),
(28, 2, 14, NULL, 'al gusto', 0),
(29, 3, 19, 1.50, 'tazas', 0),
(30, 3, 1, 400.00, 'g', 0),
(31, 3, 2, 4.00, 'unidades', 0),
(32, 3, 20, 2.00, 'unidades', 0),
(33, 3, 21, 1.00, 'taza', 0),
(34, 3, 22, 100.00, 'g', 0),
(35, 3, 6, 1.00, 'unidad', 0),
(36, 3, 8, 2.00, 'dientes', 0),
(37, 3, 9, 2.00, 'cucharadas', 1),
(38, 3, 11, NULL, 'al gusto', 0),
(39, 3, 12, NULL, 'para freír', 0),
(40, 3, 23, NULL, '2 litros', 0),
(41, 3, 14, NULL, 'al gusto', 0),
(42, 4, 24, 600.00, 'g', 0),
(43, 4, 2, 4.00, 'unidades', 0),
(44, 4, 6, 1.00, 'unidad', 0),
(45, 4, 25, 2.00, 'cucharadas', 0),
(46, 4, 21, 1.00, 'taza', 0),
(47, 4, 8, 2.00, 'dientes', 0),
(48, 4, 3, 2.00, 'tazas', 1),
(49, 4, 11, NULL, 'al gusto', 0),
(50, 4, 12, NULL, 'para freír', 0),
(51, 4, 14, NULL, 'al gusto', 0),
(52, 5, 26, 800.00, 'g', 0),
(53, 5, 25, 4.00, 'cucharadas', 0),
(54, 5, 6, 1.00, 'unidad', 0),
(55, 5, 8, 3.00, 'dientes', 0),
(56, 5, 27, 2.00, 'tazas', 0),
(57, 5, 28, 4.00, 'unidades', 0),
(58, 5, 29, NULL, 'al gusto', 0),
(59, 5, 9, 2.00, 'cucharadas', 1),
(60, 5, 11, NULL, 'al gusto', 0),
(61, 5, 12, NULL, 'para freír', 0),
(62, 5, 23, NULL, '2 litros', 0),
(63, 5, 14, NULL, 'al gusto', 0),
(64, 6, 30, 250.00, 'g', 0),
(65, 6, 3, 2.00, 'tazas', 0),
(66, 6, 6, 1.00, 'unidad', 0),
(67, 6, 5, 1.00, 'unidad', 0),
(68, 6, 4, 4.00, 'unidades', 0),
(69, 6, 31, 2.00, 'unidades', 0),
(70, 6, 8, 2.00, 'dientes', 0),
(71, 6, 11, NULL, 'al gusto', 0),
(72, 6, 12, NULL, 'para freír', 0),
(73, 6, 23, NULL, '4 tazas', 0),
(74, 6, 14, NULL, 'al gusto', 0),
(75, 7, 24, 700.00, 'g', 0),
(76, 7, 25, 3.00, 'cucharadas', 0),
(77, 7, 6, 1.00, 'unidad', 0),
(78, 7, 8, 2.00, 'dientes', 0),
(79, 7, 2, 4.00, 'unidades', 0),
(80, 7, 28, 3.00, 'unidades', 0),
(81, 7, 21, 0.50, 'taza', 0),
(82, 7, 3, 2.00, 'tazas', 1),
(83, 7, 11, NULL, 'al gusto', 0),
(84, 7, 12, NULL, 'para freír', 0),
(85, 7, 29, NULL, 'al gusto', 0),
(86, 7, 14, NULL, 'al gusto', 0),
(87, 8, 30, 300.00, 'g', 0),
(88, 8, 27, 2.00, 'tazas', 0),
(89, 8, 2, 4.00, 'unidades', 0),
(90, 8, 4, 4.00, 'unidades', 0),
(91, 8, 32, 200.00, 'g', 0),
(92, 8, 6, 1.00, 'unidad', 0),
(93, 8, 5, 1.00, 'unidad', 0),
(94, 8, 11, NULL, 'al gusto', 0),
(95, 8, 12, NULL, 'para freír', 0),
(96, 8, 23, NULL, 'para hervir', 0),
(97, 9, 24, 500.00, 'g', 0),
(98, 9, 4, 2.00, 'unidades', 0),
(99, 9, 7, 1.00, 'taza', 0),
(100, 9, 10, 1.00, 'unidad', 1),
(101, 9, 8, 1.00, 'diente', 1),
(102, 9, 11, NULL, 'al gusto', 0),
(103, 9, 12, NULL, 'para freír', 0),
(104, 9, 13, NULL, 'al gusto', 0),
(105, 10, 24, 1.00, 'kg', 0),
(106, 10, 2, 5.00, 'unidades', 0),
(107, 10, 8, 4.00, 'dientes', 0),
(108, 10, 10, 2.00, 'unidades', 0),
(109, 10, 6, 1.00, 'unidad', 0),
(110, 10, 29, NULL, 'al gusto', 0),
(111, 10, 9, 2.00, 'cucharadas', 1),
(112, 10, 11, NULL, 'al gusto', 0),
(113, 10, 12, NULL, 'para freír', 0),
(114, 10, 13, NULL, 'al gusto', 0),
(115, 11, 24, 400.00, 'g', 0),
(116, 11, 20, 1.00, 'unidad', 0),
(117, 11, 6, 1.00, 'unidad', 0),
(118, 11, 5, 1.00, 'unidad', 0),
(119, 11, 8, 2.00, 'dientes', 0),
(120, 11, 33, 2.00, 'cucharadas', 1),
(121, 11, 10, 1.00, 'unidad', 1),
(122, 11, 11, NULL, 'al gusto', 0),
(123, 11, 12, NULL, 'para freír', 0),
(124, 11, 13, NULL, 'al gusto', 0),
(125, 12, 1, 500.00, 'g', 0),
(126, 12, 6, 2.00, 'unidades', 0),
(127, 12, 5, 2.00, 'unidades', 0),
(128, 12, 2, 4.00, 'unidades', 0),
(129, 12, 3, 2.00, 'tazas', 0),
(130, 12, 33, 3.00, 'cucharadas', 0),
(131, 12, 34, 1.00, 'cucharada', 1),
(132, 12, 25, 1.00, 'cucharada', 1),
(133, 12, 9, 2.00, 'cucharadas', 1),
(134, 12, 11, NULL, 'al gusto', 0),
(135, 12, 12, NULL, 'para freír', 0),
(136, 12, 13, NULL, 'al gusto', 0),
(137, 12, 14, NULL, 'al gusto', 0),
(138, 13, 1, 400.00, 'g', 0),
(139, 13, 3, 1.00, 'taza', 0),
(140, 13, 2, 3.00, 'unidades', 0),
(141, 13, 31, 1.00, 'unidad', 0),
(142, 13, 4, 2.00, 'unidades', 0),
(143, 13, 6, 1.00, 'unidad', 0),
(144, 13, 8, 1.00, 'diente', 0),
(145, 13, 11, NULL, 'al gusto', 0),
(146, 13, 12, NULL, 'para freír', 0),
(147, 13, 13, NULL, 'al gusto', 0),
(148, 14, 35, 500.00, 'g', 0),
(149, 14, 4, 1.00, 'unidad', 0),
(150, 14, 7, 0.50, 'taza', 0),
(151, 14, 6, 1.00, 'unidad', 0),
(152, 14, 5, 4.00, 'unidades', 0),
(153, 14, 8, 2.00, 'dientes', 0),
(154, 14, 9, 2.00, 'cucharadas', 1),
(155, 14, 22, 200.00, 'g', 1),
(156, 14, 11, NULL, 'al gusto', 0),
(157, 14, 12, NULL, 'para freír', 0),
(158, 14, 13, NULL, 'al gusto', 0),
(159, 14, 29, NULL, 'al gusto', 0),
(160, 15, 36, 2.00, 'unidades', 0),
(161, 15, 37, 0.50, 'taza', 0),
(162, 15, 10, 1.00, 'unidad', 0),
(163, 15, 2, 3.00, 'unidades', 0),
(164, 15, 38, 1.00, 'unidad', 1),
(165, 15, 5, 1.00, 'unidad', 1),
(166, 15, 11, NULL, 'al gusto', 0),
(167, 15, 12, NULL, 'para freír', 0),
(168, 15, 13, NULL, 'al gusto', 0),
(169, 16, 39, 600.00, 'g', 0),
(170, 16, 2, 3.00, 'unidades', 0),
(171, 16, 10, 2.00, 'unidades', 0),
(172, 16, 8, 3.00, 'dientes', 0),
(173, 16, 6, 1.00, 'unidad', 0),
(174, 16, 9, 2.00, 'cucharadas', 1),
(175, 16, 11, NULL, 'al gusto', 0),
(176, 16, 12, NULL, 'para freír', 0),
(177, 16, 13, NULL, 'al gusto', 0),
(178, 16, 29, NULL, 'al gusto', 0),
(179, 17, 3, 1.00, 'taza', 0),
(180, 17, 4, 2.00, 'unidades', 0),
(181, 17, 5, 1.00, 'unidad', 1),
(182, 17, 11, NULL, 'al gusto', 0),
(183, 17, 12, NULL, 'para freír', 0),
(184, 18, 3, 2.00, 'tazas', 0),
(185, 18, 24, 400.00, 'g', 0),
(186, 18, 20, 1.00, 'unidad', 0),
(187, 18, 21, 0.50, 'taza', 0),
(188, 18, 6, 1.00, 'unidad', 0),
(189, 18, 8, 2.00, 'dientes', 0),
(190, 18, 11, NULL, 'al gusto', 0),
(191, 18, 12, NULL, 'para freír', 0),
(192, 18, 14, NULL, 'al gusto', 0),
(193, 19, 3, 3.00, 'tazas', 0),
(194, 19, 24, 250.00, 'g', 0),
(195, 19, 4, 3.00, 'unidades', 0),
(196, 19, 20, 1.00, 'unidad', 0),
(197, 19, 21, 0.50, 'taza', 0),
(198, 19, 6, 1.00, 'unidad', 0),
(199, 19, 8, 2.00, 'dientes', 0),
(200, 19, 33, 3.00, 'cucharadas', 0),
(201, 19, 40, 1.00, 'cucharadita', 1),
(202, 19, 11, NULL, 'al gusto', 0),
(203, 19, 12, NULL, 'para freír', 0),
(204, 19, 13, NULL, 'al gusto', 0),
(205, 20, 22, 250.00, 'g', 0),
(206, 20, 5, 3.00, 'unidades', 0),
(207, 20, 6, 1.00, 'unidad', 0),
(208, 20, 8, 2.00, 'dientes', 0),
(209, 20, 32, 50.00, 'g', 1),
(210, 20, 11, NULL, 'al gusto', 0),
(211, 20, 12, NULL, 'para freír', 0),
(212, 20, 29, NULL, 'al gusto', 0),
(213, 21, 22, 400.00, 'g', 0),
(214, 21, 35, 400.00, 'g', 0),
(215, 21, 5, 5.00, 'unidades', 0),
(216, 21, 6, 1.00, 'unidad', 0),
(217, 21, 20, 1.00, 'unidad', 0),
(218, 21, 8, 2.00, 'dientes', 0),
(219, 21, 32, 60.00, 'g', 1),
(220, 21, 11, NULL, 'al gusto', 0),
(221, 21, 12, NULL, 'para freír', 0),
(222, 21, 29, NULL, 'al gusto', 0),
(223, 21, 13, NULL, 'al gusto', 0),
(224, 22, 22, 300.00, 'g', 0),
(225, 22, 32, 200.00, 'g', 0),
(226, 22, 41, 2.00, 'tazas', 0),
(227, 22, 42, 2.00, 'cucharadas', 0),
(228, 22, 37, 2.00, 'cucharadas', 0),
(229, 22, 11, NULL, 'al gusto', 0),
(230, 22, 13, NULL, 'al gusto', 0),
(231, 23, 43, 1.00, 'taza', 0),
(232, 23, 5, 2.00, 'unidades', 0),
(233, 23, 44, 1.00, 'unidad', 0),
(234, 23, 6, 0.50, 'unidad', 0),
(235, 23, 10, 2.00, 'unidades', 0),
(236, 23, 9, 2.00, 'cucharadas', 1),
(237, 23, 32, 100.00, 'g', 1),
(238, 23, 11, NULL, 'al gusto', 0),
(239, 23, 12, NULL, 'para freír', 0),
(240, 24, 2, 4.00, 'unidades', 0),
(241, 24, 20, 2.00, 'unidades', 0),
(242, 24, 21, 1.00, 'taza', 0),
(243, 24, 4, 2.00, 'unidades', 0),
(244, 24, 45, 4.00, 'cucharadas', 0),
(245, 24, 10, 1.00, 'unidad', 1),
(246, 24, 11, NULL, 'al gusto', 0),
(247, 24, 13, NULL, 'al gusto', 0),
(248, 25, 38, 1.00, 'unidad', 0),
(249, 25, 24, 300.00, 'g', 0),
(250, 25, 46, 2.00, 'rebanadas', 0),
(251, 25, 32, 50.00, 'g', 0),
(252, 25, 45, 3.00, 'cucharadas', 0),
(253, 25, 10, 1.00, 'unidad', 0),
(254, 25, 8, 1.00, 'diente', 0),
(255, 25, 11, NULL, 'al gusto', 0),
(256, 25, 12, NULL, 'para freír', 0),
(257, 25, 13, NULL, 'al gusto', 0),
(258, 26, 37, 1.00, 'taza', 0),
(259, 26, 41, 1.00, 'taza', 0),
(260, 26, 4, 2.00, 'unidades', 0),
(261, 26, 42, 2.00, 'cucharadas', 0),
(262, 26, 47, 1.00, 'cucharada', 0),
(263, 26, 48, 3.00, 'cucharadas', 1),
(264, 26, 11, NULL, 'una pizca', 0),
(265, 27, 46, 4.00, 'rebanadas', 0),
(266, 27, 4, 2.00, 'unidades', 0),
(267, 27, 41, 0.50, 'taza', 0),
(268, 27, 49, 1.00, 'cucharadita', 0),
(269, 27, 47, 2.00, 'cucharadas', 0),
(270, 27, 42, 1.00, 'cucharada', 0),
(271, 27, 48, 2.00, 'cucharadas', 1),
(272, 28, 50, 8.00, 'unidades', 0),
(273, 28, 32, 200.00, 'g', 0),
(274, 28, 51, 1.00, 'cucharadita', 1),
(275, 28, 42, 3.00, 'cucharadas', 0),
(276, 28, 47, 2.00, 'cucharadas', 0),
(277, 28, 6, 0.50, 'unidad', 0),
(278, 28, 11, NULL, 'al gusto', 0),
(279, 29, 3, 1.00, 'taza', 0),
(280, 29, 41, 1.00, 'litro', 0),
(281, 29, 47, 0.75, 'taza', 0),
(282, 29, 49, 1.00, 'rama', 0),
(283, 29, 10, 1.00, 'unidad', 1),
(284, 29, 52, 0.25, 'taza', 1),
(285, 30, 41, 3.00, 'tazas', 0),
(286, 30, 4, 4.00, 'unidades', 0),
(287, 30, 47, 1.00, 'taza', 0),
(288, 30, 53, 1.00, 'cucharadita', 1),
(289, 31, 54, 200.00, 'g', 0),
(290, 31, 42, 150.00, 'g', 0),
(291, 31, 47, 1.00, 'taza', 0),
(292, 31, 4, 3.00, 'unidades', 0),
(293, 31, 37, 0.75, 'taza', 0),
(294, 31, 55, 0.50, 'taza', 1),
(295, 32, 56, 1.00, 'taza', 0),
(296, 32, 6, 1.00, 'unidad', 0),
(297, 32, 20, 1.00, 'unidad', 0),
(298, 32, 8, 2.00, 'dientes', 0),
(299, 32, 7, 0.50, 'taza', 0),
(300, 32, 4, 1.00, 'unidad', 0),
(301, 32, 46, 4.00, 'unidades', 1),
(302, 32, 11, NULL, 'al gusto', 0),
(303, 32, 12, NULL, 'para freír', 0),
(304, 32, 14, NULL, 'al gusto', 0),
(305, 33, 2, 5.00, 'unidades', 0),
(306, 33, 32, 200.00, 'g', 0),
(307, 33, 41, 1.00, 'taza', 0),
(308, 33, 8, 2.00, 'dientes', 0),
(309, 33, 42, 1.00, 'cucharada', 0),
(310, 33, 11, NULL, 'al gusto', 0),
(311, 33, 13, NULL, 'al gusto', 0),
(312, 34, 37, 3.00, 'tazas', 0),
(313, 34, 32, 300.00, 'g', 0),
(314, 34, 42, 100.00, 'g', 0),
(315, 34, 4, 1.00, 'unidad', 0),
(316, 34, 47, 1.00, 'cucharada', 0),
(317, 34, 11, NULL, 'al gusto', 0),
(318, 34, 12, NULL, 'para freír', 0),
(319, 34, 23, NULL, 'tibia', 0),
(320, 35, 2, 6.00, 'unidades', 0),
(321, 35, 35, 250.00, 'g', 0),
(322, 35, 4, 3.00, 'unidades', 0),
(323, 35, 6, 1.00, 'unidad', 0),
(324, 35, 21, 0.50, 'taza', 1),
(325, 35, 37, 0.50, 'taza', 0),
(326, 35, 11, NULL, 'al gusto', 0),
(327, 35, 12, NULL, 'para freír', 0),
(328, 35, 14, NULL, 'al gusto', 0),
(329, 36, 57, 600.00, 'g', 0),
(330, 36, 32, 250.00, 'g', 0),
(331, 36, 42, 2.00, 'cucharadas', 0),
(332, 36, 11, NULL, 'al gusto', 0),
(333, 36, 12, NULL, 'para freír', 0),
(334, 37, 5, 4.00, 'unidades', 0),
(335, 37, 16, 2.00, 'unidades', 0),
(336, 37, 6, 0.50, 'unidad', 1),
(337, 37, 11, NULL, 'al gusto', 0),
(338, 38, 22, 100.00, 'g', 0),
(339, 38, 2, 2.00, 'unidades', 0),
(340, 38, 20, 1.00, 'unidad', 0),
(341, 38, 6, 1.00, 'unidad', 0),
(342, 38, 11, NULL, 'al gusto', 0),
(343, 39, 24, 500.00, 'g', 0),
(344, 39, 2, 3.00, 'unidades', 0),
(345, 39, 20, 2.00, 'unidades', 0),
(346, 39, 6, 1.00, 'unidad', 0),
(347, 39, 22, 80.00, 'g', 1),
(348, 39, 9, 2.00, 'cucharadas', 1),
(349, 39, 11, NULL, 'al gusto', 0),
(350, 39, 23, NULL, '2 litros', 0),
(351, 40, 58, 600.00, 'g', 0),
(352, 40, 6, 1.00, 'unidad', 0),
(353, 40, 2, 1.00, 'unidad', 0),
(354, 40, 8, 1.00, 'diente', 0),
(355, 40, 41, 1.00, 'taza', 0),
(356, 40, 42, 1.00, 'cucharada', 0),
(357, 40, 11, NULL, 'al gusto', 0),
(358, 40, 13, NULL, 'al gusto', 0),
(359, 41, 56, 1.00, 'taza', 0),
(360, 41, 2, 2.00, 'unidades', 0),
(361, 41, 20, 1.00, 'unidad', 0),
(362, 41, 6, 1.00, 'unidad', 0),
(363, 41, 8, 2.00, 'dientes', 0),
(364, 41, 11, NULL, 'al gusto', 0),
(365, 41, 12, NULL, 'para freír', 0),
(366, 42, 1, 600.00, 'g', 0),
(367, 42, 2, 4.00, 'unidades', 0),
(368, 42, 20, 2.00, 'unidades', 0),
(369, 42, 21, 0.50, 'taza', 0),
(370, 42, 6, 1.00, 'unidad', 0),
(371, 42, 5, 2.00, 'unidades', 0),
(372, 42, 8, 2.00, 'dientes', 0),
(373, 42, 11, NULL, 'al gusto', 0),
(374, 42, 12, NULL, 'para freír', 0),
(375, 42, 13, NULL, 'al gusto', 0),
(376, 42, 29, NULL, 'al gusto', 0),
(377, 43, 2, 3.00, 'unidades', 0),
(378, 43, 4, 4.00, 'unidades', 0),
(379, 43, 6, 1.00, 'unidad', 0),
(380, 43, 11, NULL, 'al gusto', 0),
(381, 43, 12, NULL, 'para freír', 0),
(382, 44, 4, 3.00, 'unidades', 0),
(383, 44, 20, 1.00, 'unidad', 0),
(384, 44, 6, 1.00, 'unidad', 0),
(385, 44, 5, 1.00, 'unidad', 0),
(386, 44, 11, NULL, 'al gusto', 0),
(387, 44, 12, NULL, 'para freír', 0),
(388, 45, 4, 4.00, 'unidades', 0),
(389, 45, 5, 1.00, 'unidad', 0),
(390, 45, 6, 0.50, 'unidad', 0),
(391, 45, 32, 50.00, 'g', 1),
(392, 45, 11, NULL, 'al gusto', 0),
(393, 45, 12, NULL, 'para freír', 0),
(394, 45, 13, NULL, 'al gusto', 0),
(395, 46, 2, 5.00, 'unidades', 0),
(396, 46, 6, 1.00, 'unidad', 0),
(397, 46, 20, 1.00, 'unidad', 0),
(398, 46, 8, 1.00, 'diente', 0),
(399, 46, 41, 1.00, 'taza', 0),
(400, 46, 32, 100.00, 'g', 1),
(401, 46, 9, 2.00, 'cucharadas', 1),
(402, 46, 11, NULL, 'al gusto', 0),
(403, 46, 12, NULL, 'para freír', 0),
(404, 46, 13, NULL, 'al gusto', 0),
(405, 46, 23, NULL, '1.5 litros', 0),
(406, 47, 6, 5.00, 'unidades', 0),
(407, 47, 42, 2.00, 'cucharadas', 0),
(408, 47, 37, 1.00, 'cucharada', 0),
(409, 47, 46, 4.00, 'rebanadas', 0),
(410, 47, 32, 150.00, 'g', 0),
(411, 47, 11, NULL, 'al gusto', 0),
(412, 47, 13, NULL, 'al gusto', 0),
(413, 47, 23, NULL, '1 litro', 0),
(414, 48, 43, 0.50, 'taza', 0),
(415, 48, 2, 2.00, 'unidades', 0),
(416, 48, 20, 1.00, 'unidad', 0),
(417, 48, 6, 1.00, 'unidad', 0),
(418, 48, 21, 0.50, 'taza', 0),
(419, 48, 1, 200.00, 'g', 1),
(420, 48, 9, 2.00, 'cucharadas', 1),
(421, 48, 11, NULL, 'al gusto', 0),
(422, 48, 12, NULL, 'para freír', 0),
(423, 48, 14, NULL, 'al gusto', 0),
(424, 48, 23, NULL, '1.5 litros', 0),
(425, 49, 2, 2.00, 'unidades', 0),
(426, 49, 20, 2.00, 'unidades', 0),
(427, 49, 58, 200.00, 'g', 0),
(428, 49, 6, 1.00, 'unidad', 0),
(429, 49, 21, 0.50, 'taza', 0),
(430, 49, 22, 50.00, 'g', 1),
(431, 49, 11, NULL, 'al gusto', 0),
(432, 49, 12, NULL, 'para freír', 0),
(433, 49, 23, NULL, '1.5 litros', 0),
(434, 50, 2, 5.00, 'unidades', 0),
(435, 50, 4, 4.00, 'unidades', 0),
(436, 50, 32, 200.00, 'g', 0),
(437, 50, 41, 2.00, 'tazas', 0),
(438, 50, 6, 1.00, 'unidad', 0),
(439, 50, 25, 1.00, 'cucharada', 0),
(440, 50, 21, 0.50, 'taza', 0),
(441, 50, 50, 1.00, 'unidad', 1),
(442, 50, 11, NULL, 'al gusto', 0),
(443, 50, 12, NULL, 'para freír', 0),
(444, 50, 29, NULL, 'al gusto', 0),
(445, 50, 23, NULL, '1 litro', 0),
(446, 51, 3, 0.50, 'taza', 0),
(447, 51, 20, 1.00, 'unidad', 0),
(448, 51, 2, 1.00, 'unidad', 0),
(449, 51, 6, 1.00, 'unidad', 0),
(450, 51, 21, 0.50, 'taza', 0),
(451, 51, 9, 1.00, 'cucharada', 1),
(452, 51, 11, NULL, 'al gusto', 0),
(453, 51, 12, NULL, 'para freír', 0),
(454, 51, 23, NULL, '1.5 litros', 0),
(455, 52, 2, 4.00, 'unidades', 0),
(456, 52, 4, 3.00, 'unidades', 0),
(457, 52, 6, 0.50, 'unidad', 0),
(458, 52, 10, 2.00, 'unidades', 0),
(459, 52, 45, 2.00, 'cucharadas', 1),
(460, 52, 9, 1.00, 'cucharada', 1),
(461, 52, 11, NULL, 'al gusto', 0),
(462, 52, 12, NULL, 'para freír', 0),
(463, 52, 13, NULL, 'al gusto', 0),
(464, 53, 5, 3.00, 'unidades', 0),
(465, 53, 6, 1.00, 'unidad', 0),
(466, 53, 10, 2.00, 'unidades', 0),
(467, 53, 16, 1.00, 'unidad', 1),
(468, 53, 9, 1.00, 'cucharada', 1),
(469, 53, 11, NULL, 'al gusto', 0),
(470, 53, 12, NULL, 'para freír', 0),
(471, 54, 5, 3.00, 'unidades', 0),
(472, 54, 32, 150.00, 'g', 0),
(473, 54, 6, 0.50, 'unidad', 1),
(474, 54, 10, 1.00, 'unidad', 1),
(475, 54, 11, NULL, 'al gusto', 0),
(476, 54, 12, NULL, 'para freír', 0),
(477, 54, 29, NULL, 'al gusto', 0),
(478, 55, 2, 5.00, 'unidades', 0),
(479, 55, 32, 200.00, 'g', 0),
(480, 55, 41, 0.50, 'taza', 0),
(481, 55, 25, 2.00, 'cucharadas', 0),
(482, 55, 4, 2.00, 'unidades', 0),
(483, 55, 12, NULL, 'para freír', 0),
(484, 55, 11, NULL, 'al gusto', 0),
(485, 55, 38, 4.00, 'hojas', 1),
(486, 56, 2, 6.00, 'unidades', 0),
(487, 56, 41, 0.50, 'taza', 0),
(488, 56, 42, 2.00, 'cucharadas', 0),
(489, 56, 11, NULL, 'al gusto', 0),
(490, 56, 13, NULL, 'al gusto', 0),
(491, 57, 4, 4.00, 'unidades', 0),
(492, 57, 6, 1.00, 'unidad', 0),
(493, 57, 5, 2.00, 'unidades', 0),
(494, 57, 25, 1.00, 'cucharada', 1),
(495, 57, 3, 1.00, 'taza', 1),
(496, 57, 11, NULL, 'al gusto', 0),
(497, 57, 12, NULL, 'para freír', 0),
(498, 57, 29, NULL, 'al gusto', 0),
(499, 58, 2, 3.00, 'unidades', 0),
(500, 58, 4, 3.00, 'unidades', 0),
(501, 58, 6, 1.00, 'unidad', 0),
(502, 58, 5, 1.00, 'unidad', 1),
(503, 58, 11, NULL, 'al gusto', 0),
(504, 58, 12, NULL, 'para freír', 0),
(505, 58, 13, NULL, 'al gusto', 0),
(506, 59, 4, 4.00, 'unidades', 0),
(507, 59, 5, 1.00, 'unidad', 0),
(508, 59, 6, 0.50, 'unidad', 0),
(509, 59, 25, 1.00, 'cucharadita', 1),
(510, 59, 46, 2.00, 'rebanadas', 1),
(511, 59, 11, NULL, 'al gusto', 0),
(512, 59, 12, NULL, 'para freír', 0),
(513, 60, 2, 4.00, 'unidades', 0),
(514, 60, 11, NULL, 'al gusto', 0),
(515, 60, 12, NULL, 'para freír', 0),
(516, 61, 4, 6.00, 'unidades', 0),
(517, 61, 45, 3.00, 'cucharadas', 0),
(518, 61, 17, 1.00, 'cucharadita', 1),
(519, 61, 9, 1.00, 'cucharada', 1),
(520, 61, 11, NULL, 'al gusto', 0),
(521, 61, 13, NULL, 'al gusto', 0),
(522, 62, 6, 2.00, 'unidades', 0),
(523, 62, 37, 0.50, 'taza', 0),
(524, 62, 4, 1.00, 'unidad', 0),
(525, 62, 41, 0.25, 'taza', 0),
(526, 62, 7, 1.00, 'taza', 0),
(527, 62, 11, NULL, 'al gusto', 0),
(528, 62, 12, NULL, 'para freír', 0),
(529, 62, 13, NULL, 'al gusto', 0),
(530, 63, 46, 6.00, 'rebanadas', 0),
(531, 63, 41, 2.00, 'tazas', 0),
(532, 63, 4, 3.00, 'unidades', 0),
(533, 63, 47, 0.75, 'taza', 0),
(534, 63, 49, 1.00, 'cucharadita', 0),
(535, 63, 52, 0.25, 'taza', 1),
(536, 63, 42, 1.00, 'cucharada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `clave_hash` varchar(255) NOT NULL,
  `rol` enum('administrador','usuario') NOT NULL DEFAULT 'usuario',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `clave_hash`, `rol`, `activo`, `fecha_registro`) VALUES
(1, 'Administrador', 'admin@gustoff.com', 'Admin123', 'administrador', 1, '2026-11-18 19:17:28'),
(2, 'Usuario de prueba', 'usuario@gustoff.com', 'User456', 'usuario', 1, '2026-11-18 19:17:28');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD UNIQUE KEY `id_receta` (`id_receta`,`id_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id_usuario`,`id_receta`),
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD UNIQUE KEY `nombre_normalizado` (`nombre_normalizado`);

--
-- Indices de la tabla `pasos_receta`
--
ALTER TABLE `pasos_receta`
  ADD PRIMARY KEY (`id_paso`),
  ADD UNIQUE KEY `id_receta` (`id_receta`,`numero_paso`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `receta_ingredientes`
--
ALTER TABLE `receta_ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_receta` (`id_receta`,`id_ingrediente`),
  ADD KEY `id_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `pasos_receta`
--
ALTER TABLE `pasos_receta`
  MODIFY `id_paso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `receta_ingredientes`
--
ALTER TABLE `receta_ingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=537;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE,
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pasos_receta`
--
ALTER TABLE `pasos_receta`
  ADD CONSTRAINT `pasos_receta_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;

--
-- Filtros para la tabla `receta_ingredientes`
--
ALTER TABLE `receta_ingredientes`
  ADD CONSTRAINT `receta_ingredientes_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE,
  ADD CONSTRAINT `receta_ingredientes_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
