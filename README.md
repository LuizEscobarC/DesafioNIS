# DesafioNIS
Desafio em PHP utilizando REST

# CRUD REST SIMPLES DE CADASTRO DE CIDADÃO COM IDENTIFICADOR SOCIAL 📝
link repositório: 

## Caso você queira analisar o projeto em sua maquina, siga este passo a passo de instalação com DOCKER: 😁


<h3>Dependências / Tecnologias</h3>

```
PHP >= 7.2
Xdebug 3.2
Composer 2.1
MariaDB
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

 Alterei algumas configuyrações nos arquivos para adaptar a minha necessidade, logo, é interessante utilizar os arquivos docker que estão nesse repositório.
```
cd <pasta que clonou>/DesafioNIS && sh linux-mac-server.sh start 
```

### As dependências composer já serão instaladas automaticamente via ShellScript�


### A aplicação, por padrão, fica na porta:🤗
```
apache : 80:80
MariaDB: 7000:3306
```

### Configure o apache <small>Crie o arquivo .htaccess de não houver e cole a config a baixo</small>:

Caso altere algo no htaccess é necessário descer e subir o container elimpar o cache do navegador.

```htaccess
RewriteEngine On
#Options All -Indexes

## ROUTER WWW Redirect.
#RewriteCond %{HTTP_HOST} !^www\. [NC]
#RewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

## ROUTER HTTPS Redirect
#RewriteCond %{HTTP:X-Forwarded-Proto} !https
#RewriteCond %{HTTPS} off
#RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# ROUTER URL Rewrite
RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=/$1 [L,QSA]
```



### Restaure o Banco de dados
<ol>
 <li>
   Conecte o seu DbManager no container MariaDB
 </li>
 
 ```json
   {"serverHost": "localhost", "port": 7000, "userName": "root", "password": ""}
  ```
 
 <li>
  Crie a tabela Citizen (Use utf8 se preferir)
 </li>
 
```json
   {"charSet": "latin1", "Collation": "latin1_swedish_ci"}
  ```
 
 <li>
  Rode o SQL abaixo ou faça o restore do dump.
 </li>
 
  ```sh
 <pasta que clonou>/dump-cidadao-DB.sql
 ```
  ```sql
  -- citizen.citizen definition

  CREATE TABLE `citizen` (
    `id` mediumint(9) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `nis` bigint(20) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
 ```

</ol>


### Configure o acesso ao BANCO no caminho:
```
nano <pasta que clonou>/DesafioNIS/source/Boot/Config.php
```
```php
define("CONF_DB_HOST", "db");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", null);
define("CONF_DB_NAME", "citizen");
```


### Configure a url base localhost no arquivo de caminho <small>Logo abaixo das config do banco</small>:
nano <pasta que clonou>/DesafioNIS/source/Boot/Config.php

```php
/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "http://localhost");
define("CONF_URL_TEST", "http://localhost"); 
```


```
nano <pasta que clonou>/DesafioNIS/source/Boot/Config.php
```
### Acesse a url http://localhost/:

## Imagens do projeto 💻
![image](https://github.com/LuizEscobarC/DesafioNIS/assets/54407649/9e73b134-9955-4069-800e-8d3f1823203a)

![image](https://github.com/LuizEscobarC/DesafioNIS/assets/54407649/dc0481c6-d2a5-4d03-8b19-d55cd79e2169)



