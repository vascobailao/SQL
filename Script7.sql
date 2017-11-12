DELIMITER ;
-- desativa a verificaÃ§Ãµ das chaves estrangeiras
SET foreign_key_checks = 0 ;

SET SQL_SAFE_UPDATES = 0;

TRUNCATE TABLE DimDate;
TRUNCATE TABLE DimLoc;
TRUNCATE TABLE TabFac;

SET foreign_key_checks = 1 ;
SET SQL_SAFE_UPDATES = 1;


DROP TABLE IF EXISTS TabFac;
CREATE TABLE TabFac (
maxl INT NOT NULL, 
localid INT NOT NULL,
dateid DATE NOT NULL,
FOREIGN KEY (localid) REFERENCES DimLoc(localid),
FOREIGN KEY (dateid) REFERENCES DimDate(dateid));







DROP TABLE IF EXISTS DimLoc;
CREATE TABLE DimLoc (
localid INT NOT NULL,
conc VARCHAR (80) NULL,
regiao VARCHAR (80) NULL,
PRIMARY KEY (localid));


DROP TABLE IF EXISTS DimDate;
CREATE TABLE DimDate (
dateid DATE NOT NULL,
ano INT NOT NULL,
mes INT NOT NULL,
dia INT NOT NULL,
PRIMARY KEY (dateid));


INSERT INTO DimLoc (localid,conc,regiao) VALUES
(1,"RA Acores","Norte"),
(2,"RA Madeira","Norte"),
(3,"RA Madeira","Sul"),
(4,"RA Madeira","Este"),
(5,"Ilhas Selvagens","Este"),
(6,"Ilhas Selvagens","Oeste"),
(7,"Ilhas Selvagens","Norte"),
(8,"Mar Continental","Sul"),
(9,"Mar Continental","Norte"),
(10,"Mar Acores","Norte"),
(11,"Mar Madeira","Norte"),
(12,"Mar Madeira","Sul"),
(13,"Mar Madeira","Este"),
(14,"Ilhas Selvagens","Este"),
(15,"Ilhas Selvagens","Oeste"),
(16,"Ilhas Selvagens","Norte"),
(17,"Mar Continental","Sul"),
(18,"Mar Continental","Norte"),
(19,"RA Acores","Norte"),
(20,"RA Madeira","Norte"),
(21,"RA Madeira","Sul"),
(22,"RA Madeira","Este"),
(23,"Ilhas Selvagens","Este"),
(24,"Ilhas Selvagens","Oeste"),
(25,"Ilhas Selvagens","Norte"),
(26,"Mar Continental","Sul"),
(27,"Mar Continental","Norte"),
(28,"RA Acores","Norte"),
(29,"RA Madeira","Norte"),
(30,"RA Madeira","Sul"),
(31,"RA Madeira","Este"),
(32,"Ilhas Selvagens","Este"),
(33,"Ilhas Selvagens","Oeste"),
(34,"Ilhas Selvagens","Norte"),
(35,"Mar Continental","Sul"),
(36,"Mar Continental","Norte"),
(37,"RA Acores","Norte"),
(38,"RA Acores","Norte"),
(39,"RA Acores","Norte"),
(40,"RA Acores","Norte"),
(41,"RA Acores","Norte");





INSERT INTO DimDate (dateid,ano,mes,dia) VALUES
("2014-10-01",2014,10,1),
("2014-10-02",2014,10,2),
("2012-10-01", 2012, 10,1),
("2013-10-01", 2013,10,1);




INSERT INTO TabFac (maxl,localid,dateid) SELECT  max(E.valor),E.leilao,R.dia from lance E, leilaor R where E.leilao=R.lid group by E.leilao;
