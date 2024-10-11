CREATE DATABASE IF NOT EXISTS GASYSTEM;
USE GASYSTEM;

CREATE TABLE IF NOT EXISTS users(
    id int not null primary key auto_increment,
    role varchar(20) not null DEFAULT 'gestor',
    name varchar(100) not null,
    lastname varchar(100) not null,
    email varchar(100) not null,
    passowrd TEXT,
    created_at datetime,
    updated_at datetime
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS environments(
    id int not null primary key auto_increment,
    name varchar(100) not null,
    capacity varchar(100) not null,
    availability varchar(100) not null,
    created_at datetime,
    updated_at datetime
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS implements(
    id int not null primary key auto_increment,
    name varchar(100) not null,
    status varchar(100) not null,
    environment_id int not null,
    created_at datetime,
    updated_at datetime,

    CONSTRAINT fk_environments_implements FOREIGN KEY (environment_id) REFERENCES environments(id)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS schedule(
    id int not null primary key auto_increment,
    environment_id int not null,
    date date,
    hour time,
    user_id int not null,
    created_at datetime,
    updated_at datetime,

    CONSTRAINT fk_schedule_environments FOREIGN KEY (environment_id) REFERENCES environments(id),
    CONSTRAINT fk_schedule_users FOREIGN KEY (user_id) REFERENCES users(id)
)Engine=InnoDB;