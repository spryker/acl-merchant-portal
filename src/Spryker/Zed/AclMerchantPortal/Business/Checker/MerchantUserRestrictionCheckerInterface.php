<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Checker;

use Generated\Shared\Transfer\MerchantUserTransfer;

interface MerchantUserRestrictionCheckerInterface
{
    public function isLoginRestricted(MerchantUserTransfer $merchantUserTransfer): bool;
}
