CREATE TABLE `fps_web_players`(
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nickname` VARCHAR(255) NOT NULL,
    `steam_id` VARCHAR(255) NOT NULL UNIQUE KEY,
    `avatar_icon` varchar(255) NOT NULL,
    `avatar_full` varchar(255) NOT NULL
);