CREATE TABLE todo (
    id int NOT NULL AUTO_INCREMENT,
    description varchar(255),
    responsible varchar(255),
    action varchar(500),
    status tinyint default 0,
    PRIMARY KEY (id)
);
