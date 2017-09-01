
INSERT INTO `admin_menu` VALUES (1,0,'Dashboard',1,500,'2017-09-01 14:42:45','2017-09-01 14:43:14',NULL);
INSERT INTO `admin_menu` VALUES (2,0,'Admin',0,500,'2017-09-01 14:43:25','2017-09-01 14:43:25',NULL);
INSERT INTO `admin_menu` VALUES (3,2,'路由管理',2,500,'2017-09-01 14:43:40','2017-09-01 14:43:40',NULL);
INSERT INTO `admin_menu` VALUES (4,2,'菜单管理',3,500,'2017-09-01 14:43:56','2017-09-01 14:43:56',NULL);
INSERT INTO `admin_menu` VALUES (5,2,'角色管理',4,500,'2017-09-01 14:43:58','2017-09-01 14:44:27',NULL);
INSERT INTO `admin_menu` VALUES (6,2,'用户管理',5,500,'2017-09-01 14:44:41','2017-09-01 14:44:41',NULL);


INSERT INTO `admin_router` VALUES (1,'Dashboard','/home','','GET','admin.home','T',500,'2017-09-01 14:41:23','2017-09-01 14:41:23',NULL);
INSERT INTO `admin_router` VALUES (2,'路由管理','/router','','GET','admin.router','T',500,'2017-09-01 14:41:41','2017-09-01 14:41:41',NULL);
INSERT INTO `admin_router` VALUES (3,'菜单管理','/menu','','GET','admin.menu','T',500,'2017-09-01 14:41:56','2017-09-01 14:41:56',NULL);
INSERT INTO `admin_router` VALUES (4,'角色管理','/role','','GET','admin.role','T',500,'2017-09-01 14:42:12','2017-09-01 14:42:12',NULL);
INSERT INTO `admin_router` VALUES (5,'用户管理','/user','','GET','admin.user','T',500,'2017-09-01 14:42:27','2017-09-01 14:42:27',NULL);
