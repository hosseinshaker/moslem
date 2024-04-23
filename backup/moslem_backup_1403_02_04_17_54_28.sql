

CREATE TABLE `admintable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `name` varchar(99) NOT NULL,
  `type` varchar(99) NOT NULL,
  `access` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO admintable VALUES("1","hossein","1234","حسین شاکر","superAdmin","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26");



CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` text NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO options VALUES("1","گروه تولیدی مسلم","bbb.png");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `productqr` int(11) NOT NULL,
  `minStock` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `pack` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products VALUES("1","سومیت ساده","1000","300","0","4");
INSERT INTO products VALUES("2","سومیت پلاس فنری","1002","500","0","4");
INSERT INTO products VALUES("3","سومیت پلاس تسمه دار","1003","500","0","4");
INSERT INTO products VALUES("4","صندلی کمپینگ","1005","200","4","4");
INSERT INTO products VALUES("5","صندلی یاوند","1001","540","17","5");
INSERT INTO products VALUES("6","میز استراکچر","1004","100","134","6");



CREATE TABLE `products_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_data` text NOT NULL,
  `entry_id` text NOT NULL,
  `clock` text NOT NULL,
  `date` text NOT NULL,
  `user` text NOT NULL,
  `user_edited` text NOT NULL,
  `comment` text NOT NULL,
  `foroshande_name` text NOT NULL,
  `foroshande_phone` text NOT NULL,
  `name_ranande` text NOT NULL,
  `phone_ranande` text NOT NULL,
  `pelak_khodro` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_input VALUES("1","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/023644597","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("2","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/034281872","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("3","{"2":{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"8"},"3":{"product_id":"6","product_name":"میز استراکچر","productqr":"1004","quantity":"144"}}","955888","13:08","1403/02/31","ییی","","ببب8888","گروه ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("4","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/047180503","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("5","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/049690083","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("6","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/048554990","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("7","{"2":{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633 u0641u0646u0631u06cc","productqr":"1002","quantity":"4"},"3":{"product_id":"4","product_name":"u0635u0646u062fu0644u06cc u06a9u0645u067eu06ccu0646u06af","productqr":"1005","quantity":"8"}}","1403/02/049331124","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","","","");



CREATE TABLE `products_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exit_id` text NOT NULL,
  `date` text NOT NULL,
  `clock` text NOT NULL,
  `product_data` text NOT NULL,
  `user` text NOT NULL,
  `user_edited` text NOT NULL,
  `comment` text NOT NULL,
  `name_ranande` text NOT NULL,
  `phone_ranande` text NOT NULL,
  `pelak_khodro` text NOT NULL,
  `shomareh_bargkhoroj` int(11) NOT NULL,
  `kharidar_name` text NOT NULL,
  `kharidar_phone` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;


