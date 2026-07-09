# Ambiente em Docker
Para garantir e faciliar a execução.

# testeBasico
Teste básico para vaga PHP na empresa Supremo CRM para Imobiliárias.

<div>
    <h3>Descrição:</h3>
    <p>Teste Básico para a Vaga "Desenvolvedor PHP - Remoto PJ" na Empresa Supremo CRM para Imobiliárias (Edbraulio Vieira - Diretor de Tecnologia, Full Cycle Developer)</p>
    <p>TAREFA: Criar um CRUD de cadastro de um de Agenda de Contatos, com os campos: Nome, Telefone, 
        Cidade, Estado. Crie as tabelas no MySQL. Faça em PHP Puro. <br>Preciso também de uma pesquisa, 
        na tela de listar, para nome, telefone, cidade (em texto) e estado(em texto). Após fazer a tarefa, 
        publique ela em seu Github e me envie o link.
    </p>
    <p>RECOMENDAÇÃO: Não use IA nesse momento, quero ver a sua lógica. Se você usar IA neste teste, 
        será desclassificado(a).
    </p>
    <p>APRESENTAÇÃO: Após isso, vamos fazer uma entrevista, via google meet, para você me apresentar 
        e fazer alterações aovivo no projeto.
    </p>
</div>

# composer
o projeto foi dado init pelo composer php, para ter estrutura base padrão autoload

# nao houve utilizacao de IA
para nao utilizar IA, utilizei como base de consulta, um antigo projeto meu de micro-framework que criei,
com consultas no google e documentações.
Projeto em: https://github.com/flaviosalgado2/mvc

# rodar projeto docker
docker-compose up -d

# Acessar bash container
docker exec -it testebasico-php bash

# stop containers
docker-compose down

# stop containers removendo volumes
docker-compose down -v

# recriar containers
docker-compose up -d --build

# SQL com estados e municipios brasileiros
https://github.com/chinnonsantos/sql-paises-estados-cidades/tree/main/MySQL

# sobre estratégia /docker-entrypoint-initdb.d da imagem docker MySQL (tópico - Initializing a fresh instance)
https://hub.docker.com/_/mysql