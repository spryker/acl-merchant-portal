<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Generator;

use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig;

class AclMerchantPortalGenerator implements AclMerchantPortalGeneratorInterface
{
    /**
     * @var string
     */
    protected const KEY_MERCHANT_PORTAL = 'MerchantPortral';

    /**
     * @var \Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig
     */
    protected AclMerchantPortalConfig $aclMerchantPortalConfig;

    public function __construct(AclMerchantPortalConfig $aclMerchantPortalConfig)
    {
        $this->aclMerchantPortalConfig = $aclMerchantPortalConfig;
    }

    public function generateAclMerchantRoleName(MerchantTransfer $merchantTransfer): string
    {
        return $this->generateMerchantPortalKeyToMerchantNameConjunction($merchantTransfer);
    }

    public function generateAclMerchantGroupName(MerchantTransfer $merchantTransfer): string
    {
        return $this->generateMerchantPortalKeyToMerchantNameConjunction($merchantTransfer);
    }

    public function generateAclMerchantUserRoleName(MerchantUserTransfer $merchantUserTransfer): string
    {
        return $this->generateMerchantNameToMerchantUserNameConjunction(
            $merchantUserTransfer->getMerchantOrFail(),
            $merchantUserTransfer->getUserOrFail(),
        );
    }

    public function generateAclMerchantUserGroupName(MerchantUserTransfer $merchantUserTransfer): string
    {
        return $this->generateMerchantNameToMerchantUserNameConjunction(
            $merchantUserTransfer->getMerchantOrFail(),
            $merchantUserTransfer->getUserOrFail(),
        );
    }

    public function generateAclMerchantReference(MerchantTransfer $merchantTransfer): string
    {
        return sprintf(
            '%s%s',
            $this->aclMerchantPortalConfig->getMerchantAclReferencePrefix(),
            $merchantTransfer->getMerchantReferenceOrFail(),
        );
    }

    public function generateAclMerchantSegmentName(MerchantTransfer $merchantTransfer): string
    {
        return $this->generateMerchantPortalKeyToMerchantNameConjunction($merchantTransfer);
    }

    public function generateAclMerchantUserSegmentName(MerchantTransfer $merchantTransfer, UserTransfer $userTransfer): string
    {
        return $this->generateMerchantNameToMerchantUserNameConjunction($merchantTransfer, $userTransfer);
    }

    public function generateAclMerchantUserReference(UserTransfer $userTransfer): string
    {
        return sprintf(
            '%s%d',
            $this->aclMerchantPortalConfig->getMerchantUserAclReferencePrefix(),
            $userTransfer->getIdUserOrFail(),
        );
    }

    protected function generateMerchantPortalKeyToMerchantNameConjunction(MerchantTransfer $merchantTransfer): string
    {
        return sprintf(
            '%s - %s',
            $merchantTransfer->getNameOrFail(),
            static::KEY_MERCHANT_PORTAL,
        );
    }

    protected function generateMerchantNameToMerchantUserNameConjunction(
        MerchantTransfer $merchantTransfer,
        UserTransfer $userTransfer
    ): string {
        if ($this->aclMerchantPortalConfig->isMerchantToMerchantUserConjunctionByUsernameEnabled()) {
            return sprintf(
                '%s - %s - %s',
                $merchantTransfer->getNameOrFail(),
                static::KEY_MERCHANT_PORTAL,
                $userTransfer->getUsernameOrFail(),
            );
        }

        return sprintf(
            '%s - %s - %s %s',
            $merchantTransfer->getNameOrFail(),
            static::KEY_MERCHANT_PORTAL,
            $userTransfer->getFirstNameOrFail(),
            $userTransfer->getLastNameOrFail(),
        );
    }
}
