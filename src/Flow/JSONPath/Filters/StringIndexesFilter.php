<?php
namespace Flow\JSONPath\Filters;

use Flow\JSONPath\AccessHelper;

class StringIndexesFilter extends AbstractFilter
{
    /**
     * @param $collection
     * @return array
     */
    public function filter($collection)
    {
        $return = [];
        foreach ($this->token->value as $index) {
            if (AccessHelper::keyExists($collection, $index, $this->magicIsAllowed)) {
                $return[$index] = AccessHelper::getValue($collection, $index, $this->magicIsAllowed);
            }
        }
        return [$return];
    }
}
 