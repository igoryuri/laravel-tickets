<?php
declare(strict_types=1);


namespace App\Handlers;

use App\User as EloquentUser;
use Adldap\Models\User as LdapUser;

class LdapAttributeHandler
{
    /**
     * @param LdapUser $ldapUser
     * @param LdapUser $eloquentUser
     *
     * @return void
     */

    public function handle(LdapUser $ldapUser, EloquentUser $eloquentUser)
    {
        $eloquentUser->name = $ldapUser->getCommonName();
        $eloquentUser->username = $ldapUser->getAccountName();
        $eloquentUser->email = $ldapUser->getEmail();
        $eloquentUser->groups = implode(',', $ldapUser->getGroupNames());
        $eloquentUser->access_level = 10;
        $eloquentUser->department_id = 1;
//        dd($ldapUser->getGroupNames());

        foreach ($ldapUser->getGroupNames() as $group) {
            if ($group == "GRP-Intranet-admin") {
                $eloquentUser->access_level = 1;
                $eloquentUser->department_id = 2;
            }
        }

    }

}