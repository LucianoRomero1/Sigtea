<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Riesgo
 *
 * @ORM\Table(name="riesgo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RiesgoRepository")
 */
class Riesgo
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
     * @ORM\Column(name="categorizacion", type="string", length=2600, nullable=true)
     */
    private $categorizacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plan_contingencia", type="string", length=4400, nullable=true)
     */
    private $planContingencia;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="riesgo")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    private $planta;


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
     * Set categorizacion.
     *
     * @param string|null $categorizacion
     *
     * @return Riesgo
     */
    public function setCategorizacion($categorizacion = null)
    {
        $this->categorizacion = $categorizacion;

        return $this;
    }

    /**
     * Get categorizacion.
     *
     * @return string|null
     */
    public function getCategorizacion()
    {
        return $this->categorizacion;
    }

    /**
     * Set planContingencia.
     *
     * @param string|null $planContingencia
     *
     * @return Riesgo
     */
    public function setPlanContingencia($planContingencia = null)
    {
        $this->planContingencia = $planContingencia;

        return $this;
    }

    /**
     * Get planContingencia.
     *
     * @return string|null
     */
    public function getPlanContingencia()
    {
        return $this->planContingencia;
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
