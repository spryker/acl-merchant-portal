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

interface AclMerchantPortalToAclFacadeInterface
{
    public function addRule(RuleTransfer $ruleTransfer): RuleTransfer;

    public function createGroup(GroupTransfer $groupTransfer, RolesTransfer $rolesTransfer): GroupTransfer;

    public function updateGroup(GroupTransfer $transfer, RolesTransfer $rolesTransfer): GroupTransfer;

    public function createRole(RoleTransfer $roleTransfer): RoleTransfer;

    public function getRoleByName(string $name): RoleTransfer;

    public function existsRoleByName(string $name): bool;

    public function findGroup(GroupCriteriaTransfer $groupCriteriaTransfer): ?GroupTransfer;

    public function addUserToGroup(int $idUser, int $idGroup): int;

    public function getUserGroups(int $idUser): GroupsTransfer;

    public function getGroupRoles(int $idGroup): RolesTransfer;

    public function getAclUserHasGroupCollection(
        AclUserHasGroupCriteriaTransfer $aclUserHasGroupCriteriaTransfer
    ): AclUserHasGroupCollectionTransfer;

    public function existsRoleRule(
        int $idAclRole,
        string $bundle,
        string $controller,
        string $action,
        string $type
    ): bool;
}
