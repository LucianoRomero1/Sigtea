<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtroRecurso
 *
 * @ORM\Table(name="otro_recurso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OtroRecursoRepository")
 */
class OtroRecurso
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
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="extraccion_captacion", type="string", length=255, nullable=true)
     */
    private $extraccionCaptacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etapa_proceso", type="string", length=255, nullable=true)
     */
    private $etapaProceso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cantidad_tiempo", type="string", length=255, nullable=true)
     */
    private $cantidadTiempo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_anexo", type="string", length=255, nullable=true)
     */
    private $nombreAnexo;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso", inversedBy="otroRecurso")
     * @ORM\JoinColumn(name="recurso_id", referencedColumnName="id")
     */
    private $recurso;


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
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return OtroRecurso
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set extraccionCaptacion.
     *
     * @param string|null $extraccionCaptacion
     *
     * @return OtroRecurso
     */
    public function setExtraccionCaptacion($extraccionCaptacion = null)
    {
        $this->extraccionCaptacion = $extraccionCaptacion;

        return $this;
    }

    /**
     * Get extraccionCaptacion.
     *
     * @return string|null
     */
    public function getExtraccionCaptacion()
    {
        return $this->extraccionCaptacion;
    }

    /**
     * Set etapaPorceso.
     *
     * @param string|null $etapaPorceso
     *
     * @return OtroRecurso
     */
    public function setEtapaProceso($etapaProceso = null)
    {
        $this->etapaProceso = $etapaProceso;

        return $this;
    }

    /**
     * Get etapaProceso.
     *
     * @return string|null
     */
    public function getEtapaProceso()
    {
        return $this->etapaProceso;
    }

    /**
     * Set cantidadTiempo.
     *
     * @param string|null $cantidadTiempo
     *
     * @return OtroRecurso
     */
    public function setCantidadTiempo($cantidadTiempo = null)
    {
        $this->cantidadTiempo = $cantidadTiempo;

        return $this;
    }

    /**
     * Get cantidadTiempo.
     *
     * @return string|null
     */
    public function getCantidadTiempo()
    {
        return $this->cantidadTiempo;
    }

    /**
     * Set nombreAnexo.
     *
     * @param string|null $nombreAnexo
     *
     * @return OtroRecurso
     */
    public function setNombreAnexo($nombreAnexo = null)
    {
        $this->nombreAnexo = $nombreAnexo;

        return $this;
    }

    /**
     * Get nombreAnexo.
     *
     * @return string|null
     */
    public function getNombreAnexo()
    {
        return $this->nombreAnexo;
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
    public function getRecurso()
    {
        return $this->recurso;
    }
}
