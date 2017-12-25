-- -----------------------------------------------------
-- Table `admin_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '用户名称',
  `avatar` VARCHAR(50) NOT NULL COMMENT '头像地址',
  `username` VARCHAR(45) NOT NULL COMMENT '登录账号',
  `password` VARCHAR(60) NOT NULL COMMENT '用户密码',
  `email` VARCHAR(200) NOT NULL COMMENT '邮箱',
  `is_lock` ENUM('T', 'F') NOT NULL DEFAULT 'F' COMMENT '是否锁定',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '用户';


-- -----------------------------------------------------
-- Table `admin_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(50) NOT NULL,
  `created_at` DATETIME NOT NULL COMMENT '						',
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_slug` (`slug` ASC))
ENGINE = InnoDB
COMMENT = '角色';


-- -----------------------------------------------------
-- Table `admin_user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_user_role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '用户角色关联表';


-- -----------------------------------------------------
-- Table `admin_router`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_router` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL COMMENT '路由名称',
  `path` VARCHAR(80) NOT NULL COMMENT '路由地址',
  `query` VARCHAR(100) NOT NULL COMMENT '附加参数',
  `method` ENUM('GET', 'POST', 'PUT', 'DELETE', 'OPTION') NOT NULL DEFAULT 'GET',
  `slug` VARCHAR(50) NOT NULL COMMENT '路由标记',
  `status` ENUM('T', 'F') NOT NULL DEFAULT 'T' COMMENT '启用状态',
  `sort` INT NOT NULL DEFAULT 500,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '管理后台路由表';


-- -----------------------------------------------------
-- Table `admin_menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pid` INT NOT NULL DEFAULT 0,
  `name` VARCHAR(45) NOT NULL COMMENT '菜单名称',
  `router_id` INT UNSIGNED NOT NULL,
  `sort` INT NOT NULL DEFAULT 500,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '菜单管理';


-- -----------------------------------------------------
-- Table `setting`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `setting` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(50) NOT NULL,
  `value` VARCHAR(150) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '系统配置';


-- -----------------------------------------------------
-- Table `category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '分类名称',
  `slug` VARCHAR(45) NOT NULL COMMENT '分类标记',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '分类';


-- -----------------------------------------------------
-- Table `article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `article` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL COMMENT '文章分类ID',
  `title` VARCHAR(150) NOT NULL COMMENT '文章标题',
  `content` TEXT NOT NULL COMMENT '文章内容',
  `img` VARCHAR(150) NOT NULL COMMENT '封面图',
  `view_cnt` INT NOT NULL DEFAULT 0 COMMENT '点击数',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '文章表';


-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tags` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '标签名称',
  `use_cnt` INT NOT NULL DEFAULT 0 COMMENT '使用数量',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '标签';


-- -----------------------------------------------------
-- Table `article_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `article_tag` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tag_id` INT NOT NULL COMMENT '标签ID',
  `article_id` INT NOT NULL COMMENT '文章ID',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '文章标签关联表';


-- -----------------------------------------------------
-- Table `comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `article_id` INT NOT NULL COMMENT '文章ID',
  `content` VARCHAR(150) NOT NULL COMMENT '评论内容',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '评论';


-- -----------------------------------------------------
-- Table `admin_role_router`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_role_router` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `router_id` INT UNSIGNED NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `admin_user_router`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_user_router` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `router_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `operation_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `operation_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL DEFAULT 0,
  `method` VARCHAR(45) NOT NULL DEFAULT 'GET',
  `path` VARCHAR(45) NOT NULL DEFAULT '/',
  `ip` VARCHAR(15) NOT NULL DEFAULT '0.0.0.0',
  `input` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '操作日志';
