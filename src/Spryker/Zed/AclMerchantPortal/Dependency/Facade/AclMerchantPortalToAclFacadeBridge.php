<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Dependency\Facade;

use Generated\Shared\Transfer\AclUserHasGroupCollectionTransfer;
use Generated\Shared\Transfer\AclUserHasGroupCriteriaTransfer;
use Generated\Shared\Transfer\GroupCriteriaTransfer;
use Generated\Shared\Transfer\GroupsTransfer;
use Generated\Shared\Transfer\GroupTransfer;
use Generated\Shared\Transfer\RolesTransfer;
use Generated\Shared\Transfer\RoleTransfer;
use Generated\Shared\Transfer\RuleTransfer;

class AclMerchantPortalToAclFacadeBridge implements AclMerchantPortalToAclFacadeInterface
{
    /**
     * @var \Spryker\Zed\Acl\Business\AclFacadeInterface
     */
    protected $aclFacade;

    /**
     * @param \Spryker\Zed\Acl\Business\AclFacadeInterface $aclFacade
     */
    public function __construct($aclFacade)
    {
        $this->aclFacade = $aclFacade;
    }

    public function addRule(RuleTransfer $ruleTransfer): RuleTransfer
    {
        return $this->aclFacade->addRule($ruleTransfer);
    }

    public function createGroup(GroupTransfer $groupTransfer, RolesTransfer $rolesTransfer): GroupTransfer
    {
        return $this->aclFacade->createGroup($groupTransfer, $rolesTransfer);
    }

    public function createRole(RoleTransfer $roleTransfer): RoleTransfer
    {
        return $this->aclFacade->createRole($roleTransfer);
    }

    public function findGroup(GroupCriteriaTransfer $groupCriteriaTransfer): ?GroupTransfer
    {
        return $this->aclFacade->findGroup($groupCriteriaTransfer);
    }

    public function addUserToGroup(int $idUser, int $idGroup): int
    {
        return $this->aclFacade->addUserToGroup($idUser, $idGroup);
    }

    public function getUserGroups(int $idUser): GroupsTransfer
    {
        return $this->aclFacade->getUserGroups($idUser);
    }

    public function getAclUserHasGroupCollection(
        AclUserHasGroupCriteriaTransfer $aclUserHasGroupCriteriaTransfer
    ): AclUserHasGroupCollectionTransfer {
        return $this->aclFacade->getAclUserHasGroupCollection($aclUserHasGroupCriteriaTransfer);
    }

    public function getRoleByName(string $name): RoleTransfer
    {
        return $this->aclFacade->getRoleByName($name);
    }

    public function existsRoleRule(
        int $idAclRole,
        string $bundle,
        string $controller,
        string $action,
        string $type
    ): bool {
        return $this->aclFacade->existsRoleRule($idAclRole, $bundle, $controller, $action, $type);
    }

    public function updateGroup(GroupTransfer $transfer, RolesTransfer $rolesTransfer): GroupTransfer
    {
        return $this->aclFacade->updateGroup($transfer, $rolesTransfer);
    }

    public function existsRoleByName(string $name): bool
    {
        return $this->aclFacade->existsRoleByName($name);
    }

    public function getGroupRoles(int $idGroup): RolesTransfer
    {
        return $this->aclFacade->getGroupRoles($idGroup);
    }
}
