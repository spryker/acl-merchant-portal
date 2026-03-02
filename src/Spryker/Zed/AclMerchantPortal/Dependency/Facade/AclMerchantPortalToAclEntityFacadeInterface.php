<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Dependency\Facade;

use ArrayObject;
use Generated\Shared\Transfer\AclEntityRuleCollectionTransfer;
use Generated\Shared\Transfer\AclEntityRuleCriteriaTransfer;
use Generated\Shared\Transfer\AclEntitySegmentCollectionTransfer;
use Generated\Shared\Transfer\AclEntitySegmentCriteriaTransfer;
use Generated\Shared\Transfer\AclEntitySegmentRequestTransfer;
use Generated\Shared\Transfer\AclEntitySegmentResponseTransfer;

interface AclMerchantPortalToAclEntityFacadeInterface
{
    public function getAclEntitySegmentCollection(
        AclEntitySegmentCriteriaTransfer $aclEntitySegmentCriteriaTransfer
    ): AclEntitySegmentCollectionTransfer;

    public function createAclEntitySegment(AclEntitySegmentRequestTransfer $aclEntitySegmentRequestTransfer): AclEntitySegmentResponseTransfer;

    public function getAclEntityRuleCollection(AclEntityRuleCriteriaTransfer $aclEntityRuleCriteriaTransfer): AclEntityRuleCollectionTransfer;

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\AclEntityRuleTransfer> $aclEntityRuleTransfers
     *
     * @return void
     */
    public function saveAclEntityRules(ArrayObject $aclEntityRuleTransfers): void;
}
