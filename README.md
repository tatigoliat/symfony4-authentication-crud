# symfony4-authentication-crud

Instalación

1- Clonar repo: https://github.com/tatigoliat/symfony4-authentication-crud.git

3- Instalar componentes y dependencias ejecutando: composer install

4- Configurar datos de conexión en el archivo .env

5- Crear la base de datos con doctrine: php bin/console doctrine:database:create

6- importar el archivo .sql con doctrine: php bin/console doctrine:database:import resources/sql/user.sql

7.- Ejecutar localhost con el comando: php bin/console server:run

Usuarios de prueba: 
	AMIND 
		Username: admin 
		Password: adminpassword 
	PAGE_1 
		Username: page1 
		Password: page1
	PAGE_2 
		Username: page2 
		Password: page2
