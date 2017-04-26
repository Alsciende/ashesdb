<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of User
 * 
 * @ORM\Entity
 * @ORM\Table(name="users")
 * 
 * @author Alsciende <alsciende@icloud.com>
 */
class User implements UserInterface
{

    /**
     * @ORM\Column(name="id", type="string", length=255, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     *
     * @ORM\Column(name="password",type="string",length=255)
     */
    private $password;

    /**
     *
     * @var array
     * 
     * @ORM\Column(name="roles",type="simple_array")
     */
    private $roles;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="is_enabled",type="boolean")
     */
    private $enabled;
    
    function __construct ()
    {
        $this->roles = ['ROLE_USER'];
    }
    
    function getId ()
    {
        return $this->id;
    }

    public function getUsername ()
    {
        return $this->username;
    }

    public function getRoles ()
    {
        return $this->roles;
    }

    public function getPassword ()
    {
        return $this->password;
    }

    public function getSalt ()
    {
        
    }

    public function eraseCredentials ()
    {
        
    }

    function setUsername ($username)
    {
        $this->username = $username;
    }

    function setPassword ($password)
    {
        $this->password = $password;
    }

    function addRole ($role)
    {
        $roles = $this->roles;
        $roles[] = $role;
        $this->roles = array_unique($roles);
    }
    
    function getEnabled ()
    {
        return $this->enabled;
    }

    function setEnabled ($enabled)
    {
        $this->enabled = $enabled;
    }


}
