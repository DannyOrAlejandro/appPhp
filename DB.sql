CREATE DATABASE appphp;
CREATE TABLE usuarios(
    ID int(11) NOT NULL AUTO_INCREMENT,
    user_name varchar(30) NOT NULL,
    email varchar(40) NOT NULL,
    number varchar(12) NOT NULL,
    password varchar(100) NOT NULL,
    PRIMARY KEY(ID)
);
CREATE TABLE imgs(
    ID INT(11) NOT NULL AUTO_INCREMENT,
    img MEDIUMBLOB NOT NULL,
    user_id int(11) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users FOREIGN KEY(user_id)REFERENCES usuarios(ID),
    tipoDeImg varchar(20),
    PRIMARY KEY(ID)
);