
CREATE DATABASE IF NOT EXISTS ETT;

USE ETT;

CREATE TABLE autores (
	  id	int not null auto_increment
	, nombre	varchar(500) null
	, mail		varchar(50) not null
	, ciudad	int	default 0
	, fNacimiento	date
	, personaJuridica	boolean default 1
	, notas		blob
	, avatar	blob
	, PRIMARY KEY (id)
	, UNIQUE KEY mail (mail)

) ENGINE=INNODB;

CREATE TABLE mascotas (
	  id	int not null auto_increment
	, nombre	varchar (100) null
	, apodo		varchar (50)
	, ciudad	int 	default 0
	, avatar	blob
	, PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE autoresmascotas (
	   id	int not null auto_increment
	, autor_id	int not null
	, mascota_id	int not null
	, cuando	date
	, como		varchar(500)
	, donde		varchar(500)
	, PRIMARY KEY (id)
	, INDEX autor_idx  (autor_id)
	, FOREIGN  KEY (autor_id)
		REFERENCES autores(id)
		ON DELETE CASCADE
	, INDEX mascota_idx (mascota_id)
	, FOREIGN KEY (mascota_id)
		REFERENCES mascotas(id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE historias (
	  id	int not null auto_increment
	, titulo	varchar(200) not null
	, fpublicacion	date
	, autor_id	int not null
	, foto		blob
        , texto		blob
	, PRIMARY KEY (id)
	, INDEX autor_idx (autor_id)
	, FOREIGN KEY (autor_id)
	 	REFERENCES autores(id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE historiasmascotas (
	  id int not null auto_increment
	, historia_id	int not null
	, mascota_id	int not null
	, PRIMARY KEY(id)
	, INDEX historia_idx (historia_id)
	, FOREIGN KEY (historia_id)
		REFERENCES historias(id)
		ON DELETE CASCADE
	, INDEX mascota_idx (mascota_id)
	, FOREIGN KEY (mascota_id)
		REFERENCES mascotas (id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE tags (
	  id int not null auto_increment
	, tag	varchar(30) not null
	, PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE historiastag (
	  id int not null auto_increment
	, historia_id	int not null
	, tag_id int not null
	, PRIMARY KEY (id)
	, INDEX historia_idx (historia_id)
	, FOREIGN KEY (historia_id)
		REFERENCES historias (id)
		ON DELETE CASCADE
	, INDEX tags_idx (tag_id)
	, FOREIGN KEY (tag_id)
		REFERENCES tags(id)
		ON DELETE CASCADE
) ENGINE= INNODB;
