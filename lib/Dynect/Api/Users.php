<?php

namespace Dynect\Api;

use Dynect\Exception\MissingArgumentException;

class Users extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('User');
    }

    public function info($username)
    {
        return $this->get('User/'.urlencode($username));
    }

    public function create($username, array $params)
    {
        if (!isset($params['email'])) {
            throw new MissingArgumentException('User email address must be supplied');
        }

        if (!isset($params['first_name'])) {
            throw new MissingArgumentException('User first name must be supplied');
        }

        if (!isset($params['last_name'])) {
            throw new MissingArgumentException('User last name must be supplied');
        }

        if (!isset($params['nickname'])) {
            throw new MissingArgumentException('User nickname must be supplied');
        }

        if (!isset($params['organization'])) {
            throw new MissingArgumentException('Contact organization must be supplied');
        }

        if (!isset($params['password'])) {
            throw new MissingArgumentException('Contact password must be supplied');
        }

        if (!isset($params['phone'])) {
            throw new MissingArgumentException('Contact phone must be supplied');
        }

        return $this->post('User/'.urlencode($username), $params);
    }

    public function update($username, array $params)
    {
        return $this->put('User/'.urlencode($username), $params);
    }

    public function remove($username)
    {
        return $this->delete('User/'.urlencode($username));
    }

    public function forbid($username, $permission, array $zones, $validate = true)
    {
        if ($validate) {
            foreach ($zones as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->post('UserForbidEntry/'.urlencode($username).'/'.urlencode($permission), array(
            'zone' => $zones
        ));
    }

    public function removeForbid($username, $permission, array $zones, $validate = true)
    {
        if ($validate) {
            foreach ($zones as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->delete('UserForbidEntry/'.urlencode($username).'/'.urlencode($permission), array(
            'zone' => $zones
        ));
    }

    public function replaceForbids($username, array $permissions, $validate = true)
    {
        if ($validate) {
            foreach ($permissions as $permission) {
                if (!isset($permission['name'])) {
                    throw new MissingArgumentException('Permission name is missing');
                }

                foreach ($permission['zone'] as $zone) {
                    if (!isset($zone['zone_name'])) {
                        throw new MissingArgumentException('Zone name is missing');
                    }
                }
            }
        }

        return $this->put('UserForbidEntry/'.urlencode($username), array(
            'forbid' => $permissions
        ));
    }

    public function addToGroup($username, $group)
    {
        return $this->post('UserGroupEntry/'.urlencode($username).'/'.urlencode($group));
    }

    public function removeFromGroup($username, $group)
    {
        return $this->delete('UserGroupEntry/'.urlencode($username).'/'.urlencode($group));
    }

    public function updateGroups($username, array $groups)
    {
        return $this->put('UserGroupEntry/'.urlencode($username), array(
            'group' => $groups
        ));
    }

    public function addPermission($username, $permission)
    {
        return $this->post('UserPermissionEntry/'.urlencode($username).'/'.urlencode($permission));
    }

    public function removePermission($username, $permission)
    {
        return $this->delete('UserPermissionEntry/'.urlencode($username).'/'.urlencode($permission));
    }

    public function updatePermissions($username, array $permissions)
    {
        return $this->put('UserPermissionEntry/'.urlencode($username), array(
            'permission' => $permissions
        ));
    }

    public function addZone($username, $zone, $recurse = true)
    {
        return $this->post('UserZoneEntry/'.urlencode($username).'/'.urlencode($zone), array(
            'recurse' => $recurse ? self::OPTION_YES : self::OPTION_NO
        ));
    }

    public function removeZone($username, $zone, $recurse = true)
    {
        return $this->delete('UserZoneEntry/'.urlencode($username).'/'.urlencode($zone), array(
            'recurse' => $recurse ? self::OPTION_YES : self::OPTION_NO
        ));
    }

    public function updateZone($username, array $zones, $validate = true)
    {
        if ($validate) {
            foreach ($zones as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->put('UserZoneEntry/'.urlencode($username), array(
            'zone' => $zones
        ));
    }
}