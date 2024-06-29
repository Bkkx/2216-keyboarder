DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_id_UNIQUE` (`category_id`),
  UNIQUE KEY `category_name_UNIQUE` (`category_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

INSERT INTO `category` VALUES (5,'barebone'),(2,'cables'),(4,'keyboard'),(3,'keycaps'),(1,'switches');

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_fname` varchar(45) COLLATE utf8mb3_bin DEFAULT NULL,
  `customer_lname` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `customer_address` longtext COLLATE utf8mb3_bin NOT NULL,
  `customer_number` int NOT NULL,
  `customer_password` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `customer_points` int NOT NULL DEFAULT '0',
  `customer_joindate` DATE COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_id_UNIQUE` (`customer_id`),
  UNIQUE KEY `customer_email_UNIQUE` (`customer_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  `product_cost` double NOT NULL,
  `category_id` int unsigned NOT NULL,
  `product_sd` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `product_ld` longtext COLLATE utf8mb3_bin,
  `product_quantity` int NOT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_id_UNIQUE` (`product_id`),
  UNIQUE KEY `product_name_UNIQUE` (`product_name`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;



DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `order_quantity` int NOT NULL,
  `order_tracking_no` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_id_UNIQUE` (`order_id`),
  KEY `product_id_idx` (`product_id`),
  KEY `customer_id_idx` (`customer_id`),
  CONSTRAINT `customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

INSERT INTO `product` VALUES (1,'Kailh Box White',0.15,1,'Clicky Switch','Kailh Box switches have their signature box around a cross-shaped MX style stem which protects the switch from dust and moisture - giving it an IP56 resistance rating.',50),(2,'CableMod Pro Coiled',49.9,2,'Keyboard Cable','Elevate your keyboard setup to the next level with the CableMod Pro Keyboard Cable. Made for keyboards with a USB-C port, this coiled keyboard cable is sleeved with both ModFlex and ModMesh sleeving, and is the ultimate accessory to make your keyboard setup pop.',10),(3,'Pikachu Keycaps',79.9,3,'OEM Profile','Might not fit for Razer, Steelseries, Corsair, Logitec, Etc. If you`re unsure about this, please enquire as via IG DM @thekapco',5),(4,'Keychron K2',79.9,4,'Wireless','The Keychron K2 (Version 2) is a decent entry-level mechanical keyboard. Its small and compact design makes it fairly easy to carry around, and you shouldn`t have to worry about damaging it thanks to its excellent build quality.',5),(5,'Tecware Veil 87',85,5,'DIY Kit','Removable Type-C Cable, Southfacing per-key RGB PCB, 5-pin Mechanical Switch Compatible, Modular Kailh Switch Sockets, EVA PCB to Plate Dampener, Silicon Case Dampener, Key Remapping through Software, Customizable Fn1 Layer, RGB illumination, Compatible with Win XP,Vista 7,8,10, NKRO/87 Keys TKL Layout, Windows Key Disable, 1.8m Braided USB cable, Switch Keycap Puller Included, 1 Years Local Manufacturer Warranty',8);

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `admin_id` int unsigned NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(45) COLLATE utf8mb3_bin NOT NULL,
  `admin_password` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_id_UNIQUE` (`admin_id`),
  UNIQUE KEY `admin_email_UNIQUE` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;
