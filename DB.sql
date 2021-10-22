CREATE DATABASE danny;
CREATE TABLE usuarios(
    ID int(11) NOT NULL AUTO_INCREMENT,
    user_name varchar(10) NOT NULL,
    password varchar(100) NOT NULL,
    perfil_img mediumblob NOT NULL,
    email varchar(40) NOT NULL,
    tipoDeImg varchar(20),
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