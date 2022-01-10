<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarcoLegal
 *
 * @ORM\Table(name="marco_legal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarcoLegalRepository")
 */
class MarcoLegal
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
     * @ORM\Column(name="tipo_norma", type="string", length=100, nullable=true)
     */
    private $tipoNorma;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tema", type="string", length=200, nullable=true)
     */
    private $tema;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aplicacion_especifica", type="string", length=500, nullable=true)
     */
    private $aplicacionEspecifica;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="marco_legal")
     * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id")
     */
    private $empresa;


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
     * Set tipoNorma.
     *
     * @param string|null $tipoNorma
     *
     * @return MarcoLegal
     */
    public function setTipoNorma($tipoNorma = null)
    {
        $this->tipoNorma = $tipoNorma;

        return $this;
    }

    /**
     * Get tipoNorma.
     *
     * @return string|null
     */
    public function getTipoNorma()
    {
        return $this->tipoNorma;
    }

    /**
     * Set tema.
     *
     * @param string|null $tema
     *
     * @return MarcoLegal
     */
    public function setTema($tema = null)
    {
        $this->tema = $tema;

        return $this;
    }

    /**
     * Get tema.
     *
     * @return string|null
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set aplicacionEspecifica.
     *
     * @param string|null $aplicacionEspecifica
     *
     * @return MarcoLegal
     */
    public function setAplicacionEspecifica($aplicacionEspecifica = null)
    {
        $this->aplicacionEspecifica = $aplicacionEspecifica;

        return $this;
    }

    /**
     * Get aplicacionEspecifica.
     *
     * @return string|null
     */
    public function getAplicacionEspecifica()
    {
        return $this->aplicacionEspecifica;
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
