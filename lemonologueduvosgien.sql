-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 25 jan. 2021 à 13:40
-- Version du serveur :  8.0.18
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lemonologueduvosgien`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_author` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment_content` text NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_post_id` int(11) UNSIGNED NOT NULL,
  `comment_flag` tinyint(1) NOT NULL,
  `comment_new` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_id_comments_fk` (`comment_post_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `comment_author`, `comment_content`, `comment_date`, `comment_post_id`, `comment_flag`, `comment_new`) VALUES
(203, 'bruno', 'Hello ! \r\nVoici mon premier commentaire :\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2021-01-06 12:33:58', 87, 0, 0),
(204, 'bruno', 'Why do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2021-01-06 12:35:07', 87, 0, 0),
(205, 'bruno', 'Where does it come from?\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '2021-01-06 12:35:22', 87, 1, 0),
(206, 'bruno', 'Where can I get some?\r\nThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2021-01-06 12:35:34', 87, 0, 0),
(207, 'bruno', 'HTML est une des trois inventions à la base du World Wide Web, avec le Hypertext Transfer Protocol (HTTP) et les adresses web (URL). HTML a été inventé pour permettre d\'écrire des documents hypertextuels liant les différentes ressources d’Internet avec des hyperliens. Aujourd’hui, ces documents sont appelés « page web ». En août 1991, lorsque Tim Berners-Lee annonce publiquement le web sur Usenet, il ne cite que le langage SGML, mais donne l’URL d’un document de suffixe .html.\r\n\r\nDans son livre Weaving the web3, Tim Berners-Lee décrit la décision de baser HTML sur SGML comme étant aussi « diplomatique » que technique : techniquement, il trouvait SGML trop complexe, mais il voulait attirer la communauté hypertexte qui considérait que SGML était le langage le plus prometteur pour standardiser le format des documents hypertexte. En outre, SGML était déjà utilisé par son employeur, l’Organisation européenne pour la recherche nucléaire (CERN). ;', '2021-01-06 15:09:37', 87, 0, 1),
(208, 'bruno', 'fghfghfghfgh', '2021-01-06 15:11:44', 87, 1, 0),
(213, 'admin', 'xcvxcvxcvxcv', '2021-01-08 17:06:02', 61, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `post_title`, `post_content`, `post_date`, `user_id`) VALUES
(60, 'Using the aria-controls attribute', 'There are a handful of ARIA1.0 attributes that can be used to indicate relationships between elements, when those relationships can’t be ascertained easily from the DOM. One such attribute is aria-controls.\r\n\r\nThe aria-controls attribute creates a cause and effect relationship. It identifies the element(s) that are controlled by the current element, when that relationship isn’t represented in the DOM. For example a button that controls the display of information contained within a div:\r\nThe more widely the two elements are separated in the DOM, the more useful the aria-controls attribute becomes. Imagine a checkbox that controls the filtration of search results, or a tab that controls a tabpanel:\r\nWhen a User Agent (UA) supports aria-controls, it makes it possible for focus to be moved from the current element directly to the element it controls. The alternative is to navigate through all the intervening content in hopes of discovering what might have changed elsewhere on the page. For this reason, aria-controls should only be used to point to something that is available in the DOM and which can be navigated to.', '2021-01-06 11:15:53', 9),
(61, 'Bootstrap Alerts', 'Alerts are available for any length of text, as well as an optional dismiss button. For proper styling, use one of the eight required contextual classes (e.g., .alert-success). For inline dismissal, use the alerts jQuery plugin.\r\n\r\nConveying meaning to assistive technologies\r\n\r\nUsing color to add meaning only provides a visual indication, which will not be conveyed to users of assistive technologies – such as screen readers. Ensure that information denoted by the color is either obvious from the content itself (e.g. the visible text), or is included through alternative means, such as additional text hidden with the .sr-only class.\r\n\r\nDismissing\r\nUsing the alert JavaScript plugin, it’s possible to dismiss any alert inline. Here’s how:\r\n\r\nBe sure you’ve loaded the alert plugin, or the compiled Bootstrap JavaScript.\r\nIf you’re building our JavaScript from source, it requires util.js. The compiled version includes this.\r\nAdd a dismiss button and the .alert-dismissible class, which adds extra padding to the right of the alert and positions the .close button.\r\nOn the dismiss button, add the data-dismiss=\"alert\" attribute, which triggers the JavaScript functionality. Be sure to use the <button> element with it for proper behavior across all devices.\r\nTo animate alerts when dismissing them, be sure to add the .fade and .show classes.', '2021-01-06 12:17:52', 9),
(87, 'Twig Templating Language', 'The Twig templating language allows you to write concise, readable templates that are more friendly to web designers and, in several ways, more powerful than PHP templates. Take a look at the following Twig template example. Even if it’s the first time you see Twig, you probably understand most of it:\r\n\r\nTwig syntax is based on these three constructs:\r\n\r\n- {{ ... }}, used to display the content of a variable or the result of evaluating an expression;\r\n- {% ... %}, used to run some logic, such as a conditional or a loop;\r\n- {# ... #}, used to add comments to the template (unlike HTML comments, these comments are not included in the rendered page).\r\nYou can’t run PHP code inside Twig templates, but Twig provides utilities to run some logic in the templates. For example, filters modify content before being rendered, like the upper filter to uppercase contents:\r\n\r\nTwig comes with a long list of tags, filters and functions that are available by default. In Symfony applications you can also use these Twig filters and functions defined by Symfony and you can create your own Twig filters and functions.\r\n\r\nTwig is fast in the prod environment (because templates are compiled into PHP and cached automatically), but convenient to use in the dev environment (because templates are recompiled automatically when you change them).\r\n\r\nTwig Configuration\r\nTwig has several configuration options to define things like the format used to display numbers and dates, the template caching, etc. Read the Twig configuration reference to learn about them.\r\n\r\nCreating Templates\r\nBefore explaining in detail how to create and render templates, look at the following example for a quick overview of the whole process. First, you need to create a new file in the templates/ directory to store the template contents.', '2021-01-06 12:22:23', 9);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'new');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_pseudo` varchar(100) NOT NULL,
  `user_email` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_created_at` datetime NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_user_pseudo` (`user_pseudo`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `user_pseudo`, `user_email`, `user_password`, `user_created_at`, `role_id`) VALUES
(9, 'admin', 'bruno.grosdidier@gmail.com', '$2y$10$Jsb3Q.ifwwABY3h8puHgLeVJ7KoQfcwpdID66WVPLsPBWTv4Gdq3i', '2020-12-15 16:50:10', 1),
(40, 'tzarinsitu', 'tzarinsitu@gmail.com', '$2y$10$HM8P0C8nJcp8WAkGMKQcLuAoS49IVqrKhOxepCAOQ0sOZnnwbOnnm', '2021-01-07 20:07:43', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `posts_id_comments_fk` FOREIGN KEY (`comment_post_id`) REFERENCES `post` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
