First creat the tables
devices
sensors
sensor data

-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(6) unsigned NOT NULL DEFAULT '0',
  `description` varchar(200) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_text` varchar(30) NOT NULL,
  `ipaddress` varchar(30) DEFAULT NULL,
  `latest_value` float DEFAULT NULL,
  PRIMARY KEY (`id_text`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `sensors`
--

DROP TABLE IF EXISTS `sensors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensors` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) DEFAULT NULL,
  `lower_warning_limit` float NOT NULL,
  `higher_warning_limit` float NOT NULL,
  `lower_action_limit` float NOT NULL,
  `higher_action_limit` float NOT NULL,
  `source_device` varchar(200) DEFAULT NULL,
  `source_api` varchar(200) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `UOM` varchar(20) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_text` varchar(30) DEFAULT NULL,
  `ipaddress` varchar(30) DEFAULT NULL,
  `latest_value` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensor_data`
--

DROP TABLE IF EXISTS `sensor_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensor_data` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) DEFAULT NULL,
  `sensor_value` float DEFAULT '9999.9',
  `notes` varchar(200) DEFAULT NULL,
  `reg_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `event_acknowledged` tinyint(1) DEFAULT '0',
  `event_triggered` tinyint(1) DEFAULT '0',
  `id_text` varchar(30) DEFAULT NULL,
  `sensor_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7531 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

#################################### (A) select summary from sensor data table 
MariaDB [projects]> SELECT sensors.description,date(sensor_data.reg_date) as sdate,sensor_data.id_text,count(sensor_data.id) as scount,format(AVG(sensor_value),1) as savg,max(sensor_value) as smax,min(sensor_value)as smin from sensor_data inner join sensors on sensors.id_text = sensor_data.id_text where datediff(date(sensor_data.reg_date),DATE_SUB(CURDATE(), INTERVAL 1 DAY)) = 0 group by sensor_data.id_text;
+------------------------+------------+-------------------------+--------+------+------+------+
| description            | sdate      | id_text                 | scount | savg | smax | smin |
+------------------------+------------+-------------------------+--------+------+------+------+
| Tasmota_Greenhouse     | 2021-05-03 | tasmota_03CA1DDS18B20   |      4 | 14.2 | 14.9 | 13.6 |
| Compost 3 2nd May 2021 | 2021-05-03 | tasmota_4C7759DS18B20-1 |      7 | 6.4  |  9.1 |  4.4 |
| Greenhouse             | 2021-05-03 | tasmota_4C7759DS18B20-2 |      8 | 10.0 |   21 |  6.8 |
+------------------------+------------+-------------------------+--------+------+------+------+
3 rows in set (0.00 sec)
################################### (A) select summary from sensor data table


############(B) select summary from sensor data table and insert into summary table which I used for procedure
insert into summary_sensors (description,sdate,id_text,scount,savg,smax,smin) SELECT sensors.description,date(sensor_data.reg_date) as sdate,sensor_data.id_text,count(sensor_data.id) as scount,format(AVG(sensor_value),1) as savg,max(sensor_value) as smax,min(sensor_value)as smin from sensor_data inner join sensors on sensors.id_text = sensor_data.id_text where datediff(date(sensor_data.reg_date),DATE_SUB(CURDATE(), INTERVAL 1 DAY)) = 0 group by sensor_data.id_text;
############(B) select summary from sensor data table and insert into summary table which I used for procedure


##########(C)procedure using sql query above - and delete yesterday's data from sensor dataworks
delimiter //

CREATE PROCEDURE yesterdays_summary (IN con CHAR(20)) BEGIN insert into summary_sensors (description,sdate,id_text,scount,savg,smax,smin) SELECT sensors.description,date(sensor_data.reg_date) as sdate,sensor_data.id_text,count(sensor_data.id) as scount,format(AVG(sensor_value),1) as savg,max(sensor_value) as smax,min(sensor_value)as smin from sensor_data inner join sensors on sensors.id_text = sensor_data.id_text where datediff(date(sensor_data.reg_date),DATE_SUB(CURDATE(), INTERVAL 1 DAY)) = 0 group by sensor_data.id_text; SELECT SLEEP(1); delete from sensor_data where datediff(date(reg_date),DATE_SUB(CURDATE(), INTERVAL 1 DAY)) = 0; END//
###########(C)procedure using sql query above - works


##################(D) - schedule to call yesterday's summary daily - tried this and worked but duplicate might be other event which i removed
CREATE EVENT daily_summary ON SCHEDULE EVERY '1' DAY STARTS '2012-05-05 1:00:00' DO CALL yesterdays_summary('');END
##################(D) - schedule to call yesterday's summary daily - tried this and worked but duplicate might be other event which i removed

POINTS TO NOTE 
id_text must be set as primary key in devices table
alter table devices ADD CONSTRAINT main_id PRIMARY KEY (`id_text`);
then during autodiscovery the 'insert ignore' construct prevents duplicte device records
insert ignore into projects.devices (description,ipaddress,id_text) values ("tasmota_4C7759-5977","192.168.8.114","tasmota_4C7759");



