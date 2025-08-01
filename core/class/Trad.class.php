<?php
/**
 * classe raccourcis pour remplacer la fonction muette __( )
 * traduction de texte
 */
class Trad {
    // attributs
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $file;
    /**
     * @var bool
     */
    private $backslash = false;

    /**
     * constructeur avec 3 paramètres: valoriser les attributs
     * $text
     * $file = __FILE__
     * $backslash
     */
    public function __construct(string $text, string $file = __FILE__, bool $_backslash = false) {
        $this->text = $text;
        $this->file = $file;
        $this->backslash = $_backslash;
    }

    public function __toString() {
        if (defined('PHPSTAN_RUNNING')) {
            return '__PHPSTAN_PLACEHOLDER__';
        }
        try {
            return translate::sentence(str_replace("\'", "'", $this->text), $this->file, $this->backslash);
        } catch (Exception $e) {
            // log error and return default value
            return $this->text;
        }
    }

}