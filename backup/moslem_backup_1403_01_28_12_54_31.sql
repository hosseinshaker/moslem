

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



CREATE TABLE `input_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_name` text NOT NULL,
  `products_id` int(11) NOT NULL,
  `products_count` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `clock` int(11) NOT NULL,
  `input_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;




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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products VALUES("1","سومیت ساده","100","30","3");
INSERT INTO products VALUES("2","سومیت پلاس","101","55","45");
INSERT INTO products VALUES("3","طرحدار پلاس","103","77","93");



CREATE TABLE `products_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` text NOT NULL,
  `product_data` text NOT NULL,
  `entry_id` text NOT NULL,
  `products_quantity` text NOT NULL,
  `login_id` text NOT NULL,
  `clock` text NOT NULL,
  `date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_input VALUES("3","","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"10"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"20"},{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"30"}]","451684858704558299","","","۱۷:۰۰","1403/01/27");
INSERT INTO products_input VALUES("4","","[{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"103"}]","349912993038912281","","","۱۷:۱۴","1403/01/13");
INSERT INTO products_input VALUES("5","","[{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"103"}]","349912993038912281","","","۱۷:۱۴","1403/01/13");
INSERT INTO products_input VALUES("6","","[{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"250"}]","741593623241957524","","","۱۷:۱۸","1403/01/30");



CREATE TABLE `products_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exit_id` text NOT NULL,
  `date` text NOT NULL,
  `clock` text NOT NULL,
  `product_data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_output VALUES("3","36601890988449234","1403/01/26","۱۷:۳۷","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"5"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"12"}]");
INSERT INTO products_output VALUES("4","684841577629918764","1403/01/21","۱۷:۴۶","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"2"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"5"},{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"7"}]");

