<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TratamientoPlantaPropia
 *
 * @ORM\Table(name="tratamiento_planta_propia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TratamientoPlantaPropiaRepository")
 */
class TratamientoPlantaPropia
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
     * @var int|null
     *
     * @ORM\Column(name="tratamiento_incompleto", type="integer", nullable=true)
     */
    private $tratamientoIncompleto;

      /**
     * @ORM\ManyToOne(targetEntity="Residuo", inversedBy="tratamientoPlantaPropia")
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
     * @return TratamientoPlantaPropia
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
     * Set tratamientoIncompleto.
     *
     * @param int|null $tratamientoIncompleto
     *
     * @return TratamientoPlantaPropia
     */
    public function setTratamientoIncompleto($tratamientoIncompleto = null)
    {
        $this->tratamientoIncompleto = $tratamientoIncompleto;

        return $this;
    }

    /**
     * Get tratamientoIncompleto.
     *
     * @return int|null
     */
    public function getTratamientoIncompleto()
    {
        return $this->tratamientoIncompleto;
    }

        /**
     * Set residuo.
     *
     * @param Residuo $residuo
     *
     * @return Residuo
     */
    public function setResiduo($residuo)
    {
        $this->residuo = $residuo;

        return $this;
    }

    /**
     * Get residuo.
     *
     * @return Residuo
     */
    public function getResiduo()
    {
        return $this->residuo;
    }
}
