<?php

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use UnexpectedValueException;

/**
 * Turns an array into a string
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class EncodingService
{
    /**
     * 
     * @param Block $block
     * @return Fragment[]
     */
    public function decode(Block $block)
    {
        $list = json_decode($block->getData(), true);
        if(!$list or ! is_array($list)) {
            throw new UnexpectedValueException("Block data cannot be decoded to an array!");
        }
        $fragments = [];
        foreach($list as $data) {
            $fragment = new Fragment($data);
            $fragment->setBlock($block);
            $fragments[] = $fragment;
        }
        return $fragments;
    }

    /**
     * 
     * @param Fragment[] $fragments
     * @return Block
     */
    public function encode($fragments)
    {
        $list = [];
        foreach($fragments as $fragment) {
            $list[] = $fragment->getData();
        }
        $data = json_encode($list);
        return new Block($data);
    }

}
