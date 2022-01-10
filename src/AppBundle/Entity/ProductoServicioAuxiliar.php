<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoServicioAuxiliar
 *
 * @ORM\Table(name="producto_servicio_auxiliar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductoServicioAuxiliarRepository")
 */
class ProductoServicioAuxiliar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;


    /**
     * @var int|null
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unidad", type="string", length=255, nullable=true)
     */
    private $unidad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="responsable", type="string", length=255, nullable=true)
     */
    private $responsable;

     /**
     * @ORM\OneToOne(targetEntity="TipoAplicacionAuxiliar")
     * @ORM\JoinColumn(name="tipo_aplicacion_auxiliar_id", referencedColumnName="id")
     */
    public $tipoAplicacionAuxiliar;

    
    /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numero.
     *
     * @param int|null $numero
     *
     * @return ProductoServicioAuxiliar
     */
    public function setNumero($numero = null)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return int|null
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return ProductoServicioAuxiliar
     */
    public function setDescripcion($descripcion = null)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }


    /**
     * Set cantidad.
     *
     * @param int|null $cantidad
     *
     * @return ProductoServicioAuxiliar
     */
    public function setCantidad($cantidad = null)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return int|null
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set unidad.
     *
     * @param string|null $unidad
     *
     * @return ProductoServicioAuxiliar
     */
    public function setUnidad($unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad.
     *
     * @return string|null
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * Set responsable.
     *
     * @param string|null $responsable
     *
     * @return ProductoServicioAuxiliar
     */
    public function setResponsable($responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable.
     *
     * @return string|null
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

     /**
     * Set tipoAplicacionAuxiliar.
     *
     * @param TipoAplicacionAuxiliar $tipoAplicacionAuxiliar
     *
     * @return TipoAplicacionAuxiliar
     */
    public function setTipoAplicacionAuxiliar($tipoAplicacionAuxiliar)
    {
        $this->tipoAplicacionAuxiliar = $tipoAplicacionAuxiliar;

        return $this;
    }

    /**
     * Get tipoAplicacionAuxiliar.
     *
     * @return TipoAplicacionAuxiliar
     */
    public function getTipoAplicacionAuxiliar()
    {
        return $this->tipoAplicacionAuxiliar;
    }

    
       /**
     * Set planta.
     *
     * @param Planta $planta
     *
     * @return Planta
     */
    public function setPlanta($planta)
    {
        $this->planta = $planta;

        return $this;
    }

    /**
     * Get planta.
     *
     * @return Planta
     */
    public function getPlanta()
    {
        return $this->planta;
    }
}
