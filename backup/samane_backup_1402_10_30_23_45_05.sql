

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;




CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;




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

INSERT INTO primaryproduct VALUES("15","تست1","9999991121040.11","عدد","","","1402/10/11","222");
INSERT INTO primaryproduct VALUES("16","محصول 43","44444414260258.39","گرم","","","1402/10/07","3434");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;




CREATE TABLE `product_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_materials VALUES("1","1","محصول نهایی 1","15","2");
INSERT INTO product_materials VALUES("2","1","محصول نهایی 1","16","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO product_outputs VALUES("157","9673611851","1402/10/01","60","1","","","{"15":"120","16":"60"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("158","7025741760","1402/10/01","10","1","","","{"15":"40","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("159","5092689549","1402/10/01","10","1","","","{"15":"0","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("160","6809931986","1402/10/01","10","1","","","{"15":"0","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("161","1025564611","1402/10/01","10","1","","","{"15":"0","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("162","3339398047","1402/10/01","10","1","","","{"15":"0","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("163","8782323465","1402/10/01","10","1","","","{"15":"20","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("164","8777249850","1402/10/01","10","1","","","{"15":"20","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("165","3517369859","1402/10/01","10","1","","","{"15":"20","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("166","842223218","1402/10/01","10","1","","","{"15":"60","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("167","4989428952","1402/10/01","10","1","","","{"15":"20","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("168","8732460278","1402/10/01","10","1","","","{"15":"40","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("169","6012347176","1402/10/01","10","1","","","{"15":"20/54","16":"10"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("170","4118521654","1402/10/01","10","1","","","{"15":"20","16":"0"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("171","8978551626","1402/10/01","10","1","","","{"15":"20","16":"0"}","حسین شاکر","1");
INSERT INTO product_outputs VALUES("172","4429616988","1402/10/01","10","1","","","{"15":"20","16":"50"}","حسین شاکر","1");



CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `salary` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO products VALUES("1","محصول نهایی 1","5555555 ");



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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

INSERT INTO users_stock VALUES("15","1","15","360.37","0");
INSERT INTO users_stock VALUES("16","1","16","220","20");

