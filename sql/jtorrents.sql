-- Create database.

DROP DATABASE jtorrents;
CREATE DATABASE jtorrents;
USE jtorrents;


-- Create tables with no dependencies.

CREATE TABLE roles (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
name VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY(id)
);

CREATE TABLE torrent_categories (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
name VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY(id)
);

CREATE TABLE inquiry_categories (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
name VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY(id)
);


-- Create tables with dependencies.

CREATE TABLE users (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
username VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL UNIQUE,
date_created TIMESTAMP
DEFAULT CURRENT_TIMESTAMP,
role_id INT,
PRIMARY KEY(id),
FOREIGN KEY(role_id)
REFERENCES roles(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

CREATE TABLE torrents (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
file_count INT NOT NULL,
file_size INT NOT NULL,
source VARCHAR(255) NOT NULL UNIQUE,
cover VARCHAR(255) NOT NULL UNIQUE,
date_created TIMESTAMP
DEFAULT CURRENT_TIMESTAMP,
user_id INT,
torrent_category_id INT,
PRIMARY KEY(id),
FOREIGN KEY(user_id)
REFERENCES users(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(torrent_category_id)
REFERENCES torrent_categories(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

-- CREATE TABLE ratings (
-- id INT NOT NULL UNIQUE AUTO_INCREMENT,
-- positive INT NOT NULL,
-- negative INT NOT NULL,
-- date_created TIMESTAMP
-- DEFAULT CURRENT_TIMESTAMP,
-- user_id INT,
-- torrent_id INT,
-- PRIMARY KEY(id),
-- FOREIGN KEY(user_id)
-- REFERENCES users(id)
-- ON UPDATE CASCADE
-- ON DELETE SET NULL,
-- FOREIGN KEY(torrent_id)
-- REFERENCES torrents(id)
-- ON UPDATE CASCADE
-- ON DELETE SET NULL
-- );

CREATE TABLE comments (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
message TEXT NOT NULL,
date_created TIMESTAMP
DEFAULT CURRENT_TIMESTAMP,
user_id INT,
torrent_id INT,
PRIMARY KEY(id),
FOREIGN KEY(user_id)
REFERENCES users(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(torrent_id)
REFERENCES torrents(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

CREATE TABLE messages (
id INT UNIQUE AUTO_INCREMENT,
subject TEXT NOT NULL,
message TEXT NOT NULL,
date_created TIMESTAMP
DEFAULT CURRENT_TIMESTAMP,
user_id INT,
message_id INT,
PRIMARY KEY(id),
FOREIGN KEY(user_id)
REFERENCES users(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(message_id)
REFERENCES messages(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

CREATE TABLE inquiries (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
inquiry_category_id INT,
message_id INT,
PRIMARY KEY(id),
FOREIGN KEY(inquiry_category_id)
REFERENCES inquiry_categories(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(message_id)
REFERENCES messages(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

CREATE TABLE torrent_reports (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
torrent_id INT,
message_id INT,
PRIMARY KEY(id),
FOREIGN KEY(torrent_id)
REFERENCES torrents(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(message_id)
REFERENCES messages(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);

CREATE TABLE comment_reports (
id INT NOT NULL UNIQUE AUTO_INCREMENT,
comment_id INT,
message_id INT,
PRIMARY KEY(id),
FOREIGN KEY(comment_id)
REFERENCES comments(id)
ON UPDATE CASCADE
ON DELETE SET NULL,
FOREIGN KEY(message_id)
REFERENCES messages(id)
ON UPDATE CASCADE
ON DELETE SET NULL
);


-- Insert records to tables with no dependencies.

INSERT INTO roles (name) VALUES
('Admin'),
('Member');

INSERT INTO torrent_categories (name) VALUES
('Anime'),
('Apps'),
('Books'),
('Games'),
('Movies'),
('Music'),
('TV'),
('Other');

INSERT INTO inquiry_categories (name) VALUES
('Rules'),
('Uploading'),
('Downloading'),
('Seeding'),
('Ratio'),
('Donation'),
('Copyright'),
('Other');


-- Insert records to tables with dependencies.

INSERT INTO users (username, password, email, role_id) VALUES
('admin', '7110EDA4D09E062AA5E4A390B0A572AC0D2C0220', 'admin@jt.com', 1);

-- INSERT INTO torrents (name, description, file_count, file_size, source, cover, user_id, torrent_category_id) VALUES
-- ('Name 1', 'Description 1', 1, 1, 'Source 1', 'Cover 1', 1, 1),
-- ('Name 2', 'Description 2', 2, 2, 'Source 2', 'Cover 2', 1, 1),
-- ('Name 3', 'Description 3', 3, 3, 'Source 3', 'Cover 3', 1, 1),
-- ('Name 4', 'Description 4', 4, 4, 'Source 4', 'Cover 4', 1, 2),
-- ('Name 5', 'Description 5', 5, 5, 'Source 5', 'Cover 5', 1, 2),
-- ('Name 6', 'Description 6', 6, 6, 'Source 6', 'Cover 6', 1, 2),
-- ('Name 7', 'Description 7', 7, 7, 'Source 7', 'Cover 7', 1, 3),
-- ('Name 8', 'Description 8', 8, 8, 'Source 8', 'Cover 8', 1, 3),
-- ('Name 9', 'Description 9', 9, 9, 'Source 9', 'Cover 9', 1, 3),
-- ('Name 10', 'Description 10', 10, 10, 'Source 10', 'Cover 10', 1, 4),
-- ('Name 11', 'Description 11', 11, 11, 'Source 11', 'Cover 11', 1, 4),
-- ('Name 12', 'Description 12', 12, 12, 'Source 12', 'Cover 12', 1, 4),
-- ('Name 13', 'Description 13', 13, 13, 'Source 13', 'Cover 13', 1, 5),
-- ('Name 14', 'Description 14', 14, 14, 'Source 14', 'Cover 14', 1, 5),
-- ('Name 15', 'Description 15', 15, 15, 'Source 15', 'Cover 15', 1, 5),
-- ('Name 16', 'Description 16', 16, 16, 'Source 16', 'Cover 16', 1, 6),
-- ('Name 17', 'Description 17', 17, 17, 'Source 17', 'Cover 17', 1, 6),
-- ('Name 18', 'Description 18', 18, 18, 'Source 18', 'Cover 18', 1, 6),
-- ('Name 19', 'Description 19', 19, 19, 'Source 19', 'Cover 19', 1, 7),
-- ('Name 20', 'Description 20', 20, 20, 'Source 20', 'Cover 20', 1, 7),
-- ('Name 21', 'Description 21', 21, 21, 'Source 21', 'Cover 21', 1, 7),
-- ('Name 22', 'Description 22', 22, 22, 'Source 22', 'Cover 22', 1, 8),
-- ('Name 23', 'Description 23', 23, 23, 'Source 23', 'Cover 23', 1, 8),
-- ('Name 24', 'Description 24', 24, 24, 'Source 24', 'Cover 24', 1, 8),
-- ('Name 25', 'Description 25', 25, 25, 'Source 25', 'Cover 25', 1, 8);

-- INSERT INTO comments (message, user_id, torrent_id) VALUES
-- ('Comment 1', 1, 1),
-- ('Comment 2', 1, 1),
-- ('Comment 3', 1, 1),
-- ('Comment 4', 1, 2),
-- ('Comment 5', 1, 2),
-- ('Comment 6', 1, 2),
-- ('Comment 7', 1, 3),
-- ('Comment 8', 1, 3),
-- ('Comment 9', 1, 3),
-- ('Comment 10', 1, 4),
-- ('Comment 11', 1, 4),
-- ('Comment 12', 1, 4),
-- ('Comment 13', 1, 5),
-- ('Comment 14', 1, 5),
-- ('Comment 15', 1, 5),
-- ('Comment 16', 1, 6),
-- ('Comment 17', 1, 6),
-- ('Comment 18', 1, 6),
-- ('Comment 19', 1, 7),
-- ('Comment 20', 1, 7);

INSERT INTO messages (id, subject, message, user_id, message_id) VALUES
(1, 'ADMIN', 'ADMIN', 1, 1);

-- INSERT INTO messages (subject, message, user_id, message_id) VALUES
-- ('Inquiry 1', 'Inquiry Message 1', 1, 2),
-- ('Inquiry 2', 'Inquiry Message 2', 1, 3),
-- ('Inquiry 3', 'Inquiry Message 3', 1, 4),
-- ('Inquiry 4', 'Inquiry Message 4', 1, 5),
-- ('Inquiry 5', 'Inquiry Message 5', 1, 6),
-- ('Inquiry 6', 'Inquiry Message 6', 1, 7),
-- ('Inquiry 7', 'Inquiry Message 7', 1, 8),
-- ('Inquiry 8', 'Inquiry Message 8', 1, 9),
-- ('Inquiry 9', 'Inquiry Message 9', 1, 10),
-- ('Inquiry 10', 'Inquiry Message 10', 1, 11),
-- ('T-Report 1', 'T-Report Message 1', 1, 12),
-- ('T-Report 2', 'T-Report Message 2', 1, 13),
-- ('T-Report 3', 'T-Report Message 3', 1, 14),
-- ('T-Report 4', 'T-Report Message 4', 1, 15),
-- ('T-Report 5', 'T-Report Message 5', 1, 16),
-- ('T-Report 6', 'T-Report Message 6', 1, 17),
-- ('T-Report 7', 'T-Report Message 7', 1, 18),
-- ('T-Report 8', 'T-Report Message 8', 1, 19),
-- ('T-Report 9', 'T-Report Message 9', 1, 20),
-- ('T-Report 10', 'T-Report Message 10', 1, 21),
-- ('C-Report 1', 'C-Report Message 1', 1, 22),
-- ('C-Report 2', 'C-Report Message 2', 1, 23),
-- ('C-Report 3', 'C-Report Message 3', 1, 24),
-- ('C-Report 4', 'C-Report Message 4', 1, 25),
-- ('C-Report 5', 'C-Report Message 5', 1, 26),
-- ('C-Report 6', 'C-Report Message 6', 1, 27),
-- ('C-Report 7', 'C-Report Message 7', 1, 28),
-- ('C-Report 8', 'C-Report Message 8', 1, 29),
-- ('C-Report 9', 'C-Report Message 9', 1, 30),
-- ('C-Report 10', 'C-Report Message 10', 1, 31);

-- INSERT INTO inquiries (inquiry_category_id, message_id) VALUES
-- (1, 2),
-- (1, 3),
-- (2, 4),
-- (2, 5),
-- (3, 6),
-- (4, 7),
-- (5, 8),
-- (6, 9),
-- (7, 10),
-- (8, 11);

-- INSERT INTO torrent_reports (torrent_id, message_id) VALUES
-- (1, 12),
-- (2, 13),
-- (3, 14),
-- (4, 15),
-- (5, 16),
-- (6, 17),
-- (7, 18),
-- (8, 19),
-- (9, 20),
-- (10, 21);

-- INSERT INTO comment_reports (comment_id, message_id) VALUES
-- (1, 22),
-- (2, 23),
-- (3, 24),
-- (4, 25),
-- (5, 26),
-- (6, 27),
-- (7, 28),
-- (8, 29),
-- (9, 30),
-- (10, 31);
