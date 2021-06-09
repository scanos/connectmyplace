CREATE TABLE todo (
    id int NOT NULL AUTO_INCREMENT,
    description varchar(255),
    responsible varchar(255),
    action varchar(500),
    reg_date TIMESTAMP,
    status tinyint default 0,
    PRIMARY KEY (id)
);
sample output
MariaDB [projects]> insert into todo (description,responsible) values ('weed side garden','sk');
Query OK, 1 row affected (0.019 sec)

MariaDB [projects]> select *  from todo;
+----+------------------+-------------+--------+---------------------+--------+
| id | description      | responsible | action | reg_date            | status |
+----+------------------+-------------+--------+---------------------+--------+
|  1 | weed side garden | sk          | NULL   | 2021-06-09 08:00:09 |      0 |
+----+------------------+-------------+--------+---------------------+--------+
