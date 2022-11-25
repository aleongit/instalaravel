
/*borra schema si existeix*/
DROP SCHEMA IF EXISTS instalaravel;

CREATE SCHEMA IF NOT EXISTS instalaravel DEFAULT CHARACTER SET utf8mb4 ;
USE instalaravel ;

/*user*/
DROP USER IF EXISTS 'instalaravel'@'%';
CREATE USER 'instalaravel'@'%' IDENTIFIED BY '1234';

/*GRANT type_of_permission ON database_name.table_name TO 'username'@'localhost';*/
GRANT ALL PRIVILEGES ON instalaravel.* TO 'instalaravel'@'%' with grant option;
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'instalaravel'@'%';

/*
CREATE DATABASE IF NOT EXISTS instalaravel;
USE instalaravel;
*/

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
role            varchar(20),
name            varchar(100),
surname         varchar(200),
nick            varchar(100),
email           varchar(255),
password        varchar(255),
image           varchar(255) default 'NOIMG.png',
created_at      datetime,
updated_at      datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

/*
INSERT INTO users VALUES(NULL, 'user', 'Maria', 'Garcia', 'mgarci', 'maria@maria.com', 'pass', null, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Joan', 'Lopez', 'joanlopez', 'joan@joan.com', 'pass', null, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'Manel', 'Cots', 'manelc', 'manel@manel.com', 'pass', null, CURTIME(), CURTIME(), NULL);
*/
INSERT INTO `users` VALUES 
(1,'user','Capita','Enciam','capitaenciam','capitaenciam@gmail.com','$2y$10$Z1LzfXkLgKADsI0/i3ANKO7YAWcyaPj7vVxqVhsLdCaIz1gKF4AVC','CAPITA-ENCIAM_20220412163915.png',current_date(),current_date(),NULL),
(2,'user','Capita','Haddock','capitahaddock','capitahaddock@gmail.com','$2y$10$Z1LzfXkLgKADsI0/i3ANKO7YAWcyaPj7vVxqVhsLdCaIz1gKF4AVC','CAPITA_20220412164555.png',current_date(),current_date(),NULL),
(3,'user','Matusalem','Junior','Matusalem','matusalem@gmail.com','$2y$10$Z1LzfXkLgKADsI0/i3ANKO7YAWcyaPj7vVxqVhsLdCaIz1gKF4AVC','MUTEN_20220412171459.png',current_date(),current_date(),NULL);

CREATE TABLE IF NOT EXISTS images(
id              int(255) auto_increment not null,
user_id         int(255),
image_path      varchar(255),
description     text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

/*
INSERT INTO images VALUES(NULL, 1, 'test.jpg', 'descripció 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'platja.jpg', 'descripció 2', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 1, 'arena.jpg', 'descripció 3', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, 3, 'familia.jpg', 'descripció 4', CURTIME(), CURTIME());
*/
INSERT INTO `images` VALUES 
(1,1,'ENCIAM_20220412164210.png','Els petits canvis són poderosos!','2022-01-01 16:42:10','2022-01-01 16:42:10'),
(2,1,'LLIMONER_20220412164321.jpg','Ohhh aquest any llimonada!','2022-04-01 16:43:21','2022-04-01 16:43:21'),
(3,2,'LLAMPS_20220412164634.jpg','Llamps i trons! quin bon dia que fa!','2022-04-05 16:46:34','2022-04-05 16:46:34'),
(4,2,'ALPACA_20220412164805.jpg','Llamp de rellamp! però què és això!?','2022-04-12 16:48:05','2022-04-12 16:48:05'),
(5,3,'275303540_2062332150607191_8777816168377824433_n_20220412171716.jpg','Treballant amb alegria i seguretat','2022-04-02 17:17:16','2022-04-02 17:17:16'),
(6,3,'272739857_2027635360743537_5090617828773684104_n_20220412172006.jpg','Muntant els semàfors per l\'Eixample','2022-04-11 17:20:06','2022-04-11 17:20:06'),
(7,3,'272699229_2027637467409993_2071924336730918412_n_20220412172250.jpg','No la vam començar per la teulada','2022-04-12 17:22:50','2022-04-12 17:22:50'),
(8,3,'275112389_2058891900951216_5629215912292035679_n_20220412172338.jpg','El meu primer dron','2022-04-12 17:23:38','2022-04-12 17:23:38');

CREATE TABLE IF NOT EXISTS comments(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
content         text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

/*
INSERT INTO comments VALUES(NULL, 1, 4, 'Bona foto de familia!!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 1, 'Buena foto de platja!!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, 2, 4, 'q xulo!!', CURTIME(), CURTIME());
*/
INSERT INTO `comments` VALUES 
(null,1,4,'Una alpaca cap de suro!','2022-04-12 16:49:45','2022-04-12 16:49:45'),
(null,2,4,'Ves a plantar escaroles!','2022-04-12 16:51:13','2022-04-12 16:51:13'),
(null,2,1,'ets molt pesat! tros de quòniam!','2022-04-12 16:54:47','2022-04-12 16:54:47'),
(null,2,2,'ja vindré a agafar-ne!','2022-04-12 17:00:31','2022-04-12 17:00:31'),
(null,1,2,'Ni t\'atreveixis! Mico de gitano empeltat de rata sàvia!','2022-04-12 17:04:13','2022-04-12 17:04:13'),
(null,2,2,'A veure si m\'atrapes saltabardisses!','2022-04-12 17:05:21','2022-04-12 17:05:21'),
(null,1,3,'No tindrem la sort que te\'n caigui un!','2022-04-12 17:08:49','2022-04-12 17:08:49'),
(null,2,3,'No tindrem la sort que et caigui a tu! Capità de pa sucat amb oli!','2022-04-12 17:10:44','2022-04-12 17:10:44'),
(null,3,2,'nens no us baralleu!','2022-04-12 17:28:19','2022-04-12 17:28:19'),
(null,3,3,'nens quiets!','2022-04-12 17:28:55','2022-04-12 17:28:55');


CREATE TABLE IF NOT EXISTS likes(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

/*
INSERT INTO likes VALUES(NULL, 1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, 2, 1, CURTIME(), CURTIME());
*/
INSERT INTO `likes` VALUES 
(1,1,4,'2022-04-12 16:49:15','2022-04-12 16:49:15'),
(2,1,3,'2022-04-12 16:55:16','2022-04-12 16:55:16'),
(3,2,2,'2022-04-12 16:58:55','2022-04-12 16:58:55'),
(4,2,1,'2022-04-12 17:13:00','2022-04-12 17:13:00'),
(5,1,8,'2022-04-12 17:26:39','2022-04-12 17:26:39'),
(6,1,7,'2022-04-12 17:26:42','2022-04-12 17:26:42'),
(7,1,6,'2022-04-12 17:26:49','2022-04-12 17:26:49'),
(8,1,5,'2022-04-12 17:26:56','2022-04-12 17:26:56'),
(9,3,4,'2022-04-12 17:27:20','2022-04-12 17:27:20'),
(10,3,3,'2022-04-12 17:27:31','2022-04-12 17:27:31'),
(11,3,2,'2022-04-12 17:27:38','2022-04-12 17:27:38'),
(12,3,1,'2022-04-12 17:27:43','2022-04-12 17:27:43'),
(13,2,8,'2022-04-12 17:29:58','2022-04-12 17:29:58'),
(14,2,7,'2022-04-12 17:30:01','2022-04-12 17:30:01'),
(15,2,6,'2022-04-12 17:30:09','2022-04-12 17:30:09'),
(16,2,5,'2022-04-12 17:30:14','2022-04-12 17:30:14');