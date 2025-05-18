-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-05-2025 a las 18:35:38
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
-- Base de datos: `recipes_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `type` enum('desayuno','comida','cena','postre') NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `image_url`, `type`, `ingredients`, `instructions`, `created_at`) VALUES
(14, 'Tostadas integrales con aguacate y huevo pochado', 'images/descarga.jpeg', 'desayuno', '2 rebanadas de pan integral\r\n1 aguacate maduro\r\n2 huevos\r\nSal y pimienta al gusto\r\nAceite de oliva\r\nLimón', '1.Tuesta las rebanadas de pan integral.\r\n\r\n2. Tritura el aguacate con un tenedor, añadiendo sal, pimienta y unas gotas de limón.\r\n\r\n3.Cocina los huevos pochados en agua con vinagre durante 3-4 minutos.\r\n\r\n4.Unta el aguacate en las tostadas y coloca un huevo pochado encima de cada una. Sirve.', '2024-11-14 17:09:30'),
(15, 'Avena con frutas y nueces', 'images/26-avena-con-fruta-y-nueces.jpg', 'desayuno', '1 taza de avena\r\n2 tazas de leche o bebida vegetal\r\n1 manzana\r\n1 plátano\r\nUn puñado de nueces\r\nMiel al gusto', '1. Cocina la avena en la leche a fuego medio durante 5-10 minutos, removiendo ocasionalmente.\r\n2. Corta las frutas en trozos pequeños.\r\n3. Sirve la avena caliente, agregando las frutas y nueces por encima.\r\n4. Añade miel al gusto.\r\n', '2024-11-14 17:12:30'),
(16, 'Smoothie de plátano y espinacas', 'images/smothie-espinaca.jpg', 'desayuno', '1 plátano maduro\r\n1 taza de espinacas frescas\r\n1 taza de leche o bebida vegetal\r\n1 cucharada de mantequilla de almendra\r\n1 cucharadita de miel', '1.Coloca todos los ingredientes en una licuadora.\r\n2.Licúa hasta obtener una mezcla suave y homogénea.\r\n3.Sirve frío.', '2024-11-14 17:14:35'),
(17, 'Tortilla de espinacas y champiñones', 'images/descarga (1).jpeg', 'desayuno', '2 huevos\r\n1 taza de espinacas frescas\r\n1/2 taza de champiñones\r\nAceite de oliva\r\nSal y pimienta', '1.En una sartén, saltea los champiñones en un poco de aceite de oliva hasta que estén tiernos.\r\n\r\n2. Añade las espinacas y cocina hasta que se marchiten.\r\n\r\n3. Batir los huevos con sal y pimienta, verterlos sobre los vegetales y cocinar hasta que la tortilla esté firme.', '2024-11-14 17:16:36'),
(18, 'Panqueques de avena', 'images/images.jpeg', 'desayuno', '1 taza de avena\r\n1 huevo\r\n1/2 taza de leche o bebida vegetal\r\n1 cucharadita de polvo de hornear\r\n1 cucharadita de canela\r\nMiel o frutas para acompañar', '1.Tritura la avena hasta obtener una harina fina.\r\n2.Mezcla la avena con el huevo, la leche, el polvo de hornear y la canela.\r\n3.Cocina los panqueques en una sartén caliente con un poco de aceite.\r\n4.Sirve con miel o frutas frescas.', '2024-11-14 17:19:08'),
(19, 'Yogur con granola y frutos rojos', 'images/descarga (2).jpeg', 'desayuno', '1 taza de yogur natural\r\n1/2 taza de granola\r\n1/2 taza de frutos rojos (fresas, arándanos, etc.)\r\nMiel al gusto', '1.Coloca el yogur en un tazón.\r\n2.Añade la granola y los frutos rojos por encima.\r\n3.Agrega un poco de miel y sirve.', '2024-11-14 17:20:51'),
(20, 'Tostadas francesas', 'images/tostadas-francesas.jpeg', 'desayuno', '2 rebanadas de pan\r\n1 huevo\r\n1/2 taza de leche\r\n1 cucharadita de canela\r\nMantequilla\r\nMiel o frutas', '1.Mezcla el huevo, la leche y la canela en un tazón.\r\n2.Sumerge las rebanadas de pan en la mezcla.\r\n3.Cocina las tostadas en una sartén con mantequilla hasta que estén doradas.\r\n4.Sirve con miel o frutas.', '2024-11-14 17:22:27'),
(21, 'Ensalada de pollo a la parrilla', 'images/grilled-chicken-salad.jpg', 'comida', '1 pechuga de pollo\r\nLechuga, espinacas y rúcula\r\nTomates cherry\r\nAguacate\r\nAceite de oliva, vinagre balsámico\r\nSal y pimienta', '1.Asa la pechuga de pollo en una parrilla o sartén hasta que esté completamente cocida.\r\n2.Corta el pollo en tiras y resérvalo.\r\n3.Mezcla las verduras en un tazón y agrega el pollo por encima.\r\n4.Aliña con aceite de oliva, vinagre balsámico, sal y pimienta.', '2024-11-14 17:24:29'),
(22, 'Tacos de pescado', 'images/3628.jpg', 'comida', '4 filetes de pescado (tilapia o merluza)\r\nTortillas de maíz\r\nRepollo rallado\r\nSalsa de aguacate (aguacate, cilantro, limón, sal)\r\nLimón\r\nAceite de oliva', '1.Cocina los filetes de pescado con aceite de oliva y limón.\r\n2.Calienta las tortillas de maíz.\r\n3.Arma los tacos colocando el pescado, repollo rallado y salsa de aguacate.', '2024-11-14 17:28:15'),
(23, 'Arroz integral con verduras', 'images/1366_2000.jpg', 'desayuno', '1 taza de arroz integral\r\n1 zanahoria\r\n1 pimiento rojo\r\n1/2 cebolla\r\nAceite de oliva, sal y pimienta', '1.Cocina el arroz integral según las indicaciones del paquete.\r\n\r\n2.En una sartén, saltea las verduras picadas en aceite de oliva.\r\n\r\n3.Mezcla el arroz con las verduras y sazona con sal y pimienta.', '2024-11-14 17:30:28'),
(24, 'Pasta con tomate y albahaca', 'images/pasta-with-cherry-tomatoes-15-scaled.jpg', 'comida', '200 g de pasta\r\n2 tomates maduros\r\n1 diente de ajo\r\nAlbahaca fresca\r\nAceite de oliva\r\nSal y pimienta', '1.Cocina la pasta según las indicaciones del paquete.\r\n2.En una sartén, sofríe el ajo picado y los tomates troceados en aceite de oliva.\r\n3.Agrega la pasta cocida a la sartén y mezcla bien.\r\n4.Añade albahaca fresca y sazona con sal y pimienta.', '2024-11-14 17:32:22'),
(25, 'Ensalada de quinoa con aguacate', 'images/ensalada-de-quinoa-con-aguacate-1200x675.jpg', 'comida', '1 taza de quinoa\r\n1 aguacate\r\n1 pepino\r\nJugo de 1 limón\r\nAceite de oliva, sal y pimienta\r\n', '1.Cocina la quinoa según las indicaciones del paquete.\r\n2.Corta el aguacate y el pepino en cubos.\r\n3.Mezcla todos los ingredientes en un tazón y aliña con aceite de oliva, jugo de limón, sal y pimienta.', '2024-11-14 17:33:46'),
(26, 'Pollo al curry con arroz basmati', 'images/images.jpeg', 'comida', '2 pechugas de pollo\r\n1 cucharada de curry en polvo\r\n1 taza de arroz basmati\r\n1 taza de leche de coco\r\n1 cebolla\r\nAceite de oliva', '1.Cocina el arroz basmati.\r\n2.En una sartén, sofríe la cebolla picada en aceite de oliva, luego agrega el pollo cortado en trozos pequeños.\r\n3.Añade el curry en polvo y la leche de coco, y cocina a fuego medio hasta que el pollo esté bien cocido.\r\n4.Sirve con el arroz basmati.', '2024-11-14 17:35:30'),
(27, 'Hamburguesas vegetarianas', 'images/images (1).jpeg', 'comida', '1 taza de garbanzos cocidos\r\n1 zanahoria rallada\r\n1/2 cebolla picada\r\nPan rallado\r\nEspecias al gusto\r\nAceite de oliva', '1.Tritura los garbanzos hasta obtener una pasta.\r\n\r\n2. Mezcla con la zanahoria, cebolla y pan rallado hasta formar una masa.\r\n\r\n3. Forma las hamburguesas y cocínelas en una sartén con aceite de oliva.\r\n\r\n4. Sirve con pan integral y los ingredientes de tu elección.', '2024-11-14 17:37:36'),
(28, 'Sopa de verduras', 'images/sopadeverduras.jpeg', 'cena', '2 zanahorias\r\n1 calabacín\r\n1/2 cebolla\r\n1 litro de caldo de verduras\r\nSal y pimienta', '1.Cocina las verduras picadas en una cacerola con el caldo de verduras.\r\n2.Cocina a fuego lento hasta que estén tiernas.\r\n3.Sazona con sal y pimienta, y sirve.', '2024-11-14 17:40:34'),
(29, 'Tortilla española', 'images/TortillaEspanola_58036-1_16x9.jpeg', 'cena', '4 patatas\r\n4 huevos\r\n1 cebolla\r\nAceite de oliva\r\nSal', '1. Pela y corta las patatas en rodajas finas.\r\n2. Fríe las patatas y la cebolla en aceite de oliva hasta que estén tiernas.\r\n3.Bate los huevos, mezcla con las patatas y cocina a fuego lento hasta que esté cuajada.', '2024-11-14 17:42:08'),
(30, 'Ensalada de atún y garbanzos', 'images/ensaladaatunygarbanzos.jpg', 'cena', '1 lata de atún\r\n1 taza de garbanzos cocidos\r\n1 tomate\r\n1 pepino\r\nAceite de oliva, vinagre, sal', '1.Mezcla todos los ingredientes en un bol.\r\n2.Aliña con aceite de oliva, vinagre y sal.\r\n3.Sirve fría.', '2024-11-14 17:43:33'),
(31, 'Filete de salmón con verduras asadas', 'images/filetedesalmonconverduras.jpeg', 'cena', '2 filetes de salmón\r\n1 pimiento rojo\r\n1 calabacín\r\nAceite de oliva\r\nLimón\r\nSal y pimienta', '1.Asa el salmón en el horno con limón, sal y pimienta.\r\n\r\n2.Corta las verduras en trozos y ásalas en una bandeja con aceite de oliva.\r\n\r\n3.Sirve el salmón con las verduras.', '2024-11-14 17:45:05'),
(33, 'Crema de calabaza', 'images/7f4c97b79ac4cd95ddda9979fa388818_435_Crema_Calabaza_BAJA.jpg', 'cena', '1 calabaza\r\n1 cebolla\r\n1 diente de ajo\r\n1 litro de caldo de verduras\r\nAceite de oliva\r\nSal y pimienta', '1.Cocina la calabaza, cebolla y ajo en una cacerola con aceite de oliva.\r\n2.Añade el caldo de verduras y cocina hasta que la calabaza esté tierna.\r\n3.Tritura todo hasta obtener una crema suave. Sazona con sal y pimienta.', '2024-11-14 17:48:16'),
(34, 'Pechuga de pollo al horno', 'images/pechugadepolloalhorno.jpeg', 'cena', '2 pechugas de pollo\r\nAceite de oliva\r\nAjo en polvo\r\nRomero y tomillo\r\nSal y pimienta', '1.Sazona las pechugas de pollo con aceite, ajo en polvo, romero, tomillo, sal y pimienta.\r\n\r\n2.Hornea a 180°C durante 25-30 minutos o hasta que el pollo esté cocido.\r\n\r\n3.Sirve con una ensalada o verduras al vapor.', '2024-11-14 17:50:10'),
(35, 'Mousse de chocolate', 'images/mussedechocolate.jpeg', 'postre', '200 g de chocolate negro\r\n2 huevos\r\n200 ml de nata para montar\r\n50 g de azúcar', '1.Derrite el chocolate.\r\n\r\n2.Bate los huevos con el azúcar.\r\n\r\n3.Monta la nata y mézclala con el chocolate y los huevos batidos.\r\n\r\n4.Refrigera por 2 horas y sirve.', '2024-11-14 17:51:41'),
(36, 'Tarta de manzana', 'images/tartademnzana.jpeg', 'postre', '2 manzanas\r\n1 masa quebrada\r\n50 g de azúcar\r\n1 cucharadita de canela', '1.Coloca la masa quebrada en un molde y pincha con un tenedor.\r\n\r\n2.Corta las manzanas en rodajas finas y colócalas sobre la masa.\r\n\r\n3.Espolvorea con azúcar y canela.\r\n\r\n4.Hornea a 180°C durante 30 minutos.', '2024-11-14 18:02:09'),
(37, 'Helado de plátano y fresa', 'images/heladodeplatanoyfresa.jpeg', 'postre', '2 plátanos maduros\r\n1 taza de fresas\r\n1 cucharadita de miel', '1.Tritura el plátano y las fresas en un procesador de alimentos.\r\n2.Añade miel al gusto.\r\n3.Congela por al menos 4 horas y sirve.', '2024-11-14 18:03:52'),
(38, 'Brownies de chocolate', 'images/brownie-de-chocolate.jpg', 'postre', '200 g de chocolate negro\r\n100 g de mantequilla\r\n2 huevos\r\n150 g de azúcar\r\n100 g de harina', '1.Derrite el chocolate y la mantequilla.\r\n2.Bate los huevos con el azúcar.\r\n3.Mezcla todos los ingredientes y hornea a 180°C durante 20-25 minutos.', '2024-11-14 18:05:16'),
(39, 'Panna cotta de vainilla', 'images/pannacottadevainilla.jpeg', 'postre', '250 ml de nata\r\n100 ml de leche\r\n2 cucharadas de azúcar\r\n1 cucharadita de esencia de vainilla\r\n1 hoja de gelatina\r\n', '1.Calienta la nata, la leche y el azúcar en una cacerola.\r\n2.Disuelve la gelatina en agua y añade a la mezcla caliente.\r\n3.Vierte en moldes y refrigera por 4 horas.', '2024-11-14 18:06:33'),
(40, 'Flan de huevo', 'images/flandehuevo.jpeg', 'postre', '4 huevos\r\n500 ml de leche\r\n150 g de azúcar\r\n1 cucharadita de esencia de vainilla', '1.Calienta la leche con el azúcar y la esencia de vainilla.\r\n2.Bate los huevos y mezcla con la leche caliente.\r\n3.Vierte en moldes y hornea al baño maría durante 40 minutos.', '2024-11-14 18:07:50'),
(41, 'Crumble de manzana', 'images/crumbledemanzana.jpg', 'comida', '3 manzanas\r\n100 g de harina\r\n50 g de azúcar\r\n50 g de mantequilla\r\nCanela al gusto1', '1.Pela y corta las manzanas en cubos, colócalas en una fuente para hornear.\r\n2.Mezcla la harina, el azúcar, la mantequilla y la canela hasta obtener una mezcla arenosa.\r\n3.Cubre las manzanas con la mezcla y hornea a 180°C durante 30 minutos.', '2024-11-14 18:09:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(20, 'Temporal', '$2y$10$0wg/5wsJ3fqLay240XdgqOIsCctbB3Y8XyAVgass/1td581uEHW8O'),
(21, 'Ricardo', '$2y$10$risbJxIJkAKqzGphyBueZ.y60UAG05bl2cl4P3LgPwCFL/tIRiuXy');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
