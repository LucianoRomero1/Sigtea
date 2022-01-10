<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TramitePlantaExpendio
 *
 * @ORM\Table(name="tramite_planta_expendio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TramitePlantaExpendioRepository")
 */
class TramitePlantaExpendio
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
     * @ORM\Column(name="item", type="integer")
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_registro", type="integer", nullable=true)
     */
    private $numeroRegistro;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_destruccion", type="integer", nullable=true)
     */
    private $numeroDestruccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="empresa_transportadora", type="string", length=255, nullable=true)
     */
    private $empresaTransportadora;

    /**
     * @var string|null
     *
     * @ORM\Column(name="disposicion_final", type="string", length=255, nullable=true)
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
     * @param int $item
     *
     * @return TramitePlantaExpendio
     */
    public function setItem($item)
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
     * @return TramitePlantaExpendio
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
     * @return TramitePlantaExpendio
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
     * @return TramitePlantaExpendio
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
     * Set empresaTransportadora.
     *
     * @param string|null $empresaTransportadora
     *
     * @return TramitePlantaExpendio
     */
    public function setEmpresaTransportadora($empresaTransportadora = null)
    {
        $this->empresaTransportadora = $empresaTransportadora;

        return $this;
    }

    /**
     * Get empresaTransportadora.
     *
     * @return string|null
     */
    public function getEmpresaTransportadora()
    {
        return $this->empresaTransportadora;
    }

    /**
     * Set disposicionFinal.
     *
     * @param string|null $disposicionFinal
     *
     * @return TramitePlantaExpendio
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
