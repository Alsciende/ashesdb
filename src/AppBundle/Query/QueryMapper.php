<?php

namespace AppBundle\Query;

/**
 * Maps clause names to field names and field types
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryMapper
{
    static $map = [
        '' => [
            'name' => 'name',
            'type' => 'string',
        ],
        'x' => [
            'name' => 'text',
            'type' => 'string',
        ],
    ];
    
    public function getField($type)
    {
        if(key_exists($type, self::$map)) {
            return self::$map[$type];
        }
        
        return FALSE;
    }
}
