CREATE TABLE IF NOT EXISTS `parkamon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `breed` text,
  `location` text,
  PRIMARY KEY (`id`)
);

INSERT INTO `parkamon` 
	(`breed`, `location`) 
VALUES
	('Bulbacoat', 'forest'),
	('Tentacoat', 'shore'),
	('Articoato', 'tundra'),
	('Parkachu', 'forest'),
	('Magicoat', 'shore'),
	('Coatster', 'tundra'),
	('Jacketlypuff', 'sky'),
	('Dragoncoat', 'sky'),
	('Parkawhirl', 'shore');

CREATE TABLE IF NOT EXISTS `player` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(10),
	`password_hash` varchar(64),
	PRIMARY KEY (`id`)
);
	
INSERT INTO player
	(`name`, `password_hash`)
VALUES
    ('Parthenia', '$2y$10$Uc2MGBbfLE12WgRLMLp2iunQoMn1USVmd5rOxkzKyDYtJQWv4W8.a'),
	('Tomika', '$2y$10$/l9SUQqYDTz0AYY4xLZbGepLbwWbl8tP62pJRQFRbcvlCuJXsTzqa'),
	('Kip', '$2y$10$OxEYGhKdsmnsQScu9wcn4ONlYDX5EwuPTvoZjkfd0etQ4YlbylyKC'),
	('Imelda', '$2y$10$4PIdQRGlLDz78fKDtpHDEeisiwmOdbtJn4JnuQ7nZVZ.e8Heg/FA6'),
	('Geoffrey', '$2y$10$Xu51JzZf9TIRCcIg26hrL.tmg1pxvXf7ZnQaS1Ys4Jv402p8JBJkq'),
	('Shanel', '$2y$10$EWRPL7frameMLpLf7VqLIO6uQv5d0Ce6y3ARDNBFLuhB1iBXVZREe'),
	('Lilliana', '$2y$10$rDF0WlFo8IP3Ceu5i1maaOA98.9mkDjvPi0W9Q6fJSuGA4SKLx2e6'),
	('Deloris', '$2y$10$4sxlyUjxzpLmqgD18l42bOCZwwesvCfXSv6zgzB.vL6wmsMS3ptV.'),
	('Giovanna', '$2y$10$pzSBWacaqvN4YYnat6urbuLqC1dtqzveFXismnDs5HKviDPY4LHTW'),
	('Suanne', '$2y$10$IZ2nVrgzgOHYN6Kalg6RlubMITjXQZDIMVz1mLAA8tPcVSYUuapY.');

CREATE TABLE IF NOT EXISTS `ownership` (
	`id` int NOT NULL AUTO_INCREMENT, 
	`player_id` int,
	`parkamon_id` int,
	`nickname` varchar(8),
	PRIMARY KEY (`id`)
);