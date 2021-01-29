<?php
/* Icinga Web 2 | (c) 2016 Icinga Development Team | GPLv2+ */

namespace Icinga\Authentication;

class Role
{
    /**
     * Name of the role
     *
     * @var string
     */
    protected $name;

    /**
     * Permissions of the role
     *
     * @var string[]
     */
    protected $permissions = [];

    /**
     * Refusals of the role
     *
     * @var string[]
     */
    protected $refusals = [];

    /**
     * Restrictions of the role
     *
     * @var string[]
     */
    protected $restrictions = [];

    /**
     * Get the name of the role
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the role
     *
     * @param   string  $name
     *
     * @return  $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the permissions of the role
     *
     * @return  string[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Set the permissions of the role
     *
     * @param   string[]    $permissions
     *
     * @return  $this
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get the refusals of the role
     *
     * @return string[]
     */
    public function getRefusals()
    {
        return $this->refusals;
    }

    /**
     * Set the refusals of the role
     *
     * @param array $refusals
     *
     * @return $this
     */
    public function setRefusals(array $refusals)
    {
        $this->refusals = $refusals;

        return $this;
    }

    /**
     * Get the restrictions of the role
     *
     * @param   string  $name   Optional name of the restriction
     *
     * @return  string[]|null
     */
    public function getRestrictions($name = null)
    {
        $restrictions = $this->restrictions;

        if ($name === null) {
            return $restrictions;
        }

        if (isset($restrictions[$name])) {
            return $restrictions[$name];
        }

        return null;
    }

    /**
     * Set the restrictions of the role
     *
     * @param   string[]    $restrictions
     *
     * @return  $this
     */
    public function setRestrictions(array $restrictions)
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    /**
     * Whether this role grants the given permission
     *
     * @param string $permission
     *
     * @return bool
     */
    public function grants($permission)
    {
        foreach ($this->permissions as $grantedPermission) {
            if ($this->match($grantedPermission, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Whether this role denies the given permission
     *
     * @param string $permission
     *
     * @return bool
     */
    public function denies($permission)
    {
        foreach ($this->refusals as $refusedPermission) {
            if ($this->match($refusedPermission, $permission, false)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get whether the role expression matches the required permission
     *
     * @param string $roleExpression
     * @param string $requiredPermission
     * @param bool $cascadeUpwards `false` if `foo/bar/*` and `foo/bar/raboof` should not match `foo/*`
     *
     * @return bool
     */
    protected function match($roleExpression, $requiredPermission, $cascadeUpwards = true)
    {
        if ($roleExpression === '*' || $roleExpression === $requiredPermission) {
            return true;
        }

        $requiredWildcard = strpos($requiredPermission, '*');
        if ($requiredWildcard !== false) {
            if (($grantedWildcard = strpos($roleExpression, '*')) !== false) {
                $wildcard = $cascadeUpwards ? min($requiredWildcard, $grantedWildcard) : $grantedWildcard;
            } else {
                $wildcard = $cascadeUpwards ? $requiredWildcard : false;
            }
        } else {
            $wildcard = strpos($roleExpression, '*');
        }

        if ($wildcard !== false && $wildcard > 0) {
            if (substr($requiredPermission, 0, $wildcard) === substr($roleExpression, 0, $wildcard)) {
                return true;
            }
        } elseif ($requiredPermission === $roleExpression) {
            return true;
        }

        return false;
    }
}
