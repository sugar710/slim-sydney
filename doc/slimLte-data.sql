-- 创建菜单
INSERT INTO `admin_menu` VALUES (1,0,'Dashboard',1,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_menu` VALUES (2,0,'Admin',0,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_menu` VALUES (3,2,'路由管理',2,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_menu` VALUES (4,2,'菜单管理',3,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_menu` VALUES (5,2,'角色管理',4,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_menu` VALUES (6,2,'用户管理',5,500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);

-- 创建路由
INSERT INTO `admin_router` VALUES (1,'Dashboard','/home','','GET','admin.home','T',500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_router` VALUES (2,'路由管理','/router','','GET','admin.router','T',500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_router` VALUES (3,'菜单管理','/menu','','GET','admin.menu','T',500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_router` VALUES (4,'角色管理','/role','','GET','admin.role','T',500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);
INSERT INTO `admin_router` VALUES (5,'用户管理','/user','','GET','admin.user','T',500,'2017-11-11 00:00:00','2017-11-11 00:00:00',NULL);

-- 创建角色
INSERT INTO `admin_role` VALUES (1,'超级管理员','root','2017-11-11 00:00:00','2017-11-11 00:00:00');

-- 创建角色用户关联 - 超管
INSERT INTO `admin_user_role` VALUES (1,1,1);