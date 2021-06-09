CREATE TABLE todo (
    id int NOT NULL AUTO_INCREMENT,
    description varchar(255),
    responsible varchar(255),
    action varchar(500),
    reg_date TIMESTAMP,
    status tinyint default 0,
    PRIMARY KEY (id)
);
