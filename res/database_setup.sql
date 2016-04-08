CREATE TABLE guests (

	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	name TEXT,
	group_id VARCHAR(30),
	arrival_info VARCHAR(100),
	return_info VARCHAR(100),
	shoe_size VARCHAR(40),
	accommodation VARCHAR(40),
	food VARCHAR(100),
	age VARCHAR(40),
	agent VARCHAR(20),
	payed VARCHAR(40),
	comment TEXT,

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;

CREATE TABLE groups (

	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	creator VARCHAR(30),
	group_number VARCHAR(30),
	group_name VARCHAR(30),
	start_date date,
	end_date date,
	confirmed VARCHAR(30),
	comfort VARCHAR(30),
	group_type VARCHAR(30),
	group_skill VARCHAR(30),
	transportation VARCHAR(30),
	comment TEXT,

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;

CREATE TABLE news (

	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	creator VARCHAR(30),
	header VARCHAR(30),
	content TEXT,
	link TEXT,
	linktext VARCHAR(30),
	image TEXT,
	data_route VARCHAR(30),
	position INTEGER,

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;

CREATE TABLE photos (

	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	creator VARCHAR(30),
	header VARCHAR(30),
	content TEXT,
	link_url TEXT,
	link_text VARCHAR(30),
	image_url TEXT,
	link_alt VARCHAR(30),

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;

CREATE TABLE bookings (

	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	creator VARCHAR(30),
	type VARCHAR(30),
	start_date date,
	end_date date,
	number_of_people INTEGER,
	linktext VARCHAR(30),
	name VARCHAR(40),
	email VARCHAR(50),
	phone VARCHAR(30),
	adress VARCHAR(150),
	country VARCHAR(30),
	people TEXT,

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;

CREATE TABLE people (

	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
	datetime TIMESTAMP,

	name TEXT,
	group_id VARCHAR(30),
	arrival_info VARCHAR(100),
	return_info VARCHAR(100),
	shoe_size VARCHAR(40),
	accommodation VARCHAR(40),
	food VARCHAR(10),
	age VARCHAR(40),
	agent VARCHAR(20),
	payed VARCHAR(40),
	comment TEXT,

	PRIMARY KEY (id)
) AUTO_INCREMENT = 100;
