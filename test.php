<?php

class MinifyHTML {

    /**
     * Minify html
     *
     * <code>
     * echo MinifyHTML::process($html);
     * </code>
     *
     * @param string $buffer html
     * @return string
     */
    public static function process($html) {

// Remove HTML comments (not containing IE conditional comments).
        $html = preg_replace_callback('/<!--([\\s\\S]*?)-->/', 'MinifyHTML::_comments', $html);

// Trim each line.
        $html = preg_replace('/^\\s+|\\s+$/m', '', $html);

// Return HTML

        return $html;
    }

    protected static function _comments($m) {

        return (0 === strpos($m[1], '[') || false !== strpos($m[1], '<![')) ? $m[0] : '';
    }

}
