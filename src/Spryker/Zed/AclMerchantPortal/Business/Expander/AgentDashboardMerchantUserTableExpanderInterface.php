<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\AclMerchantPortal\Business\Expander;

use Generated\Shared\Transfer\GuiTableDataResponseTransfer;

interface AgentDashboardMerchantUserTableExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\GuiTableDataResponseTransfer $guiTableDataResponseTransfer
     *
     * @return \Generated\Shared\Transfer\GuiTableDataResponseTransfer
     */
    public function expand(GuiTableDataResponseTransfer $guiTableDataResponseTransfer): GuiTableDataResponseTransfer;
}
