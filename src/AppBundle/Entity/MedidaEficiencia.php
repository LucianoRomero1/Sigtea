<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MedidaEficiencia
 *
 * @ORM\Table(name="medida_eficiencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MedidaEficienciaRepository")
 */
class MedidaEficiencia
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
     * @ORM\Column(name="medida", type="string", length=2600, nullable=true)
     */
    private $medida;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="MedidaEficiencia")
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
     * Set medida.
     *
     * @param string|null $medida
     *
     * @return MedidaEficiencia
     */
    public function setMedida($medida = null)
    {
        $this->medida = $medida;

        return $this;
    }

    /**
     * Get medida.
     *
     * @return string|null
     */
    public function getMedida()
    {
        return $this->medida;
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
