<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedidaPreventiva
 *
 * @ORM\Table(name="medida_preventiva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedidaPreventivaRepository")
 */
class MedidaPreventiva
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
     * @ORM\Column(name="infraestructuraSaneamiento", type="string", length=255, nullable=true)
     */
    private $infraestructuraSaneamiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcionMitigacionImpacto", type="string", length=255, nullable=true)
     */
    private $descripcionMitigacionImpacto;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="MedidaPreventiva")
     * @ORM\JoinColumn(name="urbanizacion_id", referencedColumnName="id")
     */
    private $urbanizacion;


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
     * Set infraestructuraSaneamiento.
     *
     * @param string|null $infraestructuraSaneamiento
     *
     * @return MedidaPreventiva
     */
    public function setInfraestructuraSaneamiento($infraestructuraSaneamiento = null)
    {
        $this->infraestructuraSaneamiento = $infraestructuraSaneamiento;

        return $this;
    }

    /**
     * Get infraestructuraSaneamiento.
     *
     * @return string|null
     */
    public function getInfraestructuraSaneamiento()
    {
        return $this->infraestructuraSaneamiento;
    }

    /**
     * Set descripcionMitigacionImpacto.
     *
     * @param string|null $descripcionMitigacionImpacto
     *
     * @return MedidaPreventiva
     */
    public function setDescripcionMitigacionImpacto($descripcionMitigacionImpacto = null)
    {
        $this->descripcionMitigacionImpacto = $descripcionMitigacionImpacto;

        return $this;
    }

    /**
     * Get descripcionMitigacionImpacto.
     *
     * @return string|null
     */
    public function getDescripcionMitigacionImpacto()
    {
        return $this->descripcionMitigacionImpacto;
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
}
