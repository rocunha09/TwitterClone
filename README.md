# TwitterClone

Obs.: Projeto elaborado durante estudos MVC com PHP

Este repositório contém um clone do Twitter utilizando mini framework criado no repositório: [miniframework-MVC-PHP](https://github.com/rocunha09/miniframework-MVC-PHP.git)

O objetivo este projeto é praticar a criação de aplicações utilizando MVC desta forma foi realizado:
- Criação de todas as rotas para funcionamento da aplicação
- Interação com banco de dados (CRUD). 
- Consultas com subconsultas SQL.
- Utilização de POO em todo projeto e variações de uso
- Uso de Bootstrap 4 no frontEnd incluindo uso de paginação de tweets.
-realizado deploy local (XAMPP), e hostgator.
- E muito mais.

Para rodar e testar a aplicação pode-se ativar um servidor php a partir do cmd com o comando ``php -S localhost:8080``, desta forma o servidor irá iniciar na porta 8080 da máquina para fins de desenvolvimento.

Foi utilizado MySql, para isso pode-se usar a seu critério outro banco de dados, ou diretamente o que é oferecido pelo Xampp(por exemplo) e para fins de desenvolvimento utilizado a aplicação phpmyadmin nativa do Xampp.

Obs.: para facilitar o uso baixe e instale o Xampp, e adicione o caminho da pasta php(que está no diretório do Xampp nas variáveis de ambiente do seu sistema operacional para possibilitar rodar no terminal do sistema operacional o comando para ativar o servidor local.

Para uso da aplicação realizando deploy local deve-se seguir os seguintes passos:
- Criação do banco de dados e tabelas (para isto use as querys presentes no arquivo querys.sql).
- Ajuste do arquivo Connection.php (colocar os parâmetros de conexão com seu MySql e nome do banco de dados Ex.: twitter ou twitter_clone).
- Inserir os arquivos da pasta public diretamente em htdocs (para que o Xampp entenda que quando a aplicação for acessada pelo browser partirá deste ponto através do arquivo index.php)
- Criar um novo diretório na raiz do Xampp chamado twitter_clone, e mover para dentro dele os demais arquivos que compõe a aplicação.
- Alterar os caminhos de inclusão de scripts em index.php(da pasta htdocs) e Action.php( que está em MF>Controller lá dentro da pasta twitter_clone criada anteriormente), 
- Realizar alteração dos caminhos dos "includes" de scripts (é necessário realizar pois os scripts foram movidos para um novo nível de diretório, e assim deve-se ajustá-los (ex.: em index.php: require_once "../twitter_clone/vendor/autoload.php"; e em Action.php: ../twitter_clone/App/Views/ (sendo 3 pontos necessários para esta alteração).
- Inserir o novo arquivo .htaccess na pasta public (este novo arquivo se encontra no diretório: "htaccesse para deploy no xampp".

Pronto! basta abrir o navegador e acesar http://localhost/ e será direcionado tela de login da aplicação.
