<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viento
 *
 * @ORM\Table(name="viento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VientoRepository")
 */
class Viento
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
     * @ORM\Column(name="direccionPredominante", type="string", length=500, nullable=true)
     */
    private $direccionPredominante;

    /**
     * @ORM\OneToOne(targetEntity="Recurso")
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     */
    public $recurso;


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
     * Set direccionPredominante.
     *
     * @param string|null $direccionPredominante
     *
     * @return Viento
     */
    public function setDireccionPredominante($direccionPredominante = null)
    {
        $this->direccionPredominante = $direccionPredominante;

        return $this;
    }

    /**
     * Get direccionPredominante.
     *
     * @return string|null
     */
    public function getDireccionPredominante()
    {
        return $this->direccionPredominante;
    }

    /**
     * Set recurso.
     *
     * @param Recurso $recurso
     *
     * @return Recurso
     */
    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;

        return $this;
    }

    /**
     * Get recurso.
     *
     * @return Recurso
     */
    public function getRcurso()
    {
        return $this->recurso;
    }
}
