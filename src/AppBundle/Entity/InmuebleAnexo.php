<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InmuebleAnexo
 *
 * @ORM\Table(name="inmueble_anexo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InmuebleAnexoRepository")
 */
class InmuebleAnexo
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
     * @ORM\Column(name="domicilio", type="string", length=255)
     */
    private $domicilio;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad_desarrollada", type="string", length=255)
     */
    private $actividadDesarrollada;

    /**
     * @ORM\ManyToOne(targetEntity="PartidaInmobiliaria", inversedBy="inmuebleAnexo", cascade={"persist"})
     * @ORM\JoinColumn(name="partidaInmobiliaria_id", referencedColumnName="id")
     */
    private $partidaInmobiliaria;


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
     * Set domicilio.
     *
     * @param string $domicilio
     *
     * @return InmuebleAnexo
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio.
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set actividadDesarrollada.
     *
     * @param string $actividadDesarrollada
     *
     * @return InmuebleAnexo
     */
    public function setActividadDesarrollada($actividadDesarrollada)
    {
        $this->actividadDesarrollada = $actividadDesarrollada;

        return $this;
    }

    /**
     * Get actividadDesarrollada.
     *
     * @return string
     */
    public function getActividadDesarrollada()
    {
        return $this->actividadDesarrollada;
    }

    /**
     * Set partidaInmobiliaria.
     *
     * @param partidaInmobiliaria $partidaInmobiliaria
     *
     * @return partidaInmobiliaria
     */
    public function setPartidaInmobiliaria($partidaInmobiliaria)
    {
        $this->partidaInmobiliaria = $partidaInmobiliaria;

        return $this;
    }

    /**
     * Get partidaInmobiliaria.
     *
     * @return PartidaInmobiliaria
     */
    public function getPartidaInmobiliaria()
    {
        return $this->partidaInmobiliaria;
    }
}
