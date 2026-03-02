<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Writer;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;

/**
 * @deprecated Use {@link \Spryker\Zed\AclMerchantPortal\Business\Creator\AclEntityCreatorInterface} instead.
 */
interface AclMerchantPortalWriterInterface
{
    public function createMerchantAclData(MerchantTransfer $merchantTransfer): MerchantResponseTransfer;

    public function createMerchantUserAclData(MerchantUserTransfer $merchantUserTransfer): MerchantUserTransfer;
}
