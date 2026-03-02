<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Creator;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;

interface AclEntityCreatorInterface
{
    public function createAclEntitiesForMerchant(MerchantTransfer $merchantTransfer): MerchantResponseTransfer;

    public function createAclEntitiesForMerchantUser(MerchantUserTransfer $merchantUserTransfer): MerchantUserTransfer;
}
