<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ObjetoSubdivision
 *
 * @ORM\Table(name="objeto_subdivision")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObjetoSubdivisionRepository")
 */
class ObjetoSubdivision
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
     * @ORM\Column(name="objeto", type="string", length=255)
     */
    private $objeto;

    /**
     * @ORM\OneToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(name="tramite_id", referencedColumnName="id")
     */
    public $tramite;

    /**
     * @ORM\OneToOne(targetEntity="Urbanizacion")
     * @ORM\JoinColumn(name="urbanizacion_id", referencedColumnName="id")
     */
    public $urbanizacion;


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
     * Set objeto.
     *
     * @param string $objeto
     *
     * @return ObjetoSubdivision
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;

        return $this;
    }

    /**
     * Get objeto.
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
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

    /**
     * Set urbanizacion.
     *
     * @param Urbanizacion $urbanizacion
     *
     * @return Urbanizacion
     */
    public function setUrbanizacion($urbanizacion)
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }

    /**
     * Get urbanizacion.
     *
     * @return Urbanizacion
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }
}
