<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anexo
 *
 * @ORM\Table(name="anexo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnexoRepository")
 */
class Anexo
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
     * @ORM\Column(name="archivo", type="string", length=255)
     */
    private $archivo;

        /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=3000)
     */
    private $observacion;


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
     * Set archivo.
     *
     * @param string $archivo
     *
     * @return Anexo
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Set observacion.
     *
     * @param string $observacion
     *
     * @return Anexo
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get archivo.
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Get observacion.
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }
}
