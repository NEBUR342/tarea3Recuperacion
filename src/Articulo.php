<?php
namespace Src;
use PDO;
use PDOException;
class Articulo extends Conexion {
    // id int unsigned auto_increment primary key,
    // nombre varchar(20),
    // descripcion varchar(100),
    // pvp real(6,2),
    // stock varchar(20),
    // disponible enum('SI','NO'),
    // categoria enum('BAZAR','ALIMENTACION')
    private int $id;
    private string $nombre;
    private string $descripcion;
    private float $pvp;
    private int $stock;
    private string $disponible;
    private string $categoria;
    
    public function __construct() {
        parent::crearConexion();
    }

    //-----------------------------------------------------------------CRUD
    public function create() {
        $q="insert into articulos(nombre, descripcion, pvp, stock, disponible, categoria) values (:n, :d, :p, :s, :a, :c)";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute([
                ":n"=>$this->nombre,
                ":d"=>$this->descripcion,
                ":p"=>$this->pvp,
                ":s"=>$this->stock,
                ":a"=>$this->disponible,
                ":c"=>$this->categoria
            ]);
        }catch(PDOException $ex){
            die("Eroor en create: ".$ex->getMessage());
        }
        parent::$con=null;
    }
    public static function read($count=20, $cat=null){
        if($count<=0) $count=20;
        parent::crearConexion();
        $q=($cat!="BAZAR" && $cat!="ALIMENTACION") ? "select * from articulos LIMIT $count" : "select * from articulos where categoria='$cat' LIMIT $count";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error en read: ".$ex->getMessage());
        }
        parent::$con=null;
        $datos=['HTTP_RESPONSE'=>http_response_code()];
        $datos['TOTAL']=$stmt->rowcount();
        $datos['AUTOR']="Ruben Alvarez Fernandez";
        if($stmt->rowcount()==0) $datos['ARTICULOS']="No se han encontrado articulos";
        while($articulo=$stmt->fetch(PDO::FETCH_OBJ)){
            $datos['ARTICULOS'][]=[
                'id'=>$articulo->id,
                'nombre'=>$articulo->nombre,
                'descripcion'=>$articulo->descripcion,
                'pvp'=>$articulo->pvp,
                'stock'=>$articulo->stock,
                'disponible'=>$articulo->disponible,
                'categoria'=>$articulo->categoria
            ];
        }
        return json_encode($datos);
    }
    //-----------------------------------------------------------------METODOS
    public static function crearArticulos(int $cantidad) {
        if (self::hayArticulos()) return;
        $faker = \Faker\Factory::create();
        for($x=0;$x<$cantidad;$x++){
            // en el stock voy a poner un numero entre 1-1000
            (new Articulo)->setNombre(ucfirst($faker->unique()->words(3,true)))
            ->setDescripcion($faker->text())
            ->setPvp($faker->randomFloat(2,10,9999))
            ->setStock($faker->numberBetween(1,1000))
            ->setDisponible($faker->randomElements(["SI","NO"])[0])
            ->setCategoria($faker->randomElements(["BAZAR","ALIMENTACION"])[0])
            ->create();
        }
    }
    public static function hayArticulos():bool{
        parent::crearConexion();
        $q="select id from articulos";
        $stmt=parent::$con->prepare($q);
        try{
            $stmt->execute();
        } catch(PDOException $ex){
            die("Error en hayArticulos: ".$ex->getMessage());
        }
        parent::$con=null;
        return $stmt->rowCount();
    }
    //-----------------------------------------------------------------SETTERS
    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }
    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }
    /**
     * Set the value of pvp
     *
     * @return  self
     */ 
    public function setPvp($pvp) {
        $this->pvp = $pvp;
        return $this;
    }
    /**
     * Set the value of stock
     *
     * @return  self
     */ 
    public function setStock($stock) {
        $this->stock = $stock;
        return $this;
    }
    /**
     * Set the value of disponible
     *
     * @return  self
     */ 
    public function setDisponible($disponible) {
        $this->disponible = $disponible;
        return $this;
    }
    /**
     * Set the value of enum
     *
     * @return  self
     */ 
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
        return $this;
    }
}