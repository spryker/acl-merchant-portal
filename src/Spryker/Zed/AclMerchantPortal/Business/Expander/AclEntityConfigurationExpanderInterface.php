<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Expander;

use Generated\Shared\Transfer\AclEntityMetadataConfigTransfer;

interface AclEntityConfigurationExpanderInterface
{
    public function expandAclEntityConfiguration(
        AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer
    ): AclEntityMetadataConfigTransfer;
}
