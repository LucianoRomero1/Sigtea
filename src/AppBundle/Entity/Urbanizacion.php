<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Urbanizacion
 *
 * @ORM\Table(name="urbanizacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UrbanizacionRepository")
 */
class Urbanizacion
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
     * @ORM\Column(name="calleRuta", type="string", length=255, nullable=true)
     */
    private $calleRuta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numeroKm", type="string", length=255, nullable=true)
     */
    private $numeroKm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="entreCalles", type="string", length=255, nullable=true)
     */
    private $entreCalles;

    /**
     * @var int|null
     *
     * @ORM\Column(name="superficieTotal", type="integer", nullable=true)
     */
    private $superficieTotal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="desarrolloEtapa", type="string", length=500, nullable=true)
     */
    private $desarrolloEtapa;

    /**
     * @var int|null
     *
     * @ORM\Column(name="riesgoHidrico", type="integer", nullable=true)
     */
    private $riesgoHidrico;

    
    /**
     * @ORM\OneToOne(targetEntity="Loteo")
     * @ORM\JoinColumn(name="loteo_id", referencedColumnName="id")
     */
    public $loteo;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="urbanizacion")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @ORM\OneToMany(targetEntity="DimensionamientoLoteo", mappedBy="urbanizacion")
     */
    protected $dimensionamiento;

    
    /**
     * @ORM\OneToMany(targetEntity="DimensionamientoLoteo", mappedBy="urbanizacion")
     */
    protected $destinoSuelo;

    /**
     * @ORM\OneToMany(targetEntity="FactibilidadServicio", mappedBy="urbanizacion")
     */
    protected $factibilidad;




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
     * Set calleRuta.
     *
     * @param string|null $calleRuta
     *
     * @return Urbanizacion
     */
    public function setCalleRuta($calleRuta = null)
    {
        $this->calleRuta = $calleRuta;

        return $this;
    }

    /**
     * Get calleRuta.
     *
     * @return string|null
     */
    public function getCalleRuta()
    {
        return $this->calleRuta;
    }

    /**
     * Set numeroKm.
     *
     * @param string|null $numeroKm
     *
     * @return Urbanizacion
     */
    public function setNumeroKm($numeroKm = null)
    {
        $this->numeroKm = $numeroKm;

        return $this;
    }

    /**
     * Get numeroKm.
     *
     * @return string|null
     */
    public function getNumeroKm()
    {
        return $this->numeroKm;
    }

    /**
     * Set entreCalles.
     *
     * @param string|null $entreCalles
     *
     * @return Urbanizacion
     */
    public function setEntreCalles($entreCalles = null)
    {
        $this->entreCalles = $entreCalles;

        return $this;
    }

    /**
     * Get entreCalles.
     *
     * @return string|null
     */
    public function getEntreCalles()
    {
        return $this->entreCalles;
    }

    /**
     * Set superficieTotal.
     *
     * @param int|null $superficieTotal
     *
     * @return Urbanizacion
     */
    public function setSuperficieTotal($superficieTotal = null)
    {
        $this->superficieTotal = $superficieTotal;

        return $this;
    }

    /**
     * Get superficieTotal.
     *
     * @return int|null
     */
    public function getSuperficieTotal()
    {
        return $this->superficieTotal;
    }

    /**
     * Set desarrolloEtapa.
     *
     * @param string|null $desarrolloEtapa
     *
     * @return Urbanizacion
     */
    public function setDesarrolloEtapa($desarrolloEtapa = null)
    {
        $this->desarrolloEtapa = $desarrolloEtapa;

        return $this;
    }

    /**
     * Get desarrolloEtapa.
     *
     * @return string|null
     */
    public function getDesarrolloEtapa()
    {
        return $this->desarrolloEtapa;
    }

    /**
     * Set riesgoHidrico.
     *
     * @param int|null $riesgoHidrico
     *
     * @return Urbanizacion
     */
    public function setRiesgoHidrico($riesgoHidrico = null)
    {
        $this->riesgoHidrico = $riesgoHidrico;

        return $this;
    }

    /**
     * Get riesgoHidrico.
     *
     * @return int|null
     */
    public function getRiesgoHidrico()
    {
        return $this->riesgoHidrico;
    }

    /**
     * Set loteo.
     *
     * @param Loteo $loteo
     *
     * @return Loteo
     */
    public function setLoteo($loteo)
    {
        $this->loteo = $loteo;

        return $this;
    }

    /**
     * Get loteo.
     *
     * @return Loteo
     */
    public function getLoteo()
    {
        return $this->loteo;
    }

    /**
     * Set empresa.
     *
     * @param Empresa $empresa
     *
     * @return Empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa.
     *
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
