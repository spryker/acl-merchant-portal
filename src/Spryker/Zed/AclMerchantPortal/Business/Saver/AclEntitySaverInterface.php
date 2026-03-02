<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Saver;

use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;

interface AclEntitySaverInterface
{
    public function saveAclEntitiesForMerchant(MerchantTransfer $merchantTransfer): void;

    public function saveAclEntitiesForMerchantUser(MerchantUserTransfer $merchantUserTransfer): void;
}
