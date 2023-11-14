DROP DATABASE IF EXISTS workshop_api_biznutz;

CREATE DATABASE workshop_api_biznutz;

USE workshop_api_biznutz;

CREATE TABLE nut (
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(64) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);

INSERT INTO nut (name, stock) VALUES
    ('noix', 150),
    ('noisette', 180),
    ('pistache', 100);
