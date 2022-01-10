<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactibilidadServicio
 *
 * @ORM\Table(name="factibilidad_servicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactibilidadServicioRepository")
 */
class FactibilidadServicio
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
     * @var int|null
     *
     * @ORM\Column(name="recoleccionRsu", type="integer", nullable=true)
     */
    private $recoleccionRsu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cloacasRed", type="integer", nullable=true)
     */
    private $cloacasRed;

    /**
     * @var int|null
     *
     * @ORM\Column(name="gas", type="integer", nullable=true)
     */
    private $gas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="energiaElectrica", type="integer", nullable=true)
     */
    private $energiaElectrica;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aguaPotable", type="integer", nullable=true)
     */
    private $aguaPotable;

    /**
     * @var int|null
     *
     * @ORM\Column(name="transportePublico", type="integer", nullable=true)
     */
    private $transportePublico;

    /**
     * @var string|null
     *
     * @ORM\Column(name="otras",  type="string", length=255, nullable=true)
     */
    private $otras;

    /**
     * @ORM\ManyToOne(targetEntity="Urbanizacion", inversedBy="factibilidad")
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
     * Set recoleccionRsu.
     *
     * @param int|null $recoleccionRsu
     *
     * @return FactibilidadServicio
     */
    public function setRecoleccionRsu($recoleccionRsu = null)
    {
        $this->recoleccionRsu = $recoleccionRsu;

        return $this;
    }

    /**
     * Get recoleccionRsu.
     *
     * @return int|null
     */
    public function getRecoleccionRsu()
    {
        return $this->recoleccionRsu;
    }

    /**
     * Set cloacasRed.
     *
     * @param int|null $cloacasRed
     *
     * @return FactibilidadServicio
     */
    public function setCloacasRed($cloacasRed = null)
    {
        $this->cloacasRed = $cloacasRed;

        return $this;
    }

    /**
     * Get cloacasRed.
     *
     * @return int|null
     */
    public function getCloacasRed()
    {
        return $this->cloacasRed;
    }

    /**
     * Set gas.
     *
     * @param int|null $gas
     *
     * @return FactibilidadServicio
     */
    public function setGas($gas = null)
    {
        $this->gas = $gas;

        return $this;
    }

    /**
     * Get gas.
     *
     * @return int|null
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * Set energiaElectrica.
     *
     * @param int|null $energiaElectrica
     *
     * @return FactibilidadServicio
     */
    public function setEnergiaElectrica($energiaElectrica = null)
    {
        $this->energiaElectrica = $energiaElectrica;

        return $this;
    }

    /**
     * Get energiaElectrica.
     *
     * @return int|null
     */
    public function getEnergiaElectrica()
    {
        return $this->energiaElectrica;
    }

    /**
     * Set aguaPotable.
     *
     * @param int|null $aguaPotable
     *
     * @return FactibilidadServicio
     */
    public function setAguaPotable($aguaPotable = null)
    {
        $this->aguaPotable = $aguaPotable;

        return $this;
    }

    /**
     * Get aguaPotable.
     *
     * @return int|null
     */
    public function getAguaPotable()
    {
        return $this->aguaPotable;
    }

    /**
     * Set transportePublico.
     *
     * @param int|null $transportePublico
     *
     * @return FactibilidadServicio
     */
    public function setTransportePublico($transportePublico = null)
    {
        $this->transportePublico = $transportePublico;

        return $this;
    }

    /**
     * Get transportePublico.
     *
     * @return int|null
     */
    public function getTransportePublico()
    {
        return $this->transportePublico;
    }

    /**
     * Set otras.
     *
     * @param string|null $otras
     *
     * @return FactibilidadServicio
     */
    public function setOtras($otras = null)
    {
        $this->otras = $otras;

        return $this;
    }

    /**
     * Get otras.
     *
     * @return string|null
     */
    public function getOtras()
    {
        return $this->otras;
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

    /**
     * Get urbanizacion.
     *
     * @return Urbanizacion
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }
}
