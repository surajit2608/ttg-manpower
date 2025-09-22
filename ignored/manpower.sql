-- Adminer 4.8.1 MySQL 5.7.23-23 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `slug` text,
  `job_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `address` text,
  `city` char(100) DEFAULT NULL,
  `post_code` char(20) DEFAULT NULL,
  `country` char(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `hourly_salary` float NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `applications` (`id`, `title`, `slug`, `job_id`, `client_id`, `address`, `city`, `post_code`, `country`, `latitude`, `longitude`, `hourly_salary`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Need an experience driver',	'need-an-experience-driver',	2,	1,	'VIP Road, Baguiati',	'Kolkata',	'700059',	'India',	22.61633030,	88.43133390,	1.5,	NULL,	'2023-09-27 04:32:23',	'2023-07-25 18:48:48',	NULL),
(3,	'Need urgent delivery boy',	'need-urgent-delivery-boy',	3,	3,	'LM Ghosh Street',	'Krishnanagar',	'741101',	'India',	23.41513900,	88.50241090,	2.5,	NULL,	'2023-09-27 04:31:42',	'2023-07-31 18:31:16',	NULL),
(4,	'Packer Jobs',	'Packer-Jobs',	4,	3,	'23, sts London',	'London',	'SW193PH',	'UK',	51.41615060,	-0.21065340,	8,	NULL,	'2023-09-24 16:32:54',	'2023-09-08 14:43:17',	'2025-09-19 16:27:52'),
(5,	'TEST JOB',	'testjob',	4,	4,	'178 Merton High Street',	'London',	'SW19 1AY',	'United Kingdom',	51.41589860,	-0.18951280,	5,	NULL,	'2023-09-29 17:57:26',	'2023-09-29 12:02:11',	'2025-09-19 16:27:25');

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `in_time` datetime DEFAULT NULL,
  `in_note` char(50) DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `out_note` char(50) DEFAULT NULL,
  `hours` float NOT NULL DEFAULT '0',
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `awarding_bodies`;
CREATE TABLE `awarding_bodies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `change_logs`;
CREATE TABLE `change_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `type` char(100) DEFAULT NULL,
  `method` char(100) DEFAULT NULL,
  `comment` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `change_logs` (`id`, `user_id`, `record_id`, `type`, `method`, `comment`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	5,	'application.delete',	'delete',	'test',	'2025-09-19 16:27:25',	'2025-09-19 16:27:25',	NULL),
(2,	1,	4,	'application.delete',	'delete',	'test',	'2025-09-19 16:27:52',	'2025-09-19 16:27:52',	NULL);

DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` char(200) DEFAULT NULL,
  `contact_person` char(200) DEFAULT NULL,
  `email` char(64) DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `contract_start` date DEFAULT NULL,
  `contract_end` date DEFAULT NULL,
  `week_start_day` char(10) DEFAULT NULL,
  `week_end_day` char(10) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `clients` (`id`, `business_name`, `contact_person`, `email`, `phone`, `contract_start`, `contract_end`, `week_start_day`, `week_end_day`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Amazon',	'Surajit Pramanik',	'surajit@gmail.com',	'+919804105617',	NULL,	NULL,	'thursday',	'wednesday',	NULL,	'2024-01-19 17:13:16',	'2023-07-08 08:13:00',	NULL),
(3,	'Flipkart',	'Flipkart Admin',	'admin@flipkart.com',	'+919865321470',	NULL,	NULL,	'sunday',	'monday',	NULL,	'2024-01-19 17:13:00',	'2023-07-31 18:29:49',	NULL),
(4,	'Dnata Catering UK',	'Martin Rowe',	'martin.rowe@dnata.com',	'01293404801',	'0000-00-00',	'0000-00-00',	'monday',	'sunday',	NULL,	'2024-01-19 17:12:44',	'2023-09-19 09:22:17',	NULL);

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` char(100) DEFAULT NULL,
  `address` char(200) DEFAULT NULL,
  `city` char(100) DEFAULT NULL,
  `postal` char(20) DEFAULT NULL,
  `phone` char(16) DEFAULT NULL,
  `fax` char(16) DEFAULT NULL,
  `email` char(64) DEFAULT NULL,
  `website` char(200) DEFAULT NULL,
  `logo` char(200) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `companies` (`id`, `user_id`, `name`, `address`, `city`, `postal`, `phone`, `fax`, `email`, `website`, `logo`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'Time Tech Global',	'178 Merton High Street',	'London',	'SW19 1YA',	'+44 7572454166',	'515253',	'operations@timetechglobal.com',	'https://timetechglobal.com',	'/uploads/logos/logo-64ac239a2903f.png',	NULL,	'2023-07-20 20:04:02',	'2023-07-10 15:16:38',	NULL);

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` char(255) DEFAULT NULL,
  `label` char(255) DEFAULT NULL,
  `details` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `countries` (`id`, `value`, `label`, `details`, `created_at`, `updated_at`) VALUES
(1,	'93',	'(+93) Afghanistan',	NULL,	NULL,	NULL),
(2,	'355',	'(+355) Albania',	NULL,	NULL,	NULL),
(3,	'213',	'(+213) Algeria',	NULL,	NULL,	NULL),
(4,	'1684',	'(+1684) American Samoa',	NULL,	NULL,	NULL),
(5,	'376',	'(+376) Andorra',	NULL,	NULL,	NULL),
(6,	'244',	'(+244) Angola',	NULL,	NULL,	NULL),
(7,	'1264',	'(+1264) Anguilla',	NULL,	NULL,	NULL),
(8,	'0',	'(+0) Antarctica',	NULL,	NULL,	NULL),
(9,	'1268',	'(+1268) Antigua and Barbuda',	NULL,	NULL,	NULL),
(10,	'54',	'(+54) Argentina',	NULL,	NULL,	NULL),
(11,	'374',	'(+374) Armenia',	NULL,	NULL,	NULL),
(12,	'297',	'(+297) Aruba',	NULL,	NULL,	NULL),
(13,	'61',	'(+61) Australia',	NULL,	NULL,	NULL),
(14,	'43',	'(+43) Austria',	NULL,	NULL,	NULL),
(15,	'994',	'(+994) Azerbaijan',	NULL,	NULL,	NULL),
(16,	'1242',	'(+1242) Bahamas',	NULL,	NULL,	NULL),
(17,	'973',	'(+973) Bahrain',	NULL,	NULL,	NULL),
(18,	'880',	'(+880) Bangladesh',	NULL,	NULL,	NULL),
(19,	'1246',	'(+1246) Barbados',	NULL,	NULL,	NULL),
(20,	'375',	'(+375) Belarus',	NULL,	NULL,	NULL),
(21,	'32',	'(+32) Belgium',	NULL,	NULL,	NULL),
(22,	'501',	'(+501) Belize',	NULL,	NULL,	NULL),
(23,	'229',	'(+229) Benin',	NULL,	NULL,	NULL),
(24,	'1441',	'(+1441) Bermuda',	NULL,	NULL,	NULL),
(25,	'975',	'(+975) Bhutan',	NULL,	NULL,	NULL),
(26,	'591',	'(+591) Bolivia',	NULL,	NULL,	NULL),
(27,	'387',	'(+387) Bosnia and Herzegovina',	NULL,	NULL,	NULL),
(28,	'267',	'(+267) Botswana',	NULL,	NULL,	NULL),
(29,	'0',	'(+0) Bouvet Island',	NULL,	NULL,	NULL),
(30,	'55',	'(+55) Brazil',	NULL,	NULL,	NULL),
(31,	'246',	'(+246) British Indian Ocean Territory',	NULL,	NULL,	NULL),
(32,	'673',	'(+673) Brunei Darussalam',	NULL,	NULL,	NULL),
(33,	'359',	'(+359) Bulgaria',	NULL,	NULL,	NULL),
(34,	'226',	'(+226) Burkina Faso',	NULL,	NULL,	NULL),
(35,	'257',	'(+257) Burundi',	NULL,	NULL,	NULL),
(36,	'855',	'(+855) Cambodia',	NULL,	NULL,	NULL),
(37,	'237',	'(+237) Cameroon',	NULL,	NULL,	NULL),
(38,	'238',	'(+238) Cape Verde',	NULL,	NULL,	NULL),
(39,	'1345',	'(+1345) Cayman Islands',	NULL,	NULL,	NULL),
(40,	'236',	'(+236) Central African Republic',	NULL,	NULL,	NULL),
(41,	'235',	'(+235) Chad',	NULL,	NULL,	NULL),
(42,	'56',	'(+56) Chile',	NULL,	NULL,	NULL),
(43,	'86',	'(+86) China',	NULL,	NULL,	NULL),
(44,	'61',	'(+61) Christmas Island',	NULL,	NULL,	NULL),
(45,	'672',	'(+672) Cocos (Keeling) Island',	NULL,	NULL,	NULL),
(46,	'57',	'(+57) Colombia',	NULL,	NULL,	NULL),
(47,	'269',	'(+269) Comoros',	NULL,	NULL,	NULL),
(48,	'242',	'(+242) Congo',	NULL,	NULL,	NULL),
(49,	'682',	'(+682) Cook Islands',	NULL,	NULL,	NULL),
(50,	'506',	'(+506) Costa Rica',	NULL,	NULL,	NULL),
(51,	'225',	'(+225) Cote D\'\'Ivoire',	NULL,	NULL,	NULL),
(52,	'385',	'(+385) Croatia',	NULL,	NULL,	NULL),
(53,	'53',	'(+53) Cuba',	NULL,	NULL,	NULL),
(54,	'357',	'(+357) Cyprus',	NULL,	NULL,	NULL),
(55,	'420',	'(+420) Czech Republic',	NULL,	NULL,	NULL),
(56,	'45',	'(+45) Denmark',	NULL,	NULL,	NULL),
(57,	'253',	'(+253) Djibouti',	NULL,	NULL,	NULL),
(58,	'1767',	'(+1767) Dominica',	NULL,	NULL,	NULL),
(59,	'1809',	'(+1809) Dominican Republic',	NULL,	NULL,	NULL),
(60,	'593',	'(+593) Ecuador',	NULL,	NULL,	NULL),
(61,	'20',	'(+20) Egypt',	NULL,	NULL,	NULL),
(62,	'503',	'(+503) El Salvador',	NULL,	NULL,	NULL),
(63,	'240',	'(+240) Equatorial Guinea',	NULL,	NULL,	NULL),
(64,	'291',	'(+291) Eritrea',	NULL,	NULL,	NULL),
(65,	'372',	'(+372) Estonia',	NULL,	NULL,	NULL),
(66,	'251',	'(+251) Ethiopia',	NULL,	NULL,	NULL),
(67,	'500',	'(+500) Falkland Islands (Malvinas',	NULL,	NULL,	NULL),
(68,	'298',	'(+298) Faroe Islands',	NULL,	NULL,	NULL),
(69,	'679',	'(+679) Fiji',	NULL,	NULL,	NULL),
(70,	'358',	'(+358) Finland',	NULL,	NULL,	NULL),
(71,	'33',	'(+33) France',	NULL,	NULL,	NULL),
(72,	'594',	'(+594) French Guiana',	NULL,	NULL,	NULL),
(73,	'689',	'(+689) French Polynesia',	NULL,	NULL,	NULL),
(74,	'0',	'(+0) French Southern Territories',	NULL,	NULL,	NULL),
(75,	'241',	'(+241) Gabon',	NULL,	NULL,	NULL),
(76,	'220',	'(+220) Gambia',	NULL,	NULL,	NULL),
(77,	'995',	'(+995) Georgia',	NULL,	NULL,	NULL),
(78,	'49',	'(+49) Germany',	NULL,	NULL,	NULL),
(79,	'233',	'(+233) Ghana',	NULL,	NULL,	NULL),
(80,	'350',	'(+350) Gibraltar',	NULL,	NULL,	NULL),
(81,	'30',	'(+30) Greece',	NULL,	NULL,	NULL),
(82,	'299',	'(+299) Greenland',	NULL,	NULL,	NULL),
(83,	'1473',	'(+1473) Grenada',	NULL,	NULL,	NULL),
(84,	'590',	'(+590) Guadeloupe',	NULL,	NULL,	NULL),
(85,	'1671',	'(+1671) Guam',	NULL,	NULL,	NULL),
(86,	'502',	'(+502) Guatemala',	NULL,	NULL,	NULL),
(87,	'224',	'(+224) Guinea',	NULL,	NULL,	NULL),
(88,	'245',	'(+245) Guinea-Bissau',	NULL,	NULL,	NULL),
(89,	'592',	'(+592) Guyana',	NULL,	NULL,	NULL),
(90,	'509',	'(+509) Haiti',	NULL,	NULL,	NULL),
(91,	'0',	'(+0) Heard Island and Mcdonald Islands',	NULL,	NULL,	NULL),
(92,	'39',	'(+39) Holy See',	NULL,	NULL,	NULL),
(93,	'504',	'(+504) Honduras',	NULL,	NULL,	NULL),
(94,	'852',	'(+852) Hong Kong',	NULL,	NULL,	NULL),
(95,	'36',	'(+36) Hungary',	NULL,	NULL,	NULL),
(96,	'354',	'(+354) Iceland',	NULL,	NULL,	NULL),
(97,	'91',	'(+91) India',	NULL,	NULL,	NULL),
(98,	'62',	'(+62) Indonesia',	NULL,	NULL,	NULL),
(99,	'98',	'(+98) Iran, Islamic Republic of',	NULL,	NULL,	NULL),
(100,	'964',	'(+964) Iraq',	NULL,	NULL,	NULL),
(101,	'353',	'(+353) Ireland',	NULL,	NULL,	NULL),
(102,	'972',	'(+972) Israel',	NULL,	NULL,	NULL),
(103,	'39',	'(+39) Italy',	NULL,	NULL,	NULL),
(104,	'1876',	'(+1876) Jamaica',	NULL,	NULL,	NULL),
(105,	'81',	'(+81) Japan',	NULL,	NULL,	NULL),
(106,	'962',	'(+962) Jordan',	NULL,	NULL,	NULL),
(107,	'7',	'(+7) Kazakhstan',	NULL,	NULL,	NULL),
(108,	'254',	'(+254) Kenya',	NULL,	NULL,	NULL),
(109,	'686',	'(+686) Kiribati',	NULL,	NULL,	NULL),
(110,	'850',	'(+850) Korea, Democratic People\'\'s Republic of',	NULL,	NULL,	NULL),
(111,	'82',	'(+82) Korea, Republic of',	NULL,	NULL,	NULL),
(112,	'965',	'(+965) Kuwait',	NULL,	NULL,	NULL),
(113,	'996',	'(+996) Kyrgyzstan',	NULL,	NULL,	NULL),
(114,	'856',	'(+856) Lao People\'\'s Democratic Republic',	NULL,	NULL,	NULL),
(115,	'371',	'(+371) Latvia',	NULL,	NULL,	NULL),
(116,	'961',	'(+961) Lebanon',	NULL,	NULL,	NULL),
(117,	'266',	'(+266) Lesotho',	NULL,	NULL,	NULL),
(118,	'231',	'(+231) Liberia',	NULL,	NULL,	NULL),
(119,	'218',	'(+218) Libyan Arab Jamahiriya',	NULL,	NULL,	NULL),
(120,	'423',	'(+423) Liechtenstein',	NULL,	NULL,	NULL),
(121,	'370',	'(+370) Lithuania',	NULL,	NULL,	NULL),
(122,	'352',	'(+352) Luxembourg',	NULL,	NULL,	NULL),
(123,	'853',	'(+853) Macao',	NULL,	NULL,	NULL),
(124,	'389',	'(+389) Macedonia, the Former Yugoslav Republic of',	NULL,	NULL,	NULL),
(125,	'261',	'(+261) Madagascar',	NULL,	NULL,	NULL),
(126,	'265',	'(+265) Malawi',	NULL,	NULL,	NULL),
(127,	'60',	'(+60) Malaysia',	NULL,	NULL,	NULL),
(128,	'960',	'(+960) Maldives',	NULL,	NULL,	NULL),
(129,	'223',	'(+223) Mali',	NULL,	NULL,	NULL),
(130,	'356',	'(+356) Malta',	NULL,	NULL,	NULL),
(131,	'692',	'(+692) Marshall Islands',	NULL,	NULL,	NULL),
(132,	'596',	'(+596) Martinique',	NULL,	NULL,	NULL),
(133,	'222',	'(+222) Mauritania',	NULL,	NULL,	NULL),
(134,	'230',	'(+230) Mauritius',	NULL,	NULL,	NULL),
(135,	'269',	'(+269) Mayotte',	NULL,	NULL,	NULL),
(136,	'52',	'(+52) Mexico',	NULL,	NULL,	NULL),
(137,	'691',	'(+691) Micronesia, Federated States of',	NULL,	NULL,	NULL),
(138,	'373',	'(+373) Moldova, Republic of',	NULL,	NULL,	NULL),
(139,	'377',	'(+377) Monaco',	NULL,	NULL,	NULL),
(140,	'976',	'(+976) Mongolia',	NULL,	NULL,	NULL),
(141,	'1664',	'(+1664) Montserrat',	NULL,	NULL,	NULL),
(142,	'212',	'(+212) Morocco',	NULL,	NULL,	NULL),
(143,	'258',	'(+258) Mozambique',	NULL,	NULL,	NULL),
(144,	'95',	'(+95) Myanmar',	NULL,	NULL,	NULL),
(145,	'264',	'(+264) Namibia',	NULL,	NULL,	NULL),
(146,	'674',	'(+674) Nauru',	NULL,	NULL,	NULL),
(147,	'977',	'(+977) Nepal',	NULL,	NULL,	NULL),
(148,	'31',	'(+31) Netherlands',	NULL,	NULL,	NULL),
(149,	'599',	'(+599) Netherlands Antilles',	NULL,	NULL,	NULL),
(150,	'687',	'(+687) New Caledonia',	NULL,	NULL,	NULL),
(151,	'64',	'(+64) New Zealand',	NULL,	NULL,	NULL),
(152,	'505',	'(+505) Nicaragua',	NULL,	NULL,	NULL),
(153,	'227',	'(+227) Niger',	NULL,	NULL,	NULL),
(154,	'234',	'(+234) Nigeria',	NULL,	NULL,	NULL),
(155,	'683',	'(+683) Niue',	NULL,	NULL,	NULL),
(156,	'672',	'(+672) Norfolk Island',	NULL,	NULL,	NULL),
(157,	'1670',	'(+1670) Northern Mariana Islands',	NULL,	NULL,	NULL),
(158,	'47',	'(+47) Norway',	NULL,	NULL,	NULL),
(159,	'968',	'(+968) Oman',	NULL,	NULL,	NULL),
(160,	'92',	'(+92) Pakistan',	NULL,	NULL,	NULL),
(161,	'680',	'(+680) Palau',	NULL,	NULL,	NULL),
(162,	'970',	'(+970) Palestinian Territory, Occupied',	NULL,	NULL,	NULL),
(163,	'507',	'(+507) Panama',	NULL,	NULL,	NULL),
(164,	'675',	'(+675) Papua New Guinea',	NULL,	NULL,	NULL),
(165,	'595',	'(+595) Paraguay',	NULL,	NULL,	NULL),
(166,	'51',	'(+51) Peru',	NULL,	NULL,	NULL),
(167,	'63',	'(+63) Philippines',	NULL,	NULL,	NULL),
(168,	'0',	'(+0) Pitcairn',	NULL,	NULL,	NULL),
(169,	'48',	'(+48) Poland',	NULL,	NULL,	NULL),
(170,	'351',	'(+351) Portugal',	NULL,	NULL,	NULL),
(171,	'1787',	'(+1787) Puerto Rico',	NULL,	NULL,	NULL),
(172,	'974',	'(+974) Qatar',	NULL,	NULL,	NULL),
(173,	'262',	'(+262) Reunion',	NULL,	NULL,	NULL),
(174,	'40',	'(+40) Romania',	NULL,	NULL,	NULL),
(175,	'70',	'(+70) Russian Federation',	NULL,	NULL,	NULL),
(176,	'250',	'(+250) Rwanda',	NULL,	NULL,	NULL),
(177,	'290',	'(+290) Saint Helena',	NULL,	NULL,	NULL),
(178,	'1869',	'(+1869) Saint Kitts and Nevis',	NULL,	NULL,	NULL),
(179,	'1758',	'(+1758) Saint Lucia',	NULL,	NULL,	NULL),
(180,	'508',	'(+508) Saint Pierre and Miquelon',	NULL,	NULL,	NULL),
(181,	'1784',	'(+1784) Saint Vincent and the Grenadines',	NULL,	NULL,	NULL),
(182,	'684',	'(+684) Samoa',	NULL,	NULL,	NULL),
(183,	'378',	'(+378) San Marino',	NULL,	NULL,	NULL),
(184,	'239',	'(+239) Sao Tome and Principe',	NULL,	NULL,	NULL),
(185,	'966',	'(+966) Saudi Arabia',	NULL,	NULL,	NULL),
(186,	'221',	'(+221) Senegal',	NULL,	NULL,	NULL),
(187,	'381',	'(+381) Serbia and Montenegro',	NULL,	NULL,	NULL),
(188,	'248',	'(+248) Seychelles',	NULL,	NULL,	NULL),
(189,	'232',	'(+232) Sierra Leone',	NULL,	NULL,	NULL),
(190,	'65',	'(+65) Singapore',	NULL,	NULL,	NULL),
(191,	'421',	'(+421) Slovakia',	NULL,	NULL,	NULL),
(192,	'386',	'(+386) Slovenia',	NULL,	NULL,	NULL),
(193,	'677',	'(+677) Solomon Islands',	NULL,	NULL,	NULL),
(194,	'252',	'(+252) Somalia',	NULL,	NULL,	NULL),
(195,	'27',	'(+27) South Africa',	NULL,	NULL,	NULL),
(196,	'34',	'(+34) Spain',	NULL,	NULL,	NULL),
(197,	'94',	'(+94) Sri Lanka',	NULL,	NULL,	NULL),
(198,	'249',	'(+249) Sudan',	NULL,	NULL,	NULL),
(199,	'597',	'(+597) Suriname',	NULL,	NULL,	NULL),
(200,	'47',	'(+47) Svalbard and Jan Mayen',	NULL,	NULL,	NULL),
(201,	'268',	'(+268) Swaziland',	NULL,	NULL,	NULL),
(202,	'46',	'(+46) Sweden',	NULL,	NULL,	NULL),
(203,	'41',	'(+41) Switzerland',	NULL,	NULL,	NULL),
(204,	'963',	'(+963) Syrian Arab Republic',	NULL,	NULL,	NULL),
(205,	'886',	'(+886) Taiwan, Province of China',	NULL,	NULL,	NULL),
(206,	'992',	'(+992) Tajikistan',	NULL,	NULL,	NULL),
(207,	'255',	'(+255) Tanzania, United Republic of',	NULL,	NULL,	NULL),
(208,	'66',	'(+66) Thailand',	NULL,	NULL,	NULL),
(209,	'670',	'(+670) Timor-Leste',	NULL,	NULL,	NULL),
(210,	'228',	'(+228) Togo',	NULL,	NULL,	NULL),
(211,	'690',	'(+690) Tokelau',	NULL,	NULL,	NULL),
(212,	'676',	'(+676) Tonga',	NULL,	NULL,	NULL),
(213,	'1868',	'(+1868) Trinidad and Tobago',	NULL,	NULL,	NULL),
(214,	'216',	'(+216) Tunisia',	NULL,	NULL,	NULL),
(215,	'90',	'(+90) Turkey',	NULL,	NULL,	NULL),
(216,	'7370',	'(+7370) Turkmenistan',	NULL,	NULL,	NULL),
(217,	'1649',	'(+1649) Turks and Caicos Islands',	NULL,	NULL,	NULL),
(218,	'688',	'(+688) Tuvalu',	NULL,	NULL,	NULL),
(219,	'256',	'(+256) Uganda',	NULL,	NULL,	NULL),
(220,	'380',	'(+380) Ukraine',	NULL,	NULL,	NULL),
(221,	'971',	'(+971) United Arab Emirates',	NULL,	NULL,	NULL),
(222,	'44',	'(+44) United Kingdom',	NULL,	NULL,	NULL),
(223,	'1',	'(+1) United States',	NULL,	NULL,	NULL),
(224,	'598',	'(+598) Uruguay',	NULL,	NULL,	NULL),
(225,	'998',	'(+998) Uzbekistan',	NULL,	NULL,	NULL),
(226,	'678',	'(+678) Vanuatu',	NULL,	NULL,	NULL),
(227,	'58',	'(+58) Venezuela',	NULL,	NULL,	NULL),
(228,	'84',	'(+84) Viet Nam',	NULL,	NULL,	NULL),
(229,	'1284',	'(+1284) Virgin Islands, British',	NULL,	NULL,	NULL),
(230,	'1340',	'(+1340) Virgin Islands, U.S.',	NULL,	NULL,	NULL),
(231,	'681',	'(+681) Wallis and Futuna',	NULL,	NULL,	NULL),
(232,	'212',	'(+212) Western Sahara',	NULL,	NULL,	NULL),
(233,	'967',	'(+967) Yemen',	NULL,	NULL,	NULL),
(234,	'260',	'(+260) Zambia',	NULL,	NULL,	NULL),
(235,	'263',	'(+263) Zimbabwe',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `document_types`;
CREATE TABLE `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `document_types` (`id`, `name`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Passport Front',	NULL,	'2023-09-26 19:58:44',	'2023-09-26 19:58:44',	NULL),
(2,	'Passport Back',	NULL,	'2023-09-26 19:58:54',	'2023-09-26 19:58:54',	NULL),
(3,	'University Letter',	NULL,	'2023-09-26 19:59:12',	'2023-09-26 19:59:12',	NULL),
(4,	'Bank Letter',	NULL,	'2023-09-26 19:59:33',	'2023-09-26 19:59:33',	NULL),
(5,	'Utility Bill',	NULL,	'2023-09-26 19:59:53',	'2023-09-26 19:59:53',	NULL),
(6,	'Bank Statement',	NULL,	'2023-09-26 20:00:07',	'2023-09-26 20:00:07',	NULL),
(7,	'DNLA',	NULL,	'2023-09-26 20:00:17',	'2023-09-26 20:00:17',	NULL),
(8,	'Experience Letter',	NULL,	'2023-09-26 20:00:55',	'2023-09-26 20:00:55',	NULL),
(9,	'Bio-metric Back',	NULL,	'2023-09-26 20:01:00',	'2023-09-26 20:01:00',	NULL),
(10,	'Driving License',	NULL,	'2024-01-19 18:38:40',	'2024-01-19 18:38:40',	NULL),
(11,	'Proof of Address',	NULL,	'2024-01-19 18:54:34',	'2024-01-19 18:54:34',	NULL);

DROP TABLE IF EXISTS `grievance_types`;
CREATE TABLE `grievance_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `holidays` (`id`, `name`, `date`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Independence Day',	'2023-08-15',	NULL,	'2023-07-14 04:25:11',	'2023-07-14 04:25:11',	NULL),
(2,	'Gandhi Jayanti',	'2023-10-02',	NULL,	'2023-07-14 04:26:07',	'2023-07-14 04:26:07',	NULL);

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `jobs` (`id`, `name`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(2,	'Driver',	'',	'2023-07-20 20:40:02',	'2023-07-20 20:40:02',	NULL),
(3,	'Delivery boy',	NULL,	'2023-07-31 18:30:39',	'2023-07-31 18:30:39',	NULL),
(4,	'Packer',	NULL,	'2023-09-08 14:40:44',	'2023-09-08 14:40:44',	NULL),
(5,	'General Assistant Gatwick',	NULL,	'2023-09-19 09:18:51',	'2023-09-19 09:18:51',	NULL);

DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `holiday_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `message` text,
  `comment` text,
  `status` char(20) NOT NULL DEFAULT 'pending',
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `leaves` (`id`, `holiday_id`, `worker_id`, `message`, `comment`, `status`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	2,	1,	'Need a leave on 2nd Oct 2023 this year',	'Sorry it\'s rejected',	'rejected',	'',	'2023-08-21 17:53:19',	'2023-08-01 19:33:18',	NULL),
(2,	1,	2,	'Hello Sir, I am applying a leave on 15th August for Independence day celebration',	'Sorry application is Rejected',	'rejected',	NULL,	'2023-08-14 19:47:08',	'2023-08-14 19:40:37',	NULL);

DROP TABLE IF EXISTS `nationalities`;
CREATE TABLE `nationalities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nationalities` (`id`, `name`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(3,	'Indian',	NULL,	'2023-07-24 04:30:21',	'2023-07-24 04:30:21',	NULL);

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_type` char(16) DEFAULT NULL,
  `content` text,
  `url` text,
  `status` char(10) NOT NULL DEFAULT 'unread',
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `notifications` (`id`, `sender_id`, `receiver_id`, `receiver_type`, `content`, `url`, `status`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	0,	1,	'worker',	'Thank you for submitting the job application for Packer Jobs',	NULL,	'unread',	NULL,	'2023-09-24 19:36:27',	'2023-09-24 19:36:27',	NULL),
(2,	0,	1,	'admin',	'Surajit Pramanik has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=1&tab=basic',	'read',	NULL,	'2023-09-24 19:36:33',	'2023-09-24 19:36:33',	NULL),
(3,	0,	2,	'admin',	'Surajit Pramanik has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=1&tab=basic',	'unread',	NULL,	'2023-09-24 19:36:33',	'2023-09-24 19:36:33',	NULL),
(4,	0,	3,	'admin',	'Surajit Pramanik has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=1&tab=basic',	'unread',	NULL,	'2023-09-24 19:36:33',	'2023-09-24 19:36:33',	NULL),
(5,	1,	1,	'worker',	'Admin has changed your login password',	NULL,	'unread',	NULL,	'2023-09-25 19:35:40',	'2023-09-25 19:35:40',	NULL),
(6,	1,	1,	'worker',	'Congratulations, your Job Application has been approved',	NULL,	'unread',	NULL,	'2023-09-25 19:42:33',	'2023-09-25 19:42:33',	NULL),
(7,	1,	1,	'worker',	'Admin has changed your login password',	NULL,	'unread',	NULL,	'2023-09-25 19:47:56',	'2023-09-25 19:47:56',	NULL),
(8,	1,	2,	'worker',	'Thank you for submitting the job application for Packer Jobs',	NULL,	'unread',	NULL,	'2023-09-27 06:22:24',	'2023-09-27 06:22:24',	NULL),
(9,	0,	1,	'admin',	'Swapna Mondal has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=2&tab=basic',	'read',	NULL,	'2023-09-27 06:22:28',	'2023-09-27 06:22:28',	NULL),
(10,	0,	2,	'admin',	'Swapna Mondal has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=2&tab=basic',	'unread',	NULL,	'2023-09-27 06:22:28',	'2023-09-27 06:22:28',	NULL),
(11,	0,	3,	'admin',	'Swapna Mondal has submitted a job application for Packer Jobs',	'/admin/workers/application/?id=2&tab=basic',	'unread',	NULL,	'2023-09-27 06:22:28',	'2023-09-27 06:22:28',	NULL),
(12,	1,	2,	'worker',	'Congratulations, your Job Application has been approved',	NULL,	'unread',	NULL,	'2023-09-27 11:25:24',	'2023-09-27 11:25:24',	NULL),
(13,	1,	2,	'worker',	'You have assigned for a job named Need an experience driver',	'/jobs',	'unread',	NULL,	'2024-01-31 12:20:34',	'2024-01-31 12:20:34',	NULL),
(14,	1,	1,	'worker',	'You have assigned for a job named Need an experience driver',	'/jobs',	'unread',	NULL,	'2024-01-31 12:21:22',	'2024-01-31 12:21:22',	NULL),
(15,	1,	3,	'worker',	'Thank you for submitting the job application for TEST JOB',	NULL,	'unread',	NULL,	'2024-02-22 11:14:40',	'2024-02-22 11:14:40',	NULL),
(16,	1,	4,	'worker',	'Thank you for submitting the job application for TEST JOB',	NULL,	'unread',	NULL,	'2024-02-26 11:08:20',	'2024-02-26 11:08:20',	NULL),
(17,	1,	4,	'worker',	'Congratulations, your Job Application has been approved',	NULL,	'unread',	NULL,	'2024-02-26 11:10:53',	'2024-02-26 11:10:53',	NULL);

DROP TABLE IF EXISTS `relationships`;
CREATE TABLE `relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `relationships` (`id`, `name`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(2,	'Father',	NULL,	'2023-07-20 20:49:09',	'2023-07-20 20:49:09',	NULL);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `permissions` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `permissions`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Admin',	'[{\"name\":\"Worker Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Client Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"User Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Role Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Application Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Settings Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Holiday Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Leave Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"},{\"name\":\"Attendance Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Allow\"}]',	NULL,	'2023-07-18 04:46:48',	'2023-07-04 23:49:48',	NULL),
(2,	'Manager',	'[{\"name\":\"Worker Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Client Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"User Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Role Module\",\"value\":\"Deny\",\"create\":\"Deny\",\"read\":\"Deny\",\"update\":\"Deny\",\"remove\":\"Deny\"},{\"name\":\"Application Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Settings Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Holiday Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Leave Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"},{\"name\":\"Attendance Module\",\"value\":\"Allow\",\"create\":\"Allow\",\"read\":\"Allow\",\"update\":\"Allow\",\"remove\":\"Deny\"}]',	NULL,	'2023-07-14 04:33:06',	'2023-07-04 23:49:48',	NULL);

DROP TABLE IF EXISTS `skillsets`;
CREATE TABLE `skillsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `wage` float NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `skillsets` (`id`, `name`, `wage`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(2,	'Skill 1',	5,	NULL,	'2023-07-11 04:08:58',	'2023-07-11 04:08:58',	NULL);

DROP TABLE IF EXISTS `training_types`;
CREATE TABLE `training_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` char(100) DEFAULT NULL,
  `last_name` char(100) DEFAULT NULL,
  `full_name` char(200) DEFAULT NULL,
  `image` text,
  `email` char(64) DEFAULT NULL,
  `username` char(64) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  `phone` char(16) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `details` text,
  `tz_offset` int(11) NOT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `first_name`, `last_name`, `full_name`, `image`, `email`, `username`, `password`, `phone`, `role_id`, `details`, `tz_offset`, `last_loggedin`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	'Time Tech',	'Global',	'Time Tech Global',	'/uploads/profiles/dp-64b018a5e6fd7.jpg',	'admin@gmail.com',	'admin',	'7c4a8d09ca3762af61e59520943dc26494f8941b',	'+91 9000000000',	1,	NULL,	-19800,	'2025-09-19 16:22:08',	'2023-09-27 14:21:48',	'2023-06-30 12:07:23',	NULL),
(2,	'Swapna',	'Mondal',	'Swapna Mondal',	'/uploads/users/dp-64da8f9cb70a1.png',	'swapna@gmail.com',	'swapna',	'7c4a8d09ca3762af61e59520943dc26494f8941b',	'+91 9932270925',	2,	NULL,	-19800,	'2023-08-14 19:54:50',	'2023-08-14 20:33:41',	'2023-06-30 12:07:23',	NULL),
(3,	'Surajit',	'Pramanik',	'Surajit Pramanik',	'/uploads/profiles/dp-64b01bca3875f.jpg',	'surajit@gmail.com',	'surajit',	'7c4a8d09ca3762af61e59520943dc26494f8941b',	'+91 9804105617',	2,	NULL,	-19800,	'2023-07-04 04:43:49',	'2023-07-13 15:44:12',	'2023-06-30 12:07:23',	NULL);

DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `title` char(10) DEFAULT NULL,
  `first_name` char(100) DEFAULT NULL,
  `middle_name` char(100) DEFAULT NULL,
  `last_name` char(100) DEFAULT NULL,
  `account_name` char(200) DEFAULT NULL,
  `image` text,
  `gender` char(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` char(64) DEFAULT NULL,
  `username` char(64) DEFAULT NULL,
  `password` char(64) DEFAULT NULL,
  `phone` char(16) DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `client_start_date` date DEFAULT NULL,
  `client_end_date` date DEFAULT NULL,
  `holidays_entitlement` int(11) NOT NULL,
  `status` char(20) NOT NULL DEFAULT 'pending',
  `tz_offset` int(11) NOT NULL,
  `last_loggedin` datetime DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers` (`id`, `application_id`, `title`, `first_name`, `middle_name`, `last_name`, `account_name`, `image`, `gender`, `dob`, `email`, `username`, `password`, `phone`, `joining_date`, `client_start_date`, `client_end_date`, `holidays_entitlement`, `status`, `tz_offset`, `last_loggedin`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'Mr',	'Surajit',	'',	'Pramanik',	'Surajit Pramanik',	NULL,	'Male',	'1987-08-26',	'jitdxpert@gmail.com',	'jitdxpert',	'b61ad4f4977a0b0f15c45b4b3729c8718eca3779',	'+919804105617',	'2024-01-31',	NULL,	NULL,	0,	'approved',	-19800,	'2025-09-19 11:34:24',	NULL,	'2024-02-13 15:13:14',	'2023-09-24 19:36:27',	NULL),
(2,	1,	'Mrs',	'Swapna',	'',	'Mondal',	'Swapna Mondal',	NULL,	'Female',	'1987-07-09',	'swapna.mondal@gmail.com',	'swapna',	'2bc9ce60a08aefe3c5591ca41ffd399e848829df',	'9830123456',	'2024-01-31',	NULL,	NULL,	0,	'approved',	-19800,	NULL,	NULL,	'2024-01-30 19:32:24',	'2023-09-27 06:22:24',	NULL),
(3,	5,	'Mr',	'Kaustab',	'k',	'Nandy',	'Kaustab k Nandy',	NULL,	'Male',	'1991-10-09',	'kaustabwiseowl@gmail.com',	'kaus',	'9e8e28a1d729a8216714a216235b4e8ff6e91faf',	'8276044433',	NULL,	NULL,	NULL,	0,	'active',	-19800,	NULL,	NULL,	'2024-02-22 11:14:40',	'2024-02-22 11:14:40',	NULL),
(4,	5,	'Mr',	'Hamza',	'',	'Khan',	'Hamza Khan',	NULL,	'Male',	'1995-06-16',	'consultant.1@timetechglobal.com',	'Consultant.1',	'510d24ffb45ad320cb3dc2c09e81989477f8f183',	'07405012468',	NULL,	NULL,	NULL,	0,	'approved',	0,	'2024-02-26 11:57:46',	NULL,	'2024-02-26 11:08:19',	'2024-02-26 11:08:19',	NULL);

DROP TABLE IF EXISTS `workers_addresses`;
CREATE TABLE `workers_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `address` text,
  `city` char(100) DEFAULT NULL,
  `post_code` char(20) DEFAULT NULL,
  `country` char(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `utility_bill` text,
  `bank_statement` text,
  `dnla` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_addresses` (`id`, `worker_id`, `address`, `city`, `post_code`, `country`, `latitude`, `longitude`, `from_date`, `to_date`, `utility_bill`, `bank_statement`, `dnla`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'85 Dabre Para Lane',	'Santipur',	'741404',	'India',	23.24398560,	88.42649250,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-09-27 14:30:35',	'2023-09-24 19:36:27',	NULL),
(2,	2,	'17-B, Mother Teresa Sarani, Park Street',	'Kolkata',	'700016',	'India',	22.55407160,	88.35155400,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-09-27 06:22:24',	'2023-09-27 06:22:24',	NULL),
(3,	3,	'9 ABC road',	'kolkata',	'700012',	'India',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-22 11:14:40',	'2024-02-22 11:14:40',	NULL),
(4,	4,	'flat 63 mortise house',	'london',	'ub33fp',	'united kingdom',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-26 11:08:20',	'2024-02-26 11:08:20',	NULL);

DROP TABLE IF EXISTS `workers_assignments`;
CREATE TABLE `workers_assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `shift_start_time` time DEFAULT NULL,
  `shift_end_time` time DEFAULT NULL,
  `details` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_availabilities`;
CREATE TABLE `workers_availabilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `monday_from` time DEFAULT NULL,
  `monday_to` time DEFAULT NULL,
  `tuesday_from` time DEFAULT NULL,
  `tuesday_to` time DEFAULT NULL,
  `wednesday_from` time DEFAULT NULL,
  `wednesday_to` time DEFAULT NULL,
  `thursday_from` time DEFAULT NULL,
  `thursday_to` time DEFAULT NULL,
  `friday_from` time DEFAULT NULL,
  `friday_to` time DEFAULT NULL,
  `saturday_from` time DEFAULT NULL,
  `saturday_to` time DEFAULT NULL,
  `sunday_from` time DEFAULT NULL,
  `sunday_to` time DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_availabilities` (`id`, `worker_id`, `monday_from`, `monday_to`, `tuesday_from`, `tuesday_to`, `wednesday_from`, `wednesday_to`, `thursday_from`, `thursday_to`, `friday_from`, `friday_to`, `saturday_from`, `saturday_to`, `sunday_from`, `sunday_to`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(3,	1,	'05:00:17',	'14:00:59',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-13 15:13:14',	'2024-02-13 15:13:14',	NULL);

DROP TABLE IF EXISTS `workers_basics`;
CREATE TABLE `workers_basics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `share_code` char(100) DEFAULT NULL,
  `marital_status` char(15) DEFAULT NULL,
  `nationality_id` int(11) NOT NULL,
  `alternative_phone` char(20) DEFAULT NULL,
  `ni_number` char(200) DEFAULT NULL,
  `next_of_kin_name` char(200) DEFAULT NULL,
  `kin_relationship_id` int(11) DEFAULT NULL,
  `kin_phone` char(20) DEFAULT NULL,
  `first_uk_entry` date DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `passport_front` text,
  `passport_back` text,
  `visa_expiry` date DEFAULT NULL,
  `visa_type` char(100) DEFAULT NULL,
  `need_uk_visa` char(10) DEFAULT NULL,
  `address_document` text,
  `have_own_transport` char(10) DEFAULT NULL,
  `license_type` char(100) DEFAULT NULL,
  `license_document` text,
  `english_spoken_lavel` int(11) NOT NULL,
  `english_written_lavel` int(11) NOT NULL,
  `english_reading_lavel` int(11) NOT NULL,
  `criminal_record_1` char(10) DEFAULT NULL,
  `criminal_record_2` char(10) DEFAULT NULL,
  `criminal_record_3` char(10) DEFAULT NULL,
  `unspent_convictions` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_basics` (`id`, `worker_id`, `share_code`, `marital_status`, `nationality_id`, `alternative_phone`, `ni_number`, `next_of_kin_name`, `kin_relationship_id`, `kin_phone`, `first_uk_entry`, `passport_expiry`, `passport_front`, `passport_back`, `visa_expiry`, `visa_type`, `need_uk_visa`, `address_document`, `have_own_transport`, `license_type`, `license_document`, `english_spoken_lavel`, `english_written_lavel`, `english_reading_lavel`, `criminal_record_1`, `criminal_record_2`, `criminal_record_3`, `unspent_convictions`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'',	NULL,	3,	'+917003047213',	NULL,	NULL,	NULL,	NULL,	'2013-01-01',	'0000-00-00',	NULL,	NULL,	'2025-02-28',	'Student',	'yes',	'/uploads/applications/addresses/address-65baa2548e967.png',	'yes',	'Full UK Driving License',	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-13 15:13:14',	'2023-09-24 19:36:27',	NULL),
(2,	2,	'',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2030-06-05',	NULL,	NULL,	'2029-10-18',	'Dependant',	NULL,	'/uploads/applications/addresses/address-65b94e7948cc1.png',	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-01-30 19:32:24',	'2023-09-27 06:22:24',	NULL),
(3,	3,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-12-12',	NULL,	NULL,	'1994-05-05',	'Dependant',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-22 11:14:40',	'2024-02-22 11:14:40',	NULL),
(4,	4,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2031-06-17',	NULL,	NULL,	'2025-06-17',	'Dependent',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-26 11:08:19',	'2024-02-26 11:08:19',	NULL);

DROP TABLE IF EXISTS `workers_classes`;
CREATE TABLE `workers_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `university_letter` text,
  `monday_start` time DEFAULT NULL,
  `monday_end` time DEFAULT NULL,
  `tuesday_start` time DEFAULT NULL,
  `tuesday_end` time DEFAULT NULL,
  `wednesday_start` time DEFAULT NULL,
  `wednesday_end` time DEFAULT NULL,
  `thursday_start` time DEFAULT NULL,
  `thursday_end` time DEFAULT NULL,
  `friday_start` time DEFAULT NULL,
  `friday_end` time DEFAULT NULL,
  `saturday_start` time DEFAULT NULL,
  `saturday_end` time DEFAULT NULL,
  `sunday_start` time DEFAULT NULL,
  `sunday_end` time DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_classes` (`id`, `worker_id`, `start_date`, `end_date`, `university_letter`, `monday_start`, `monday_end`, `tuesday_start`, `tuesday_end`, `wednesday_start`, `wednesday_end`, `thursday_start`, `thursday_end`, `friday_start`, `friday_end`, `saturday_start`, `saturday_end`, `sunday_start`, `sunday_end`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(4,	1,	'2023-04-01',	'2025-03-31',	NULL,	'10:00:55',	'17:00:00',	'10:00:06',	'17:00:14',	'10:00:20',	'17:00:25',	'10:00:32',	'17:00:45',	'10:00:38',	'17:00:50',	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-02-13 15:13:14',	'2023-09-27 08:08:34',	NULL),
(5,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2024-01-30 19:32:24',	'2024-01-30 19:32:24',	NULL);

DROP TABLE IF EXISTS `workers_documents`;
CREATE TABLE `workers_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_documents` (`id`, `worker_id`, `document_type_id`, `document`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	2,	10,	'/uploads/applications/addresses/address-65b94e7948cc1.png',	NULL,	'2024-01-30 19:32:24',	'2024-01-30 19:32:24',	NULL),
(2,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:41:13',	'2024-01-31 19:41:13',	NULL),
(3,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:41:22',	'2024-01-31 19:41:22',	NULL),
(4,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:41:41',	'2024-01-31 19:41:41',	NULL),
(5,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:42:14',	'2024-01-31 19:42:14',	NULL),
(6,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:43:44',	'2024-01-31 19:43:44',	NULL),
(7,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:43:48',	'2024-01-31 19:43:48',	NULL),
(8,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-01-31 19:44:07',	'2024-01-31 19:44:07',	NULL),
(9,	1,	10,	'/uploads/applications/addresses/address-65baa2548e967.png',	NULL,	'2024-02-13 15:13:14',	'2024-02-13 15:13:14',	NULL);

DROP TABLE IF EXISTS `workers_employments`;
CREATE TABLE `workers_employments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `no_employment` int(11) NOT NULL DEFAULT '0',
  `employment_position` text,
  `leaving_reason` text,
  `reference_name` char(200) DEFAULT NULL,
  `reference_address` char(200) DEFAULT NULL,
  `reference_phone` char(20) DEFAULT NULL,
  `reference_email` char(64) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `experience_letter` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_employments_references`;
CREATE TABLE `workers_employments_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `reference_name` char(200) DEFAULT NULL,
  `reference_phone` char(20) DEFAULT NULL,
  `reference_email` char(100) DEFAULT NULL,
  `reference_profession` char(100) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_grievances`;
CREATE TABLE `workers_grievances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `grievance_type_id` int(11) NOT NULL,
  `grievance_date` date DEFAULT NULL,
  `grievance_time` time DEFAULT NULL,
  `comments` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_healths`;
CREATE TABLE `workers_healths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `heart_bp` char(10) DEFAULT NULL,
  `asthma_bronchitis_shortness_breath` char(10) DEFAULT NULL,
  `diabetes` char(10) DEFAULT NULL,
  `epilepsy_fainting_attacks` char(10) DEFAULT NULL,
  `migraine` char(10) DEFAULT NULL,
  `severe_head_injury` char(10) DEFAULT NULL,
  `back_problems` char(10) DEFAULT NULL,
  `allergies` char(10) DEFAULT NULL,
  `nut_allergy` char(10) DEFAULT NULL,
  `heart_circulatory_diseases` char(10) DEFAULT NULL,
  `stomach_intestinal_disorders` char(10) DEFAULT NULL,
  `difficulty_sleeping` char(10) DEFAULT NULL,
  `fractures_ligament_damage` char(10) DEFAULT NULL,
  `physical_other_disability` char(10) DEFAULT NULL,
  `psychiatric_mental_illness` char(10) DEFAULT NULL,
  `hospitalised_last_2years` char(10) DEFAULT NULL,
  `suffered_carrier_infectious_diseases` char(10) DEFAULT NULL,
  `registered_disabled` char(10) DEFAULT NULL,
  `tuberculosis` char(10) DEFAULT NULL,
  `skin_trouble_dermatitis` char(10) DEFAULT NULL,
  `indigestive_stomach_trouble` char(10) DEFAULT NULL,
  `chronic_chest_disorders` char(10) DEFAULT NULL,
  `strict_time_medication` char(10) DEFAULT NULL,
  `night_unfitness` char(10) DEFAULT NULL,
  `health_details` text,
  `medication_details` text,
  `disclosure` int(11) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_healths` (`id`, `worker_id`, `heart_bp`, `asthma_bronchitis_shortness_breath`, `diabetes`, `epilepsy_fainting_attacks`, `migraine`, `severe_head_injury`, `back_problems`, `allergies`, `nut_allergy`, `heart_circulatory_diseases`, `stomach_intestinal_disorders`, `difficulty_sleeping`, `fractures_ligament_damage`, `physical_other_disability`, `psychiatric_mental_illness`, `hospitalised_last_2years`, `suffered_carrier_infectious_diseases`, `registered_disabled`, `tuberculosis`, `skin_trouble_dermatitis`, `indigestive_stomach_trouble`, `chronic_chest_disorders`, `strict_time_medication`, `night_unfitness`, `health_details`, `medication_details`, `disclosure`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `workers_payrolls`;
CREATE TABLE `workers_payrolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `account_holder` char(200) DEFAULT NULL,
  `account_number` char(100) DEFAULT NULL,
  `sort_code` char(100) DEFAULT NULL,
  `bank_name` char(100) DEFAULT NULL,
  `other_info` text,
  `primary` char(10) DEFAULT NULL,
  `employee_statement` char(50) DEFAULT NULL,
  `bank_letter` text,
  `have_ni` char(10) DEFAULT NULL,
  `ni_number` char(100) DEFAULT NULL,
  `p45_document` text,
  `p46_document` text,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_payrolls` (`id`, `worker_id`, `account_holder`, `account_number`, `sort_code`, `bank_name`, `other_info`, `primary`, `employee_statement`, `bank_letter`, `have_ni`, `ni_number`, `p45_document`, `p46_document`, `details`, `updated_at`, `created_at`, `deleted_at`) VALUES
(1,	1,	'Surajit Pramanik',	'23568947585',	'SBIN0053664',	'State Bank of India',	NULL,	'yes',	'P46 A',	NULL,	'yes',	'1542632510',	NULL,	NULL,	NULL,	'2024-01-19 19:29:04',	NULL,	NULL);

DROP TABLE IF EXISTS `workers_policies`;
CREATE TABLE `workers_policies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `agreement1` int(11) NOT NULL,
  `agreement2` int(11) NOT NULL,
  `agreement3` int(11) NOT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_references`;
CREATE TABLE `workers_references` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `referee_name` char(200) DEFAULT NULL,
  `referee_phone` char(20) DEFAULT NULL,
  `referee_email` char(64) DEFAULT NULL,
  `referee_profession` char(200) DEFAULT NULL,
  `referee_relationship_id` int(11) NOT NULL,
  `referee_address` text,
  `know_last_5years` char(10) DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `workers_termbreaks`;
CREATE TABLE `workers_termbreaks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `name` char(100) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `details` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `workers_termbreaks` (`id`, `worker_id`, `name`, `from`, `to`, `details`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'Vacation 1',	'2024-02-01',	'2024-02-15',	NULL,	'2024-01-31 19:44:07',	'2024-02-13 15:13:14',	NULL),
(2,	1,	'Vacation 2',	'2024-03-20',	'2024-03-30',	NULL,	'2024-01-31 19:44:07',	'2024-02-13 15:13:14',	NULL);

DROP TABLE IF EXISTS `workers_trainings`;
CREATE TABLE `workers_trainings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) NOT NULL,
  `no_training` int(11) NOT NULL DEFAULT '0',
  `qualification` char(200) DEFAULT NULL,
  `institute` char(200) DEFAULT NULL,
  `award_date` date DEFAULT NULL,
  `course_length` char(100) DEFAULT NULL,
  `institute_contact_name` char(200) DEFAULT NULL,
  `institute_contact_phone` char(20) DEFAULT NULL,
  `institute_contact_email` char(100) DEFAULT NULL,
  `institute_address` text,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `details` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2025-09-21 06:40:44
