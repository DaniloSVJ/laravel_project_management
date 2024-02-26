## Introdução:
Para executar o projeto primeiro vc precisa instalar o composer. Você pode baixá-lo e instalá-lo seguindo as instruções do site oficial do Composer: https://getcomposer.org/download/

Agora vc também precisa instalar o laravel. Use o comando abaixo:

$**_composer global require laravel/installer_**

### Agora instale as libs do projeto com o comando abaixo
$ **_composer install_** 

### Chegou a hora de instalar o mysql. 

Observação: Como não foi solicitado o docker no projeto, então precisa instalar o mysql.

Faça o download do MySQL:
Vá para o site oficial do MySQL (https://dev.mysql.com/downloads/) e faça o download do instalador apropriado para o seu sistema operacional. Não vou orientar como instala o mysql por que vc já é bem gradinho para saber :-D

### Tendo instalado o mysql e estando ele executação crie o banco de dados no servidor mysql com o nome abaixo: 

**project_management**

Crie um arquivo .env . Cole todas as informações que estão no arquivo ‘.env.exemple’. Voce pode também se quiser em vez criar **.env**, da copiar e colar ‘.env.exemple’, e renomear a copia para “.env”. 

Crie todas as tabelas do banco com o comando abaixo:
**php artisan migration**

### Tendo carregado todas as libs chegou a hora de testar o projeto

Para primeiro lige o servidor com o comando abaixo:
**php artisan serve**

Abra o postman e import a coleção rest que foi enviada por email, nela vai conter todos os endpoins criado neste teste. O projeto também tem todos os tests dos controllers que estão no diretorio tests

### EXPLICANDO O PROJETO:

### Além do model padrão o projeto tem mais 4 mdoels: Activity,Project,Task e UserProject.

**Activity**: está tabela vai ter todos os registro de atividade realizado na tabela Project. Ela é alimentada automaticamente pelo Observer. Cada vez que é feito alguma criação, atualizaçao e exclusão do Project, ela o Observer identifica o usuário, título do projeto (e também id) e ação, ele grava na tabela Activity.

**Project**: está tabela guarda todos projetos criado, contendo o título, descrição, data de início e prazo de entrega. Ela é alimentada via endpoint.

**Task**: está tabela guarda todas as task criada, contendo o título, descrição, data de início, prazo de entrega, status, responsável(id user) e id do projeto.

**UserProject**: está tabela guarda o id do projeto e o id dos usuarios associado ao projeto. Como a relação entre o projeto e usuários é muito para muitos, ela é uma tabela intermediaria para assim alocar os usuários que farão parte do projeto. 

## Teste Automatizados

O projeto tem todos os teste automatizados. Para executar digite os comando conforme abaixo:

- Executar todos os teste:
$ php artisan test

- Test Controller AuthController
$ php artisan test --filter=AuthControllerTest

- Test Controller ProjectController
$ php artisan test --filter=ProjectControllerTest

- Test Controller ProjectsUsersController
$ php artisan test --filter=ProjectsUsersController

- Test Controller TaskController
$ php artisan test --filter=TaskControllerTest

Você tambem pode executar cada metodo de cada teste em particular
Exemplo:
$ php artisan test --filter=AuthControllerTest::test_user_logout

Nos arquivo de test dexei no comentario os comando para executar test de um metodo em particular


