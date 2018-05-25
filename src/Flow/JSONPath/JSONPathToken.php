<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 6/25/15
 * Time: 12:52 PM
 */

namespace Flow\JSONPath;


class JSONPathToken
{
    /*
     * Tokens
     */
    const T_INDEX           = 'index';
    const T_RECURSIVE       = 'recursive';
    const T_QUERY_RESULT    = 'queryResult';
    const T_QUERY_MATCH     = 'queryMatch';
    const T_SLICE           = 'slice';
    const T_INDEXES         = 'indexes';
    const T_STRING_INDEXES  = 'stringIndexes';
    const T_COLUMN_INDEXES  = 'columnIndexes';

    public $type;
    public $value;

    public function __construct($type, $value)
    {
        $this->validateType($type);

        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @param $type
     * @throws JSONPathException
     */
    public function validateType($type)
    {
        if (!in_array($type, static::getTypes(), true)) {
            throw new JSONPathException('Invalid token: ' . $type);
        }
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            static::T_INDEX,
            static::T_RECURSIVE,
            static::T_QUERY_RESULT,
            static::T_QUERY_MATCH,
            static::T_SLICE,
            static::T_INDEXES,
            static::T_STRING_INDEXES,
            static::T_COLUMN_INDEXES
        ];
    }


    /**
     * @param $token
     * @return AbstractFilter
     * @throws \Exception
     */
    public function buildFilter($options)
    {
        $filterClass = 'Flow\\JSONPath\\Filters\\' . ucfirst($this->type) . 'Filter';

        if (! class_exists($filterClass)) {
            throw new JSONPathException("No filter class exists for token [{$this->type}]");
        }

        return new $filterClass($this, $options);
    }

}