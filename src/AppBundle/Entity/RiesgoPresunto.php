<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RiesgoPresunto
 *
 * @ORM\Table(name="riesgo_presunto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RiesgoPresuntoRepository")
 */
class RiesgoPresunto
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
     * @var smallint|null
     *
     * @ORM\Column(name="fuentes_moviles", type="smallint", nullable=true)
     */
    private $fuentesMoviles;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="aparato_sometido", type="smallint", nullable=true)
     */
    private $aparatoSometido;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="sustancia_quimica", type="smallint", nullable=true)
     */
    private $sustanciaQuimica;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="explosion", type="smallint", nullable=true)
     */
    private $explosion;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="incendio", type="smallint", nullable=true)
     */
    private $incendio;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="otro", type="smallint", nullable=true)
     */
    private $otro;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="acustico", type="smallint", nullable=true)
     */
    private $acustico;

    /**
     * @var smallint|null
     *
     * @ORM\Column(name="presion", type="smallint", nullable=true)
     */
    private $presion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="proceso", type="string", length=255, nullable=true)
     */
    private $proceso;

    /**
     * @ORM\ManyToOne(targetEntity="Planta", inversedBy="riesgoPresunto")
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
     * Set fuentesMoviles.
     *
     * @param smallint|null $fuentesMoviles
     *
     * @return RiesgoPresunto
     */
    public function setFuentesMoviles($fuentesMoviles = null)
    {
        $this->fuentesMoviles = $fuentesMoviles;

        return $this;
    }

    /**
     * Get fuentesMoviles.
     *
     * @return smallint|null
     */
    public function getFuentesMoviles()
    {
        return $this->fuentesMoviles;
    }

    /**
     * Set aparatoSometido.
     *
     * @param smallint|null $aparatoSometido
     *
     * @return RiesgoPresunto
     */
    public function setAparatoSometido($aparatoSometido = null)
    {
        $this->aparatoSometido = $aparatoSometido;

        return $this;
    }

    /**
     * Get aparatoSometido.
     *
     * @return smallint|null
     */
    public function getAparatoSometido()
    {
        return $this->aparatoSometido;
    }

    /**
     * Set sustanciaQuimica.
     *
     * @param smallint|null $sustanciaQuimica
     *
     * @return RiesgoPresunto
     */
    public function setSustanciaQuimica($sustanciaQuimica = null)
    {
        $this->sustanciaQuimica = $sustanciaQuimica;

        return $this;
    }

    /**
     * Get sustanciaQuimica.
     *
     * @return smallint|null
     */
    public function getSustanciaQuimica()
    {
        return $this->sustanciaQuimica;
    }

    /**
     * Set explosion.
     *
     * @param smallint|null $explosion
     *
     * @return RiesgoPresunto
     */
    public function setExplosion($explosion = null)
    {
        $this->explosion = $explosion;

        return $this;
    }

    /**
     * Get explosion.
     *
     * @return smallint|null
     */
    public function getExplosion()
    {
        return $this->explosion;
    }

    /**
     * Set incendio.
     *
     * @param smallint|null $incendio
     *
     * @return RiesgoPresunto
     */
    public function setIncendio($incendio = null)
    {
        $this->incendio = $incendio;

        return $this;
    }

    /**
     * Get incendio.
     *
     * @return smallint|null
     */
    public function getIncendio()
    {
        return $this->incendio;
    }

    /**
     * Set otro.
     *
     * @param smallint|null $otro
     *
     * @return RiesgoPresunto
     */
    public function setOtro($otro = null)
    {
        $this->otro = $otro;

        return $this;
    }

    /**
     * Get otro.
     *
     * @return smallint|null
     */
    public function getOtro()
    {
        return $this->otro;
    }

    /**
     * Set observaciones.
     *
     * @param string|null $observaciones
     *
     * @return RiesgoPresunto
     */
    public function setObservaciones($observaciones = null)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set acustico.
     *
     * @param smallint|null $acustico
     *
     * @return RiesgoPresunto
     */
    public function setAcustico($acustico = null)
    {
        $this->acustico = $acustico;

        return $this;
    }

    /**
     * Get acustico.
     *
     * @return smallint|null
     */
    public function getAcustico()
    {
        return $this->acustico;
    }

    /**
     * Set presion.
     *
     * @param smallint|null $presion
     *
     * @return RiesgoPresunto
     */
    public function setPresion($presion = null)
    {
        $this->presion = $presion;

        return $this;
    }

    /**
     * Get presion.
     *
     * @return smallint|null
     */
    public function getPresion()
    {
        return $this->presion;
    }

    /**
     * Set proceso.
     *
     * @param string|null $proceso
     *
     * @return RiesgoPresunto
     */
    public function setProceso($proceso = null)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso.
     *
     * @return string|null
     */
    public function getProceso()
    {
        return $this->proceso;
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
