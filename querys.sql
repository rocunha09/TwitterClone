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