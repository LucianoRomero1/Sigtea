<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Storage
 *
 * @ORM\Table(name="storage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StorageRepository")
 */
class Storage
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
     * @ORM\Column(name="uid", type="string", length=100, nullable=true)
     */
    private $uid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="estado", type="string", length=100, nullable=true)
     */
    private $estado;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="inciso", type="string", length=45, nullable=true)
     */
    private $inciso;

    /**
     * @ORM\ManyToOne(targetEntity="Tramite", inversedBy="storage")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    private $tramite;


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
     * Set uid.
     *
     * @param string|null $uid
     *
     * @return Storage
     */
    public function setUid($uid = null)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid.
     *
     * @return string|null
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return Storage
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
     * Set estado.
     *
     * @param string|null $estado
     *
     * @return Storage
     */
    public function setEstado($estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return string|null
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set observaciones.
     *
     * @param string|null $observaciones
     *
     * @return Storage
     */
    public function setObservaciones($observaciones = null)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string|null
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set inciso.
     *
     * @param string|null $inciso
     *
     * @return Storage
     */
    public function setInciso($inciso = null)
    {
        $this->inciso = $inciso;

        return $this;
    }

    /**
     * Get inciso.
     *
     * @return string|null
     */
    public function getInciso()
    {
        return $this->inciso;
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
