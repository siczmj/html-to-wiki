<?php

/**
 * Created by PhpStorm.
 * User: Sicz-Mesziár János
 * Date: 2015.11.10.
 * Time: 21:43
 */
class HtmlToWiki {

    //@formatter:off
    private static $inline = array(
        '<i>'       => "''",        // italic
        '</i>'      => "''",
        '<b>'       => "'''",       // bold
        '</b>'      => "'''",
        '<strong>'  => "'''",
        '</strong>' => "'''",
        '<span>'    => "",          // span
        '</span>'   => "",
        '&nbsp;'    => " "
    );

    private static $block = array(
        '<div>'     => "",          // div
        '</div>'    => "\n",
        '<p>'       => "\n",        // p
        '</p>'      => "\n",
        '<ul>'      => "\n",        // ul
        '</ul>'     => "\n",
        '<ol>'      => "\n",        // ol
        '</ol>'     => "\n",
        '<li>'      => "* ",        // li
        '</li>'     => "\n"
    );

    private static $heading = array(
        '<h1>'      => "\n= ",
        '</h1>'     => " =\n",
        '<h2>'      => "\n== ",
        '</h2>'     => " ==\n",
        '<h3>'      => "\n=== ",
        '</h3>'     => " ===\n",
        '<h4>'      => "\n==== ",
        '</h4>'     => " ====\n",
        '<h5>'      => "\n===== ",
        '</h5>'     => " =====\n",
        '<h6>'      => "\n====== ",
        '</h6>'     => " ======\n",
    );

    private static $separator = array(
        '<br>'      => "\n",
        '<br/>'     => "\n",
        '<hr>'      => "---\n",
        '<hr/>'     => "---\n"
    );
    //@formatter:on


    /**
     * @param $html String
     * @return String
     */
    public function toWiki($html) {
        // trim
        $result = trim($html);

        // convert
        $result = $this->parseHTMLBody($result);
        $result = $this->removeHTMLArguments($result);
        $result = $this->removeNewLines($result);
        $result = $this->replaceHTMLInlineElements($result);
        $result = $this->replaceHTMLBlockElements($result);
        $result = $this->replaceHTMLHeadingElements($result);
        $result = $this->replaceHTMLSeparatorElements($result);
        $result = $this->trimLines($result);
        $result = $this->removeWhitespaces($result);
        $result = $this->removeWhitelines($result);

        return trim($result);
    }


    // HTML CLEANING & CONVERTER FUNCTIONS ----------------------------------------------
    public function parseHTMLBody($html) {
        preg_match('/<body[^>]*>(.*?)<\/body>/s', $html, $matches);
        return trim($matches[1]);
    }

    public function removeHTMLArguments($html) {
        return preg_replace('/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i', '<$1$2>', $html);
    }

    public function replaceHTMLInlineElements($html) {
        foreach (self::$inline as $k => $v)
            $html = str_replace($k, $v, $html);
        return $html;
    }

    public function replaceHTMLBlockElements($html) {
        foreach (self::$block as $k => $v)
            $html = str_replace($k, $v, $html);
        return $html;
    }

    public function replaceHTMLHeadingElements($html) {
        foreach (self::$heading as $k => $v)
            $html = str_replace($k, $v, $html);
        return $html;
    }

    public function replaceHTMLSeparatorElements($html) {
        foreach (self::$separator as $k => $v)
            $html = str_replace($k, $v, $html);
        return $html;
    }

    // SIMPLE TEXT CLEANING FUNCTIONS ----------------------------------------------
    public function removeNewLines($text) {
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    public function removeWhitespaces($text) {
        for ($i = 0; $i < 5; $i++)
            $text = str_replace('  ', ' ', $text);
        return $text;
    }

    public function removeWhitelines($text) {
        return preg_replace('/\n(\s*\n)+/', "\n\n", $text);
    }

    public function trimLines($text) {
        return implode("\n", array_map('trim', explode("\n", $text)));
    }


}