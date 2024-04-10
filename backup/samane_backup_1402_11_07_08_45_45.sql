

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO colors VALUES("1","سبز");
INSERT INTO colors VALUES("2","صورتی");
INSERT INTO colors VALUES("3","قرمز");



CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO materials VALUES("1","طرح1");
INSERT INTO materials VALUES("2","طرح2");



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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO primaryproduct VALUES("15","تست1","999999119921020.1","عدد","","","1402/10/11","222");
INSERT INTO primaryproduct VALUES("16","محصول 43","44444414260248.39","گرم","","","1402/10/07","3434");



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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO primaryproductreport VALUES("1","تست1","","","1402/10/13","33333333","حسین شاکر","increase","33333333");
INSERT INTO primaryproductreport VALUES("2","محصول 43","","","1402/10/05","2147483647","حسین شاکر","increase","2147483647");
INSERT INTO primaryproductreport VALUES("3","تست1","","","1402/10/08","90000000","حسین شاکر","increase","123189697");
INSERT INTO primaryproductreport VALUES("4","تست1","","","1402/10/05","2147483647","حسین شاکر","increase","2147483647");
INSERT INTO primaryproductreport VALUES("5","تست1","","","1402/10/07","2147483647","حسین شاکر","deduction","0");
INSERT INTO primaryproductreport VALUES("6","تست1","","","1402/10/28","2147483647","حسین شاکر","increase","2147483647");



CREATE TABLE `product_inputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_input` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_number` int(11) NOT NULL,
  `idoutput` int(11) NOT NULL,
  `username` int(11) NOT NULL,
  `by_member` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;




CREATE TABLE `product_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_materials VALUES("1","1","محصول نهایی 1","15","2");
INSERT INTO product_materials VALUES("2","1","محصول نهایی 1","16","1");
INSERT INTO product_materials VALUES("3","2","محصول تست11114545","15","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_outputs VALUES("1","9719108926","1402/11/02","10","1","طرح1","سبز","{"15":"20","16":"10"}","حسین شاکر","2");
INSERT INTO product_outputs VALUES("2","5802725615","1402/11/02","10","2","طرح1","صورتی","[]","حسین شاکر","1");
INSERT INTO product_outputs VALUES("3","5802725615","1402/11/02","10","2","طرح1","صورتی","[]","حسین شاکر","1");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `salary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO products VALUES("1","محصول نهایی 1","5555555 ");
INSERT INTO products VALUES("2","محصول تست11114545","0 ");



CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `stock` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO users VALUES("1","حسین احمدی","");
INSERT INTO users VALUES("2","طاهره شاکر","");



CREATE TABLE `users_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `material_id` float NOT NULL,
  `material_number` float NOT NULL,
  `Surplus` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO users_stock VALUES("1","2","15","348","0");
INSERT INTO users_stock VALUES("2","2","16","395","0");

