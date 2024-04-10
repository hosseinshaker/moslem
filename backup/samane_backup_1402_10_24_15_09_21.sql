

CREATE TABLE `admintable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(99) NOT NULL,
  `password` varchar(99) NOT NULL,
  `name` varchar(99) NOT NULL,
  `type` varchar(99) NOT NULL,
  `access` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO admintable VALUES("1","hossein","1234","حسین شاکر","superAdmin","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26");



CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colorname` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO colors VALUES("1","صورتی");
INSERT INTO colors VALUES("2","سبز");
INSERT INTO colors VALUES("3","آبی");
INSERT INTO colors VALUES("4","قرمز");
INSERT INTO colors VALUES("5","مشکی");



CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO materials VALUES("1","گلبهی");



CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` text NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO options VALUES("1","گروه تولیدی شیراز کاور","bbb.png");



CREATE TABLE `primaryproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `productCount` text NOT NULL,
  `productType` text NOT NULL,
  `productPattern` text NOT NULL,
  `productColor` text NOT NULL,
  `entryDate` text NOT NULL,
  `minStock` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO primaryproduct VALUES("1","پارچه تترون","9999242","سانتی متر","گلبهی","آبی","1402/10/01","100");



CREATE TABLE `primaryproductreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productName` text NOT NULL,
  `productPattern` text NOT NULL,
  `productColor` text NOT NULL,
  `date` text NOT NULL,
  `value` int(11) NOT NULL,
  `user` text NOT NULL,
  `status` text NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO primaryproductreport VALUES("1","پارچه تترون","گلبهی","آبی","1402/10/01","1000","حسین شاکر","increase","1000");
INSERT INTO primaryproductreport VALUES("2","پارچه تترون","گلبهی","آبی","1402/10/08","500","حسین شاکر","deduction","500");
INSERT INTO primaryproductreport VALUES("3","پارچه تترون","گلبهی","آبی","1402/10/26","9999999","حسین شاکر","increase","10000479");



CREATE TABLE `product_inputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_input` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_number` int(11) NOT NULL,
  `idoutput` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `by_member` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_inputs VALUES("1","1402/10/08","2","33","32223","1","حسین شاکر");



CREATE TABLE `product_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_materials VALUES("1","1","محصول تست شماره1","1","100");
INSERT INTO product_materials VALUES("2","2","محصول تستی2","1","37.5");



CREATE TABLE `product_outputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idoutput` text NOT NULL,
  `date_output` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_pattern` text NOT NULL,
  `product_color` text NOT NULL,
  `materials` text NOT NULL,
  `by_member` text NOT NULL,
  `username` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_outputs VALUES("1","1847648224","1402/10/01","10","1","گلبهی","سبز","{"1":"50"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("2","3570203073","1402/10/05","33","2","گلبهی","سبز","{"1":"1237.5"}","حسین شاکر","1");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `salary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO products VALUES("1","محصول تست شماره1","45000 ");
INSERT INTO products VALUES("2","محصول تستی2","20000 ");



CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `stock` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO users VALUES("1","عباس بوعذار","");
INSERT INTO users VALUES("2","غلی امامی","");



CREATE TABLE `users_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `material_id` float NOT NULL,
  `material_number` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO users_stock VALUES("1","1","1","20");

