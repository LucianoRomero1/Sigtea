<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntidadHasRepositorio
 *
 * @ORM\Table(name="entidad_has_repositorio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntidadHasRepositorioRepository")
 */
class EntidadHasRepositorio
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
     * @ORM\Column(name="entidad", type="string", length=45, nullable=true)
     */
    private $entidad;

    /**
     * @var int
     *
     * @ORM\Column(name="entidad_id", type="integer")
     */
    private $entidadId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="storage_id", type="integer")
     */
    private $storage;


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
     * Set entidad.
     *
     * @param string|null $entidad
     *
     * @return EntidadHasRepositorio
     */
    public function setEntidad($entidad = null)
    {
        $this->entidad = $entidad;

        return $this;
    }

    /**
     * Get entidad.
     *
     * @return string|null
     */
    public function getEntidad()
    {
        return $this->entidad;
    }

    /**
     * Set entidadId.
     *
     * @param int $entidadId
     *
     * @return Entidad
     */
    public function setEntidadId($entidadId)
    {
        $this->entidadId = $entidadId;

        return $this;
    }

    /**
     * Get entidadId.
     *
     * @return int
     */
    public function getEntidadId()
    {
        return $this->entidadId;
    }
    
    /**
     * Set storage.
     *
     * @param int $storage
     *
     * @return Storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Get storage.
     *
     * @return int
     */
    public function getStorage()
    {
        return $this->storage;
    }
}
