<?php

namespace App\Response;

use App\Response\Partials\Pagination as PaginationPartial;

/**
 * A response object used for lists
 */
class Std200ListResponse extends StdResponse
{
    /**
     * The list of items that will be sent on the response
     * @var mixed[]
     */
    public $items;

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }
}
