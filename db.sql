-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2015. Aug 20. 23:48
-- Szerver verzió: 5.6.21
-- PHP verzió: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `nemlotto`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `addressphase`
--

CREATE TABLE IF NOT EXISTS `addressphase` (
  `nxt1_p` varchar(225) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt2_p` varchar(225) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt3_p` varchar(225) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt4_p` varchar(225) COLLATE utf8_hungarian_ci NOT NULL,
  `btc1_p` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `btc2_p` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `btc3_p` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `btc4_p` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `amounts`
--

CREATE TABLE IF NOT EXISTS `amounts` (
`id` int(11) NOT NULL,
  `btc1` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `btc2` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `btc3` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `btc4` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `biggestwiner`
--

CREATE TABLE IF NOT EXISTS `biggestwiner` (
`bwid` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `amount` decimal(10,0) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `biggestwiner`
--

INSERT INTO `biggestwiner` (`bwid`, `timestamp`, `amount`) VALUES
(1, '2015-05-05 21:10:11', '123'),
(2, '2015-05-19 10:23:17', '122');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `btcwallet`
--

CREATE TABLE IF NOT EXISTS `btcwallet` (
  `guid` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `time` varchar(45) COLLATE utf8_hungarian_ci NOT NULL,
  `rnd` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `session` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `btcwallet`
--

INSERT INTO `btcwallet` (`guid`, `address`, `time`, `rnd`, `session`) VALUES
('01922777-d3df-4377-a773-c74f9db50469', '1K66gsd5Du8baVNmqga6BcVW6s2dZPPbEG', '2015-08-02 14:05', '1496269624', '27'),
('2a59a379-1478-4170-8750-954ee0345b5c', '1KJySTAaMBbz9tJBfjexFLum8wFUimX4W9', '2015-07-21 22:33:57', '-929454215', '0'),
('6efd7edc-33fb-464b-831a-0c407dc9940c', '1D2yygb1k91ArRGiiBAFhwgu4uZeuURRec', '2015-08-02 13:54', '470976637', '0'),
('b77b578c-d9ab-44ce-8421-b10cc458ca1f', '1DDa6NGLHHRihMWWeWLUhAw9Xk1QGEpGSg', '2015-08-02 13:57', '1329210395', '0'),
('b78f2989-6241-434b-b62d-3a39cbc091ee', '14fL2bff4uzvTPrqv86n9Q5cBh9AwcpMED', '2015-07-27 23:43', '-1788859271', '0'),
('c9316935-98cf-4f0e-8406-5ac7ebd29b29', '18ge8YMsEYnEF8aLfnGhjEQBSyMZRo8Vm', '2015-07-31 23:15', '-1244647268', '0'),
('da420a31-e072-40a1-9d28-cd4545cea82d', '1CEnZM57znFTQ5YhZjpcxvGYcLn2eE4UaM', '2015-07-31 23:15', '-1538378614', '0'),
('e887c7a6-0be0-4e54-9868-327df08da818', '1CBqePNu7mP1t8fNXqGWCwGdx1eXTXAjid', '2015-07-27 23:43', '-1939253431', '0'),
('f8aa15ea-92b1-47b4-ac55-2a4e95b1b2d7', '1rWupVWtkSkiqt1tZPhXqRMgEg1Yrs3pz', '2015-08-02 13:57', '865522048', '0'),
('f9542378-5acb-439c-a8db-80696457a323', '13iNcr3cgErYfBgcwq3RFQCScJez64krwk', '2015/07/25 22:26', '-265538818', '0');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
`EID` int(11) NOT NULL,
  `Sender` varchar(35) COLLATE utf8_hungarian_ci NOT NULL,
  `Nem` varchar(46) COLLATE utf8_hungarian_ci NOT NULL,
  `Type` varchar(3) COLLATE utf8_hungarian_ci NOT NULL,
  `option` int(11) NOT NULL,
  `recipientaddress` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `entry`
--

INSERT INTO `entry` (`EID`, `Sender`, `Nem`, `Type`, `option`, `recipientaddress`) VALUES
(1, 'NXT-D6K7-MLY6-98FM-FLL5T', 'NAGDY7W53P46SCAFDZ6C4A5JQ4DNBLW34S5KDAXB', 'nxt', 4, NULL),
(2, 'NXT-D6K7-MLY6-98FM-FLL5T', 'NAGDY7W53P46SCAFDZ6C4A5JQ4DNBLW34S5KDAXB', 'nxt', 1, NULL),
(4, '1K66gsd5Du8baVNmqga6BcVW6s2dZPPbEG', 'NAGDY7W53P46SCAFDZ6C4A5JQ4DNBLW34S5KDAXB', 'btc', 3, '13JhTwn4YAVh3vArCYSQ1iLQBrfmscHZ2g');

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `entryamount`
--
CREATE TABLE IF NOT EXISTS `entryamount` (
`amount` double
,`option` varchar(7)
,`onum` tinyint(1)
,`currency` char(3)
,`totalentries` bigint(21)
);
-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `optionaddresses`
--

CREATE TABLE IF NOT EXISTS `optionaddresses` (
`id` int(11) NOT NULL,
  `nxtp1` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nxtp2` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nxtp3` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nxtp4` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nxt1` varchar(24) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt2` varchar(24) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt3` varchar(24) COLLATE utf8_hungarian_ci NOT NULL,
  `nxt4` varchar(24) COLLATE utf8_hungarian_ci NOT NULL,
  `session` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `optionaddresses`
--

INSERT INTO `optionaddresses` (`id`, `nxtp1`, `nxtp2`, `nxtp3`, `nxtp4`, `nxt1`, `nxt2`, `nxt3`, `nxt4`, `session`) VALUES
(1, NULL, NULL, NULL, NULL, 'NXT-9LGJ-YESL-ARTV-74VWH', 'NXT-AMRR-ZYTE-A66D-8Q8LT', '', '', 1),
(3, '0a73bf130e3504a9dc522db9934e9966cc242cc7a6c4b06d7ef1d31c2226d702', '74da883db2e961129b5c345b3518e2d379a8c609ce282783d14584b72267ab39', '0025c3eb6f276771a387a4a8c6863ea7f22e1f2292fd4c455d57ef31f3780b3a', '1215e5adc0a68616cd618b9932164d643128d30d67cd58167e3b7135b669031a', 'NXT-4V3M-WHTE-FHV9-2PE3L', 'NXT-BBE7-JCXT-XYLE-4UKDS', 'NXT-X9CJ-ULVE-VHN4-EK8WQ', 'NXT-CJKB-CPUC-QNQT-CMJT5', 27),
(4, 'aa2a918ef1c3c6633aacfaed8ffda56c205c7df4d4450513394dc8729a13f55b', '57b6a52bac8cb6afdabba5b8cf83a48a290bbf2239ac614f2a7b2e39d3e36f04', 'a4d9c2acbdfcbfc91a1116193ba2849a4f9de62bcea171903ebec7e6f7c1b62f', 'f8d561a553138f065f868d140e4933c517caf744e09db83ee44accf02859542b', 'NXT-XX2H-7Y94-SVN7-52HHV', 'NXT-YHLW-6CSL-N5Q4-3TFC3', 'NXT-NE8X-N3B5-8A6A-35HYZ', 'NXT-7AM7-AXEJ-7JUH-5QUE2', 0),
(5, '3074eec6b8c854759b786b48d4229087bd1169362ca57c62e4f886146bdaf533', '8757ac3ee45e13c8f8cf49769a7e882b6f0dbda307b5f82fabe72cc63387520a', '4c037d149a37347f38777cfbe2537d82a2a7928e2216e584a98540a0468c421c', '0c6cd9d35894c5862fbe276f05e32a38785a6d104217c90cc19933772a7ce256', 'NXT-F4L9-RF3H-AMCM-BXEP9', 'NXT-XQYZ-CTZE-2VXD-ET8DZ', 'NXT-PZ6S-74DZ-TB5S-DVS6C', 'NXT-PUVY-9CVG-CG4K-D8CNE', 0),
(6, 'a312a0359e0ae3a972b72f11497fc899f1c2eb5c947e4635795e8e9a4d85c76c', '50adc4956412b212877dd907a2dbc2534782658edf21952eed2dd647b16bcb23', '3eca8d93f3fb718fe5c1fb6887a163d0fe2fc0737cf74e6b370dfa2efab64f6f', '3bffbd475fef69c3594b6fae58b952ff48319cf7897f9f21e8c728fa5081ba52', 'NXT-44S4-JDMU-PWSR-H4N6Z', 'NXT-XREU-P4MM-BG5H-8MAM3', 'NXT-C8X6-ZQUS-XDJ7-DJRXM', 'NXT-XGLN-W88K-56SJ-EB4VS', 0),
(7, '6888f23c074c9d901fe0f56a02049134229e79fc63fe40b6da8fbd6286322a7b', '0035ecb815863699b44253f8aca15301d8ded9d0101069d89d12f16054db3636', '6b04d3893039d9b5e19fa9ca99c6e2755b2636dbbd05e4c30fd0e2ab5677b958', 'c9d1d6c5aa2856f75539d6ee048e0da077d0c7d78f52da6f157e2ba18caafb29', 'NXT-K94K-JWSH-4XJX-9NN79', 'NXT-LPD8-K33P-USUC-86JHW', 'NXT-CVWK-9PJA-3JL6-A4HN3', 'NXT-GQ7J-P7TW-C6W3-37B7S', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `refund`
--

CREATE TABLE IF NOT EXISTS `refund` (
  `transactionid` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `Sender` varchar(23) COLLATE utf8_hungarian_ci NOT NULL,
  `Amount` int(11) NOT NULL,
  `option` tinyint(1) NOT NULL,
  `currency` char(3) COLLATE utf8_hungarian_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`SID` int(11) NOT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeperiod` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'Day',
  `refunded` tinyint(1) DEFAULT '0',
  `paid` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `session`
--

INSERT INTO `session` (`SID`, `start`, `end`, `changeperiod`, `refunded`, `paid`) VALUES
(1, '2015-04-14 00:00:00', '2015-08-01 22:26:00', 'Day', 0, 1),
(27, '2015-08-01 22:26:00', '2015-08-02 22:26:00', 'Day', 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `siteaddress`
--

CREATE TABLE IF NOT EXISTS `siteaddress` (
`id` int(11) NOT NULL,
  `root_dir` varchar(45) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `web_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nxt_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `nis_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `btc_address` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `siteaddress`
--

INSERT INTO `siteaddress` (`id`, `root_dir`, `web_address`, `nxt_address`, `nis_address`, `btc_address`) VALUES
(1, 'nem', '89.100.193.18', 'http://humanoide.thican.net:7876/', 'http://85.25.46.119:7890/', 'https://blockchain.info/');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sitetexts`
--

CREATE TABLE IF NOT EXISTS `sitetexts` (
  `id` tinyint(4) NOT NULL,
  `Desc` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `Option1` varchar(11) COLLATE utf8_hungarian_ci NOT NULL,
  `Option2` varchar(11) COLLATE utf8_hungarian_ci NOT NULL,
  `Option3` varchar(11) COLLATE utf8_hungarian_ci NOT NULL,
  `Option4` varchar(11) COLLATE utf8_hungarian_ci NOT NULL,
  `opt1text` varchar(25) COLLATE utf8_hungarian_ci NOT NULL,
  `opt2text` varchar(25) COLLATE utf8_hungarian_ci NOT NULL,
  `opt3text` varchar(25) COLLATE utf8_hungarian_ci NOT NULL,
  `opt4text` varchar(25) COLLATE utf8_hungarian_ci NOT NULL,
  `opening` varchar(1000) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `sitetexts`
--

INSERT INTO `sitetexts` (`id`, `Desc`, `Option1`, `Option2`, `Option3`, `Option4`, `opt1text`, `opt2text`, `opt3text`, `opt4text`, `opening`) VALUES
(0, 'A NEW ECONOMY STARTS WITH me', '1-10', '11-20', '21-30', '31-40', 'Option 1', 'Option 2', 'Option 3', 'Option 4', '1234566\n	');

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `totalentries`
--
CREATE TABLE IF NOT EXISTS `totalentries` (
`amount` double
,`currency` char(3)
);
-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `sender` varchar(40) COLLATE utf8_hungarian_ci NOT NULL,
  `amount` float DEFAULT NULL,
  `option` tinyint(1) NOT NULL,
  `currency` char(3) COLLATE utf8_hungarian_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_hungarian_ci NOT NULL,
  `pass` varchar(36) COLLATE utf8_hungarian_ci NOT NULL,
  `auth` tinyint(4) DEFAULT '0',
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(15) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `name`, `pass`, `auth`, `lastlogin`, `ip`) VALUES
(1, 'admin', 'admin', 1, '2015-08-02 14:05:18', '0'),
(2, 'Kailin', '123', 1, '2015-03-04 12:19:30', '');

-- --------------------------------------------------------

--
-- Nézet szerkezete `entryamount`
--
DROP TABLE IF EXISTS `entryamount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `entryamount` AS select sum(`transaction`.`amount`) AS `amount`,concat(`transaction`.`currency`,`transaction`.`option`) AS `option`,`transaction`.`option` AS `onum`,`transaction`.`currency` AS `currency`,count(`transaction`.`transactionid`) AS `totalentries` from `transaction` group by `transaction`.`option`,`transaction`.`currency`;

-- --------------------------------------------------------

--
-- Nézet szerkezete `totalentries`
--
DROP TABLE IF EXISTS `totalentries`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `totalentries` AS select sum(`transaction`.`amount`) AS `amount`,`transaction`.`currency` AS `currency` from `transaction` group by `transaction`.`currency`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amounts`
--
ALTER TABLE `amounts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biggestwiner`
--
ALTER TABLE `biggestwiner`
 ADD PRIMARY KEY (`bwid`);

--
-- Indexes for table `btcwallet`
--
ALTER TABLE `btcwallet`
 ADD PRIMARY KEY (`guid`), ADD UNIQUE KEY `address_UNIQUE` (`address`);

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
 ADD PRIMARY KEY (`EID`);

--
-- Indexes for table `optionaddresses`
--
ALTER TABLE `optionaddresses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund`
--
ALTER TABLE `refund`
 ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
 ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `siteaddress`
--
ALTER TABLE `siteaddress`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sitetexts`
--
ALTER TABLE `sitetexts`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
 ADD PRIMARY KEY (`transactionid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amounts`
--
ALTER TABLE `amounts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `biggestwiner`
--
ALTER TABLE `biggestwiner`
MODIFY `bwid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
MODIFY `EID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `optionaddresses`
--
ALTER TABLE `optionaddresses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `siteaddress`
--
ALTER TABLE `siteaddress`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
