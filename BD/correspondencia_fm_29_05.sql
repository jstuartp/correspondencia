-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2018 a las 00:10:17
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `correspondencia_fm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `id_avatar` int(10) NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `descripcion`) VALUES
(1, 'mujer.jpg'),
(2, 'hombre.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_oficios_salida`
--

CREATE TABLE `detalle_oficios_salida` (
  `id_detalle_oficios_Salida` int(11) NOT NULL,
  `id_oficio` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `observaciones` varchar(70) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `numOficio` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_oficios_salida`
--

INSERT INTO `detalle_oficios_salida` (`id_detalle_oficios_Salida`, `id_oficio`, `id_estado`, `id_usuario`, `observaciones`, `fecha`, `numOficio`) VALUES
(10, 62, 1, 2, 'Ingresado', '2018-05-28 00:00:00', 'FM28-2018'),
(11, 63, 1, 2, 'Ingresado', '2018-05-28 00:00:00', 'FM28-2018'),
(12, 63, 2, 2, 'Ahora esta en tramite 29/05', '2018-05-29 23:39:33', 'FM28-2018'),
(13, 63, 4, 4, 'Ahora esta esperando respuesta 29/05', '2018-05-29 23:40:08', 'FM28-2018'),
(14, 63, 5, 1, 'Listo', '2018-05-29 23:40:42', 'FM28-2018');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_oficio`
--

CREATE TABLE `estado_oficio` (
  `id_estado` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_oficio`
--

INSERT INTO `estado_oficio` (`id_estado`, `descripcion`) VALUES
(1, 'Proceso Administrativo'),
(2, 'En Tramite'),
(3, 'Pendiente de tramite'),
(4, 'Esperando Respuesta'),
(5, 'Finalizado'),
(6, 'Revisión Doctor'),
(7, 'Devuelto'),
(8, 'Traslado'),
(9, 'Recién Asignado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id_estado` int(10) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id_estado`, `descripcion`) VALUES
(0, 'Inactivo'),
(1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_oficios`
--

CREATE TABLE `info_oficios` (
  `oficio_id` int(11) NOT NULL,
  `oficio_id1` int(11) NOT NULL,
  `oficio_id2` int(11) NOT NULL,
  `unidad_entidad` varchar(200) NOT NULL,
  `anno` year(4) NOT NULL,
  `destinatario` varchar(1000) NOT NULL,
  `asunto` varchar(1000) NOT NULL,
  `usuario_inserta` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_archivado` date NOT NULL,
  `ubicacion` varchar(250) NOT NULL,
  `usuario_modifica` int(11) NOT NULL,
  `no_oficio` varchar(100) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `observaciones` text,
  `extension_archivos` varchar(255) NOT NULL,
  `remitente` varchar(1000) NOT NULL,
  `tipo_oficio` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `destinatario_in` varchar(250) NOT NULL,
  `cuerpo_oficio` text NOT NULL,
  `cc_copia` varchar(500) NOT NULL,
  `id_jefatura` int(11) NOT NULL,
  `destinatario_out` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_oficios`
--

INSERT INTO `info_oficios` (`oficio_id`, `oficio_id1`, `oficio_id2`, `unidad_entidad`, `anno`, `destinatario`, `asunto`, `usuario_inserta`, `fecha`, `fecha_archivado`, `ubicacion`, `usuario_modifica`, `no_oficio`, `imagen`, `observaciones`, `extension_archivos`, `remitente`, `tipo_oficio`, `respuesta`, `id_estado`, `destinatario_in`, `cuerpo_oficio`, `cc_copia`, `id_jefatura`, `destinatario_out`) VALUES
(1, 1, 0, '\'Aporte a otros Proyectos\'', 2017, 'Esteban Nanito<br />\r\nDirector<br />\r\nHotel Lapa Lisa', 'Prueba cambio año', 4, '2018-02-08 21:54:18', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 1, '', 'Holi!!', 'C: Archivo', 3, ''),
(2, 2, 0, 'Centro de Investigación en Enfermedades Tropicales', 2017, 'Esteban Dido<br />\r\nSubdirector<br />\r\nFinca Li Brar', 'Test 2', 4, '2018-02-08 21:56:13', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 1, '', 'Chau', 'C: Archivo', 3, ''),
(3, 1, 0, 'Sección Servicios Contratados, Oficina de Servicios Generales', 2018, 'Esteban Ca Rota<br />\r\nDueño<br />\r\nInversiones Cesidades', 'Prueba 3', 4, '2018-02-08 21:59:45', '0000-00-00', '', 0, '', '', 'Esta es la observacion', '', '0', 0, 0, 2, '', 'So?', 'C: Archivo', 3, ''),
(4, 2, 0, 'Centro de Investigación en Enfermedades Tropicales', 2018, 'Dra. Guiselle<br />\r\n<br />\r\n<br />\r\n<br />\r\n&nbsp;', 'Solicitud', 1, '2018-03-06 20:16:52', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 1, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel iaculis mauris. Curabitur tellus mauris, sodales eget venenatis ut, vestibulum et nibh. Curabitur congue blandit aliquam. Donec mattis libero lacus. Ut dapibus egestas finibus. Integer consectetur velit in pellentesque pharetra. Mauris porta tellus ut risus lacinia placerat. Mauris egestas, nibh nec efficitur viverra, felis ante tincidunt elit, a gravida diam nibh eget risus.<br />\r\nDonec ornare venenatis ante, ut auctor eros ornare nec. Nunc ullamcorper neque ut pellentesque mattis. Vestibulum sed tincidunt lorem. Sed eleifend non turpis ornare viverra. Mauris est turpis, fringilla vulputate congue vitae, venenatis ut sapien. Aliquam vel cursus mauris. Aliquam ac consectetur ligula. Praesent justo quam, auctor sit amet bibendum quis, tincidunt eu ligula. Praesent maximus pellentesque leo ut rutrum.<br />\r\nNam facilisis augue vel nulla tincidunt, non dignissim turpis commodo. Proin eget porttitor nisi. Fusce id luctus dolor. Aenean ac nisl dolor. Aliquam placerat nisi est, vitae finibus nisi posuere at. Aenean et congue diam, ac maximus lorem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus ex diam, maximus ultricies neque pretium, posuere malesuada turpis. In nibh purus, auctor non pretium ut, vestibulum ut ex. Suspendisse mauris ante, porttitor congue eros non, scelerisque hendrerit velit. Curabitur tempor urna in orci commodo rhoncus. Duis sit amet malesuada magna. Mauris rutrum justo ac nunc ullamcorper laoreet. Aliquam posuere ex eros, varius dignissim purus porttitor et. Cras sed risus sed ex tristique varius et ut purus.<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lectus neque, rhoncus sit amet dignissim id, ultricies ut arcu. Nam sem ex, hendrerit dictum vestibulum nec, posuere accumsan tellus. Vivamus consequat dolor urna. Praesent orci massa, ullamcorper a venenatis at, molestie in erat. Pellentesque quis augue sed nisi porta tempus. Integer at magna nisl. Suspendisse semper dignissim nulla, in ornare turpis bibendum et. Maecenas lacinia, mauris ac fringilla gravida, nisi nulla mollis risus, at tincidunt dui orci vel arcu.<br />\r\nAenean viverra massa nec nibh vulputate sagittis id id est. Nullam feugiat lorem eget condimentum gravida. Phasellus lobortis, dui eu porta malesuada, metus leo vehicula ipsum, at volutpat felis mauris auctor dui. Mauris porta eros eget velit faucibus, eget scelerisque libero interdum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut sodales ultricies ipsum ut elementum. Vivamus id faucibus arcu.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel iaculis mauris. Curabitur tellus mauris, sodales eget venenatis ut, vestibulum et nibh. Curabitur congue blandit aliquam. Donec mattis libero lacus. Ut dapibus egestas finibus. Integer consectetur velit in pellentesque pharetra. Mauris porta tellus ut risus lacinia placerat. Mauris egestas, nibh nec efficitur viverra, felis ante tincidunt elit, a gravida diam nibh eget risus.<br />\r\nDonec ornare venenatis ante, ut auctor eros ornare nec. Nunc ullamcorper neque ut pellentesque mattis. Vestibulum sed tincidunt lorem. Sed eleifend non turpis ornare viverra. Mauris est turpis, fringilla vulputate congue vitae, venenatis ut sapien. Aliquam vel cursus mauris. Aliquam ac consectetur ligula. Praesent justo quam, auctor sit amet bibendum quis, tincidunt eu ligula. Praesent maximus pellentesque leo ut rutrum.<br />\r\n<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel iaculis mauris. Curabitur tellus mauris, sodales eget venenatis ut, vestibulum et nibh. Curabitur congue blandit aliquam. Donec mattis libero lacus. Ut dapibus egestas finibus. Integer consectetur velit in pellentesque pharetra. Mauris porta tellus ut risus lacinia placerat. Mauris egestas, nibh nec efficitur viverra, felis ante tincidunt elit, a gravida diam nibh eget risus.<br />\r\nDonec ornare venenatis ante, ut auctor eros ornare nec. Nunc ullamcorper neque ut pellentesque mattis. Vestibulum sed tincidunt lorem. Sed eleifend non turpis ornare viverra. Mauris est turpis, fringilla vulputate congue vitae, venenatis ut sapien. Aliquam vel cursus mauris. Aliquam ac consectetur ligula. Praesent justo quam, auctor sit amet bibendum quis, tincidunt eu ligula. Praesent maximus pellentesque leo ut rutrum.', '<br />\r\n<br />\r\nC: Archivo', 3, ''),
(5, 0, 0, '837', 2018, 'Carlos', 'Asunto', 1, '2018-03-07 20:25:25', '0000-00-00', '', -1, 'ETS-2-2018', '1520360112_8.pdf', '', '', '1', 1, 0, 6, 'Carlos', '', '', 1, ''),
(6, 3, 0, 'Facultad de Derecho', 2018, 'Dra H', 'Prueba', 4, '2018-03-08 17:22:11', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 5, '', 'Este oficio de respuesta prueba', 'C. Archivo', 3, ''),
(7, 4, 0, 'Centro de Investigación en Biología Celular y Molecular', 2018, 'df', 'sgf', 4, '2018-03-08 17:24:56', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 5, '', 'sfd', 'sdf', 3, ''),
(8, 5, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, '', '', 4, '2018-03-09 15:06:26', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 1, '', '', 'C: Archivo', 3, ''),
(9, 6, 0, 'Centro de Investigación en Biología Celular y Molecular', 2018, '', '', 4, '2018-03-09 15:07:14', '0000-00-00', '', 0, '', '', '', '', '0', 0, 0, 1, '', '', 'C: Archivo', 3, ''),
(14, 7, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, 'Datos', 'Aqui el asunto', 4, '2018-04-16 19:51:14', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'datos 2', 'C: Archivo', 3, ''),
(15, 0, 1, 'Cierta unidada', 2018, '', 'Aqui el asunto', 4, '2018-04-18 06:00:00', '0000-00-00', '', -1, 'AA-1000', '1524068689_1.pdf', 'Observaciones', 'pdf', 'Stuart', 2, 0, 7, 'Jefatura1 Apellido1 Apellido2', '', '', 0, ''),
(16, 8, 0, 'Facultad de Derecho', 2018, 'MBA Jesús Brenes Fernández<br />\r\nJefe, Sección de Seguridad y Tránsito<br />\r\nOficina de Servicios Generales', 'Aparcar el vehículo placa 299-694 en el edificio de parqueos', 4, '2018-04-19 17:49:53', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimado señor:<br />\r\n&nbsp;<br />\r\nEn cumplimiento con lo que establece la Circular VRA-9-2018 le informo que el vehículo asignado a la Facultad de Medicina, <strong>placa 299-694</strong>, quedará aparcado en el edificio de Parqueos ubicado en la Ciudad de la Investigación.', 'C: Archivo', 4, ''),
(17, 0, 2, 'Facultad de Medicina', 2018, '', 'parqueo de vehiculo', 4, '2018-04-20 06:00:00', '0000-00-00', '', -1, 'FM-226-2018', '1524234032_2.pdf', 'Ninguna', 'pdf', 'Dr. Carlos Alberto Fonseca', 2, 0, 4, 'Wendy Sandí Espinoza', '', '', 0, ''),
(19, 9, 0, 'Facultad de Derecho', 2018, 'Señor<br />\r\nJosé Matías Reyes<br />\r\nVicerrectoría de Acción Social<br />\r\n&nbsp;', 'Solicitar apoyo para actividad', 1, '2018-04-20 15:36:06', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimado señor:<br />\r\n&nbsp;<br />\r\nDe la manera más atenta le solicito su apoyo para atender lo referente al sonido y al equipo audio visual del Auditorio de la Ciudad de la Investigación para la actividad del III Encuentro Académico de la Facultad de Medicina, que se realizará los días <strong>21, 22 y 23 de agosto de 2018, de 8:00 a 1:00 p.m.</strong><br />\r\n<br />\r\n<br />\r\nAtentamente,', 'YCB/LBM', 4, ''),
(20, 10, 0, 'Escuela de Ingeniería Eléctrica', 2018, 'Dra. Lizbeth Salazar Sánchez, Directora, Escuela de Medicina<br />\r\nLic. Luis Chaves Soto, Jefe Administrativo, Escuela de Medicina<br />\r\nDra. Aileen Fernández, Directora, Departamento de Fisiología<br />\r\nDr. Ronald González Argüello, Director, Departamento de Farmacología<br />\r\nDra. Silvia Quesada Mora, Directora, Departamento de Bioquímica<br />\r\nDr. Maikel Vargas Sanabria, Director, Departamento de Anatomía<br />\r\nSra. Mariana Alarcón Retana, Presidenta, Asociación de Estudiantes, Medicina', 'Trabajos en el edificio de la Facultad de Medicina', 1, '2018-04-20 17:28:21', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimados (as) señores (as):<br />\r\n&nbsp;<br />\r\nContinuando con el programa de recuperación de la deteriorada planta física de la Facultad de Medicina, misma que es sede de la Escuela de Medicina, me permito informarles que el día 22 de enero de 2018 se dará inicio al cambio de la cubierta de techo, sustitución de sensores de alarma considerados por las técnicos como obsoletos, y colocación de nuevas cámaras de vigilancia.<br />\r\n&nbsp;<br />\r\nEl 29 de enero se dará inicio a la pintura externa del edificio, el 05 de febrero se iniciará la remodelación de los servicios sanitarios destinados al público en el I, II y III piso del edificio, este proceso se realizará por etapas a fin de minimizar los inconvenientes, iniciando por los sanitarios del I piso. &nbsp;<br />\r\n&nbsp;<br />\r\nAsimismo, se continuará con la limpieza del frontispicio de la fachada principal, para lo cual aún no se cuenta con fecha cierta, y que no se logró concluir de acuerdo al programa preestablecido, por razones de índole técnico, ajenos a esta Facultad.<br />\r\n&nbsp;<br />\r\nAsimismo, se trabaja en la construcción del nicho donde se instalarán los requerimientos técnicos del departamento de Anatomía para la recuperación y mantenimiento de la osteoteca.<br />\r\n&nbsp;<br />\r\nPor todo lo anterior solicito a través de su digno medio la comprensión y colaboración de profesores, alumnos y personal administrativo, y de antemano les presento nuestras sentidas excusas por los inconvenientes que transitoriamente estos trabajos puedan provocar a cualquiera de los miembros de esta comunidad universitaria.<br />\r\n<br />\r\nNo omito manifestarles que cualquier sugerencia en pro de mitigar los eventuales inconvenientes que estos trabajos de remodelación y mantenimiento puedan ocasionar serán bien recibidos por este despacho a través de la coordinación de la Licda. Wendy Sandí, Administradora de la Facultad.<br />\r\n&nbsp;<br />\r\nAgradeciendo la comprensión e indulgencia que de antemano solicitamos, me suscribo de ustedes.<br />\r\n&nbsp;<br />\r\nAtentamente,<br />\r\n&nbsp;', 'Cc: Archivo<br />\r\n&nbsp;<br />\r\n<br />\r\nCFZ/LBM<br />\r\n&nbsp;', 4, ''),
(21, 11, 0, 'Centro de Investigación en Biología Celular y Molecular', 2018, 'Sra. Diana Tames Brenes<br />\r\nEscuela de Enfermería<br />\r\n&nbsp;', 'Reserva de sala de Directores', 1, '2018-04-20 17:31:19', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimada señora:<br />\r\n&nbsp;<br />\r\nEn respuesta a su solicitud electrónica, le informo que se ha procedido a reservar la Sala de Directores para el día martes 23 de enero del 2018, como responsable PhD Vivian Vílchez Barboza en el horario de 1:00pm a 4:30pm.<br />\r\n&nbsp;<br />\r\nEs importante tomar en cuenta las siguientes disposiciones para el adecuado uso de la sala asignada:<br />\r\n&nbsp;\r\n<ol>\r\n	<li>Al finalizar la actividad debe coordinar con el encargado para el cierre de la Sala.</li>\r\n	<li>Este espacio debe permanecer cerrado mientras no existan personas&nbsp; adentro.</li>\r\n	<li>Se requiere un manejo responsable y cuidado especial con los equipos&nbsp; que&nbsp; se encuentran en este sitio.</li>\r\n	<li>No se permite el uso de la sala para consumir alimentos.</li>\r\n	<li>La persona solicitante se hace responsable por el buen estado en que&nbsp; recibe y entrega los equipos.</li>\r\n	<li>Por razones de Seguridad y Gestión del Riesgo, el mobiliario de las Salas deberá permanecer tal y como está, salvo situaciones especiales previamente coordinadas.</li>\r\n	<li>Las puertas de emergencias están ubicadas al frente de la Sala por lo tanto no se&nbsp;&nbsp;&nbsp; puede colocar catering services que obstaculicen el espacio.</li>\r\n</ol>\r\n&nbsp;<br />\r\n&nbsp;La aprobación del uso de la Sala es estrictamente para el horario establecido y el equipo que se encuentra en ella, y no concede derechos para modificar de forma alguna el destino del uso, ni el horario autorizado. Cualquier cambio de usuario o destino debe ser solicitado previamente (no menos de 48 horas) a este Decanato. Solo podrá hacer uso de la Sala quien aparezca indicado en la programación respectiva, quien debe portar copia del oficio de aprobación.<br />\r\n&nbsp;<br />\r\n&nbsp;Cualquier uso de espacios, equipos, mobiliarios, materiales u otros no contenidos en la solicitud, deberá ser solicitado por aparte, entendiéndose que dicha solicitud se tramitará en forma totalmente independiente de esta autorización<br />\r\n&nbsp;<br />\r\nCordialmente,<br />\r\n&nbsp;', 'cc. PhD Vivian Vílchez Barboza<br />\r\nYVG', 5, ''),
(22, 0, 3, 'Facultad de Derecho', 2018, '', 'Prestamo de sala de Directores', 1, '2018-05-07 14:13:53', '0000-00-00', '', -1, 'FM-10-2018', '1524511320_9.pdf', 'Carta solicitando el prestamo de la sala de directores', 'pdf', 'Diana Tames Brenes', 1, 0, 9, 'Wendy Sandí Espinoza', '', '', 0, ''),
(23, 0, 4, 'Sección Servicios Contratados, Oficina de Servicios Generales', 2018, '', 'Fumigación del edificio', 1, '2018-04-13 06:00:00', '2018-05-07', '9999', 5, 'FM-30-2018', '1524511440_2.pdf', 'Carta solicitando la fumigación del edificio', 'pdf', 'M.Sc. Gerardo Valverde', 1, 0, 4, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(24, 12, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, 'Señor<br />\r\nJosé Matías Reyes<br />\r\nVicerrectoría de Acción Social', 'Apoyo equipo audiovisual', 4, '2018-04-23 20:07:56', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimado señor:<br />\r\n&nbsp;<br />\r\nDe la manera más atenta le solicito su apoyo para atender lo referente al sonido y al equipo audio visual del Auditorio de la Ciudad de la Investigación para la actividad del III Encuentro Académico de la Facultad de Medicina, que se realizará los días <strong>21, 22 y 23 de agosto de 2018, de 8:00 a 1:00 p.m.</strong><br />\r\n&nbsp;<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\nAtentamente,<br />\r\n&nbsp;', 'YCB/LBM', 4, ''),
(25, 13, 0, 'Escuela de Ingeniería Eléctrica', 2018, 'Dra. Lizbeth Salazar Sánchez, Directora, Escuela de Medicina<br />\r\nLic. Luis Chaves Soto, Jefe Administrativo, Escuela de Medicina<br />\r\nDra. Aileen Fernández, Directora, Departamento de Fisiología<br />\r\nDr. Ronald González Argüello, Director, Departamento de Farmacología<br />\r\nDra. Silvia Quesada Mora, Directora, Departamento de Bioquímica<br />\r\nDr. Maikel Vargas Sanabria, Director, Departamento de Anatomía<br />\r\nSra. Mariana Alarcón Retana, Presidenta, Asociación de Estudiantes, Medicina', 'Revision de obras', 4, '2018-04-23 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', ' ', 0, 0, 1, '', 'Estimados (as) señores (as):<br />\r\n&nbsp;<br />\r\nContinuando con el programa de recuperación de la deteriorada planta física de la Facultad de Medicina, misma que es sede de la Escuela de Medicina, me permito informarles que el día 22 de enero de 2018 se dará inicio al cambio de la cubierta de techo, sustitución de sensores de alarma considerados por las técnicos como obsoletos, y colocación de nuevas cámaras de vigilancia.<br />\r\n<br />\r\n&nbsp;<br />\r\nEl 29 de enero se dará inicio a la pintura externa del edificio, el 05 de febrero se iniciará la remodelación de los servicios sanitarios destinados al público en el I, II y III piso del edificio, este proceso se realizará por etapas a fin de minimizar los inconvenientes, iniciando por los sanitarios del I piso. &nbsp;<br />\r\n<br />\r\n&nbsp;<br />\r\nAsimismo, se continuará con la limpieza del frontispicio de la fachada principal, para lo cual aún no se cuenta con fecha cierta, y que no se logró concluir de acuerdo al programa preestablecido, por razones de índole técnico, ajenos a esta Facultad.<br />\r\n&nbsp;<br />\r\n<br />\r\nAsimismo, se trabaja en la construcción del nicho donde se instalarán los requerimientos técnicos del departamento de Anatomía para la recuperación y mantenimiento de la osteoteca.<br />\r\n&nbsp;<br />\r\n<br />\r\nPor todo lo anterior solicito a través de su digno medio la comprensión y colaboración de profesores, alumnos y personal administrativo, y de antemano les presento nuestras sentidas excusas por los inconvenientes que transitoriamente estos trabajos puedan provocar a cualquiera de los miembros de esta comunidad universitaria.<br />\r\n<br />\r\n<br />\r\nNo omito manifestarles que cualquier sugerencia en pro de mitigar los eventuales inconvenientes que estos trabajos de remodelación y mantenimiento puedan ocasionar serán bien recibidos por este despacho a través de la coordinación de la Licda. Wendy Sandí, Administradora de la Facultad.<br />\r\n&nbsp;<br />\r\n<br />\r\nAgradeciendo la comprensión e indulgencia que de antemano solicitamos, me suscribo de ustedes.<br />\r\n<br />\r\n<br />\r\nContinuando con el programa de recuperación de la deteriorada planta física de la Facultad de Medicina, misma que es sede de la Escuela de Medicina, me permito informarles que el día 22 de enero de 2018 se dará inicio al cambio de la cubierta de techo, sustitución de sensores de alarma considerados por las técnicos como obsoletos, y colocación de nuevas cámaras de vigilancia.<br />\r\n&nbsp;<br />\r\n<br />\r\nEl 29 de enero se dará inicio a la pintura externa del edificio, el 05 de febrero se iniciará la remodelación de los servicios sanitarios destinados al público en el I, II y III piso del edificio, este proceso se realizará por etapas a fin de minimizar los inconvenientes, iniciando por los sanitarios del I piso. &nbsp;<br />\r\n&nbsp;<br />\r\n<br />\r\nAsimismo, se continuará con la limpieza del frontispicio de la fachada principal, para lo cual aún no se cuenta con fecha cierta, y que no se logró concluir de acuerdo al programa preestablecido, por razones de índole técnico, ajenos a esta Facultad.<br />\r\n&nbsp;<br />\r\n<br />\r\nAtentamente,<br />\r\n&nbsp;', 'Cc: Archivo<br />\r\n&nbsp;<br />\r\n&nbsp;<br />\r\nCFZ/LBM', 4, ''),
(26, 14, 0, 'Centro de Investigación en Biología Celular y Molecular', 2018, 'Profesores<br />\r\nEscuela Ciencias Políticas<br />\r\n&nbsp;', 'Notificación calificaciones docentes', 4, '2018-04-23 21:07:11', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', '<p>Estimad&lt;letra&gt; &lt;tratamiento&gt;:<br />\r\n<br />\r\n<br />\r\nEn seguimiento al artículo No. 106 del Estatuto Orgánico, me permito solicitarle tomar las medidas correspondientes sobre su desempeño académico, según la evaluación realizada en el II Ciclo Lectivo 2016 por el Centro de Evaluación Académica de nuestra Universidad.<br />\r\n<br />\r\n<br />\r\nA continuación le detallo los aspectos de la evaluación con nota inferior a 7.0 correspondientes al curso &lt;Curso&gt;, grupo &lt;Grupo&gt;, la calificación &lt;Nota&gt; fue otorgada por &lt;Alumnos&gt; de &lt;Matriculados&gt; estudiantes matriculados, lo que significa un &lt;% Participación &gt;% de participación:<br />\r\n<br />\r\n<br />\r\nResultados por Factor<br />\r\n&nbsp;</p>\r\n\r\n<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" style=\"width:660px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td colspan=\"5\">\r\n			<p>Factor</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>\r\n			<p>I</p>\r\n			</td>\r\n			<td>\r\n			<p>II</p>\r\n			</td>\r\n			<td>\r\n			<p>III</p>\r\n			</td>\r\n			<td>\r\n			<p>IV</p>\r\n			</td>\r\n			<td>\r\n			<p>V</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Sigla</p>\r\n			</td>\r\n			<td>\r\n			<p>Aspectos didácticos</p>\r\n			</td>\r\n			<td>\r\n			<p>Respeto a los estudiantes</p>\r\n			</td>\r\n			<td>\r\n			<p>Dominio y aplicación de la temática</p>\r\n			</td>\r\n			<td>\r\n			<p>Cumplimiento de reglamentos</p>\r\n			</td>\r\n			<td>\r\n			<p>Aspectos de evaluación</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>&lt;Curso&gt; Grupo &lt;Grupo&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Factor I Aspectos didácticos&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Factor II Respeto a los estudiantes&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Factor III Dominio y aplicación de la temática&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Factor IV Cumplimiento de reglamentos&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Factor V Aspectos de evaluación&gt;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><br />\r\n<br />\r\nResultados por Actitud<br />\r\n<br />\r\n&nbsp;</p>\r\n\r\n<table border=\"1\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td colspan=\"2\">\r\n			<p>Docente ha logrado desarrollar en usted una actitud hacia la materia tal que...</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Sigla</p>\r\n			</td>\r\n			<td>\r\n			<p>Al inicio tenía interés y lo perdió</p>\r\n			</td>\r\n			<td>\r\n			<p>Al inicio no tenía interés y sigue sin tenerlo</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>&lt;Curso&gt; Grupo &lt;Grupo&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Al inicio tenía interés y lo perdió&gt;</p>\r\n			</td>\r\n			<td>\r\n			<p>&lt;Al inicio no tenía interés y sigue sin tenerlo&gt;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p><br />\r\n<br />\r\nDicha aplicación permite además tener acceso a los comentarios de los estudiantes, los mismos se adjuntan a esta carta con el propósito de que sea un insumo para el continuo mejoramiento en el desempeño académico.<br />\r\n<br />\r\nCon el fin de mejorar la calidad académica, me permito recomendarle los cursos que ofrece el Departamento de Docencia Universitaria de la Escuela de Formación Docente (DEDUN).<br />\r\n<br />\r\n<br />\r\nEn seguimiento al Artículo 2, de la sesión 01-2016 del Consejo Académico, realizado el pasado 08 de julio de 2016, le recuerdo el procedimiento a seguir con las evaluaciones docentes a partir de los resultados de las evaluaciones del primer ciclo 2016:<br />\r\n<br />\r\n<br />\r\n<strong>ARTÍCULO 2</strong> El Director de la unidad académica da a conocer las evaluaciones del desempeño académico del primer semestre 2016.<br />\r\nSe puede observar la nota final general de cada docente, pero también dos aspectos: el desagregado según algunos componentes y el resultado de la motivación del curso percibida por parte de los estudiantes.<br />\r\nEsto es importante ya que si bien hay docentes que en la nota general aparece un aprobado, lo cierto es que hay notas de componentes en los cuales el desempeño fue juzgado negativamente, eso puede significar varios aspectos: ¿que el profesor califica mal?, ¿que no hay criterios válidos en la forma en que se evalúan las pruebas?, ¿que prácticamente no hay evaluaciones?, ¿que el diseño de las pruebas son pobremente planteadas? En fin lo que se quiere decir es que hay distintos componentes de la evaluación que hay que ver con cuidado porque el docente quizás debería mejorar en una dimensión específica.<br />\r\n<br />\r\n<br />\r\n<strong>Se resuelve:</strong><br />\r\n2.1 Encomendar a la Dirección el envío de un oficio general dirigido al cuerpo docente para que procedan a recoger los resultados de la evaluación de sus cursos del primer ciclo 2016 e indicar:<br />\r\n<br />\r\n<br />\r\n“En los casos de los docentes evaluados con las calificaciones de 9.5 o más en la valoración general y en cada uno de los rubros en particular, se les enviará una nota de reconocimiento por su trabajo docente, la cual irá con copia al archivo del docente y a la base de datos de evidencias para los criterios de docencia y enseñanza del aprendizaje del proceso de autoevaluación continua.<br />\r\n<br />\r\n<br />\r\nEn caso de que usted requiera mejorar en alguno de los siguientes aspectos: mecanismos de evaluación, estrategias didácticas, conocimiento de la normativa de evaluación, trato con los estudiantes o inteligencia emocional, entre otros, le rogamos que lo comunique por escrito a esta Dirección para que esta en conjunto con la Comisión de Docencia, canalice de la mejor forma sus necesidades de corrección, mejora o fortalecimiento en áreas específicas de la docencia.<br />\r\n<br />\r\n<br />\r\nSe le debe indicar al docente que de constatar en su evaluación que el número de estudiantes que procedieron a completar el cuestionario es bajo respecto al número total que había matriculado el curso, es posible que el resultado evaluativo no tenga validez. Para que esta situación no se repita, el próximo ciclo se tomarán las medidas pertinentes para que el porcentaje de estudiantes que llenen el instrumento no sea inferior a un 85% de quienes aún permanecen activos en el curso la semana de aplicación.<br />\r\n<br />\r\nFinalmente, aquellas personas que en la nota general de evaluación o en rubros específicos de la misma hayan tenido un desempeño no acreditable, se les enviará un oficio particular a efectos de conversar y llegar a acuerdos que permitan una mejora sensible vía capacitación. En especial aquellos casos en el que el CEA ha señalado que el porcentaje de estudiantes dijeron mayoritariamente que <em>“Al inicio tenía interés y lo perdió”</em> o <em>“Al inicio no tenía interés y sigue sin tenerlo”</em>. En estos casos se les convocará para conversar sobre esta valoración y encontrar mecanismos de mejora.<br />\r\n<br />\r\n<br />\r\nVotos a favor: 7 (unánime).<br />\r\nVotos en contra: 0 (literal del acta)<br />\r\n<br />\r\n<br />\r\nEn vista de lo anterior esta Dirección coordinará una reunión con los docentes que se encuentren en la condición antes descrita.<br />\r\n<br />\r\n<br />\r\nCon toda consideración y estima,</p>\r\n', 'C. Dra. Marlen León Guzmán, Vicerrectora, Vicerrectoría de Docencia<br />\r\n&nbsp; &nbsp; &nbsp;M.Ev.Ed. Marta Picado Mesén Directora, CEA<br />\r\n&nbsp; &nbsp; &nbsp;Dr. Manuel Martínez Herrera, Decano, Facultad de Ciencias Sociales<br />\r\n&nbsp; &nbsp; &nbsp;Licda. Lorena Kikut, Jefa STEA, CEA<br />\r\n&nbsp; &nbsp; &nbsp;Departamento de Docencia Universitaria de la Esc. De Formación Docente (DEDUN)<br />\r\n&nbsp; &nbsp; &nbsp;Archivo', 4, ''),
(28, 0, 5, 'Aporte a otros Proyectos', 2018, '', 'dsada', 18, '2018-04-23 06:00:00', '2018-05-24', '777777', 5, '34343', '1524522735_0.pdf', 'dasd', 'pdf', 'aaa', 1, 0, 4, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(29, 0, 6, 'Centro de Investigación en Ciencias e Ingeniería de Materiales', 2018, '', 'Recordatorio para acatar la circular VRA-9-2018', 1, '2018-04-26 06:00:00', '0000-00-00', '', -1, 'FM-230-2018', '1524762819_8.pdf', NULL, 'pdf', 'Dra. Sara Gonzáles Camacho', 1, 0, 4, 'Wendy Sandí Espinoza', '', '', 0, ''),
(30, 0, 7, 'Centro de Investigación en Biología Celular y Molecular', 2018, '', 'asdasdsada', 18, '2018-04-30 06:00:00', '0000-00-00', '', -1, '787897', '1525124553_2.pdf', 'adsadsd', 'pdf', 'asdasda', 1, 0, 7, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(31, 0, 8, 'Centro de Investigación en Ciencias Geológicas', 2018, '', 'NUEVO', 18, '2018-05-02 06:00:00', '0000-00-00', '', -1, '2-5-2018', '1525285847_8.pdf', 'este es nuevo', 'pdf', 'NUEVO', 1, 0, 4, 'Wendy Sandí Espinoza', '', '', 0, ''),
(32, 0, 9, 'Apoyo Académico Institucional', 2018, '', '7777777777', 18, '2018-05-02 06:00:00', '0000-00-00', '', -1, '777777', '1525293562_4.pdf', '77777777777', 'pdf', '777777', 1, 0, 3, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(33, 0, 10, 'ICE', 2018, '', 'aaaaaaaa', 21, '2018-05-03 06:00:00', '0000-00-00', '', -1, '99999999999', '1525356418_8.pdf', 'aaaaaaaaaaa', 'pdf', 'aaaaaaaaaaa', 2, 0, 5, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(34, 0, 11, 'Mi casa', 2018, '', 'rrrrrrrrrr', 18, '2018-04-30 06:00:00', '0000-00-00', '', -1, '202020', '1525359252_2.pdf', 'rrrrrrrrrrrrrrrrr', 'pdf', 'rrrrrrrr', 2, 0, 5, 'Wendy Sandí Espinoza', '', '', 0, ''),
(35, 0, 12, 'Centro de Investigación en Comunicación', 2018, '', 'wwwwwwwwwwww', 18, '2018-05-03 06:00:00', '0000-00-00', '', -1, 'wwwwwwwwww', '1525359547_5.pdf', 'wwwwwwwwwwwwww', 'pdf', 'wwwwwwwwwww', 1, 0, 1, 'Wendy Sandí Espinoza', '', '', 0, ''),
(36, 0, 13, 'Centro de Investigación en Enfermedades Tropicales', 2018, '', '44444444444', 18, '2018-05-03 06:00:00', '0000-00-00', '', -1, '444444444', '1525361636_1.pdf', '4444444444444', 'pdf', '44444444444', 1, 0, 4, 'Wendy Sandí Espinoza', '', '', 0, ''),
(37, 0, 14, 'Escuela de Ingeniería Eléctrica', 2018, '', '33333333333333', 18, '2018-05-03 06:00:00', '0000-00-00', '', -1, '33333333333', '1525362100_2.pdf', '3333333333333', 'pdf', '3333333333', 1, 0, 5, 'Wendy Sandí Espinoza', '', '', 0, ''),
(38, 16, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, 'Dra. Sara González Camacho<br />\r\nDirectora<br />\r\nLaboratorio de Ensayos Biológicos<br />\r\n&nbsp;', 'laboratorio', 1, '2018-05-15 17:14:06', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'Estimada señora:<br />\r\n&nbsp;<br />\r\nCon base en la Circular VRA-9-2018, me permito solicitarle respetuosamente&nbsp; acatar y divulgar entre todo el personal a su digno cargo la disposición “los responsables de los edificios deberán guardar especial cuidado de que se&nbsp; desconecten aquellos dispositivos y equipos con conexión riesgosa para las instalaciones,&nbsp; tales como: percoladores, hornos de microondas, hornos convencionales, cocinas, luces y otros similares,&nbsp; además de corroborar que se cierren bien las ventanas, celosías, portones metálicos, puertas y accesos principales, en todas las áreas de su Unidad Académica.<br />\r\n&nbsp;<br />\r\nAsimismo, le informo que el cierre del edificio por receso institucional se realizará el <strong>sábado 24 de marzo de 2018 a la 2:00 p.m</strong>., sin embargo, debido a que la mayoría de las personas no laboran el sábado,&nbsp; favor comunicar esta información al personal docente y administrativo de su unidad académica para que el viernes 23 de abril&nbsp; se ponga en operación el protocolo de cierre.<br />\r\n&nbsp;<br />\r\n&nbsp;<br />\r\nAtentamente,<br />\r\n&nbsp;', 'CFZ/YCB<br />\r\n&nbsp;', 5, ''),
(39, 17, 0, 'Escuela de Ingeniería Eléctrica', 2018, 'ads', 'asda', 4, '2018-05-15 19:01:29', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'asd', 'C: Archivoasd', 4, ''),
(40, 18, 0, 'Facultad de Derecho', 2018, '<a href=\"http://localhost/oficio_in.php#\">Ingreso|Salida Correspondencia asdadasdasdasds</a>', 'asdasdasd', 4, '2018-05-15 19:02:55', '0000-00-00', '', 0, '', '', 'Enviado a revision', '', '', 0, 0, 4, '', 'asdasdad', 'C: Archivoasd', 4, ''),
(41, 19, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, '<a href=\"http://localhost/oficio_in.php#\">Ingreso|Salida Correspondencia asdadasdasdasds</a>', 'asdasdasd', 4, '2018-05-24 06:00:00', '0000-00-00', '', 0, '', '1526505862_6.pdf', 'Devolviendo', 'pdf', '', 0, 0, 1, '', 'asdasdad', 'C: Archivoasd', 4, ''),
(42, 20, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, '777777777777777', '7777777777777', 4, '2018-05-07 06:00:00', '0000-00-00', '', 0, '', '1526504475_2.doc', NULL, 'doc', '', 0, 0, 1, '', '77777777777777', 'C: Archivo777777777', 4, ''),
(43, 21, 0, 'Consejo Asesor', 2018, 'Dra. Lizbeth Salazar Sánchez, Directora, Escuela de Medicina<br />\r\nLic. Luis Chaves Soto, Jefe Administrativo, Escuela de Medicina<br />\r\nDra. Aileen Fernández, Directora, Departamento de Fisiología<br />\r\nDr. Ronald González Argüello, Director, Departamento de Farmacología<br />\r\nDra. Silvia Quesada Mora, Directora, Departamento de Bioquímica<br />\r\nDr. Maikel Vargas Sanabria, Director, Departamento de Anatomía<br />\r\nSra. Mariana Alarcón Retana, Presidenta, Asociación de Estudiantes, Medicina<br />\r\n&nbsp;<br />\r\nEstimados (as) señores (as):<br />\r\n&nbsp;', 'datos del oficio', 4, '2018-08-07 06:00:00', '0000-00-00', '', 0, '', '1526504199_6.pdf', 'Listo', 'pdf', 'Consejo Asesor', 0, 0, 5, '', 'Continuando con el programa de recuperación de la deteriorada planta física de la Facultad de Medicina, misma que es sede de la Escuela de Medicina, me permito informarles que el día 22 de enero de 2018 se dará inicio al cambio de la cubierta de techo, sustitución de sensores de alarma considerados por las técnicos como obsoletos, y colocación de nuevas cámaras de vigilancia.<br />\r\n&nbsp;<br />\r\nEl 29 de enero se dará inicio a la pintura externa del edificio, el 05 de febrero se iniciará la remodelación de los servicios sanitarios destinados al público en el I, II y III piso del edificio, este proceso se realizará por etapas a fin de minimizar los inconvenientes, iniciando por los sanitarios del I piso. &nbsp;<br />\r\n&nbsp;<br />\r\nAsimismo, se continuará con la limpieza del frontispicio de la fachada principal, para lo cual aún no se cuenta con fecha cierta, y que no se logró concluir de acuerdo al programa preestablecido, por razones de índole técnico, ajenos a esta Facultad.<br />\r\n&nbsp;<br />\r\nAsimismo, se trabaja en la construcción del nicho donde se instalarán los requerimientos técnicos del departamento de Anatomía para la recuperación y mantenimiento de la osteoteca.<br />\r\n&nbsp;<br />\r\nPor todo lo anterior solicito a través de su digno medio la comprensión y colaboración de profesores, alumnos y personal administrativo, y de antemano les presento nuestras sentidas excusas por los inconvenientes que transitoriamente estos trabajos puedan provocar a cualquiera de los miembros de esta comunidad universitaria.<br />\r\n<br />\r\nNo omito manifestarles que cualquier sugerencia en pro de mitigar los eventuales inconvenientes que estos trabajos de remodelación y mantenimiento puedan ocasionar serán bien recibidos por este despacho a través de la coordinación de la Licda. Wendy Sandí, Administradora de la Facultad.<br />\r\n&nbsp;<br />\r\nAgradeciendo la comprensión e indulgencia que de antemano solicitamos, me suscribo de ustedes.<br />\r\n&nbsp;<br />\r\nAtentamente,<br />\r\n&nbsp;', '&nbsp;<br />\r\nCc: Archivo<br />\r\n&nbsp;<br />\r\n&nbsp;<br />\r\nCFZ/LBM<br />\r\n&nbsp;', 4, ''),
(44, 1, 0, 'Centro de Investigación en Contaminación Ambiental', 1970, 'Stuart', 'oficio del 2017', 18, '2017-05-18 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'Stuart', 0, 0, 1, '', 'Este es el ultimo oficio del 2017 pero fue hecho en el 2018', 'C: Archivo', 5, ''),
(45, 2, 0, 'Centro de Investigación en Estructuras Microscópicas', 1970, '7878', 'kklklklklk', 18, '2017-07-19 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'aaaaaaaaaa   ', 0, 0, 1, '', 'este es el nuevo texto del oficio', 'C: Archivo', 4, ''),
(46, 3, 0, 'Centro de Informática', 2018, '', '', 18, '2018-03-15 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', '   ', 0, 0, 1, '', 'Este es el texto del oficio', 'C: Archivo Ademas', 4, ''),
(47, 3, 0, 'Centro de Investigación en Electroquímica y Energía Química', 2017, '898989', '898989', 18, '2017-06-14 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', '898989', 0, 0, 1, '', '89898', 'C: Archivo', 4, ''),
(48, 4, 0, 'Centro de Investigación en Electroquímica y Energía Química', 2017, '898989', '898989', 18, '2017-06-14 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', '898989', 0, 0, 1, '', '89898', 'C: Archivo', 4, ''),
(49, 3, 0, 'Centro de Investigación en Contaminación Ambiental', 1970, 'saAS', '', 18, '2018-05-17 18:01:46', '0000-00-00', '', 0, '', '', NULL, '', '', 0, 0, 1, '', 'ASDASD', 'C: Archivo', 4, ''),
(50, 0, 15, 'Escuela de Ciencias de la Comunicación Colectiva', 2018, '', 'Este es el asunto', 18, '2018-05-22 06:00:00', '0000-00-00', '', -1, 'ECP-2020-2018', '1527019661_7.pdf', 'Observaciones', 'pdf', 'Stuart', 1, 0, 9, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(51, 0, 16, 'Centro de Investigación en Ciencias e Ingeniería de Materiales', 2018, '', '34343', 18, '2018-05-22 06:00:00', '0000-00-00', '', -1, '343434', '1527026693_0.pdf', '3434', 'pdf', '343434', 1, 0, 1, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(52, 22, 0, 'Centro de Investigación en Ciencias del Mar y Limnología', 2018, 'Personas, muchas personas', 'Oficio de salida con estado fijo', 18, '2018-05-24 06:00:00', '0000-00-00', '', 0, '', '', 'Wendy lo esta finalizando', '', 'Stuart', 0, 0, 5, '', 'Aqui va el texto del oficio', 'C: Archivo', 5, ''),
(53, 0, 17, 'Escuela de Medicina', 2018, '', 'Un asunto', 18, '2017-03-23 06:00:00', '0000-00-00', '', -1, 'EM-205-2017', '1527266406_1.pdf', 'Las observaciones', 'pdf', 'Un remitente', 1, 0, 9, 'Wendy Sandí Espinoza', '', '', 0, ''),
(54, 0, 1, 'Escuela de Medicina', 2017, '', 'Stuart', 18, '2017-03-23 06:00:00', '0000-00-00', '', -1, '23Marzo', '1527266913_9.pdf', 'Stuart', 'pdf', 'Stuart', 1, 0, 1, 'Wendy Sandí Espinoza', '', '', 0, ''),
(55, 0, 2, 'Escuela de Ingeniería Civil', 2017, '', 'Asunto', 18, '2017-11-27 06:00:00', '0000-00-00', '', -1, '27-11-17', '1527267062_0.pdf', 'Observaciones', 'pdf', 'OTro oficio de noviembre anio 2017', 1, 0, 1, 'Carlos Alberto Fonseca Zamora', '', '', 0, ''),
(56, 0, 18, 'Escuela de Administración Educativa', 2018, '', 'ASunto', 18, '2018-05-25 06:00:00', '0000-00-00', '', -1, 'OF2018', '1527268964_2.pdf', 'observaciones', 'pdf', 'Remitente', 1, 0, 1, 'Wendy Sandí Espinoza', '', '', 0, ''),
(57, 23, 0, 'Centro de Investigación en Comunicación', 2018, 'Senor', 'Asunto', 18, '2018-05-23 06:00:00', '0000-00-00', '', 0, '', '', 'Ahora esta en tramite 29/05', '', 'Remiente', 0, 0, 4, '', 'Cuerpo del oficio', 'C: Archivo', 4, ''),
(58, 0, 19, 'Aporte a otros Proyectos', 2018, '', 'Stuart', 18, '2018-05-28 06:00:00', '0000-00-00', '', -1, 'Numero Nuevo', '1527520331_0.pdf', NULL, 'pdf', 'Stuart', 1, 0, 1, 'Wendy Sandí Espinoza', '', '', 0, ''),
(59, 24, 0, 'Centro de Investigación en Biología Celular y Molecular', 2018, 'Datos datos', 'Resumen oficio', 18, '2018-05-09 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'Este es el remitente', 0, 0, 1, '', 'Mas datos mas datos', 'C: Archivo', 5, ''),
(60, 25, 0, 'Centro de Investigación en Contaminación Ambiental', 2018, 'Dirigido a', 'Este es el asunto', 2, '2018-05-29 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'Nuevo remitente stuart', 0, 0, 1, '', 'probando', 'C: Archivo', 5, ''),
(61, 26, 0, 'Centro de Investigación en Ciencias Geológicas', 2018, 'Asdadsad', 'Asunto', 2, '2018-05-29 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'Remitente', 0, 0, 1, '', 'asdasd', 'C: Archivo', 5, ''),
(62, 27, 0, 'Escuela de Filosofía', 2018, 'asdasdadsasdasdasd', 'sdadsasd', 2, '2018-05-28 06:00:00', '0000-00-00', '', 0, '', '', NULL, '', 'asdasdasd', 0, 0, 1, '', 'asdasdasdasd', 'C: Archivo', 5, ''),
(63, 28, 0, 'Comedor Estudiantil', 2018, 'adsasdasd', 'asadasdasd', 2, '2018-05-28 06:00:00', '0000-00-00', '', 0, '', '', 'Listo', '', 'asdasd', 0, 0, 5, '', 'asdasdas', 'C: Archivo', 4, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `info_oficios_log`
--

CREATE TABLE `info_oficios_log` (
  `oficio_idlog` int(11) NOT NULL,
  `oficio_id` int(11) NOT NULL,
  `oficio_id1` int(11) NOT NULL,
  `oficio_id2` int(11) NOT NULL,
  `dependencia` varchar(15) NOT NULL DEFAULT 'EAP-',
  `anno` year(4) NOT NULL,
  `destinatario` text NOT NULL,
  `asunto` varchar(250) NOT NULL,
  `usuario_inserta` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_archivado` date NOT NULL,
  `ubicacion` varchar(250) NOT NULL,
  `usuario_modifica` int(11) NOT NULL,
  `no_oficio` varchar(100) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `resp_usuario` varchar(100) NOT NULL,
  `extension_archivos` varchar(255) NOT NULL,
  `usuario_asig` int(11) NOT NULL,
  `tipo_oficio` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `info_oficios_log`
--

INSERT INTO `info_oficios_log` (`oficio_idlog`, `oficio_id`, `oficio_id1`, `oficio_id2`, `dependencia`, `anno`, `destinatario`, `asunto`, `usuario_inserta`, `fecha`, `fecha_archivado`, `ubicacion`, `usuario_modifica`, `no_oficio`, `imagen`, `resp_usuario`, `extension_archivos`, `usuario_asig`, `tipo_oficio`, `respuesta`, `id_estado`) VALUES
(1, 1, 1, 0, '', 2018, 'Esteban Nanito<br />\r\nDirector<br />\r\nHotel Lapa Lisa', 'Prueba cambio año', 4, '2018-02-08 21:54:18', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(2, 2, 2, 0, '', 2018, 'Esteban Dido<br />\r\nSubdirector<br />\r\nFinca Li Brar', 'Test 2', 4, '2018-02-08 21:56:13', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(3, 1, 1, 0, '', 2017, 'Esteban Nanito<br />\r\nDirector<br />\r\nHotel Lapa Lisa', 'Prueba cambio año', 4, '2018-02-08 21:54:18', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(4, 2, 2, 0, '', 2017, 'Esteban Dido<br />\r\nSubdirector<br />\r\nFinca Li Brar', 'Test 2', 4, '2018-02-08 21:56:13', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(5, 1, 1, 0, '', 2017, 'Esteban Nanito<br />\r\nDirector<br />\r\nHotel Lapa Lisa', 'Prueba cambio año', 4, '2018-02-08 21:54:18', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(6, 3, 1, 0, '', 2018, 'Esteban Ca Rota<br />\r\nDueño<br />\r\nInversiones Cesidades', 'Prueba 3', 4, '2018-02-08 21:59:45', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(7, 4, 2, 0, '', 2018, 'Dra. Guiselle', 'Solicitud', 1, '2018-03-06 20:16:52', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(8, 4, 2, 0, '', 2018, 'Dra. Guiselle', 'Solicitud', 1, '2018-03-06 20:16:52', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(9, 4, 2, 0, '', 2018, 'Dra. Guiselle', 'Solicitud', 1, '2018-03-06 20:16:52', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(10, 4, 2, 0, '', 2018, 'Dra. Guiselle<br />\r\n<br />\r\n<br />\r\n<br />\r\n&nbsp;', 'Solicitud', 1, '2018-03-06 20:16:52', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(11, 5, 0, 0, 'ETS', 2018, 'Carlos', 'Asunto', 1, '2018-03-07 20:25:25', '0000-00-00', '', -1, 'ETS-2-2018', '', '', '', 1, 1, 0, 7),
(12, 5, 0, 0, 'ETS', 2018, 'Carlos', 'Asunto', 1, '2018-03-07 20:25:25', '0000-00-00', '', -1, 'ETS-2-2018', '1520360112_8.pdf', '', '', 1, 1, 0, 7),
(13, 6, 3, 0, '', 2018, 'Dra H', 'Prueba', 4, '2018-03-08 17:22:11', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 5),
(14, 7, 4, 0, '', 2018, 'df', 'sgf', 4, '2018-03-08 17:24:56', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 5),
(15, 8, 5, 0, '', 2018, '', '', 4, '2018-03-09 15:06:26', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(16, 9, 6, 0, '', 2018, '', '', 4, '2018-03-09 15:07:14', '0000-00-00', '', 0, '', '', '', '', 0, 0, 0, 0),
(17, 5, 0, 0, '481', 2018, 'Carlos', 'Asunto', 1, '2018-03-07 20:25:25', '0000-00-00', '', -1, 'ETS-2-2018', '1520360112_8.pdf', '', '', 1, 1, 0, 7),
(18, 5, 0, 0, '837', 2018, 'Carlos', 'Asunto', 1, '2018-03-07 20:25:25', '0000-00-00', '', -1, 'ETS-2-2018', '1520360112_8.pdf', '', '', 1, 1, 0, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefaturas`
--

CREATE TABLE `jefaturas` (
  `id_jefatura` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido1` varchar(100) NOT NULL,
  `apellido2` varchar(100) NOT NULL,
  `puesto` varchar(100) NOT NULL,
  `grado_academico` varchar(100) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `jefaturas`
--

INSERT INTO `jefaturas` (`id_jefatura`, `nombre`, `apellido1`, `apellido2`, `puesto`, `grado_academico`, `activo`) VALUES
(4, 'Carlos Alberto', 'Fonseca', 'Zamora', 'Decano', 'Dr.', 1),
(5, 'Wendy', 'Sandí', 'Espinoza', 'Jefa Administrativa', 'Licda.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(10) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `autorizado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_nivel`, `descripcion`, `autorizado`) VALUES
(1, 'Administrativa', 1),
(2, 'Subdireccion', 1),
(3, 'Informatica', 1),
(4, 'Jefatura', 1),
(5, 'Archivo', 1),
(6, 'Dirección', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficios_bloqueados`
--

CREATE TABLE `oficios_bloqueados` (
  `oficiobloc_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `oficio_id` int(11) NOT NULL,
  `fecha_bloqueo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficios_usuario`
--

CREATE TABLE `oficios_usuario` (
  `id_oficiousua` int(11) NOT NULL,
  `id_oficioin` int(11) NOT NULL,
  `observacion` varchar(1500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `resp_usuario` varchar(2000) NOT NULL,
  `detalle_traslado` varchar(2000) NOT NULL,
  `usuario_traslada` varchar(100) NOT NULL,
  `fecha_asignado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_cambios` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `coment_jefa` int(11) NOT NULL,
  `fecha_traslado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tarea` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `oficios_usuario`
--

INSERT INTO `oficios_usuario` (`id_oficiousua`, `id_oficioin`, `observacion`, `usuario_id`, `id_estado`, `resp_usuario`, `detalle_traslado`, `usuario_traslada`, `fecha_asignado`, `fecha_cambios`, `coment_jefa`, `fecha_traslado`, `tarea`) VALUES
(1, 5, 'Le asigno esto a ver', 5, 3, 'Listo, archivado', 'archivar', '4', '2018-03-08 20:31:28', '2018-04-20 14:59:30', 0, '2018-04-20 14:37:16', NULL),
(2, 15, 'Aqui va este oficio', 6, 8, '', 'Este oficio se esta trasladando', '4', '2018-04-18 17:51:06', '0000-00-00 00:00:00', 0, '2018-04-20 14:31:08', NULL),
(3, 17, 'favor archivar', 5, 3, 'Listo, ya lo tramité', '', '', '2018-04-20 14:34:44', '2018-04-20 14:58:43', 0, '0000-00-00 00:00:00', NULL),
(4, 5, 'verificar', 2, 1, '', '', '', '2018-04-20 14:35:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(5, 22, 'Revisar el siguiente oficio', 21, 5, '7777', 'sssss', '4', '2018-04-23 19:30:02', '2018-05-02 20:51:52', 0, '2018-05-02 20:50:27', NULL),
(6, 23, 'Dar tramite por favor', 19, 1, '', '', '', '2018-04-23 19:51:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(7, 17, 'Nueva asignación de pdf', 4, 4, '2222', 'ya lo envie para la revision', '21', '2018-04-23 21:50:54', '2018-05-15 17:24:02', 0, '2018-05-04 17:40:59', NULL),
(8, 22, 'Favor revisar', 19, 8, '', 'Ya esta revisado, favor archivar', '18', '2018-04-23 21:59:36', '0000-00-00 00:00:00', 0, '2018-04-23 22:00:44', NULL),
(9, 22, 'asada', 18, 5, 'Tramite finalizado', '', '', '2018-04-23 22:19:41', '2018-05-02 17:31:20', 0, '0000-00-00 00:00:00', NULL),
(10, 23, 'uuuu', 19, 8, '', 'ppppp', '18', '2018-04-23 22:19:53', '0000-00-00 00:00:00', 0, '2018-04-23 22:21:01', NULL),
(11, 28, 'ddddd', 19, 8, '', 'kkkkk', '18', '2018-04-23 22:32:30', '0000-00-00 00:00:00', 0, '2018-04-23 22:32:58', NULL),
(12, 28, 'primera asignación', 18, 5, 'listo', '', '', '2018-04-25 19:48:18', '2018-05-02 18:24:06', 0, '0000-00-00 00:00:00', NULL),
(13, 29, 'Favor revisar y gestionar', 22, 1, '', '', '', '2018-04-26 17:29:54', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(14, 29, 'favor tramitar', 18, 4, 'En espera de respuesta', '', '', '2018-04-30 20:42:16', '2018-05-02 17:18:36', 0, '0000-00-00 00:00:00', NULL),
(15, 30, 'ojo', 2, 8, 'Enviado y en espera de respuesta', 'listo', '18', '2018-04-30 21:43:01', '2018-05-02 17:10:28', 0, '2018-05-02 17:30:55', NULL),
(17, 23, 'Aqui va este oficio', 18, 5, 'Listo, ya lo tramité', '', '', '2018-05-02 18:48:22', '2018-05-03 15:44:10', 0, '0000-00-00 00:00:00', NULL),
(19, 31, 'ghjkhkj', 21, 4, 'espero', 'Mejor aqui', '18', '2018-05-02 18:55:57', '2018-05-02 21:47:18', 0, '2018-05-02 21:46:42', NULL),
(20, 32, '777777777', 18, 3, 'pen', '', '', '2018-05-02 20:40:42', '2018-05-02 20:43:30', 0, '0000-00-00 00:00:00', NULL),
(21, 33, 'pppppppppppp', 18, 5, 'Listo', '', '', '2018-05-03 14:56:22', '2018-05-07 14:47:48', 0, '0000-00-00 00:00:00', NULL),
(22, 34, 'uuuuuuuuuu', 18, 5, 'Listo', '', '', '2018-05-03 14:57:14', '2018-05-07 14:46:51', 0, '0000-00-00 00:00:00', NULL),
(23, 35, '000000000000', 20, 9, '', 'rrrrrrrrrr', '18', '2018-05-03 15:32:25', '0000-00-00 00:00:00', 0, '2018-05-03 15:43:20', NULL),
(24, 36, '44444444', 20, 9, 'aaaaa', 'ddddddd', '18', '2018-05-03 15:34:23', '2018-05-03 15:43:39', 0, '2018-05-03 15:43:51', NULL),
(25, 37, 'rrrrrr', 20, 9, '', '', '', '2018-05-03 15:42:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(26, 37, 'rrrrrr', 18, 5, 'Listo', '', '', '2018-05-03 15:42:57', '2018-05-07 14:47:28', 0, '0000-00-00 00:00:00', NULL),
(27, 50, 'oo;opopop', 18, 9, '', '', '', '2018-05-22 22:48:59', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(28, 53, 'Revisar', 18, 9, '', '', '', '2018-05-25 16:51:40', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL);

--
-- Disparadores `oficios_usuario`
--
DELIMITER $$
CREATE TRIGGER `ofi_usuario` AFTER INSERT ON `oficios_usuario` FOR EACH ROW INSERT INTO oficios_usuariolog (id_oficiousua, id_oficioin, observacion, usuario_id, id_estado, resp_usuario, detalle_traslado,`usuario_traslada`,`fecha_asignado`,`fecha_cambios`,`coment_jefa`, `fecha_traslado`) VALUES (NEW.id_oficiousua,NEW.id_oficioin,NEW.observacion,NEW.usuario_id,NEW.id_estado,NEW.resp_usuario, NEW.detalle_traslado, NEW.usuario_traslada, NEW.fecha_asignado,NEW.fecha_cambios, NEW.coment_jefa, NEW.fecha_traslado)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `oficiousuario_update` BEFORE UPDATE ON `oficios_usuario` FOR EACH ROW INSERT INTO oficios_usuariolog (id_oficiousua, id_oficioin, observacion, usuario_id, id_estado, resp_usuario, `detalle_traslado`, `usuario_traslada`,`fecha_asignado`,`fecha_cambios`, `coment_jefa`, `fecha_traslado`) VALUES (NEW.id_oficiousua,NEW.id_oficioin,NEW.observacion,NEW.usuario_id,NEW.id_estado,NEW.resp_usuario, NEW.`detalle_traslado`, NEW.`usuario_traslada`, NEW.fecha_asignado, NEW.fecha_cambios, NEW.coment_jefa, NEW.fecha_traslado)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficios_usuariolog`
--

CREATE TABLE `oficios_usuariolog` (
  `id_oficiousuariolog` int(11) NOT NULL,
  `id_oficiousua` int(11) NOT NULL,
  `id_oficioin` int(11) NOT NULL,
  `observacion` varchar(1500) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `resp_usuario` varchar(2000) NOT NULL,
  `detalle_traslado` varchar(250) NOT NULL,
  `usuario_traslada` int(11) NOT NULL,
  `fecha_asignado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_cambios` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `coment_jefa` int(11) NOT NULL,
  `fecha_traslado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `oficios_usuariolog`
--

INSERT INTO `oficios_usuariolog` (`id_oficiousuariolog`, `id_oficiousua`, `id_oficioin`, `observacion`, `usuario_id`, `id_estado`, `resp_usuario`, `detalle_traslado`, `usuario_traslada`, `fecha_asignado`, `fecha_cambios`, `coment_jefa`, `fecha_traslado`) VALUES
(1, 1, 5, 'Le asigno esto a ver', 4, 1, '', '', 0, '2018-03-08 20:31:28', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 2, 15, 'Aqui va este oficio', 4, 1, '', '', 0, '2018-04-18 17:51:06', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 2, 15, 'Aqui va este oficio', 6, 8, '', 'Este oficio se esta trasladando', 4, '2018-04-18 17:51:06', '0000-00-00 00:00:00', 0, '2018-04-20 14:31:08'),
(4, 3, 17, 'favor archivar', 5, 1, '', '', 0, '2018-04-20 14:34:44', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 4, 5, 'verificar', 2, 1, '', '', 0, '2018-04-20 14:35:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 1, 5, 'Le asigno esto a ver', 5, 8, '', 'archivar', 4, '2018-03-08 20:31:28', '0000-00-00 00:00:00', 0, '2018-04-20 14:37:16'),
(7, 3, 17, 'favor archivar', 5, 3, 'Listo, ya lo tramité', '', 0, '2018-04-20 14:34:44', '2018-04-20 14:58:43', 0, '0000-00-00 00:00:00'),
(8, 1, 5, 'Le asigno esto a ver', 5, 3, 'Listo, archivado', 'archivar', 4, '2018-03-08 20:31:28', '2018-04-20 14:59:30', 0, '2018-04-20 14:37:16'),
(9, 5, 22, 'Revisar el siguiente oficio', 4, 1, '', '', 0, '2018-04-23 19:30:02', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, 6, 23, 'Dar tramite por favor', 6, 1, '', '', 0, '2018-04-23 19:51:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, 5, 22, 'Revisar el siguiente oficio', 4, 3, 'Listo, la sala fue asignada', '', 0, '2018-04-23 19:30:02', '2018-04-23 19:55:39', 0, '0000-00-00 00:00:00'),
(12, 7, 17, 'Nueva asignación de pdf', 4, 1, '', '', 0, '2018-04-23 21:50:54', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 7, 17, 'Nueva asignación de pdf', 2, 8, '', 'Mejor aqui', 4, '2018-04-23 21:50:54', '0000-00-00 00:00:00', 0, '2018-04-23 21:51:44'),
(14, 8, 22, 'Favor revisar', 18, 1, '', '', 0, '2018-04-23 21:59:36', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 8, 22, 'Favor revisar', 19, 8, '', 'Ya esta revisado, favor archivar', 18, '2018-04-23 21:59:36', '0000-00-00 00:00:00', 0, '2018-04-23 22:00:44'),
(16, 9, 22, 'asada', 18, 1, '', '', 0, '2018-04-23 22:19:41', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 10, 23, 'uuuu', 18, 1, '', '', 0, '2018-04-23 22:19:53', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 10, 23, 'uuuu', 19, 8, '', 'ppppp', 18, '2018-04-23 22:19:53', '0000-00-00 00:00:00', 0, '2018-04-23 22:21:01'),
(19, 6, 23, 'Dar tramite por favor', 19, 1, '', '', 0, '2018-04-23 19:51:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(20, 11, 28, 'ddddd', 18, 1, '', '', 0, '2018-04-23 22:32:30', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(21, 11, 28, 'ddddd', 19, 8, '', 'kkkkk', 18, '2018-04-23 22:32:30', '0000-00-00 00:00:00', 0, '2018-04-23 22:32:58'),
(22, 9, 22, 'asada', 18, 3, 'Ya se resolvió el oficio', '', 0, '2018-04-23 22:19:41', '2018-04-25 19:38:50', 0, '0000-00-00 00:00:00'),
(23, 12, 28, 'primera asignación', 18, 1, '', '', 0, '2018-04-25 19:48:18', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(24, 12, 28, 'primera asignación', 18, 3, 'Listo', '', 0, '2018-04-25 19:48:18', '2018-04-26 14:53:34', 0, '0000-00-00 00:00:00'),
(25, 13, 29, 'Favor revisar y gestionar', 22, 1, '', '', 0, '2018-04-26 17:29:54', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 7, 17, 'Nueva asignación de pdf', 21, 8, '', 'Favor atender', 2, '2018-04-23 21:50:54', '0000-00-00 00:00:00', 0, '2018-04-26 17:53:22'),
(27, 12, 28, 'primera asignación', 18, 6, 'Cambiando de estado', '', 0, '2018-04-25 19:48:18', '2018-04-30 18:36:38', 0, '0000-00-00 00:00:00'),
(28, 14, 29, 'favor tramitar', 18, 1, '', '', 0, '2018-04-30 20:42:16', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(29, 15, 30, 'ojo', 18, 1, '', '', 0, '2018-04-30 21:43:01', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 15, 30, 'ojo', 18, 1, 'cambiando de estado', '', 0, '2018-04-30 21:43:01', '2018-04-30 21:43:35', 0, '0000-00-00 00:00:00'),
(31, 15, 30, 'ojo', 18, 1, 'Listo, ya lo tramité', '', 0, '2018-04-30 21:43:01', '2018-04-30 22:04:39', 0, '0000-00-00 00:00:00'),
(32, 15, 30, 'ojo', 18, 4, 'Enviado y en espera de respuesta', '', 0, '2018-04-30 21:43:01', '2018-05-02 17:10:28', 0, '0000-00-00 00:00:00'),
(33, 14, 29, 'favor tramitar', 18, 4, 'En espera de respuesta', '', 0, '2018-04-30 20:42:16', '2018-05-02 17:18:36', 0, '0000-00-00 00:00:00'),
(34, 15, 30, 'ojo', 2, 8, 'Enviado y en espera de respuesta', 'listo', 18, '2018-04-30 21:43:01', '2018-05-02 17:10:28', 0, '2018-05-02 17:30:55'),
(35, 9, 22, 'asada', 18, 5, 'Tramite finalizado', '', 0, '2018-04-23 22:19:41', '2018-05-02 17:31:20', 0, '0000-00-00 00:00:00'),
(36, 12, 28, 'primera asignación', 18, 5, 'listo', '', 0, '2018-04-25 19:48:18', '2018-05-02 18:24:06', 0, '0000-00-00 00:00:00'),
(37, 16, 31, 'Tramite', 18, 1, '', '', 0, '2018-05-02 18:31:26', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 17, 23, 'Aqui va este oficio', 18, 1, '', '', 0, '2018-05-02 18:48:22', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 18, 31, 'va de nuevo', 18, 1, '', '', 0, '2018-05-02 18:55:13', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 19, 31, 'ghjkhkj', 18, 1, '', '', 0, '2018-05-02 18:55:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 20, 32, '777777777', 18, 9, '', '', 0, '2018-05-02 20:40:42', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 19, 31, 'ghjkhkj', 21, 8, '', 'victor', 18, '2018-05-02 18:55:57', '0000-00-00 00:00:00', 0, '2018-05-02 20:41:53'),
(43, 17, 23, 'Aqui va este oficio', 18, 1, 'pa', '', 0, '2018-05-02 18:48:22', '2018-05-02 20:42:36', 0, '0000-00-00 00:00:00'),
(44, 20, 32, '777777777', 18, 3, 'pen', '', 0, '2018-05-02 20:40:42', '2018-05-02 20:43:30', 0, '0000-00-00 00:00:00'),
(45, 5, 22, 'Revisar el siguiente oficio', 21, 9, 'Listo, la sala fue asignada', 'sssss', 4, '2018-04-23 19:30:02', '2018-04-23 19:55:39', 0, '2018-05-02 20:50:27'),
(46, 5, 22, 'Revisar el siguiente oficio', 21, 5, '7777', 'sssss', 4, '2018-04-23 19:30:02', '2018-05-02 20:51:52', 0, '2018-05-02 20:50:27'),
(47, 19, 31, 'ghjkhkj', 18, 9, '', '5555', 21, '2018-05-02 18:55:57', '0000-00-00 00:00:00', 0, '2018-05-02 21:45:23'),
(48, 19, 31, 'ghjkhkj', 18, 2, 'tra', '5555', 21, '2018-05-02 18:55:57', '2018-05-02 21:46:05', 0, '2018-05-02 21:45:23'),
(49, 19, 31, 'ghjkhkj', 21, 9, 'tra', 'Mejor aqui', 18, '2018-05-02 18:55:57', '2018-05-02 21:46:05', 0, '2018-05-02 21:46:42'),
(50, 19, 31, 'ghjkhkj', 21, 4, 'espero', 'Mejor aqui', 18, '2018-05-02 18:55:57', '2018-05-02 21:47:18', 0, '2018-05-02 21:46:42'),
(51, 21, 33, 'pppppppppppp', 18, 1, '', '', 0, '2018-05-03 14:56:22', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(52, 22, 34, 'uuuuuuuuuu', 18, 1, '', '', 0, '2018-05-03 14:57:14', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(53, 23, 35, '000000000000', 18, 1, '', '', 0, '2018-05-03 15:32:25', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(54, 24, 36, '44444444', 18, 1, '', '', 0, '2018-05-03 15:34:23', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(55, 25, 37, 'rrrrrr', 20, 9, '', '', 0, '2018-05-03 15:42:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(56, 26, 37, 'rrrrrr', 18, 9, '', '', 0, '2018-05-03 15:42:57', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(57, 23, 35, '000000000000', 20, 9, '', 'rrrrrrrrrr', 18, '2018-05-03 15:32:25', '0000-00-00 00:00:00', 0, '2018-05-03 15:43:20'),
(58, 24, 36, '44444444', 18, 4, 'aaaaa', '', 0, '2018-05-03 15:34:23', '2018-05-03 15:43:39', 0, '0000-00-00 00:00:00'),
(59, 24, 36, '44444444', 20, 9, 'aaaaa', 'ddddddd', 18, '2018-05-03 15:34:23', '2018-05-03 15:43:39', 0, '2018-05-03 15:43:51'),
(60, 17, 23, 'Aqui va este oficio', 18, 5, 'Listo, ya lo tramité', '', 0, '2018-05-02 18:48:22', '2018-05-03 15:44:10', 0, '0000-00-00 00:00:00'),
(61, 7, 17, 'Nueva asignación de pdf', 21, 6, 'Enviado a revision', 'Favor atender', 2, '2018-04-23 21:50:54', '2018-05-04 17:40:35', 0, '2018-04-26 17:53:22'),
(62, 7, 17, 'Nueva asignación de pdf', 4, 9, 'Enviado a revision', 'ya lo envie para la revision', 21, '2018-04-23 21:50:54', '2018-05-04 17:40:35', 0, '2018-05-04 17:40:59'),
(63, 7, 17, 'Nueva asignación de pdf', 4, 2, '777', 'ya lo envie para la revision', 21, '2018-04-23 21:50:54', '2018-05-04 22:36:51', 0, '2018-05-04 17:40:59'),
(64, 22, 34, 'uuuuuuuuuu', 18, 5, 'Listo', '', 0, '2018-05-03 14:57:14', '2018-05-07 14:46:51', 0, '0000-00-00 00:00:00'),
(65, 26, 37, 'rrrrrr', 18, 5, 'Listo', '', 0, '2018-05-03 15:42:57', '2018-05-07 14:47:28', 0, '0000-00-00 00:00:00'),
(66, 21, 33, 'pppppppppppp', 18, 5, 'Listo', '', 0, '2018-05-03 14:56:22', '2018-05-07 14:47:48', 0, '0000-00-00 00:00:00'),
(67, 7, 17, 'Nueva asignación de pdf', 4, 4, '2222', 'ya lo envie para la revision', 21, '2018-04-23 21:50:54', '2018-05-15 17:24:02', 0, '2018-05-04 17:40:59'),
(68, 27, 50, 'oo;opopop', 18, 9, '', '', 0, '2018-05-22 22:48:59', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(69, 28, 53, 'Revisar', 18, 9, '', '', 0, '2018-05-25 16:51:40', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones`
--

CREATE TABLE `secciones` (
  `id_seccion` int(11) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `autorizado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `secciones` (`id_seccion`, `descripcion`, `autorizado`) VALUES
(1, 'Administrativa', 1),
(2, 'Subdireccion', 1),
(3, 'Informatica', 1),
(4, 'Jefatura', 1),
(5, 'Archivo', 1),
(6, 'Dirección', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblfechapista`
--

CREATE TABLE `tblfechapista` (
  `idFecha` int(11) NOT NULL,
  `refPista` int(11) DEFAULT NULL,
  `fchFechaInicio` datetime DEFAULT NULL,
  `fchFechaFin` datetime DEFAULT NULL,
  `strMotivo` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblimagen`
--

CREATE TABLE `tblimagen` (
  `idFoto` int(11) NOT NULL,
  `strImagen` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `refHotel` int(11) DEFAULT NULL,
  `intPrincipal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblpista`
--

CREATE TABLE `tblpista` (
  `idPista` int(11) NOT NULL,
  `refUsuario` int(11) DEFAULT NULL,
  `strNombre` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `intEstado` int(11) DEFAULT NULL,
  `refProvincia` int(11) DEFAULT NULL,
  `strLocalidad` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `strDescripcion` text CHARACTER SET latin1,
  `strDireccion` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `fchAlta` datetime DEFAULT NULL,
  `dblPrecio` double DEFAULT NULL,
  `imagen` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblpista`
--

INSERT INTO `tblpista` (`idPista`, `refUsuario`, `strNombre`, `intEstado`, `refProvincia`, `strLocalidad`, `strDescripcion`, `strDireccion`, `fchAlta`, `dblPrecio`, `imagen`) VALUES
(1, 71, 'Vehículo', 1, 2, 'Horario L-V de 8:00am-5:00pm', 'Vehículo, placa 0000', 'San Pedro de Montes de Oca', '2015-05-13 17:41:18', 0, 'carro.jpg'),
(2, 72, 'Sala Reuniones', 0, 2, 'Horario L-V de 8:00am-5:00pm', 'Sala Reuniones', 'San Pedro Montes de Oca', '2017-04-18 00:00:00', 0, 'sala.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblprovincia`
--

CREATE TABLE `tblprovincia` (
  `idProvincia` int(11) NOT NULL,
  `strProvincia` varchar(100) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblreserva`
--

CREATE TABLE `tblreserva` (
  `idReserva` int(11) NOT NULL,
  `refUsuario` int(11) DEFAULT NULL,
  `refPropietario` int(11) DEFAULT NULL,
  `refPropiedad` int(11) DEFAULT NULL,
  `fchFechaDesde` date DEFAULT NULL,
  `fchFechaFin` date DEFAULT NULL,
  `intEstado` int(11) DEFAULT NULL,
  `dblTotal` double DEFAULT NULL,
  `fchreserva` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblreservapista`
--

CREATE TABLE `tblreservapista` (
  `idReserva` int(11) NOT NULL,
  `refUsuario` int(11) DEFAULT NULL,
  `refPropietario` int(11) DEFAULT NULL,
  `refPropiedad` int(11) DEFAULT NULL,
  `fchFechaDesde` datetime DEFAULT NULL,
  `fchFechaFin` datetime DEFAULT NULL,
  `intEstado` int(11) DEFAULT NULL,
  `dblTotal` double DEFAULT NULL,
  `fchreserva` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `direccion` varchar(1000) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblstatsacceso`
--

CREATE TABLE `tblstatsacceso` (
  `idContador` int(11) NOT NULL,
  `refUsuario` int(11) DEFAULT NULL,
  `fchAcceso` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblstatsacceso`
--

INSERT INTO `tblstatsacceso` (`idContador`, `refUsuario`, `fchAcceso`) VALUES
(1, 1, '2017-05-18 20:58:54'),
(2, 2, '2017-05-18 21:04:54'),
(3, 2, '2017-05-18 21:07:02'),
(4, 4, '2017-05-18 22:39:29'),
(5, 2, '2017-05-18 22:52:17'),
(6, 5, '2017-05-18 23:10:42'),
(7, 4, '2017-05-18 23:11:26'),
(8, 1, '2017-05-18 23:15:35'),
(9, 2, '2017-05-18 23:16:24'),
(10, 5, '2017-05-19 14:35:45'),
(11, 2, '2017-05-19 14:37:46'),
(12, 4, '2017-05-19 14:49:54'),
(13, 2, '2017-05-19 14:50:30'),
(14, 5, '2017-05-19 14:56:04'),
(15, 2, '2017-05-19 14:57:49'),
(16, 5, '2017-05-19 14:58:02'),
(17, 4, '2017-05-19 15:04:24'),
(18, 5, '2017-05-19 15:04:38'),
(19, 2, '2017-05-19 15:05:33'),
(20, 5, '2017-05-19 15:12:16'),
(21, 4, '2017-05-19 15:12:32'),
(22, 5, '2017-05-19 15:12:43'),
(23, 2, '2017-05-19 15:13:15'),
(24, 5, '2017-05-19 15:26:54'),
(25, 2, '2017-05-19 15:27:55'),
(26, 2, '2017-05-19 15:42:21'),
(27, 4, '2017-05-19 15:49:48'),
(28, 1, '2017-05-19 16:30:18'),
(29, 4, '2017-05-19 16:40:28'),
(30, 5, '2017-05-19 16:57:27'),
(31, 4, '2017-05-19 17:02:17'),
(32, 5, '2017-05-19 17:02:29'),
(33, 6, '2017-05-19 17:03:25'),
(34, 1, '2017-05-19 17:04:28'),
(35, 6, '2017-05-19 17:07:48'),
(36, 1, '2017-05-19 17:09:55'),
(37, 5, '2017-05-19 17:16:12'),
(38, 2, '2017-05-19 17:16:42'),
(39, 1, '2017-05-19 17:27:54'),
(40, 2, '2017-05-19 17:29:29'),
(41, 1, '2017-05-19 17:50:48'),
(42, 2, '2017-05-19 19:57:56'),
(43, 4, '2017-05-19 20:31:23'),
(44, 2, '2017-05-22 14:45:50'),
(45, 4, '2017-05-22 14:46:08'),
(46, 4, '2017-05-22 14:51:17'),
(47, 5, '2017-05-22 14:59:09'),
(48, 4, '2018-02-07 18:20:30'),
(49, 4, '2018-02-08 21:52:56'),
(50, 4, '2018-02-12 16:08:02'),
(51, 4, '2018-02-12 20:32:03'),
(52, 4, '2018-02-13 17:20:18'),
(53, 4, '2018-02-13 18:51:24'),
(54, 4, '2018-02-14 15:29:28'),
(55, 4, '2018-03-06 14:29:14'),
(56, 4, '2018-03-06 18:06:42'),
(57, 1, '2018-03-06 18:07:40'),
(58, 4, '2018-03-07 20:22:01'),
(59, 2, '2018-03-07 20:22:42'),
(60, 4, '2018-03-07 20:32:40'),
(61, 2, '2018-03-07 20:35:48'),
(62, 4, '2018-03-07 20:50:06'),
(63, 4, '2018-03-08 16:07:19'),
(64, 4, '2018-04-16 19:50:34'),
(65, 4, '2018-04-16 21:33:38'),
(66, 4, '2018-04-17 14:04:37'),
(67, 4, '2018-04-17 14:52:51'),
(68, 4, '2018-04-18 17:46:36'),
(69, 5, '2018-04-20 14:58:14'),
(70, 1, '2018-04-20 15:00:35'),
(71, 16, '2018-04-23 19:27:31'),
(72, 4, '2018-04-23 19:54:51'),
(73, 16, '2018-04-23 21:59:12'),
(74, 18, '2018-04-23 22:00:15'),
(75, 18, '2018-04-26 16:26:30'),
(76, 2, '2018-04-26 16:27:03'),
(77, 1, '2018-04-26 16:27:52'),
(78, 18, '2018-04-26 16:31:26'),
(79, 1, '2018-04-26 17:09:12'),
(80, 2, '2018-04-26 17:16:16'),
(81, 18, '2018-04-26 17:17:02'),
(82, 20, '2018-04-26 17:22:24'),
(83, 16, '2018-04-26 17:23:37'),
(84, 2, '2018-04-26 17:23:52'),
(85, 18, '2018-04-26 17:28:34'),
(86, 2, '2018-04-26 17:29:24'),
(87, 22, '2018-04-26 17:53:43'),
(88, 18, '2018-04-30 15:08:33'),
(89, 2, '2018-04-30 15:10:02'),
(90, 16, '2018-04-30 15:11:23'),
(91, 18, '2018-04-30 15:11:49'),
(92, 2, '2018-04-30 20:14:41'),
(93, 4, '2018-04-30 20:17:07'),
(94, 18, '2018-04-30 20:17:57'),
(95, 4, '2018-05-02 14:29:38'),
(96, 21, '2018-05-02 15:51:25'),
(97, 18, '2018-05-02 15:52:05'),
(98, 21, '2018-05-02 20:43:56'),
(99, 18, '2018-05-02 20:48:58'),
(100, 21, '2018-05-02 20:49:58'),
(101, 4, '2018-05-02 20:50:16'),
(102, 21, '2018-05-02 20:51:12'),
(103, 18, '2018-05-02 21:45:41'),
(104, 21, '2018-05-02 21:47:03'),
(105, 18, '2018-05-03 14:10:33'),
(106, 20, '2018-05-03 15:44:33'),
(107, 1, '2018-05-03 15:46:22'),
(108, 18, '2018-05-03 15:50:08'),
(109, 4, '2018-05-03 18:03:51'),
(110, 4, '2018-05-04 16:02:03'),
(111, 21, '2018-05-04 17:40:07'),
(112, 4, '2018-05-04 17:41:13'),
(113, 2, '2018-05-04 17:43:25'),
(114, 18, '2018-05-04 17:43:51'),
(115, 4, '2018-05-04 20:09:10'),
(116, 5, '2018-05-07 14:13:14'),
(117, 2, '2018-05-07 14:20:10'),
(118, 18, '2018-05-07 14:46:35'),
(119, 5, '2018-05-07 14:48:43'),
(120, 5, '2018-05-07 14:54:14'),
(121, 4, '2018-05-07 15:37:27'),
(122, 5, '2018-05-07 15:39:00'),
(123, 4, '2018-05-07 15:39:54'),
(124, 18, '2018-05-15 16:41:30'),
(125, 1, '2018-05-15 16:48:38'),
(126, 4, '2018-05-15 17:15:58'),
(127, 5, '2018-05-15 17:18:30'),
(128, 4, '2018-05-15 17:19:34'),
(129, 18, '2018-05-17 14:47:11'),
(130, 18, '2018-05-18 14:07:49'),
(131, 4, '2018-05-18 21:34:22'),
(132, 18, '2018-05-21 16:29:10'),
(133, 4, '2018-05-24 17:25:43'),
(134, 18, '2018-05-24 18:04:48'),
(135, 18, '2018-05-25 15:14:57'),
(136, 18, '2018-05-25 21:30:27'),
(137, 18, '2018-05-28 14:02:47'),
(138, 4, '2018-05-28 14:54:29'),
(139, 4, '2018-05-28 21:23:11'),
(140, 18, '2018-05-29 20:46:19'),
(141, 2, '2018-05-29 20:47:04'),
(142, 4, '2018-05-29 21:40:02'),
(143, 1, '2018-05-29 21:40:37'),
(144, 18, '2018-05-29 21:41:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblusuarioactivo`
--

CREATE TABLE `tblusuarioactivo` (
  `idContador` int(11) NOT NULL,
  `refUsuario` int(11) NOT NULL,
  `fchUltimo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblusuarioactivo`
--

INSERT INTO `tblusuarioactivo` (`idContador`, `refUsuario`, `fchUltimo`) VALUES
(73, 2, '2018-05-29 21:39:57'),
(74, 4, '2018-05-29 21:40:32'),
(75, 1, '2018-05-29 21:40:59'),
(76, 18, '2018-05-29 21:41:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `nombre`) VALUES
(71, 'Facultad de Derecho'),
(78, 'Facultad de Farmacia'),
(92, 'Facultad de Microbiología'),
(96, 'Facultad de Odontología'),
(117, 'Apoyo Académico Institucional'),
(119, 'Proyectos de la Vicerrectoría de Docencia'),
(151, 'Escuela de Administración Educativa'),
(153, 'Oficina de Administración Financiera'),
(156, 'Escuela de Administración de Negocios'),
(159, 'Escuela de Administración Pública'),
(160, 'Centro de Investigación y Capacitación en Administración Pública'),
(161, 'Oficina de Asuntos Internacionales y Cooperación Externa'),
(162, 'Decanato de Ciencias Agroalimentarias'),
(163, 'Escuela de Tecnología de Alimentos'),
(164, 'Escuela de Artes Dramáticas'),
(166, 'Escuela de Antropología'),
(167, 'Escuela de Artes Musicales'),
(168, 'Escuela de Arquitectura'),
(169, 'Escuela de Sociología'),
(170, 'Escuela de Artes Plásticas'),
(173, 'Oficina de Becas y Atención Socioeconómica'),
(176, 'Decanato de la Facultad de Bellas Artes'),
(179, 'Sistema de Bibliotecas, Documentación e Información'),
(180, 'Centro de Investigación en Estudios de la Mujer'),
(181, 'Centro de Investigación en Matemática y Meta-Matemática'),
(182, 'Centro de Investigación en Matemáticas Puras y Aplicadas'),
(183, 'Centro de Investigación en Economía Agrícola y Desarrollo Agroempresarial'),
(185, 'Escuela de Biología'),
(186, 'Unidad de Bioterios'),
(187, 'Unidad de Coordinación Editorial'),
(188, 'Centro de Evaluación Académica'),
(189, 'Centro de Investigación en Ciencias del Mar y Limnología'),
(190, 'Centro de Investigación en Electroquímica y Energía Química'),
(191, 'Centro de Informática'),
(192, 'Centro de Investigación en Hematología y Trastornos Afines'),
(193, 'Centro de Investigación en Productos Naturales'),
(194, 'Centro de Investigación en Granos y Semillas'),
(195, 'Centro de Investigaciones Geofísicas'),
(196, 'Centro de Investigación en Enfermedades Tropicales'),
(197, 'Centro de Investigaciones Históricas de América Central'),
(198, 'Centro de Investigación en Contaminación Ambiental'),
(199, 'Centro Nacional de Ciencia y Tecnología de Alimentos'),
(200, 'Centro de Investigación en Estructuras Microscópicas'),
(201, 'Centro de Investigación en Biología Celular y Molecular'),
(205, 'Centro de Investigaciones en Desarrollo Sostenible'),
(207, 'Centro de Investigaciones Espaciales'),
(208, 'Centro de Investigaciones en Ciencias Atómicas Nucleares y Moleculares'),
(215, 'Escuela de Ciencias de la Computación e Informática'),
(218, 'Escuela de Ciencias de la Comunicación Colectiva'),
(221, 'Facultad de Ciencias Económicas'),
(224, 'Escuela de Ciencias Políticas'),
(226, 'Unidad de Servicios a Estudiantes con Discapacidad'),
(227, 'Comedor Estudiantil'),
(230, 'Decanato de la Facultad de Ciencias Básicas'),
(233, 'Decanato de la Facultad de Ciencias Sociales'),
(236, 'Consejo Universitario'),
(238, 'Oficina de Planificación Universitaria'),
(239, 'Oficina de Contraloría Universitaria'),
(240, 'Danza Universitaria'),
(245, 'Sección de Correo'),
(251, 'Escuela de Economía'),
(254, 'Escuela de Economía Agrícola y Agronegocios'),
(257, 'Decanato de la Facultad de Educación'),
(260, 'Escuela de Educación Física y Deportes'),
(263, 'Oficina Ejecutora del Programa de Inversiones'),
(269, 'Escuela de Enfermería'),
(272, 'Escuela de Estadística'),
(275, 'Estación Experimental Agrícola Fabio Baudrit Moreno'),
(276, 'Programa Avícola'),
(277, 'Observatorio del Desarrollo'),
(278, 'Estación Experimental de Ganado Lechero Alfredo Volio Mata'),
(281, 'Escuela de Estudios Generales'),
(287, 'Escuela de Filología, Lingüística y Literatura'),
(288, 'Instituto de Investigaciones Lingüísticas'),
(290, 'Escuela de Filosofía'),
(293, 'Escuela de Física'),
(296, 'Escuela de Agronomía'),
(299, 'Escuela de Formación Docente'),
(302, 'Escuela Centroamericana de Geología'),
(305, 'Decanato de la Facultad de Ingeniería'),
(306, 'Escuela de Ingeniería Agrícola'),
(308, 'Escuela de Ingeniería Civil'),
(311, 'Escuela de Ingeniería Eléctrica'),
(314, 'Escuela de Ingeniería Industrial'),
(317, 'Escuela de Ingeniería Mecánica'),
(320, 'Escuela de Ingeniería Química'),
(321, 'Laboratorio Nacional de Materiales y Modelos Estructurales'),
(322, 'Centro de Investigación en Protección de Cultivos'),
(323, 'Instituto Clodomiro Picado'),
(324, 'Centro de Investigación en Ciencias e Ingeniería de Materiales'),
(325, 'Centro de Investigación en Identidad y Cultura Latinoamericanas'),
(326, 'Centro de Investigaciones Agronómicas'),
(327, 'Instituto de Investigaciones Agrícolas'),
(328, 'Centro de Investigación en Ciencias Geológicas'),
(329, 'Instituto de Investigaciones en Ciencias Económicas'),
(330, 'Instituto de Investigaciones Filosóficas'),
(332, 'Instituto de Investigaciones en Ingeniería'),
(334, 'Laboratorio de Ensayos Biológicos'),
(335, 'Instituto de Investigaciones Psicológicas'),
(337, 'Centro Centroamericano de Población'),
(338, 'Instituto de Investigaciones en Salud'),
(339, 'Instituto de Investigación en Educación'),
(340, 'Unidad de Gestión y Transferencia del Conocimiento para la Innovación'),
(341, 'Instituto de Investigaciones Sociales'),
(342, 'Instituto de Investigaciones Farmacéuticas'),
(343, 'Escuela de Geografía'),
(344, 'Escuela de Historia'),
(345, 'Jardín Botánico Lankester'),
(346, 'Consejo Centroamericano de Acreditación de la Educación Superior'),
(347, 'Oficina Jurídica'),
(348, 'Centro de Investigaciones y Estudios Políticos Dr. José María Castro Madriz'),
(349, 'Unidad Especial de Investigación Áreas Protegidas de la UCR'),
(350, 'Escuela de Lenguas Modernas'),
(351, 'Sección de Maquinaria y Equipo'),
(352, 'Servicios de Apoyo, Vicerrectoría de Acción Social'),
(353, 'Decanato de la Facultad de Letras'),
(355, 'Servicios de Apoyo, Vicerrectoría de Docencia'),
(356, 'Sección de Mantenimiento y Construcción'),
(357, 'Servicios de Apoyo, Vicerrectoría de Investigación'),
(358, 'Recursos Humanos Especializado'),
(359, 'Escuela de Matemática'),
(361, 'Formación de Recursos Docentes'),
(362, 'Decanato de la Facultad de Medicina'),
(363, 'Escuela de Nutrición'),
(364, 'Escuela de Medicina'),
(365, 'Escuela de Salud Pública'),
(382, 'Centro de Investigaciones sobre Diversidad Cultural y Estudios Regionales (CIDICER)'),
(383, 'Centro de Investigación en Neurociencias (CIN)'),
(385, 'Instituto de Investigación en Arte'),
(386, 'Centro de Investigaciones en Ciencias del Movimiento Humano (CIMOHU)'),
(430, 'Escuela de Tecnologías en Salud'),
(450, 'Escuela de Orientación y Educación Especial'),
(453, 'Oficina de Recursos Humanos'),
(456, 'Programa de Ganado Porcino'),
(459, 'Escuela de Psicología'),
(465, 'Escuela de Química'),
(468, 'Radioemisoras de la Universidad de Costa Rica'),
(471, 'Rectoría'),
(473, 'Feria Científica (Apoyo Académico Institucional)'),
(474, 'Oficina de Registro e Información'),
(477, 'Oficina de Bienestar y Salud'),
(478, 'Unidad de Coordinación, Oficina de Servicios Generales'),
(479, 'Servicios de Apoyo, Vicerrectoría de Administración'),
(480, 'Oficina de Orientación'),
(483, 'Sección de Programas Deportivos'),
(484, 'Proceso de Admisión'),
(486, 'Sección de Seguridad y Tránsito'),
(487, 'Sección Servicios Contratados, Oficina de Servicios Generales'),
(489, 'Semanario Universidad'),
(490, 'Proyectos de la Vicerrectoría de Vida Estudiantil'),
(495, 'Sistema de Estudios de Posgrado'),
(496, 'Sistema Editorial de Difusión Científica de la Investigación'),
(498, 'Oficina de Suministros'),
(501, 'Teatro Universitario'),
(503, 'Archivo Universitario'),
(504, 'Escuela de Ingeniería Topográfica'),
(506, 'Atención y Previsión de Desastres'),
(507, 'Escuela de Trabajo Social'),
(508, 'Recinto de Golfito'),
(510, 'Sección de Transportes'),
(513, 'Tribunal Electoral Universitario'),
(516, 'Vicerrectoría de Acción Social'),
(519, 'Vicerrectoría de Administración'),
(522, 'Vicerrectoría de Docencia'),
(525, 'Vicerrectoría de Investigación'),
(528, 'Vicerrectoría de Vida Estudiantil'),
(529, 'Servicios de Apoyo, Vicerrectoría de Vida Estudiantil'),
(531, 'Escuela de Zootecnia'),
(534, 'Centro Infantil Laboratorio'),
(535, 'Instituto de Investigaciones Jurídicas'),
(536, 'Sistema Universitario de Televisión Canal UCR'),
(537, 'Trabajo Comunal Universitario'),
(539, 'Unidad de Extensión Docente, Vicerrectoría de Acción Social'),
(540, 'Unidad de Extensión Cultural, Vicerrectoría de Acción Social'),
(541, 'Oficina de Divulgación e Información'),
(542, 'Escuela de Bibliotecología y Ciencias de la Información'),
(543, 'Centro de Investigación en Tecnología del Cuero'),
(544, 'Centro de Investigación en Nutrición Animal'),
(545, 'Finca Experimental Río Frío'),
(548, 'Sede Regional de Occidente, Coordinación de Acción Social'),
(551, 'Sede Regional de Occidente, Coordinación de Vida Estudiantil'),
(554, 'Sede Regional de Occidente, Coordinación de Administración'),
(557, 'Sede Regional de Occidente, Dirección'),
(560, 'Sede Regional de Occidente, Coordinación de Docencia'),
(563, 'Sede Regional de Occidente, Coordinación de Investigación'),
(566, 'Sede Regional de Guanacaste, Coordinación de Acción Social'),
(569, 'Sede Regional de Guanacaste, Coordinación de Vida Estudiantil'),
(572, 'Sede Regional de Guanacaste, Coordinación de Administración'),
(575, 'Sede Regional de Guanacaste, Dirección'),
(576, 'Recinto de Santa Cruz, Coordinación Docente'),
(577, 'Recinto de Santa Cruz, Coordinación Administrativa'),
(578, 'Sede Regional de Guanacaste, Sede Regional de Docencia'),
(581, 'Sede Regional de Guanacaste, Coordinación de Investigación'),
(584, 'Sede Regional del Atlántico, Coordinación de Acción Social'),
(587, 'Sede Regional del Atlántico, Coordinación de Vida Estudiantil'),
(590, 'Sede Regional del Atlántico, Coordinación de Administración'),
(592, 'Finca Experimental Interdisciplinaria de Modelos Agroecológicos'),
(593, 'Sede Regional del Atlántico, Dirección'),
(594, 'Finca Experimental de Pejibaye'),
(596, 'Sede Regional del Atlántico, Coordinación de Docencia'),
(599, 'Sede Regional del Atlántico, Coordinación de Investigación'),
(602, 'Sede Regional del Caribe, Coordinación de Acción Social'),
(605, 'Sede Regional del Caribe, Coordinación de Vida Estudiantil'),
(608, 'Sede Regional del Caribe, Coordinación de Administración'),
(611, 'Sede Regional del Caribe, Coordinación de Docencia'),
(614, 'Sede Regional del Caribe, Coordinación de Investigación'),
(620, 'Sede Regional del Pacífico, Coordinación de Docencia'),
(621, 'Sede Regional del Pacífico, Coordinación de Investigación'),
(622, 'Sede Regional del Pacífico, Coordinación de Acción Social'),
(623, 'Sede Regional del Pacífico, Coordinación de Vida Estudiantil'),
(624, 'Sede Regional del Pacífico, Coordinación de Administración'),
(625, 'Sede Regional del Pacífico, Coordinación de Administración Superior'),
(659, 'Recinto de Paraíso, Coordinación de Investigación'),
(660, 'Recinto de Paraíso, Coordinación de Acción Social'),
(661, 'Recinto de Paraíso, Coordinación de Vida Estudiantil'),
(662, 'Recinto de Paraíso, Coordinación de Administración'),
(663, 'Recinto de Grecia, Coordinación de Administración'),
(710, 'Sede Interuniversitaria de Alajuela'),
(715, 'Programa Sociedad de la Información y el Conocimiento'),
(730, 'Recinto de Guápiles, Coordinación de Administración'),
(740, 'Comisiones Institucionales'),
(745, 'Red + Museos'),
(746, 'Plan de Mejoramiento Institucional'),
(800, 'Colecciones y Museos'),
(802, 'Programas Especiales, Vicerrectoría de Investigación'),
(804, 'Fondos Concursables (Apoyo Vicerrectoría de Investigación)'),
(806, 'Fondos Intersedes'),
(808, 'Proyectos de la Vicerrectoría de Investigación'),
(810, 'Fondos Concursables (Apoyo Vicerrectoría de Acción Social)'),
(812, 'Sistema de Información Geográfica (Apoyo Académico)'),
(814, 'Aporte a otros Proyectos'),
(815, 'Feria Vocacional'),
(830, 'Comisión Instructora Institucional'),
(831, 'Comisión Institucional contra el Hostigamiento Sexual'),
(832, 'Programa de difusión de la Cultura China'),
(833, 'Programa de gestión ambiental integral'),
(835, 'Centro de Investigaciones en Tecnologías de Información y Comunicaciones (CITIC)'),
(836, 'Programa de Voluntariado'),
(837, 'Centro de Investigación en Comunicación'),
(838, 'Consejo Asesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) NOT NULL,
  `nivel` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `estado_usuario` int(11) NOT NULL DEFAULT '1',
  `avatar` varchar(150) CHARACTER SET latin1 NOT NULL,
  `srtCookie` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `nombre`, `apellido1`, `apellido2`, `nivel`, `usuario`, `pass`, `email`, `id_seccion`, `estado_usuario`, `avatar`, `srtCookie`) VALUES
(1, 'Yorleny', 'Villalobos', 'Guzman', 1, 'Yorleny', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 1, 1, 'mujer.jpg', ''),
(2, 'Wendy', 'Sandi', 'Espinoza', 4, 'Wendy', 'c4ca4238a0b923820dcc509a6f75849b', 'jefatura@ucr.ac.cr', 4, 1, 'mujer.jpg', ''),
(4, 'Arlyne', 'Solano', 'González', 3, 'Arlyne', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 3, 1, 'mujer.jpg', ''),
(5, 'Laura', 'Barboza', 'Mejia', 5, 'Laura', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 5, 1, 'mujer.jpg', ''),
(6, 'José ', 'Morales', 'Caracas', 1, 'José', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 1, 1, 'hombre.jpg', ''),
(16, 'Carlos Alberto', 'Fonseca ', 'Zamora', 6, 'direccion', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 6, 1, 'mujer.jpg', ''),
(17, 'Subdireccion', 'Apellido1', 'Apellido2', 2, 'subdireccion', 'c4ca4238a0b923820dcc509a6f75849b', 'subdireccion@ucr.ac.cr', 2, 1, 'mujer.jpg', ''),
(18, 'Stuart', 'Perez', 'Perez', 3, 'stuart', '79e38fe7fb3fe5499b3e75f3576ca57d', 'jorgestwart.perez@ucr.ac.cr', 3, 1, 'hombre.jpg', ''),
(19, 'Stuart', 'otro', 'otro', 5, 'stuartArchivo', 'c4ca4238a0b923820dcc509a6f75849b', 'jstuartp@gmail.com', 5, 1, 'hombre.jpg', ''),
(20, 'Carlos ', 'Vargas', 'Durán', 3, 'Carlos', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 3, 1, 'hombre.jpg', ''),
(21, 'Victor', 'Miranda', 'Lara', 3, 'Victor', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 3, 1, 'hombre.jpg', ''),
(22, 'Yamileth', 'Calvo', 'Brizuela', 1, 'Yamileth', 'c4ca4238a0b923820dcc509a6f75849b', 'jorgestwart.perez@ucr.ac.cr', 1, 1, 'mujer.jpg', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_autorizados`
--

CREATE TABLE `usuarios_autorizados` (
  `id_autorizado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado_autorizado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios_autorizados`
--

INSERT INTO `usuarios_autorizados` (`id_autorizado`, `id_usuario`, `estado_autorizado`) VALUES
(38, 2, 1),
(40, 1, 1),
(41, 5, 1),
(42, 4, 1),
(43, 18, 1),
(44, 20, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id_avatar`);

--
-- Indices de la tabla `detalle_oficios_salida`
--
ALTER TABLE `detalle_oficios_salida`
  ADD PRIMARY KEY (`id_detalle_oficios_Salida`);

--
-- Indices de la tabla `estado_oficio`
--
ALTER TABLE `estado_oficio`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `info_oficios`
--
ALTER TABLE `info_oficios`
  ADD PRIMARY KEY (`oficio_id`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `info_oficios_log`
--
ALTER TABLE `info_oficios_log`
  ADD PRIMARY KEY (`oficio_idlog`),
  ADD KEY `ix_oficio_id1` (`oficio_id1`),
  ADD KEY `ix_oficio_id2` (`oficio_id2`);
ALTER TABLE `info_oficios_log` ADD FULLTEXT KEY `BUSQUEDA` (`destinatario`);

--
-- Indices de la tabla `jefaturas`
--
ALTER TABLE `jefaturas`
  ADD PRIMARY KEY (`id_jefatura`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `oficios_bloqueados`
--
ALTER TABLE `oficios_bloqueados`
  ADD PRIMARY KEY (`oficiobloc_id`);

--
-- Indices de la tabla `oficios_usuario`
--
ALTER TABLE `oficios_usuario`
  ADD PRIMARY KEY (`id_oficiousua`);

--
-- Indices de la tabla `oficios_usuariolog`
--
ALTER TABLE `oficios_usuariolog`
  ADD PRIMARY KEY (`id_oficiousuariolog`);

--
-- Indices de la tabla `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id_seccion`);

--
-- Indices de la tabla `tblfechapista`
--
ALTER TABLE `tblfechapista`
  ADD PRIMARY KEY (`idFecha`);

--
-- Indices de la tabla `tblimagen`
--
ALTER TABLE `tblimagen`
  ADD PRIMARY KEY (`idFoto`);

--
-- Indices de la tabla `tblpista`
--
ALTER TABLE `tblpista`
  ADD PRIMARY KEY (`idPista`);

--
-- Indices de la tabla `tblprovincia`
--
ALTER TABLE `tblprovincia`
  ADD PRIMARY KEY (`idProvincia`);

--
-- Indices de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  ADD PRIMARY KEY (`idReserva`);

--
-- Indices de la tabla `tblreservapista`
--
ALTER TABLE `tblreservapista`
  ADD PRIMARY KEY (`idReserva`);

--
-- Indices de la tabla `tblstatsacceso`
--
ALTER TABLE `tblstatsacceso`
  ADD PRIMARY KEY (`idContador`);

--
-- Indices de la tabla `tblusuarioactivo`
--
ALTER TABLE `tblusuarioactivo`
  ADD PRIMARY KEY (`idContador`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `usuarios_autorizados`
--
ALTER TABLE `usuarios_autorizados`
  ADD PRIMARY KEY (`id_autorizado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id_avatar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_oficios_salida`
--
ALTER TABLE `detalle_oficios_salida`
  MODIFY `id_detalle_oficios_Salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `estado_oficio`
--
ALTER TABLE `estado_oficio`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `info_oficios`
--
ALTER TABLE `info_oficios`
  MODIFY `oficio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `info_oficios_log`
--
ALTER TABLE `info_oficios_log`
  MODIFY `oficio_idlog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `jefaturas`
--
ALTER TABLE `jefaturas`
  MODIFY `id_jefatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `oficios_bloqueados`
--
ALTER TABLE `oficios_bloqueados`
  MODIFY `oficiobloc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `oficios_usuario`
--
ALTER TABLE `oficios_usuario`
  MODIFY `id_oficiousua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `oficios_usuariolog`
--
ALTER TABLE `oficios_usuariolog`
  MODIFY `id_oficiousuariolog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `secciones`
--
ALTER TABLE `secciones`
  MODIFY `id_seccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tblfechapista`
--
ALTER TABLE `tblfechapista`
  MODIFY `idFecha` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblimagen`
--
ALTER TABLE `tblimagen`
  MODIFY `idFoto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblpista`
--
ALTER TABLE `tblpista`
  MODIFY `idPista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tblprovincia`
--
ALTER TABLE `tblprovincia`
  MODIFY `idProvincia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblreserva`
--
ALTER TABLE `tblreserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblreservapista`
--
ALTER TABLE `tblreservapista`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblstatsacceso`
--
ALTER TABLE `tblstatsacceso`
  MODIFY `idContador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT de la tabla `tblusuarioactivo`
--
ALTER TABLE `tblusuarioactivo`
  MODIFY `idContador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuarios_autorizados`
--
ALTER TABLE `usuarios_autorizados`
  MODIFY `id_autorizado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
