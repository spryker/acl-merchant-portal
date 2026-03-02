<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Expander\AclEntity;

use Generated\Shared\Transfer\AclEntityMetadataConfigTransfer;

/**
 * @deprecated Use {@link \Spryker\Zed\AclMerchantPortal\Business\Expander\AclEntityConfigurationExpanderInterface} instead.
 */
interface AclEntityMetadataConfigExpanderInterface
{
    public function expandAclEntityMetadataConfig(
        AclEntityMetadataConfigTransfer $aclEntityMetadataConfigTransfer
    ): AclEntityMetadataConfigTransfer;
}
