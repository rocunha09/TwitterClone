create database twitter_clone;

use twitter_clone;

create table usuarios(
	id int not null primary key AUTO_INCREMENT,
	nome varchar(100) not null,
	email varchar(150) not null,
	senha varchar(32) not null
);

//para atualização dos campos anteriores que já haviam sido salvos, os valores agora são convertidos para md5
update usuarios set senha = md5(senha) WHERE id in(1, 2); //alterar este update de acordo com a quantidade de usuários cadastrados durante os testes.


//criação da tabela de tweets:

create table tweets(
                       id int not null PRIMARY KEY AUTO_INCREMENT,
                       id_usuario int not null,
                       tweet varchar(140) not null,
                       data datetime default current_timestamp
);