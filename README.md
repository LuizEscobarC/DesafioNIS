# DesafioNIS
Desafio em PHP utilizando REST

# CRUD REST SIMPLES DE CADASTRO DE CIDADÃO COM IDENTIFICADOR SOCIAL 📝
link repositório: 

## Caso você queira analisar o projeto em sua maquina, siga este passo a passo de instalação com DOCKER: 😁


<h3>Dependências / Tecnologias</h3>

```
PHP 7.2
Composer
Docker
linux
VanillaJS
CSS3
HMTL5
```

<p>Componentes utilizados:</p>

``` 
 League Plates - View Engine.
 CoffeeCode - Router.
```

### Clone o repositório😎

```
 cd <pasta que deseja>
 git clone 
```

### Acesse o diretorio🤓
#### certifique-se se as portas 7000 e 80 estão disponíveis
Para saber mais sobre a estrutura do docker, suas dependências e instalação windows acessar: https://github.com/silveirajedi/docker-apache-php-mariadb
```
cd <pasta que clonou> && sh linux-mac-server.sh start 
```

### As dependências já serão isntaladas automaticamente via sh�


### A aplicação, por padrão, fica na porta:🤗
```
apache : 80:80
MariaDB: 7000:3306
```

### Restaure o Banco de dados

Importe todo o banco no seu gerenciador de banco de dados...
```
<pasta que clonou>\dump-cidadao-DB.sql
```

### Configure o acesso ao BANCO no caminho:
```
nano <pasta que clonou>\crud-turim\source\Boot\Config.php
```


### Configure a url base localhost no arquivo de caminho <small>Logo abaixo das config do banco</small>:
```
nano <pasta que clonou>\crud-turim\source\Boot\Config.php
```

### Acesse a url http://www.localhost/:


## Imagens do projeto 💻




