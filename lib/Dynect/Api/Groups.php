<?php

namespace Dynect\Api;

use Dynect\Exception\MissingArgumentException;

class Groups extends AbstractApi implements ApiInterface
{
    public function all()
    {
        return $this->get('PermissionGroup');
    }

    public function info($name)
    {
        return $this->get('PermissionGroup/'.urlencode($name));
    }

    public function create($name, array $params, $validate = true)
    {
        if (!isset($params['description'])) {
            throw new MissingArgumentException('Group description is required');
        }

        if ($validate) {
            foreach ($params['zone'] as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->post('PermissionGroup/'.urlencode($name), $params);
    }

    public function update($name, array $params, $validate = true)
    {
        if ($validate) {
            foreach ($params['zone'] as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->put('PermissionGroup/'.urlencode($name), $params);
    }

    public function remove($name)
    {
        return $this->delete('PermissionGroup/'.urlencode($name));
    }

    public function addPermission($group, $permission)
    {
        return $this->post('PermissionGroupPermissionEntry/'.urlencode($group).'/'.urlencode($permission));
    }

    public function updatePermissions($group, array $permissions)
    {
        return $this->put('PermissionGroupPermissionEntry/'.urlencode($group), array(
            'permission' => $permissions
        ));
    }

    public function removePermission($group, $permission)
    {
        return $this->delete('PermissionGroupPermissionEntry/'.urlencode($group).'/'.urlencode($permission));
    }

    public function addSubGroup($group, $subgroup)
    {
        return $this->post('PermissionGroupSubgroupEntry/'.urlencode($group).'/'.urlencode($subgroup));
    }

    public function updateSubgroups($group, array $subgroups)
    {
        return $this->put('PermissionGroupSubgroupEntry/'.urlencode($group), array(
            'subgroup' => $subgroups
        ));
    }

    public function removeSubgroup($group, $subgroup)
    {
        return $this->delete('PermissionGroupSubgroupEntry/'.urlencode($group).'/'.urlencode($subgroup));
    }

    public function addUser($group, $username)
    {
        return $this->post('PermissionGroupUserEntry/'.urlencode($group).'/'.urlencode($username));
    }

    public function updateUsers($group, array $users)
    {
        return $this->put('PermissionGroupUserEntry/'.urlencode($group), array(
            'user_name' => $users
        ));
    }

    public function removeUser($group, $username)
    {
        return $this->delete('PermissionGroupUserEntry/'.urlencode($group).'/'.urlencode($username));
    }

    public function addZone($group, $zone, $recurse = true)
    {
        return $this->post('PermissionGroupZoneEntry/'.urlencode($group).'/'.urlencode($zone), array(
            'recurse' => $recurse ? self::OPTION_YES : self::OPTION_NO
        ));
    }

    public function updateZones($group, array $zones, $validate = true)
    {
        if ($validate) {
            foreach ($zones as $zone) {
                if (!isset($zone['zone_name'])) {
                    throw new MissingArgumentException('Zone name is missing');
                }
            }
        }

        return $this->put('PermissionGroupZoneEntry/'.urlencode($group), array(
            'zone' => $zones
        ));
    }

    public function removeZone($group, $zone, $recurse = true)
    {
        return $this->delete('PermissionGroupZoneEntry/'.urlencode($group).'/'.urlencode($zone), array(
            'recurse' => $recurse ? self::OPTION_YES : self::OPTION_NO
        ));
    }
}