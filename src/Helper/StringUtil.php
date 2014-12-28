<?php

namespace Saxulum\ModelGenerator\Helper;

use Symfony\Component\PropertyAccess\StringUtil as OrigStringUtil;

class StringUtil
{
    /**
     * @param string $plural
     * @return string
     */
    public static function singularify($plural)
    {
        $singular = OrigStringUtil::singularify($plural);

        if (is_array($singular)) {
            return reset($singular);
        }

        return $singular;
    }
}
