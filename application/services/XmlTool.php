<?php

class Navo_Service_XmlTool
{
    static public function mergeXML (&$base, $add)
    {
        $new = $base->addChild($add->getName());
        foreach ($add->attributes() as $a => $b) {
            $new[$a] = $b;
        }
        foreach ($add->children() as $child) {
            self::mergeXML($new, $child);
        }
    }
    
}
