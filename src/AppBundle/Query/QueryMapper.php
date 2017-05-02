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
        "e" => [
            "name" => "code",
            "type" => "code",
            "root" => "pack",
            "description" => "Expansion Code",
        ],
        "d" => [
            "name" => "code",
            "type" => "code",
            "root" => "dice",
            "description" => "Dice Code",
            "shortcuts" => [
                "c" => "ceremonial",
                "h" => "charm",
                "d" => "divine",
                "i" => "illusion",
                "n" => "natural",
                "s" => "sympathy",
            ],
        ]
    ];
    
    public function getField($type)
    {
        if(key_exists($type, self::$map)) {
            return self::$map[$type];
        }
        
        return FALSE;
    }
}
