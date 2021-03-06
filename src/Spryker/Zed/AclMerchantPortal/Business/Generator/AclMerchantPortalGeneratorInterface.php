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
    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return string
     */
    public function generateAclMerchantRoleName(MerchantTransfer $merchantTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return string
     */
    public function generateAclMerchantGroupName(MerchantTransfer $merchantTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantUserTransfer $merchantUserTransfer
     *
     * @return string
     */
    public function generateAclMerchantUserRoleName(MerchantUserTransfer $merchantUserTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantUserTransfer $merchantUserTransfer
     *
     * @return string
     */
    public function generateAclMerchantUserGroupName(MerchantUserTransfer $merchantUserTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return string
     */
    public function generateAclMerchantReference(MerchantTransfer $merchantTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return string
     */
    public function generateAclMerchantSegmentName(MerchantTransfer $merchantTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return string
     */
    public function generateAclMerchantUserSegmentName(MerchantTransfer $merchantTransfer, UserTransfer $userTransfer): string;

    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return string
     */
    public function generateAclMerchantUserReference(UserTransfer $userTransfer): string;
}
