<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Creator;

use Generated\Shared\Transfer\AclEntitySegmentTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;

interface AclEntitySegmentCreatorInterface
{
    public function createMerchantAclEntitySegment(MerchantTransfer $merchantTransfer): AclEntitySegmentTransfer;

    public function createMerchantUserAclEntitySegment(MerchantUserTransfer $merchantUserTransfer): AclEntitySegmentTransfer;
}
