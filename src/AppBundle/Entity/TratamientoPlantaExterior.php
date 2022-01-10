<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TratamientoPlantaExterior
 *
 * @ORM\Table(name="tratamiento_planta_exterior")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TratamientoPlantaExteriorRepository")
 */
class TratamientoPlantaExterior
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
     * @ORM\Column(name="item", type="integer", nullable=true)
     */
    private $item;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numeroRegistro", type="integer", nullable=true)
     */
    private $numeroRegistro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numeroDestruccion", type="integer", nullable=true)
     */
    private $numeroDestruccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="empresaTransportista", type="string", length=45, nullable=true)
     */
    private $empresaTransportista;

    /**
     * @var string|null
     *
     * @ORM\Column(name="disposicionFinal", type="string", length=45, nullable=true)
     */
    private $disposicionFinal;

    /**
     * @ORM\ManyToOne(targetEntity="Residuo", inversedBy="tratamientoPlanta")
     * @ORM\JoinColumn(name="residuo_id", referencedColumnName="id")
     */
    private $residuo;


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
     * Set item.
     *
     * @param int|null $item
     *
     * @return TratamientoPlantaExterior
     */
    public function setItem($item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return int|null
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return TratamientoPlantaExterior
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
     * Set numeroRegistro.
     *
     * @param int|null $numeroRegistro
     *
     * @return TratamientoPlantaExterior
     */
    public function setNumeroRegistro($numeroRegistro = null)
    {
        $this->numeroRegistro = $numeroRegistro;

        return $this;
    }

    /**
     * Get numeroRegistro.
     *
     * @return int|null
     */
    public function getNumeroRegistro()
    {
        return $this->numeroRegistro;
    }

    /**
     * Set numeroDestruccion.
     *
     * @param int|null $numeroDestruccion
     *
     * @return TratamientoPlantaExterior
     */
    public function setNumeroDestruccion($numeroDestruccion = null)
    {
        $this->numeroDestruccion = $numeroDestruccion;

        return $this;
    }

    /**
     * Get numeroDestruccion.
     *
     * @return int|null
     */
    public function getNumeroDestruccion()
    {
        return $this->numeroDestruccion;
    }

    /**
     * Set empresaTransportista.
     *
     * @param string|null $empresaTransportista
     *
     * @return TratamientoPlantaExterior
     */
    public function setEmpresaTransportista($empresaTransportista = null)
    {
        $this->empresaTransportista = $empresaTransportista;

        return $this;
    }

    /**
     * Get empresaTransportista.
     *
     * @return string|null
     */
    public function getEmpresaTransportista()
    {
        return $this->empresaTransportista;
    }

    /**
     * Set disposicionFinal.
     *
     * @param string|null $disposicionFinal
     *
     * @return TratamientoPlantaExterior
     */
    public function setDisposicionFinal($disposicionFinal = null)
    {
        $this->disposicionFinal = $disposicionFinal;

        return $this;
    }

    /**
     * Get disposicionFinal.
     *
     * @return string|null
     */
    public function getDisposicionFinal()
    {
        return $this->disposicionFinal;
    }

    /**
     * Set residuo.
     *
     * @param Residuo $residuo
     *
     * @return Residuo
     */
    public function SetResiduo($residuo)
    {
        $this->residuo = $residuo;

        return $this;
    }

    /**
     * Get residuo.
     *
     * @return Residuo
     */
    public function GetResiduo()
    {
        return $this->residuo;
    }
}
