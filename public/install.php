<?php 
// En esta tarea haremos una API para poder consumir los datos de la tabla:
// articulos(id, nombre, descripcion, pvp, stock, disponible (SI, NO), categoria(BAZAR, ALIMENTACION)) para ello:
// Nos crearemos con faker 100 articulos de prueba
// Haremos nuestra Api que nos muestre 20 articulos o la cantidad indicada por la variable count que pasaremos por GET
// Mostraremos los articulos de una categoria pasada por GET en la variable cat

require __DIR__ ."/../vendor/autoload.php";
use Src\Articulo;
Articulo::crearArticulos(100);