<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CertificadoUso
 *
 * @ORM\Table(name="certificado_uso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CertificadoUsoRepository")
 */
class CertificadoUso
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
     * @ORM\Column(name="certificado_uso", type="string", length=255)
     */
    private $certificadoUso;

    /**
     * @var string
     *
     * @ORM\Column(name="municipalidad_comuna", type="string", length=45)
     */
    private $municipalidadComuna;

    /**
     * @ORM\ManyToOne(targetEntity="Formulario", inversedBy="CertificadoUso")
     * @ORM\JoinColumn(name="formulario_id", referencedColumnName="id")
     */
    
    private $formularioId;


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
     * Set certificadoUso.
     *
     * @param string $certificadoUso
     *
     * @return Certificado_uso
     */
    public function setCertificadoUso($certificadoUso)
    {
        $this->certificadoUso = $certificadoUso;

        return $this;
    }

    /**
     * Get certificadoUso.
     *
     * @return string
     */
    public function getCertificadoUso()
    {
        return $this->certificadoUso;
    }

    /**
     * Set municipalidadComuna.
     *
     * @param string $municipalidadComuna
     *
     * @return Certificado_uso
     */
    public function setMunicipalidadComuna($municipalidadComuna)
    {
        $this->municipalidadComuna = $municipalidadComuna;

        return $this;
    }

    /**
     * Get municipalidadComuna.
     *
     * @return string
     */
    public function getMunicipalidadComuna()
    {
        return $this->municipalidadComuna;
    }

    /**
     * Set formularioId.
     *
     * @param int|null $formularioId
     *
     * @return Certificado_uso
     */
    public function setFormularioId($formularioId = null)
    {
        $this->formularioId = $formularioId;

        return $this;
    }

    /**
     * Get formularioId.
     *
     * @return int|null
     */
    public function getFormularioId()
    {
        return $this->formularioId;
    }
}
