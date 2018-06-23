CREATE DATABASE flightfox default CHARSET=utf8;

USE flightfox;

CREATE TABLE todo(
	item VARCHAR(64) NOT NULL,
	priority TINYINT NOT NULL,
	is_completed TINYINT NOT NULL DEFAULT 0
);