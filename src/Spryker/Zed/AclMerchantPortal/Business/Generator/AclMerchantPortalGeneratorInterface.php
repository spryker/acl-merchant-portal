<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Generator;

use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Generated\Shared\Transfer\UserTransfer;

interface AclMerchantPortalGeneratorInterface
{
    public function generateAclMerchantRoleName(MerchantTransfer $merchantTransfer): string;

    public function generateAclMerchantGroupName(MerchantTransfer $merchantTransfer): string;

    public function generateAclMerchantUserRoleName(MerchantUserTransfer $merchantUserTransfer): string;

    public function generateAclMerchantUserGroupName(MerchantUserTransfer $merchantUserTransfer): string;

    public function generateAclMerchantReference(MerchantTransfer $merchantTransfer): string;

    public function generateAclMerchantSegmentName(MerchantTransfer $merchantTransfer): string;

    public function generateAclMerchantUserSegmentName(MerchantTransfer $merchantTransfer, UserTransfer $userTransfer): string;

    public function generateAclMerchantUserReference(UserTransfer $userTransfer): string;
}
