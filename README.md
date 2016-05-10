# Books-Sales
Book &amp; Sales - Test

---
## Autor

####Nelson Daza

**LinkedIn:** https://www.linkedin.com/in/nelsonadp

**E-mail:** [nelson.daza@gmail.com](mailto:nelson.daza@gmail.com)

**Skype:** nelson.daza


---
##Laravel - Prueba Técnica

Crear un API REST que permite hacer operaciones CRUD sobre un sistema de
inventarios libros, la api debe permitir:
- CRUD en los libros
- Cantidades disponibles de un libro
- Cantidades vendidas de un libro
- Actualizar cantidades disponibles de un libro
- Comprar Libro
- Listar las compras de todos los libros
- Listar las compras de un libro
- Cambiar el valor del libro (Ningun libro puede tener valor 0)

### Requerimientos:
- Desarrollado usando el framework Laravel.
- No usar librerías o módulos externos, aparte de los que vienen con Laravel.
- Crear los migrations y seeders (Al menos 10 libros, al menos 5 registros de
ventas, con datos aleatorios).
- Pruebas usando PHPunit.
- Documentación y comentarios
- API REST
- Los libros deben de tener al por lo menos los siguientes datos: autor,
nombre, referencia, año de publicación.
- En el Readme se debe incluir: datos del autor e Instrucciones de
instalación, configuración y ejecución de pruebas.
- Buenas practicas de programacion y usar las funcionalidades que provee
el framework.
Al final enviar al correo lina.gomez@talosdigital.com elcodigo en git.

---

## Instalación

Para obtener una copia completa de la prueba use el comando: (La instalación de _git_ no es parte de este manual)
```
git clone https://github.com/nelsondaza/Books-Sales.git
```

Ubíquese dentro de la carpeta creada:
```
cd Books-Sales/
```

Ejecute composer para instalar las dependencias: (La instalación de _composer_ no es parte de este manual)
```
composer install
```

Cree un archivo de entorno basándose en el de ejemplo:
```
cp .env.example .env
```

Cree una llave de aplicación:
```
php artisan key:generate
```

Edite el archivo _.env_ configurando la conexión a una base de datos ya creada:
```
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=homestead
> DB_USERNAME=homestead
> DB_PASSWORD=secret
```

Cree las entidades en la BDD:
```
php artisan migrate
```

Cree los datos iniciales:
```
php artisan db:seed
```

Ejecute las pruebas unitarias:
```
vendor/bin/phpunit
```

Para verlo en su navegador podría usar el siguiente comando:
```
php artisan serve --host=localhost --port=9092
```
URL de prueba:

Contenido | URL
------------ | -------------
Listado de libros | [http://localhost:9092/api/books](http://localhost:9092/api/books)
Ver el libro con ID 10 y sus ventas | [http://localhost:9092/api/books/10](http://localhost:9092/api/books/10)
Listado de ventas | [http://localhost:9092/api/sales](http://localhost:9092/api/sales)
Ver la venta con ID 32 | [http://localhost:9092/api/sales/32](http://localhost:9092/api/sales/32)

> Para ver el listado de rutas y sus métodos:
> ```php artisan route:list```


## _GRACIAS_

