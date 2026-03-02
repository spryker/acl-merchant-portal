<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Saver;

use ArrayObject;
use Generated\Shared\Transfer\AclEntitySegmentConditionsTransfer;
use Generated\Shared\Transfer\AclEntitySegmentCriteriaTransfer;
use Generated\Shared\Transfer\AclEntitySegmentTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Generated\Shared\Transfer\RoleTransfer;
use Spryker\Zed\AclMerchantPortal\Business\Creator\AclEntityRuleCreatorInterface;
use Spryker\Zed\AclMerchantPortal\Business\Creator\AclEntitySegmentCreatorInterface;
use Spryker\Zed\AclMerchantPortal\Business\Creator\AclRuleCreatorInterface;
use Spryker\Zed\AclMerchantPortal\Business\Generator\AclMerchantPortalGeneratorInterface;
use Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclEntityFacadeInterface;
use Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface;

class AclRoleSaver implements AclRoleSaverInterface
{
    /**
     * @var \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface
     */
    protected AclMerchantPortalToAclFacadeInterface $aclFacade;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Business\Creator\AclEntitySegmentCreatorInterface
     */
    protected AclEntitySegmentCreatorInterface $aclEntitySegmentCreator;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Business\Creator\AclRuleCreatorInterface
     */
    protected AclRuleCreatorInterface $aclRuleCreator;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Business\Creator\AclEntityRuleCreatorInterface
     */
    protected AclEntityRuleCreatorInterface $aclEntityRuleCreator;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Business\Generator\AclMerchantPortalGeneratorInterface
     */
    protected AclMerchantPortalGeneratorInterface $aclMerchantPortalGenerator;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclEntityFacadeInterface
     */
    protected AclMerchantPortalToAclEntityFacadeInterface $aclEntityFacade;

    public function __construct(
        AclMerchantPortalToAclFacadeInterface $aclFacade,
        AclEntitySegmentCreatorInterface $aclEntitySegmentCreator,
        AclRuleCreatorInterface $aclRuleCreator,
        AclEntityRuleCreatorInterface $aclEntityRuleCreator,
        AclMerchantPortalGeneratorInterface $aclMerchantPortalGenerator,
        AclMerchantPortalToAclEntityFacadeInterface $aclEntityFacade
    ) {
        $this->aclFacade = $aclFacade;
        $this->aclEntitySegmentCreator = $aclEntitySegmentCreator;
        $this->aclRuleCreator = $aclRuleCreator;
        $this->aclEntityRuleCreator = $aclEntityRuleCreator;
        $this->aclMerchantPortalGenerator = $aclMerchantPortalGenerator;
        $this->aclEntityFacade = $aclEntityFacade;
    }

    public function saveMerchantAclRole(MerchantTransfer $merchantTransfer): RoleTransfer
    {
        $aclMerchantRoleName = $this->aclMerchantPortalGenerator->generateAclMerchantRoleName($merchantTransfer);
        $aclMerchantReference = $this->aclMerchantPortalGenerator->generateAclMerchantReference($merchantTransfer);
        $roleTransfer = $this->createRoleTransfer($aclMerchantRoleName, $aclMerchantReference);

        $roleTransfer = $this->getRoleTransfer($roleTransfer);

        $aclEntitySegmentTransfer = $this->findAclEntitySegmentByReference($aclMerchantReference);
        if (!$aclEntitySegmentTransfer) {
            $aclEntitySegmentTransfer = $this->aclEntitySegmentCreator->createMerchantAclEntitySegment($merchantTransfer);
        }

        return $roleTransfer
            ->setAclRules(new ArrayObject($this->aclRuleCreator->createMerchantAclRules($roleTransfer)))
            ->setAclEntityRules(new ArrayObject($this->aclEntityRuleCreator->createMerchantAclEntityRules($roleTransfer, $aclEntitySegmentTransfer)));
    }

    public function saveMerchantUserAclRole(MerchantUserTransfer $merchantUserTransfer): RoleTransfer
    {
        $aclMerchantUserRoleName = $this->aclMerchantPortalGenerator->generateAclMerchantUserRoleName($merchantUserTransfer);
        $aclMerchantUserReference = $this->aclMerchantPortalGenerator->generateAclMerchantUserReference($merchantUserTransfer->getUserOrFail());
        $roleTransfer = $this->createRoleTransfer($aclMerchantUserRoleName, $aclMerchantUserReference);

        $roleTransfer = $this->getRoleTransfer($roleTransfer);

        $aclEntitySegmentTransfer = $this->findAclEntitySegmentByReference($aclMerchantUserReference);
        if (!$aclEntitySegmentTransfer) {
            $aclEntitySegmentTransfer = $this->aclEntitySegmentCreator->createMerchantUserAclEntitySegment($merchantUserTransfer);
        }

        return $roleTransfer
            ->setAclRules(new ArrayObject($this->aclRuleCreator->createMerchantUserAclRules($roleTransfer)))
            ->setAclEntityRules(new ArrayObject($this->aclEntityRuleCreator->createMerchantUserAclEntityRules($roleTransfer, $aclEntitySegmentTransfer)));
    }

    protected function getRoleTransfer(RoleTransfer $roleTransfer): RoleTransfer
    {
        $roleExists = $this->aclFacade->existsRoleByName($roleTransfer->getNameOrFail());
        if ($roleExists) {
            return $this->aclFacade->getRoleByName($roleTransfer->getNameOrFail());
        }

        return $this->aclFacade->createRole($roleTransfer);
    }

    protected function findAclEntitySegmentByReference(string $reference): ?AclEntitySegmentTransfer
    {
        $aclEntitySegmentCriteriaTransfer = (new AclEntitySegmentCriteriaTransfer())
            ->setAclEntitySegmentConditions((new AclEntitySegmentConditionsTransfer())->addReference($reference));

        $aclEntitySegmentCollectionTransfer = $this->aclEntityFacade->getAclEntitySegmentCollection($aclEntitySegmentCriteriaTransfer);

        if ($aclEntitySegmentCollectionTransfer->getAclEntitySegments()->count() === 0) {
            return null;
        }

        return $aclEntitySegmentCollectionTransfer->getAclEntitySegments()->offsetGet(0);
    }

    protected function createRoleTransfer(string $aclMerchantRoleName, string $aclMerchantReference): RoleTransfer
    {
        return (new RoleTransfer())
            ->setName($aclMerchantRoleName)
            ->setReference($aclMerchantReference);
    }
}
