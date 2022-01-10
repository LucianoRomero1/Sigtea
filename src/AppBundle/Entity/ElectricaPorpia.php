<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ElectricaPorpia
 *
 * @ORM\Table(name="electrica_porpia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectricaPorpiaRepository")
 */
class ElectricaPorpia
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
     * @ORM\Column(name="metodo", type="string", length=45)
     */
    private $metodo;

    /**
     * @var float
     *
     * @ORM\Column(name="consumo", type="float")
     */
    private $consumo;

    /**
     * @var string
     *
     * @ORM\Column(name="fuente", type="string", length=45)
     */
    private $fuente;

    /**
     * @var int|null
     *
     * @ORM\Column(name="recurso_id", type="integer", nullable=true)
     */
    private $recursoId;


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
     * Set metodo.
     *
     * @param string $metodo
     *
     * @return ElectricaPorpia
     */
    public function setMetodo($metodo)
    {
        $this->metodo = $metodo;

        return $this;
    }

    /**
     * Get metodo.
     *
     * @return string
     */
    public function getMetodo()
    {
        return $this->metodo;
    }

    /**
     * Set consumo.
     *
     * @param float $consumo
     *
     * @return ElectricaPorpia
     */
    public function setConsumo($consumo)
    {
        $this->consumo = $consumo;

        return $this;
    }

    /**
     * Get consumo.
     *
     * @return float
     */
    public function getConsumo()
    {
        return $this->consumo;
    }

    /**
     * Set fuente.
     *
     * @param string $fuente
     *
     * @return ElectricaPorpia
     */
    public function setFuente($fuente)
    {
        $this->fuente = $fuente;

        return $this;
    }

    /**
     * Get fuente.
     *
     * @return string
     */
    public function getFuente()
    {
        return $this->fuente;
    }

    /**
     * Set recursoId.
     *
     * @param int|null $recursoId
     *
     * @return ElectricaPorpia
     */
    public function setRecursoId($recursoId = null)
    {
        $this->recursoId = $recursoId;

        return $this;
    }

    /**
     * Get recursoId.
     *
     * @return int|null
     */
    public function getRecursoId()
    {
        return $this->recursoId;
    }
}
