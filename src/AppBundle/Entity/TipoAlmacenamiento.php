<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoAlmacenamiento
 *
 * @ORM\Table(name="tipo_almacenamiento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoAlmacenamientoRepository")
 */
class TipoAlmacenamiento
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AlmacenamientoTanque", mappedBy="tipoAlmacenamiento")
     */
    protected $almacenamientoTanque;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->almacenamientoTanque = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return TipoAlmacenamiento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
