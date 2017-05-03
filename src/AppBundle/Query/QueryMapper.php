<?php

namespace AppBundle\Query;

/**
 * Maps clause names to field names and field types
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class QueryMapper
{
    static $default = [
        "builder" => "card", // which QueryBuilder will we add the DQL to
        "alias" => 0, // position of the alias in the QueryBuilder
    ];
    
    static $map = [
        "" => [
            "name" => "name",
            "type" => "string",
            "description" => "Card Title",
        ],
        "x" => [
            "name" => "text",
            "type" => "string",
            "description" => "Card Text",
        ],
        "a" => [
            "name" => "attack",
            "type" => "integer",
            "description" => "Unit Attack",
        ],
        "l" => [
            "name" => "life",
            "type" => "integer",
            "description" => "Unit Life",
        ],
        "r" => [
            "name" => "recover",
            "type" => "integer",
            "description" => "Unit Recover",
        ],
        "p" => [
            "name" => "code",
            "type" => "code",
            "builder" => "pack",
            "alias" => 1,
            "description" => "Prebuilt deck",
        ],
        "c" => [
            "name" => "code",
            "type" => "code",
            "builder" => "pack",
            "alias" => 2,
            "description" => "Category",
        ],
        "d" => [
            "name" => "code",
            "type" => "code",
            "builder" => "dice",
            "alias" => 1,
            "description" => "Dice Code",
        ]
    ];
    
    public function getField($type)
    {
        if(!key_exists($type, self::$map)) {
            return FALSE;
        }
        
        $data = self::$map[$type];
        return array_merge(self::$default, $data);
    }
}
