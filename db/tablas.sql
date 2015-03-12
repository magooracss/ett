
CREATE DATABASE IF NOT EXISTS ETT;

USE ETT;

CREATE TABLE authors (
	  id	int not null auto_increment
	, name		varchar(500) null
	, mail		varchar(50) not null
	, password	varchar(30) 
	, city		int	default 0
	, birthday	date
	, isHuman	boolean default 1
	, notes		blob
	, avatar	blob
	, PRIMARY KEY (id)
	, UNIQUE KEY mail (mail)

) ENGINE=INNODB;

CREATE TABLE pets (
	  id	int not null auto_increment
	, name	varchar (100) null
	, nickname	varchar (50)
	, city		int 	default 0
	, avatar	blob
	, PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE authorspets (
	   id	int not null auto_increment
	, author_id	int not null
	, pet_id	int not null
	, whenMet	date
	, howMet	varchar(500)
	, whereMet	varchar(500)
	, PRIMARY KEY (id)
	, INDEX author_idx  (author_id)
	, FOREIGN  KEY (author_id)
		REFERENCES authors(id)
		ON DELETE CASCADE
	, INDEX pet_idx (pet_id)
	, FOREIGN KEY (pet_id)
		REFERENCES pets(id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE tales (
	  id	int not null auto_increment
	, subject	varchar(200) not null
	, published	date
	, author_id	int not null
	, image		blob
        , story		blob
	, PRIMARY KEY (id)
	, INDEX author_idx (author_id)
	, FOREIGN KEY (author_id)
	 	REFERENCES authors(id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE talespets (
	  id int not null auto_increment
	, tale_id	int not null
	, pet_id	int not null
	, PRIMARY KEY(id)
	, INDEX tale_idx (tale_id)
	, FOREIGN KEY (tale_id)
		REFERENCES tales(id)
		ON DELETE CASCADE
	, INDEX pet_idx (pet_id)
	, FOREIGN KEY (pet_id)
		REFERENCES pets (id)
		ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE tags (
	  id int not null auto_increment
	, tag	varchar(30) not null
	, PRIMARY KEY (id)
) ENGINE=INNODB;

CREATE TABLE talestag (
	  id int not null auto_increment
	, tale_id	int not null
	, tag_id int not null
	, PRIMARY KEY (id)
	, INDEX tale_idx (tale_id)
	, FOREIGN KEY (tale_id)
		REFERENCES tales (id)
		ON DELETE CASCADE
	, INDEX tags_idx (tag_id)
	, FOREIGN KEY (tag_id)
		REFERENCES tags(id)
		ON DELETE CASCADE
) ENGINE= INNODB;
