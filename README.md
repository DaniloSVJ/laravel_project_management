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

## END POINTS:

**Criação de usuários:**

método: POST

**_http://127.0.0.1:8000/register_**

_parametro body_:

{
    "name": "Nome do usuário",
    "email": "emaildosuario@g.com",
    "password": "senhadosuario",
    "roles": "admin | manager | techleader | dev" //Se não colocar, por padrão fica usuário dev 
}

_response_:

status:200

message:

{
    "message": "User registered successfully!"
}


**Login de usuários:**

método: POST

**_http://127.0.0.1:8000/login_**

_parametro body_:
{
    "name": "Nome do usuário",
    "email": "emaildosuario@g.com",
}
_response_:

status:200

message:
{
    "id": 380,
    "name": "Nome do usuário",
    "token": "254|0KbfrlmSvnGph0jUetRcKCUUV37iNIkHE7RTGHIG80cd291b"
}

**LogOut de usuários:**

método: POST

**_http://127.0.0.1:8000/logout_**

Precisa colocar o token o token do usuário que você quer deslogar

**Criação de Projetos**
método: POST

**_http://127.0.0.1:8000/projetc_**

Rota autenticada. Bearer token de usuário admin ou manager.
Para criar o projeto vc precisa logar com um usuário admin ou gerente. Somente eles podem criar, atualizar e excluir projetos. 


_parametro body_:
{
    "title": "Título do Projeto",
    "description": "Descrição do Projeto",
     "start_date": "2022-02-26",
    "term_of_delivery": "2022-02-29",

}

_response_:

status:200

message:

{
    "message": "Project registered successfully"
}

**Atualização de Projetos**

método: PUT

**_http://127.0.0.1:8000/Project/{id}_**

Rota autenticada. Bearer token de usuário admin ou manager.
Para criar o projeto vc precisa logar com um usuário admin ou gerente. Somente eles podem criar, atualizar e excluir projetos. 


_parametro body_:

{
    "title": "Título do Projeto",
    "description": "Descrição do Projeto",
     "start_date": "2022-02-26",
    "term_of_delivery": "2022-02-29",

}



_response_:

status:200

message:

{
    "message": "Project registered successfully"
}












