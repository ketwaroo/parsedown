<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo;

/**
 * Customisations to erusev/parsedown-extra
 *
 * @author Yaasir Ketwaroo<ketwaroo.yaasir@gmail.com>
 */
class Parsedown extends \ParsedownExtra
{

    /**
     * for attribute parsing
     * @var string 
     */
    protected $regexAttribute = '[^\}]+';

    /**
     * Parses inline link.
     * 
     * @param array $Excerpt
     * @return array
     */
    protected function inlineLink($Excerpt)
    {
        $Link = parent::inlineLink($Excerpt);

        $remainder = trim(substr($Excerpt['text'], $Link['extent']));
        $matches   = array();

        if (preg_match('~^\{(' . $this->regexAttribute . ')\}$~', $remainder, $matches))
        {
            $Link['element']['attributes'] += $this->parseAttributeData($matches[1]);

            $Link['extent'] += strlen($matches[0]);
        }

        return $Link;
    }

    /**
     * Parses {...} attributes.
     * @param string $attributeString
     * @return array key value attributes
     */
    protected function parseAttributeData($attributeString)
    {
        $matches = array();
        $attrs   = array();

        if (
            preg_match_all(
                '~#(?P<shortId>[^ ]+)|\.(?P<shortClass>[^ ]+)|(?P<attrName>[a-z0-9\-_]+)\=((\'|\")(?P<attrValue>.*?)\5)~i'
                , $attributeString
                , $matches
                , PREG_SET_ORDER)
        )
        {
            foreach ($matches as $m)
            {

                if (!empty($m['shortId']))
                {
                    $attrs['id'] = $m['shortId'];
                }
                elseif (!empty($m['shortClass']))
                {
                    if (!isset($attrs['class']))
                    {
                        $attrs['class'] = $m['shortClass'];
                    }
                    else
                    {
                        $attrs['class'] .= ' ' . $m['shortClass'];
                    }
                }
                elseif (!empty($m['attrName']) && !empty($m['attrValue']))
                {
                    $attrs[$m['attrName']] = htmlspecialchars($m['attrValue'], ENT_QUOTES | ENT_HTML401);
                }
            }
        }

        return $attrs;
    }

    protected function blockTable($Line, array $Block = null)
    {

        $m     = array();
        $attrs = '';
        if (!empty($Block)
            && isset($Block['identified'])
            && isset($Block['element']['text'])
            && preg_match('~[^\\\]\{(' . $this->regexAttribute . ')\}[ ]*$~', $Block['element']['text'], $m))
        {
            $attrs                    = $m[1];
            $Block['element']['text'] = trim(str_replace($m[0], '', $Block['element']['text']));
        }

        $Block = parent::blockTable($Line, $Block);
        if (!empty($attrs)
            && !empty($Block)
            && isset($Block['identified'])
            && isset($Block['element']))
        {
            $Block['element']['attributes'] = $this->parseAttributeData($attrs);
        }

        return $Block;
    }

}
