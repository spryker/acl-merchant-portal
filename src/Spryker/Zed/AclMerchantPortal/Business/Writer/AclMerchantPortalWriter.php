<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Writer;

use ArrayObject;
use Generated\Shared\Transfer\AclEntitySegmentRequestTransfer;
use Generated\Shared\Transfer\AclEntitySegmentResponseTransfer;
use Generated\Shared\Transfer\AclEntitySegmentTransfer;
use Generated\Shared\Transfer\GroupCriteriaTransfer;
use Generated\Shared\Transfer\GroupTransfer;
use Generated\Shared\Transfer\MerchantErrorTransfer;
use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\MerchantUserTransfer;
use Generated\Shared\Transfer\RolesTransfer;
use Generated\Shared\Transfer\RoleTransfer;
use Orm\Zed\Merchant\Persistence\SpyMerchant;
use Orm\Zed\MerchantUser\Persistence\SpyMerchantUser;
use Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig;
use Spryker\Zed\AclMerchantPortal\Business\Generator\AclMerchantPortalGeneratorInterface;
use Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclEntityFacadeInterface;
use Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface;

class AclMerchantPortalWriter implements AclMerchantPortalWriterInterface
{
    protected const KEY_FK_MERCHANT = 'fk_merchant';
    protected const KEY_FK_MERCHANT_USER = 'fk_merchant_user';
    protected const ERROR_MESSAGE_MERCHANT_REFERENCE = 'Merchant reference not found';
    protected const ERROR_MESSAGE_MERCHANT_NAME = 'Merchant name not found';

    /**
     * @uses \Spryker\Shared\AclEntity\AclEntityConstants::SCOPE_SEGMENT
     */
    protected const SCOPE_SEGMENT = 'segment';

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface
     */
    protected $aclFacade;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclEntityFacadeInterface
     */
    protected $aclEntityFacade;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\Business\Generator\AclMerchantPortalGeneratorInterface
     */
    protected $aclMerchantPortalGenerator;

    /**
     * @var \Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig
     */
    protected $aclMerchantPortalConfig;

    /**
     * @param \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclFacadeInterface $aclFacade
     * @param \Spryker\Zed\AclMerchantPortal\Dependency\Facade\AclMerchantPortalToAclEntityFacadeInterface $aclEntityFacade
     * @param \Spryker\Zed\AclMerchantPortal\Business\Generator\AclMerchantPortalGeneratorInterface $aclMerchantPortalGenerator
     * @param \Spryker\Zed\AclMerchantPortal\AclMerchantPortalConfig $aclMerchantPortalConfig
     */
    public function __construct(
        AclMerchantPortalToAclFacadeInterface $aclFacade,
        AclMerchantPortalToAclEntityFacadeInterface $aclEntityFacade,
        AclMerchantPortalGeneratorInterface $aclMerchantPortalGenerator,
        AclMerchantPortalConfig $aclMerchantPortalConfig
    ) {
        $this->aclFacade = $aclFacade;
        $this->aclEntityFacade = $aclEntityFacade;
        $this->aclMerchantPortalGenerator = $aclMerchantPortalGenerator;
        $this->aclMerchantPortalConfig = $aclMerchantPortalConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function createMerchantAclData(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        $merchantResponseTransfer = (new MerchantResponseTransfer())
            ->setMerchant($merchantTransfer);

        if (!$merchantTransfer->getMerchantReference()) {
            return $merchantResponseTransfer->setIsSuccess(false)
                ->addError(
                    (new MerchantErrorTransfer())->setMessage(static::ERROR_MESSAGE_MERCHANT_REFERENCE)
                );
        }

        if (!$merchantTransfer->getName()) {
            return $merchantResponseTransfer->setIsSuccess(false)
                ->addError(
                    (new MerchantErrorTransfer())->setMessage(static::ERROR_MESSAGE_MERCHANT_NAME)
                );
        }

        $aclMerchantReference = $this->aclMerchantPortalGenerator->generateAclMerchantReference($merchantTransfer);
        $aclEntitySegmentResponseTransfer = $this->createMerchantAclEntitySegment(
            $merchantTransfer->getNameOrFail(),
            $aclMerchantReference,
            SpyMerchant::class,
            [$merchantTransfer->getIdMerchantOrFail()]
        );
        $roleTransfer = $this->createMerchantAclRole(
            $aclMerchantReference,
            $aclEntitySegmentResponseTransfer->getAclEntitySegmentOrFail(),
            $this->aclMerchantPortalConfig->getMerchantAclRoleRules(),
            $this->aclMerchantPortalConfig->getMerchantAclRoleEntityRules()
        );
        $rolesTransfer = (new RolesTransfer())->addRole($roleTransfer);
        $groupTransfer = (new GroupTransfer())
            ->setName($aclMerchantReference)
            ->setReference($aclMerchantReference);
        $this->aclFacade->createGroup($groupTransfer, $rolesTransfer);

        return $merchantResponseTransfer->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantUserTransfer $merchantUserTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantUserTransfer
     */
    public function createMerchantUserAclData(MerchantUserTransfer $merchantUserTransfer): MerchantUserTransfer
    {
        $aclMerchantReference = $this->aclMerchantPortalGenerator->generateAclMerchantReference(
            $merchantUserTransfer->getMerchantOrFail()
        );
        $aclMerchantUserSegmentName = $this->aclMerchantPortalGenerator->generateAclMerchantUserSegmentName(
            $merchantUserTransfer->getMerchantOrFail(),
            $merchantUserTransfer->getUserOrFail()
        );
        $aclMerchantUserReference = $this->aclMerchantPortalGenerator->generateAclMerchantUserReference(
            $merchantUserTransfer->getUserOrFail()
        );
        $groupCriteriaTransfer = (new GroupCriteriaTransfer())
            ->setReference($aclMerchantReference);

        $merchantGroupTransfer = $this->aclFacade->findGroup($groupCriteriaTransfer);
        $aclEntitySegmentResponseTransfer = $this->createMerchantAclEntitySegment(
            $aclMerchantUserSegmentName,
            $aclMerchantUserReference,
            SpyMerchantUser::class,
            [$merchantUserTransfer->getIdMerchantUserOrFail()]
        );
        $roleTransfer = $this->createMerchantAclRole(
            $aclMerchantUserReference,
            $aclEntitySegmentResponseTransfer->getAclEntitySegmentOrFail(),
            $this->aclMerchantPortalConfig->getMerchantUserAclRoleRules(),
            $this->aclMerchantPortalConfig->getMerchantUserAclRoleEntityRules()
        );
        $rolesTransfer = (new RolesTransfer())->addRole($roleTransfer);
        $groupTransfer = (new GroupTransfer())
            ->setName($aclMerchantUserReference)
            ->setReference($aclMerchantUserReference);
        $merchantUserGroupTransfer = $this->aclFacade->createGroup($groupTransfer, $rolesTransfer);

        if ($merchantGroupTransfer) {
            $this->aclFacade->addUserToGroup(
                $merchantUserTransfer->getIdUserOrFail(),
                $merchantGroupTransfer->getIdAclGroupOrFail()
            );
        }

        $this->aclFacade->addUserToGroup(
            $merchantUserTransfer->getIdUserOrFail(),
            $merchantUserGroupTransfer->getIdAclGroupOrFail()
        );

        return $merchantUserTransfer;
    }

    /**
     * @param string $name
     * @param string $reference
     * @param string $entity
     * @param int[] $entityIds
     *
     * @return \Generated\Shared\Transfer\AclEntitySegmentResponseTransfer
     */
    protected function createMerchantAclEntitySegment(
        string $name,
        string $reference,
        string $entity,
        array $entityIds = []
    ): AclEntitySegmentResponseTransfer {
        $aclEntitySegmentRequestTransfer = (new AclEntitySegmentRequestTransfer())
            ->setName($name)
            ->setReference($reference)
            ->setEntity($entity)
            ->setEntityIds($entityIds);

        return $this->aclEntityFacade->createAclEntitySegment($aclEntitySegmentRequestTransfer);
    }

    /**
     * @param string $roleReference
     * @param \Generated\Shared\Transfer\AclEntitySegmentTransfer $aclEntitySegmentTransfer
     * @param \Generated\Shared\Transfer\RuleTransfer[] $ruleTransfers
     * @param \Generated\Shared\Transfer\AclEntityRuleTransfer[] $aclEntityRuleTransfers
     *
     * @return \Generated\Shared\Transfer\RoleTransfer
     */
    protected function createMerchantAclRole(
        string $roleReference,
        AclEntitySegmentTransfer $aclEntitySegmentTransfer,
        array $ruleTransfers,
        array $aclEntityRuleTransfers
    ): RoleTransfer {
        $roleTransfer = (new RoleTransfer())
            ->setName($roleReference)
            ->setReference($roleReference);
        $roleTransfer = $this->aclFacade->createRole($roleTransfer);

        foreach ($ruleTransfers as $ruleTransfer) {
            $ruleTransfer->setFkAclRole($roleTransfer->getIdAclRole());
            $this->aclFacade->addRule($ruleTransfer);
        }

        foreach ($aclEntityRuleTransfers as $aclEntityRuleTransfer) {
            $aclEntityRuleTransfer->setIdAclRole($roleTransfer->getIdAclRole());

            if ($aclEntityRuleTransfer->getScope() === static::SCOPE_SEGMENT) {
                $aclEntityRuleTransfer->setIdAclEntitySegment($aclEntitySegmentTransfer->getIdAclEntitySegmentOrFail());
            }
        }
        $this->aclEntityFacade->saveAclEntityRules(new ArrayObject($aclEntityRuleTransfers));

        return $roleTransfer->setAclEntityRules(new ArrayObject($aclEntityRuleTransfers))
            ->setAclRules(new ArrayObject($ruleTransfers));
    }
}
