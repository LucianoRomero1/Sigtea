<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loteo
 *
 * @ORM\Table(name="loteo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoteoRepository")
 */
class Loteo
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
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numeroExpediente", type="string", length=255, nullable=true)
     */
    private $numeroExpediente;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcionProyecto", type="string", length=7500, nullable=true)
     */
    private $descripcionProyecto;


    /**
     * @ORM\OneToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    public $tramite;


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
     * @param string|null $nombre
     *
     * @return Loteo
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string|null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set numeroExpediente.
     *
     * @param string|null $numeroExpediente
     *
     * @return Loteo
     */
    public function setNumeroExpediente($numeroExpediente = null)
    {
        $this->numeroExpediente = $numeroExpediente;

        return $this;
    }

    /**
     * Get numeroExpediente.
     *
     * @return string|null
     */
    public function getNumeroExpediente()
    {
        return $this->numeroExpediente;
    }

    /**
     * Set descripcionProyecto.
     *
     * @param string|null $descripcionProyecto
     *
     * @return Loteo
     */
    public function setDescripcionProyecto($descripcionProyecto = null)
    {
        $this->descripcionProyecto = $descripcionProyecto;

        return $this;
    }

    /**
     * Get descripcionProyecto.
     *
     * @return string|null
     */
    public function getDescripcionProyecto()
    {
        return $this->descripcionProyecto;
    }

     /**
     * Set tramite.
     *
     * @param Tramite $tramite
     *
     * @return Tramite
     */
    public function setTramite($tramite)
    {
        $this->tramite = $tramite;

        return $this;
    }

    /**
     * Get tramite.
     *
     * @return Tramite
     */
    public function getTramite()
    {
        return $this->tramite;
    }
}
