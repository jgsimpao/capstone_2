-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2017 at 12:38 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jtorrents`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `torrent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment_reports`
--

CREATE TABLE `comment_reports` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `inquiry_category_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_categories`
--

CREATE TABLE `inquiry_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inquiry_categories`
--

INSERT INTO `inquiry_categories` (`id`, `name`) VALUES
(7, 'Copyright'),
(6, 'Donation'),
(3, 'Downloading'),
(8, 'Other'),
(5, 'Ratio'),
(1, 'Rules'),
(4, 'Seeding'),
(2, 'Uploading');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `message`, `date_created`, `user_id`, `message_id`) VALUES
(1, 'ADMIN', 'ADMIN', '2017-08-06 22:13:20', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `torrents`
--

CREATE TABLE `torrents` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_count` int(11) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `source` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `torrent_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `torrents`
--

INSERT INTO `torrents` (`id`, `name`, `description`, `file_count`, `file_size`, `source`, `cover`, `date_created`, `user_id`, `torrent_category_id`) VALUES
(1, 'Naruto Shippuden Season 1 - 12 English Dubbed', 'Naruto: Shippuden is an anime series adapted from Part II of Masashi Kishimoto&amp;#039;s manga series, with exactly 500 episodes. It is set two and a half years after Part I in the Naruto universe, following the ninja teenager Naruto Uzumaki and his allies. The series is directed by Hayato Date, and produced by Studio Pierrot and TV Tokyo. It began broadcasting on February 15, 2007 on TV Tokyo, and concluded on March 23, 2017.[1][2]', 252, 35803475756, 'torrents/torrent/Naruto Shippuden.torrent', 'torrents/cover/Naruto_-_Shippuden_DVD_season_1_volume_1.jpg', '2017-08-06 22:18:40', 1, 1),
(2, 'Frozen (2013) English Movie TSRip X264 850MB - Mughal125', 'Frozen is a 2013 American 3D computer-animated musical fantasy film produced by Walt Disney Animation Studios and released by Walt Disney Pictures.[4] It is the 53rd Disney animated feature film. Inspired by Hans Christian Andersen&amp;#039;s fairy tale &amp;quot;The Snow Queen&amp;quot;,[5] the film tells the story of a fearless princess who sets off on a journey alongside a rugged iceman, his loyal pet reindeer, and a naÃƒÂ¯ve snowman to find her estranged sister, whose icy powers have inadvertently trapped the kingdom in eternal winter.', 12, 895288112, 'torrents/torrent/Frozen (2013) English Movie TSRip X264 850MB.torrent', 'torrents/cover/Frozen_(2013_film)_poster.jpg', '2017-08-06 22:20:20', 1, 5),
(3, 'The Sims 4-RELOADED', 'The Sims 4 is the fourth major title in life simulation video game series The Sims, developed by Maxis and The Sims Studio and published by Electronic Arts. The Sims 4 was originally announced on May 6, 2013, and was released in North America on September 2, 2014 for Microsoft Windows.[1] A Mac compatible version of the software was made available for digital download on February 17, 2015.[2] The Sims 4 is the first PC game to top all-format charts in two years.[3] The game has received mixed reviews since its release.[4] Since its launch, it became the best selling PC game of 2014 and 2015. The Sims 4 has sold over 5 million copies worldwide.[5]', 2, 9446892831, 'torrents/torrent/The.Sims.4-RELOADED.torrent', 'torrents/cover/The_Sims_4_Box_Art.png', '2017-08-06 22:21:27', 1, 4),
(4, 'Game of Thrones - Season 6 - 720p HDTV - x265 HEVC - ShAaNiG', 'Game of Thrones is an American fantasy drama television series created by David Benioff and D. B. Weiss. It is an adaptation of A Song of Ice and Fire, George R. R. Martin&amp;#039;s series of fantasy novels, the first of which is A Game of Thrones. It is filmed at Titanic Studios in Belfast, on location in the United Kingdom, and in Canada, Croatia, Iceland, Malta, Morocco, Spain, and the United States. The series premiered on HBO in the United States on April 17, 2011, and its sixth season ended on June 26, 2016. The series was renewed for a seventh season,[1] which is scheduled to premiere on July 16, 2017,[2] and will conclude with its eighth season in 2018 or 2019.[3]', 10, 3548522321, 'torrents/torrent/Game.of.Thrones.Season.6.720p.HDTV.x265.ShAaNiG.torrent', 'torrents/cover/Game-of-Thrones.jpg', '2017-08-06 22:22:32', 1, 7),
(5, '2NE1 - 24 Track Collection by blackhyena929', '2NE1 (Korean: Ã­Ë†Â¬Ã¬â€¢Â Ã«â€¹Ë†Ã¬â€ºÂ, IPA: [tÃŠÂ°u.Ã‰â€º.ni.wÃŠÅ’n]) was a South Korean girl group formed by YG Entertainment in 2009. First appearing in &amp;quot;Lollipop&amp;quot;, a commercial campaign with Big Bang for LG Electronics. 2NE1&amp;#039;s debut single &amp;quot;Fire&amp;quot; was released on May 6, 2009. Since then, the group has released two eponymous extended plays, 2NE1 (2009) and 2NE1 (2011), and two studio albums, To Anyone (2010) and Crush (2014). Their first EP spawned the number-one single &amp;quot;I Don&amp;#039;t Care&amp;quot;, which won them the &amp;quot;Song of the Year&amp;quot; award at the 2009 Mnet Asian Music Awards. Their follow-up singles, such as &amp;quot;Go Away&amp;quot;, &amp;quot;Lonely&amp;quot; and &amp;quot;I Am the Best&amp;quot;, were similarly successful, with &amp;quot;I Am the Best&amp;quot; winning 2NE1 their second &amp;quot;Song of the Year&amp;quot; award in 2011.', 33, 134205213, 'torrents/torrent/2NE1.torrent', 'torrents/cover/2NE1.jpg', '2017-08-06 22:23:29', 1, 6),
(6, 'PHP, MYSQL, JAVASCRIPT &amp;amp; HTML5 ALL-IN-ONE FOR DUMMIES[A4]', 'PHP, javascript, and HTML5 are essential programming languages for creating dynamic websites that work with the MySQL database. PHP and MySQL provide a robust, easy-to-learn, open-source solution for creating superb e-commerce sites and content management. javascript and HTML5 add support for the most current multimedia effects. This one-stop guide gives you what you need to know about all four! Seven self-contained minibooks cover web technologies, HTML5 and CSS3, PHP programming, MySQL databases, javascript, PHP with templates, and web applications.', 2, 19362623, 'torrents/torrent/PHP.MySQL.JavaScript.and.HTML5.All-in-One.For.Dummies[A4].torrent', 'torrents/cover/PHP, MySQL, JavaScript & HTML5 All-In-One For Dummies.jpg', '2017-08-06 22:24:43', 1, 3),
(7, 'Microsoft Windows 10 Home and Pro x64 Clean ISO', 'Windows 10 is a personal computer operating system developed and released by Microsoft as part of the Windows NT family of operating systems. It was officially unveiled in September 2014 following a brief demo at Build 2014. The first version of the operating system entered a public beta testing process in October, leading up to its consumer release on July 29, 2015.[7] Unlike previous versions of Windows, Microsoft has branded Windows 10 as a &amp;quot;service&amp;quot; that receives ongoing &amp;quot;feature updates&amp;quot;; devices in enterprise environments can receive these updates at a slower pace, or use long-term support milestones that only receive critical updates, such as security patches, over their five-year lifespan of mainstream support.[8]', 3, 4083856029, 'torrents/torrent/Microsoft Windows 10 Home and Pro x64 Clean ISO.torrent', 'torrents/cover/Windows 10 Pro RS1.png', '2017-08-06 22:31:49', 1, 2),
(8, 'Icon Collection Pack 2015 (by InterlinkKnight) 14681 icons', 'All kinds of icon (*.ICO) images, like computers, laptops, phones, printers, brands, recycle bins, cars, sports, flashdrives, etc.\r\n\r\nMost of these icons where extracted from other collections packs (from torrent, websites, etc). The difference is that I rename most of the icons to something with more sense, and I delete the repeated icons. Some other icons are made by myself or have been collected from softwares, OS, websites, games, etc. by myself.', 1, 1048100450, 'torrents/torrent/Icon Collection Pack 2015 (by InterlinkKnight) 14681 icons.zip.torrent', 'torrents/cover/flat-social-media-icons-enfuzed.png', '2017-08-06 22:36:21', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `torrent_categories`
--

CREATE TABLE `torrent_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `torrent_categories`
--

INSERT INTO `torrent_categories` (`id`, `name`) VALUES
(1, 'Anime'),
(2, 'Apps'),
(3, 'Books'),
(4, 'Games'),
(5, 'Movies'),
(6, 'Music'),
(8, 'Other'),
(7, 'TV');

-- --------------------------------------------------------

--
-- Table structure for table `torrent_reports`
--

CREATE TABLE `torrent_reports` (
  `id` int(11) NOT NULL,
  `torrent_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `date_created`, `role_id`) VALUES
(1, 'Admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin@jtorrents.com', '2017-08-06 22:13:19', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `torrent_id` (`torrent_id`);

--
-- Indexes for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `inquiry_category_id` (`inquiry_category_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `inquiry_categories`
--
ALTER TABLE `inquiry_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `torrents`
--
ALTER TABLE `torrents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `source` (`source`),
  ADD UNIQUE KEY `cover` (`cover`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `torrent_category_id` (`torrent_category_id`);

--
-- Indexes for table `torrent_categories`
--
ALTER TABLE `torrent_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `torrent_reports`
--
ALTER TABLE `torrent_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `torrent_id` (`torrent_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comment_reports`
--
ALTER TABLE `comment_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inquiry_categories`
--
ALTER TABLE `inquiry_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `torrents`
--
ALTER TABLE `torrents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `torrent_categories`
--
ALTER TABLE `torrent_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `torrent_reports`
--
ALTER TABLE `torrent_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD CONSTRAINT `comment_reports_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_reports_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`inquiry_category_id`) REFERENCES `inquiry_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `inquiries_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `torrents`
--
ALTER TABLE `torrents`
  ADD CONSTRAINT `torrents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `torrents_ibfk_2` FOREIGN KEY (`torrent_category_id`) REFERENCES `torrent_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `torrent_reports`
--
ALTER TABLE `torrent_reports`
  ADD CONSTRAINT `torrent_reports_ibfk_1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `torrent_reports_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
