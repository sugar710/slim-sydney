-- -----------------------------------------------------
-- Table `admin_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '用户名称',
  `avatar` VARCHAR(50) NOT NULL COMMENT '头像地址',
  `username` VARCHAR(45) NOT NULL COMMENT '登录账号',
  `password` VARCHAR(60) NOT NULL COMMENT '用户密码',
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
  `id` INT NULL AUTO_INCREMENT,
  `admin_role_id` INT NOT NULL,
  `admin_user_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '用户角色关联表';


-- -----------------------------------------------------
-- Table `admin_permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_permission` (
  `id` INT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL COMMENT '权限名称',
  `slug` VARCHAR(45) NOT NULL COMMENT '权限标记',
  `created_at` DATETIME NOT NULL,
  `updated_at` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_slug` (`slug` ASC))
ENGINE = InnoDB
COMMENT = '权限';


-- -----------------------------------------------------
-- Table `admin_role_permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_role_permission` (
  `id` INT NULL AUTO_INCREMENT,
  `admin_role_id` INT NOT NULL,
  `admin_permission_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '角色权限关联表';


-- -----------------------------------------------------
-- Table `admin_menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` INT NULL AUTO_INCREMENT,
  `pid` INT NOT NULL DEFAULT 0,
  `name` VARCHAR(45) NOT NULL COMMENT '菜单名称',
  `router` VARCHAR(45) NOT NULL COMMENT '路由请求地址',
  `slug` VARCHAR(45) NOT NULL COMMENT '菜单标记 - 权限标记',
  `query` VARCHAR(45) NOT NULL COMMENT '请求参数',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `index_slug` (`slug` ASC))
ENGINE = InnoDB
COMMENT = '菜单管理';


-- -----------------------------------------------------
-- Table `admin_user_permission`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_user_permission` (
  `id` INT NULL AUTO_INCREMENT,
  `admin_user_id` INT NOT NULL,
  `admin_permission_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '用户权限关联表';


-- -----------------------------------------------------
-- Table `setting`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `setting` (
  `id` INT NULL AUTO_INCREMENT,
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
  `id` INT NULL AUTO_INCREMENT,
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
  `id` INT NULL AUTO_INCREMENT,
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
  `id` INT NULL AUTO_INCREMENT,
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
  `id` INT NULL AUTO_INCREMENT,
  `article_id` INT NOT NULL COMMENT '文章ID',
  `content` VARCHAR(150) NOT NULL COMMENT '评论内容',
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '评论';
