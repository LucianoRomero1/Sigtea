<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Maspyma\UsuariosBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @UniqueEntity(fields = {"iup", "fechaBaja"}, ignoreNull = false, groups={"empleado"})
 */
class Usuario  implements UserInterface, \Serializable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="iup", nullable=true)
     * @Assert\NotBlank(groups={"empleado"}) 
     * @Assert\Length(max="35", groups={"empleado"})
     */
    protected $iup;

    /**
     * @ORM\Column(name="roles", type="array", nullable=true)
     * 
     * @Assert\NotBlank(groups={"empleado"})
     * @var array
     */
    protected $roles;

    /**
     * @ORM\Column(name="fechaAlta",type="datetime")
     * @Assert\Date()
     */
    protected $fechaAlta;

    /**
     * @ORM\Column(name="fechaBaja",type="datetime", nullable=true)
     * @Assert\Date()
     */
    protected $fechaBaja;

    /**
     * @ORM\Column(name="fechaUltimaModificacion",type="datetime")
     * @Assert\Date()
     */
    protected $fechaUltimaModificacion;

    /**
     * @ORM\Column(name="usuarioUltimaModificacion",type="string", length=50)
     */
    protected $usuarioUltimaModificacion;

    public function __construct() {
        $this->roles = array();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set iup
     *
     * @param string $iup
     * @return Usuario
     */
    public function setIup($iup) {
        $this->iup = $iup;

        return $this;
    }

    /**
     * Get iup
     *
     * @return string 
     */
    public function getIup() {
        return $this->iup;
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        
    }

    public function setRoles(array $roles) {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    public function getRoles() {
        $roles = $this->roles;

        // we need to make sure to have at least one role
//    $roles[] = $this->container->getParameter('usuarios.role_default');

        return array_unique($roles);
    }

    public function addRole($role) {
        $role = strtoupper($role);

//    if ($role === $this->container->getParameter('usuarios.role_default')) {
//      return $this;
//    }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function getSalt() {
        
    }

    public function getUsername() {
        return $this->iup;
    }

    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     *         $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role) {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function removeRole($role) {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Localidad
     */
    public function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta() {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return Localidad
     */
    public function setFechaBaja($fechaBaja) {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja() {
        return $this->fechaBaja;
    }

    /**
     * Set fechaUltimaModificacion
     *
     * @param DateTime $fechaUltimaModificacion
     * @return Localidad
     */
    public function setFechaUltimaModificacion($fechaUltimaModificacion) {
        $this->fechaUltimaModificacion = $fechaUltimaModificacion;

        return $this;
    }

    /**
     * Get fechaUltimaModificacion
     *
     * @return DateTime 
     */
    public function getFechaUltimaModificacion() {
        return $this->fechaUltimaModificacion;
    }

    /**
     * Set usuarioUltimaModificacion
     *
     * @param string $usuarioUltimaModificacion
     * @return Localidad
     */
    public function setUsuarioUltimaModificacion($usuarioUltimaModificacion) {
        $this->usuarioUltimaModificacion = $usuarioUltimaModificacion;

        return $this;
    }

    /**
     * Get usuarioUltimaModificacion
     *
     * @return string 
     */
    public function getUsuarioUltimaModificacion() {
        return $this->usuarioUltimaModificacion;
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->iup
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->iup
                ) = unserialize($serialized);
    }

}