<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Creator;

use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Generated\Shared\Transfer\RoleTransfer;

interface AclRoleCreatorInterface
{
    public function createMerchantAclRole(MerchantTransfer $merchantTransfer): RoleTransfer;

    public function createMerchantUserAclRole(MerchantUserTransfer $merchantUserTransfer): RoleTransfer;
}
