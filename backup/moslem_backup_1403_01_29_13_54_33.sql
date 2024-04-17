

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products VALUES("1","سومیت ساده","100","30","201");
INSERT INTO products VALUES("2","سومیت پلاس","101","55","139");
INSERT INTO products VALUES("3","طرحدار پلاس","103","77","593");



CREATE TABLE `products_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_data` text NOT NULL,
  `entry_id` text NOT NULL,
  `products_quantity` text NOT NULL,
  `login_id` text NOT NULL,
  `clock` text NOT NULL,
  `date` text NOT NULL,
  `user` text NOT NULL,
  `user_edited` text NOT NULL,
  `comment` text NOT NULL,
  `foroshande_name` text NOT NULL,
  `foroshande_phone` int(11) NOT NULL,
  `name_ranande` text NOT NULL,
  `phone_ranande` int(11) NOT NULL,
  `pelak_khodro` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_input VALUES("3","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"10"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"20"},{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"30"}]","451684858704558299","","","۱۷:۰۰","1403/01/27","","","","","0","","0","");
INSERT INTO products_input VALUES("4","[{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"103"}]","349912993038912281","","","۱۷:۱۴","1403/01/13","","","","","0","","0","");
INSERT INTO products_input VALUES("5","[{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"103"}]","349912993038912281","","","۱۷:۱۴","1403/01/13","","","","","0","","0","");
INSERT INTO products_input VALUES("6","[{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"250"}]","741593623241957524","","","۱۷:۱۸","1403/01/30","","","","","0","","0","");
INSERT INTO products_input VALUES("7","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"200"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"100"},{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"500"}]","226820574669530570","","","۱۳:۱۴","1403/01/15","حسین شاکر","","نداررررررررد","تولیدی مسلم","91700000","کشاورز","2147483647","ایران63");



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
  `phone_ranande` int(11) NOT NULL,
  `pelak_khodro` text NOT NULL,
  `shomareh_bargkhoroj` int(11) NOT NULL,
  `kharidar_name` text NOT NULL,
  `kharidar_phone` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

INSERT INTO products_output VALUES("3","36601890988449234","1403/01/26","۱۷:۳۷","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"5"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"12"}]","","","","","0","","0","","0");
INSERT INTO products_output VALUES("4","684841577629918764","1403/01/21","۱۷:۴۶","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"2"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"5"},{"product_id":"3","product_name":"u0637u0631u062du062fu0627u0631 u067eu0644u0627u0633","productqr":"103","quantity":"7"}]","","","","","0","","0","","0");
INSERT INTO products_output VALUES("5","229661967512587409","1403/01/19","۱۴:۴۲","[{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"2"}]","حسین شاکر","","","","0","","0","","0");
INSERT INTO products_output VALUES("6","809755281524874305","1403/01/01","۱۲:۴۰","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"1"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"2"}]","حسین شاکر","","","","0","","0","","0");
INSERT INTO products_output VALUES("7","809755281524874305","1403/01/01","۱۲:۴۰","[{"product_id":"1","product_name":"u0633u0648u0645u06ccu062a u0633u0627u062fu0647","productqr":"100","quantity":"1"},{"product_id":"2","product_name":"u0633u0648u0645u06ccu062a u067eu0644u0627u0633","productqr":"101","quantity":"2"}]","حسین شاکر","","ندارد چیزی","سهیلا قاسمی","939780","13ق976ایران93","2000000","عباس صادقی","917700");

