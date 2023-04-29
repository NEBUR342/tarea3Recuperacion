Create table articulos(
    id int unsigned auto_increment primary key,
    nombre varchar(20),
    descripcion varchar(100),
    pvp real(6,2),
    stock varchar(20),
    disponible enum('SI','NO'),
    categoria enum('BAZAR','ALIMENTACION')
);