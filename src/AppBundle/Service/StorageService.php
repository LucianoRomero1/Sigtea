<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Storage;
use AppBundle\Entity\EntidadHasRepositorio;
use Symfony\AppBundle\FrameworkBundle\Controller\Controller;

class StorageService{
    
    private $em;
    public $uid = null;
    public $ruta = null;
    public $file = null;

    public function __construct(EntityManagerInterface $em, $uid = null)
    {
        $this->em = $em;

        if ($uid != null){
            $this->uid = $uid;
        }
    }

    public function subirArchivo($inciso,$tramite,$entidad = null, $idEntidad = null){

        $em = $this->em;
        $em->getConnection()->beginTransaction();

        try{
            $storage = $em->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => $inciso]);
            if ($storage == null){
                $storage = new Storage();
            }
            $storage->setUid($this->uid);
            $storage->setNombre($this->file->getClientOriginalName());
            $storage->setEstado("activo");
            $storage->setInciso($inciso);
            $storage->setTramite($tramite);

            $em->persist($storage);
            $em->flush();
            if($entidad !=null && $idEntidad != null){
                $entidadHasRepositorio = $em->getRepository(EntidadHasRepositorio::class)->findOneBy(['storage'=>$storage,'entidad'=>$entidad,'entidadId'=>$idEntidad]);
                if($entidadHasRepositorio==null){
                    $entidadHasRepositorio = new EntidadHasRepositorio();
                }
                $entidadHasRepositorio->setEntidad($entidad);
                $entidadHasRepositorio->setEntidadId($idEntidad);
                $entidadHasRepositorio->setStorage($storage->getid());
                $em->persist($entidadHasRepositorio);
            }

            $em->flush();
            $em->getConnection()->commit();

            $this->file->move($this->ruta,$this->uid);
            

        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            throw $e;
        }
    }

    public function generarUID($file){

        $this->uid= null;
        $mime = ["application/pdf"];

        // Validar que exista un solo file

        if(!in_array($file->getClientMimeType(),$mime)){
            return false;
        }
        
        $this->file = $file;

        $this->uid = substr(md5(password_hash($this->file->getClientOriginalName(), PASSWORD_BCRYPT, ['salt' => time().'000000000000'])),0,8);
        
        return true;


    }

    // Recibo por parámetro la ruta si quiero crearla en un lugar específico, sino paso NULl
    public function crearDirectorio($rutaParametro = null){

        // Convierto cada caracter en array
        $array = str_split($this->uid);

        // Ruta donde tienen que crearse todas las carpetas
        if ($rutaParametro == null){
            $ruta = __DIR__ . "/../../../web/recursos/activos/";
        }else{
            $ruta = __DIR__ . "/../../../web/recursos/archivados/";
        }
        // Utilizo los 3 primeros caracteres, y los dejo en array.
        $dirs = explode("/",$array[0] . "/" . $array[1] . "/" . $array[2]);
        // Recorro para ir creando de a uno los subdirectorios
        foreach( $dirs as $dir ){
            $ruta = $ruta . $dir . "/";
        }

        if (!is_dir($ruta)){
            if (!mkdir($ruta, 0777, true)){
                return false;
            }
        }

        if ($rutaParametro == null){
            $this->ruta= $ruta;
        }
        return true;
    }

    // ************* GET Y REMOVE **************

    public function getArchivo(){

        return ($this->getRutaUID($this->uid));
        
    }

    public function eliminarArchivo(){

        $repository = $this->em->getRepository(Storage::class);

        $storage = $repository->findBy(["uid" => $this->uid]);

        // Para traer el último storage (se supone que hay siempre uno).
        $storage = end($storage);

        if ($storage != null){
            
            $storage->setEstado("borrado");

            $this->em->flush();

            return true;
            
        }else{

            return false;

        }
    }

    // Genera la ruta basándose en el UID, y devuelve un string. Este método debería ser solamente usado en 
    // getArchivo y para cuando se archiva.

    public function getRutaUID(){

        $array = str_split($this->uid);
        // Ruta donde tienen que crearse todas las carpetas
        $ruta = __DIR__ . "/../../../web/recursos/activos/";

        // Utilizo los 3 primeros caracteres, y los dejo en array.
        return ($ruta . $array[0] . "/" . $array[1] . "/" . $array[2] . "/" . $this->uid);
    }

    public function getRutaArchivadosUID(){

        $array = str_split($this->uid);
        // Ruta donde tienen que crearse todas las carpetas
        $ruta = __DIR__ . "/../../../web/recursos/archivados/";

        // Utilizo los 3 primeros caracteres, y los dejo en array.
        return ($ruta . $array[0] . "/" . $array[1] . "/" . $array[2] . "/" . $this->uid);
    }

    // ********* Función para pasar a archivados.

    public function archivarArchivo(){

        $rutaActivos = $this->getRutaUID();
        $repository = $this->em->getRepository(Storage::class);

        $storage = $repository->findBy(["uid" => $this->uid]);

        // Para traer el último storage (se supone que hay siempre uno).
        $storage = end($storage);

        //Creo el directorio correspondiente
        if ($this->crearDirectorio("archivados")){

            copy($rutaActivos,$this->getRutaArchivadosUID());

            unlink($rutaActivos);

            if ($storage != null){

                $storage->setEstado("archivado");
                $this->em->flush();
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function archivosHuerfanos(){

        $storages = $this->em->getRepository(Storage::class)->findAll();

        foreach($storages as $storage){

            if($storage->getEstado() == "activo"){

                if (!$this->existeArchivo("activos",$storage->getUid())){
                    var_dump("Archivo UID " . $storage->getUid() . " se cae a pedazos, es huerfano.");
                }

            }elseif($storage->getEstado() == "archivado"){

                if (!$this->existeArchivo("archivados",$storage->getUid())){
                    var_dump("Archivo UID " . $storage->getUid() . " se cae a pedazos, es huerfano.");
                }

            }
        }
    }

    public function existeArchivo($estado,$uid){

        $array = str_split($uid);
        // Ruta donde tienen que crearse todas las carpetas
        $ruta = __DIR__ . "/../../../web/recursos/" . $estado . "/";

        // Utilizo los 3 primeros caracteres, y los dejo en array.
        $rutaArchivo = $ruta . $array[0] . "/" . $array[1] . "/" . $array[2] . "/" . $uid;

        return (file_exists($rutaArchivo));

    }
}