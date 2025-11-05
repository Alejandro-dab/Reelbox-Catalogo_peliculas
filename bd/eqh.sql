drop database IF EXISTS  eqh;
CREATE database eqh; 
USE eqh;      
        
CREATE TABLE Peliculas(
	id_peli INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre_peli VARCHAR (50) NOT NULL,
    imagen_url_peli TEXT NOT NULL, 
    sinopsis_peli TEXT
);

USE eqh; 
SELECT * FROM Peliculas;  

DELETE FROM Peliculas WHERE id_peli= 3; 


