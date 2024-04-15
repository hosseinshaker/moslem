

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

INSERT INTO products VALUES("1","سومیت ساده","100","500","0");
INSERT INTO products VALUES("2","سومیت پلاس","101","55","0");
INSERT INTO products VALUES("3","طرحدار پلاس","103","77","0");



CREATE TABLE `products_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` text NOT NULL,
  `products_name` text NOT NULL,
  `productsqr` text NOT NULL,
  `products_quantity` text NOT NULL,
  `login_id` text NOT NULL,
  `clock` text NOT NULL,
  `date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;


