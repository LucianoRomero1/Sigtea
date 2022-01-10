<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadServicio
 *
 * @ORM\Table(name="actividad_servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActividadServicioRepository")
 */
class ActividadServicio
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
     * @var int
     *
     * @ORM\Column(name="combustible_liquido", type="integer")
     */
    private $combustibleLiquido;

    /**
     * @var int
     *
     * @ORM\Column(name="gnc", type="integer")
     */
    private $gnc;

    /**
     * @var int
     *
     * @ORM\Column(name="otro", type="integer")
     */
    private $otro;

    /**
     * @var int
     *
     * @ORM\Column(name="lavadero", type="integer")
     */
    private $lavadero;

    /**
     * @var int
     *
     * @ORM\Column(name="cambio_aceite", type="integer")
     */
    private $cambioAceite;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_secundario", type="string", length=500)
     */
    private $otroSecundario;

    /**
     * @ORM\ManyToOne(targetEntity="MarcaBandera", inversedBy="actividadServicio")
     * @ORM\JoinColumn(name="marcaBandera_id", referencedColumnName="id")
     */
    private $marcaBandera;

    /**
     * @ORM\OneToMany(targetEntity="BocaExpendio", mappedBy="actividadServicio")
     */
    protected $bocaExpendio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bocaExpendio = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set combustibleLiquido.
     *
     * @param int $combustibleLiquido
     *
     * @return ActividadServicio
     */
    public function setCombustibleLiquido($combustibleLiquido)
    {
        $this->combustibleLiquido = $combustibleLiquido;

        return $this;
    }

    /**
     * Get combustibleLiquido.
     *
     * @return int
     */
    public function getCombustibleLiquido()
    {
        return $this->combustibleLiquido;
    }

    /**
     * Set gnc.
     *
     * @param int $gnc
     *
     * @return ActividadServicio
     */
    public function setGnc($gnc)
    {
        $this->gnc = $gnc;

        return $this;
    }

    /**
     * Get gnc.
     *
     * @return int
     */
    public function getGnc()
    {
        return $this->gnc;
    }

    /**
     * Set otro.
     *
     * @param int $otro
     *
     * @return ActividadServicio
     */
    public function setOtro($otro)
    {
        $this->otro = $otro;

        return $this;
    }

    /**
     * Get otro.
     *
     * @return int
     */
    public function getOtro()
    {
        return $this->otro;
    }

    /**
     * Set lavadero.
     *
     * @param int $lavadero
     *
     * @return ActividadServicio
     */
    public function setLavadero($lavadero)
    {
        $this->lavadero = $lavadero;

        return $this;
    }

    /**
     * Get lavadero.
     *
     * @return int
     */
    public function getLavadero()
    {
        return $this->lavadero;
    }

    /**
     * Set cambioAceite.
     *
     * @param int $cambioAceite
     *
     * @return ActividadServicio
     */
    public function setCambioAceite($cambioAceite)
    {
        $this->cambioAceite = $cambioAceite;

        return $this;
    }

    /**
     * Get cambioAceite.
     *
     * @return int
     */
    public function getCambioAceite()
    {
        return $this->cambioAceite;
    }

    /**
     * Set otroSecundario.
     *
     * @param string $otroSecundario
     *
     * @return ActividadServicio
     */
    public function setOtroSecundario($otroSecundario)
    {
        $this->otroSecundario = $otroSecundario;

        return $this;
    }

    /**
     * Get otroSecundario.
     *
     * @return string
     */
    public function getOtroSecundario()
    {
        return $this->otroSecundario;
    }

    /**
     * Set marcaBandera.
     *
     * @param MarcaBandera $marcaBandera
     *
     * @return MarcaBandera
     */
    public function setMarcaBandera($marcaBandera)
    {
        $this->marcaBandera = $marcaBandera;

        return $this;
    }

    /**
     * Get marcaBandera.
     *
     * @return MarcaBandera
     */
    public function getMarcaBandera()
    {
        return $this->marcaBandera;
    }
}
