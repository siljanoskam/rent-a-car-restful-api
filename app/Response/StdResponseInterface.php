<?php

namespace App\Response;

use App\Response\Partials\ErrorWarning as ErrorWarningPartial;

/**
 * Defines common methods that must exist on every response.
 */
interface StdResponseInterface extends StdEmptyResponseInterface
{
    /**
     * Set an array of warnings into the response
     * @param ErrorWarningPartial[] $warnings
     *
     * @return void
     */
    public function setWarnings(array $warnings);

    /**
     * Add a single warning to the response
     * @param ErrorWarningPartial $warning
     *
     * @return void
     */
    public function addWarning(ErrorWarningPartial $warning);
}
