<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\ConditionChecker\MerchantUser;

use Generated\Shared\Transfer\UserTransfer;

interface UserRoleFilterConditionCheckerInterface
{
    public function checkUserRoleFilterCondition(UserTransfer $userTransfer, string $role): bool;
}
