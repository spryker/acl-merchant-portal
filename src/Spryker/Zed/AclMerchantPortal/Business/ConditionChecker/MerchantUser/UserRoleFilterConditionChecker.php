<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\ConditionChecker\MerchantUser;

use Generated\Shared\Transfer\UserTransfer;
use Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig;
use Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface;

class UserRoleFilterConditionChecker implements UserRoleFilterConditionCheckerInterface
{
    /**
     * @var \Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig
     */
    protected $config;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface
     */
    protected $aclMerchantPortalToAclFacadeBridge;

    public function __construct(
        AclMerchantPortalConfig $config,
        AclMerchantPortalToAclFacadeInterface $aclMerchantPortalToAclFacadeBridge
    ) {
        $this->config = $config;
        $this->aclMerchantPortalToAclFacadeBridge = $aclMerchantPortalToAclFacadeBridge;
    }

    public function checkUserRoleFilterCondition(UserTransfer $userTransfer, string $role): bool
    {
        if (!in_array($role, $this->config->getRolesWithBackofficeAccess()) || $userTransfer->getIdUser() === null) {
            return true;
        }

        $groupsTransfer = $this->aclMerchantPortalToAclFacadeBridge->getUserGroups(
            $userTransfer->getIdUser(),
        );

        foreach ($groupsTransfer->getGroups() as $group) {
            if (in_array($group->getReferenceOrFail(), $this->config->getBackofficeAllowedAclGroupReferences())) {
                return false;
            }
        }

        return true;
    }
}
