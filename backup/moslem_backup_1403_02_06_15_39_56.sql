

CREATE TABLE `admintable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `name` varchar(99) NOT NULL,
  `type` varchar(99) NOT NULL,
  `access` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO admintable VALUES("1","hossein","1234","حسین شاکر","superAdmin","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26");
INSERT INTO admintable VALUES("4","abbas","123","عباس","","");



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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products VALUES("1","سومیت ساده","1000","300","30","4");
INSERT INTO products VALUES("2","سومیت پلاس فنری","1002","500","99995","4");
INSERT INTO products VALUES("3","سومیت پلاس تسمه دار","1003","500","995","4");
INSERT INTO products VALUES("4","صندلی کمپینگ","1005","200","50011","4");
INSERT INTO products VALUES("5","صندلی یاوند","1001","540","1790","5");
INSERT INTO products VALUES("6","میز استراکچر","1004","100","1365","6");
INSERT INTO products VALUES("19","صندلی سومیت پلاس طرحدار","1006","100","0","10");
INSERT INTO products VALUES("20","میز طبیعت","1007","100","0","20");
INSERT INTO products VALUES("21","میز دوطبقه","1008","100","8","5");
INSERT INTO products VALUES("22","صندلی نانو پلاس","1009","100","-4","4");
INSERT INTO products VALUES("23","صندلی کف فوم نانو","1010","1000","-210","10");



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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_input VALUES("1","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/023644597","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("2","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/034281872","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("3","[{"product_id":"","product_name":"میز استراکچر","productqr":"1004","quantity":"140"},{"product_id":"","product_name":"سومیت ساده","productqr":"1000","quantity":"48"},{"product_id":"","product_name":"صندلی یاوند","productqr":"1001","quantity":"5"}]","955888","13:08","1403/02/31","ییی","","ببب8888","گروه ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("4","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/047180503","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("5","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/049690083","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("6","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"},{"product_id":"3","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"4"},{"product_id":"2","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"4","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"8"}]","1403/02/048554990","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("7","{"2":{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633 u0641u0646u0631u06cc","productqr":"1002","quantity":"4"},"3":{"product_id":"4","product_name":"u0635u0646u062fu0644u06cc u06a9u0645u067eu06ccu0646u06af","productqr":"1005","quantity":"8"}}","1403/02/049331124","13:17","1403/02/04","حسین شاکر","","سسس","گروه تولیدی ","09038483002","","","");
INSERT INTO products_input VALUES("8","[{"product_id":"","product_name":"سومیت پلاس تسمه دار","productqr":"1003","quantity":"8"},{"product_id":"","product_name":"میز استراکچر","productqr":"1004","quantity":"4"},{"product_id":"","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"4"}]","140302054168521","10:51","1403/02/05","حسین شاکر","","","گروه تولیدی مسلم","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("9","[{"product_id":"","product_name":"میز استراکچر","productqr":"1004","quantity":"4"},{"product_id":"","product_name":"میز استراکچر","productqr":"1004","quantity":"4"}]","140302051026827","11:24","1403/02/05","حسین شاکر","",":))))))))","گروه تولیدی مسلم","09038483002","علی کشاورز","09171393541","77ل222 ایران 93");
INSERT INTO products_input VALUES("10","[{"product_id":"","product_name":"سومیت ساده","productqr":"1000","quantity":"6"},{"product_id":"","product_name":"میز دوطبقه","productqr":"1008","quantity":"3"},{"product_id":"","product_name":"صندلی کمپینگ","productqr":"1005","quantity":"4"}]","140302062841800","22222","22222222","222222","","2222222","22222222","22222222","222222","222222222","2222222");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_output VALUES("1","140302064598508","1403/02/06","10:15","[{"product_id":"","product_name":"صندلی یاوند","productqr":"1001","quantity":"5"},{"product_id":"","product_name":"سومیت پلاس فنری","productqr":"1002","quantity":"4"},{"product_id":"","product_name":"صندلی نانو پلاس","productqr":"1009","quantity":"4"}]","حسین شاکر","حسین شاکر","ببیلبل","علی کشاورز","09171393541","77ل222 ایران 93","6666","تولیدی عباسی","453344");
INSERT INTO products_output VALUES("2","140302061924704","1403/02/06","10:16","[{"product_id":"","product_name":"صندلی کف فوم نانو","productqr":"1010","quantity":"220"}]","حسین شاکر","حسین شاکر","","علی کشاورز","09171393541","77ل222 ایران 93","900251","kkkk","7777777");
INSERT INTO products_output VALUES("3","14030206760840","1403/02/06","10:17","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"9993"}]","حسین شاکر","حسین شاکر","","علی کشاورز","09171393541","77ل222 ایران 93","0","","");
INSERT INTO products_output VALUES("4","140302069019662","1403/02/06","10:17","[{"product_id":"1","product_name":"سومیت ساده","productqr":"1000","quantity":"4"}]","حسین شاکر","حسین شاکر","","علی کشاورز","09171393541","77ل222 ایران 93","0","","");
INSERT INTO products_output VALUES("5","140302061339503","1403/02/06","10:24","[{"product_id":"22","product_name":"صندلی نانو پلاس","productqr":"1009","quantity":"4"}]","حسین شاکر","حسین شاکر","","علی کشاورز","09171393541","77ل222 ایران 93","0","","");

