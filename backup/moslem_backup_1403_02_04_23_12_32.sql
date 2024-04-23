

CREATE TABLE `admintable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(99) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(99) COLLATE utf8_persian_ci NOT NULL,
  `type` varchar(99) COLLATE utf8_persian_ci NOT NULL,
  `access` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO admintable VALUES("1","hossein","1234","حسین شاکر","superAdmin","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26");



CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` text COLLATE utf8_persian_ci NOT NULL,
  `logo` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO options VALUES("1","گروه تولیدی مسلم","bbb.png");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text COLLATE utf8mb4_persian_ci NOT NULL,
  `productqr` int(11) NOT NULL,
  `minStock` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `pack` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products VALUES("1","سومیت ساده","1000","300","2900","4");
INSERT INTO products VALUES("2","سومیت پلاس فنری","1002","500","550","4");
INSERT INTO products VALUES("3","سومیت پلاس تسمه دار","1003","500","1449","4");
INSERT INTO products VALUES("4","صندلی کمپینگ","1005","200","2455","4");
INSERT INTO products VALUES("5","صندلی یاوند","1001","540","955","5");
INSERT INTO products VALUES("6","میز استراکچر","1004","100","14437","6");
INSERT INTO products VALUES("19","xxxxxx","4444","234234","500","324234");



CREATE TABLE `products_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_data` text COLLATE utf8mb4_persian_ci NOT NULL,
  `entry_id` text COLLATE utf8mb4_persian_ci NOT NULL,
  `clock` text COLLATE utf8mb4_persian_ci NOT NULL,
  `date` text COLLATE utf8mb4_persian_ci NOT NULL,
  `user` text COLLATE utf8mb4_persian_ci NOT NULL,
  `user_edited` text COLLATE utf8mb4_persian_ci NOT NULL,
  `comment` text COLLATE utf8mb4_persian_ci NOT NULL,
  `foroshande_name` text COLLATE utf8mb4_persian_ci NOT NULL,
  `foroshande_phone` text COLLATE utf8mb4_persian_ci NOT NULL,
  `name_ranande` text COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_ranande` text COLLATE utf8mb4_persian_ci NOT NULL,
  `pelak_khodro` text COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_input VALUES("8","[{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"}]","140302047583841","20:50","1403/02/04","حسین شاکر","","","گروه تولیدی مسلم","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("10","[{"product_id":"","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"2"},{"product_id":"","product_name":"سومیت ساده","productqr":"1000","quantity":"4"}]","140302043365341","22:58","1403/02/04","حسین شاکر","","","گروه تولیدی مسلم","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");



CREATE TABLE `products_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exit_id` text COLLATE utf8mb4_persian_ci NOT NULL,
  `date` text COLLATE utf8mb4_persian_ci NOT NULL,
  `clock` text COLLATE utf8mb4_persian_ci NOT NULL,
  `product_data` text COLLATE utf8mb4_persian_ci NOT NULL,
  `user` text COLLATE utf8mb4_persian_ci NOT NULL,
  `user_edited` text COLLATE utf8mb4_persian_ci NOT NULL,
  `comment` text COLLATE utf8mb4_persian_ci NOT NULL,
  `name_ranande` text COLLATE utf8mb4_persian_ci NOT NULL,
  `phone_ranande` text COLLATE utf8mb4_persian_ci NOT NULL,
  `pelak_khodro` text COLLATE utf8mb4_persian_ci NOT NULL,
  `shomareh_bargkhoroj` int(11) NOT NULL,
  `kharidar_name` text COLLATE utf8mb4_persian_ci NOT NULL,
  `kharidar_phone` text COLLATE utf8mb4_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;


