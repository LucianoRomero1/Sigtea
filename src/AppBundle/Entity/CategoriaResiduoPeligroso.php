<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoriaResiduoPeligroso
 *
 * @ORM\Table(name="categoria_residuo_peligroso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaResiduoPeligrosoRepository")
 */
class CategoriaResiduoPeligroso
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
     * @ORM\Column(name="categoria", type="string", length=45, nullable=true)
     */
    private $categoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;


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
     * Set categoria.
     *
     * @param string|null $categoria
     *
     * @return CategoriaResiduoPeligroso
     */
    public function setCategoria($categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria.
     *
     * @return string|null
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return CategoriaResiduoPeligroso
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
}
