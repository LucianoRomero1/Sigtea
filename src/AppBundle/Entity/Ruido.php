<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ruido
 *
 * @ORM\Table(name="ruido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RuidoRepository")
 */
class Ruido
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
     * @ORM\Column(name="horario", type="string", length=255, nullable=true)
     */
    private $horario;

    /**
     * @var string|null
     *
     * @ORM\Column(name="caracteristica", type="string", length=255, nullable=true)
     */
    private $caracteristica;

     /**
     * @ORM\OneToOne(targetEntity="Planta")
     * @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     */
    public $planta;

    
     /**
     * @ORM\OneToOne(targetEntity="TipoRuido")
     * @ORM\JoinColumn(name="tipo_ruido_id", referencedColumnName="id")
     */
    public $tipoRuido;


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
     * @return Ruido
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
     * Set horario.
     *
     * @param string|null $horario
     *
     * @return Ruido
     */
    public function setHorario($horario = null)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario.
     *
     * @return string|null
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * Set caracteristica.
     *
     * @param string|null $caracteristica
     *
     * @return Ruido
     */
    public function setCaracteristica($caracteristica = null)
    {
        $this->caracteristica = $caracteristica;

        return $this;
    }

    /**
     * Get caracteristica.
     *
     * @return string|null
     */
    public function getCaracteristica()
    {
        return $this->caracteristica;
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

    /**
     * Set tipoRuido.
     *
     * @param TipoRuido $tipoRuido
     *
     * @return TipoRuido
     */
    public function setTipoRuido($tipoRuido)
    {
        $this->tipoRuido = $tipoRuido;

        return $this;
    }

    /**
     * Get tipoRuido.
     *
     * @return TipoRuido
     */
    public function getTipoRuido()
    {
        return $this->tipoRuido;
    }
}
