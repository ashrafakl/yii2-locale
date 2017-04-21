<?php

/**
 * @package   yii2-locale
 * @author    Ashraf Akl <ashrafakl@yahoo.com>
 * @copyright Copyright &copy; Ashraf Akl, 2017
 * @version   1.0.0
 */

namespace ashrafakl\localization;

use yii\base\Component;
use Yii;

/**
 * Locale class represents the data relevant to a locale such as countries, languages, and orientation, 
 * this class uses and depend on the PHP intl extension.
 * @author ashrafakl@yahoo.com
 */
class Locale extends Component
{

    private $locales;
    private $countries;
    private $languages;
    private $rtlLanguages = ['ar', 'dv', 'fa', 'he', 'ks', 'ku', 'ps', 'syr', 'ur'];
    private static $relativeLanguages = null;

    /**
     * Path of ResourceBundle for which to get available locales, or empty string for default locales list.
     * @see http://php.net/manual/en/resourcebundle.locales.php
     * @var string 
     */
    public $bundlename = '';

    /**
     * Initializes Local.
     */
    public function init()
    {
        if ($this->locales === null) {
            $this->locales = \ResourceBundle::getLocales($this->bundlename);
        }
        if (self::$relativeLanguages === null) {
            foreach ($this->locales as $locale) {
                self::$relativeLanguages[\Locale::getPrimaryLanguage($locale)] = \Locale::getDisplayLanguage($locale, $locale);
            }
        }
        parent::init();
    }

    /**
     * Get Countries list
     * @param string $inLocale format locale to use to display the regions names, default to current yii language     
     * @return array      
     */
    public function getCountries($inLocale = null)
    {
        if (!$inLocale) {
            $inLocale = Yii::$app->language;
        }
        $key = strtolower($inLocale);
        if (!isset($this->countries[$key])) {
            foreach ($this->locales as $locale) {
                $countryName = \Locale::getDisplayRegion($locale, $inLocale);
                if ($countryName) {
                    $territoryId = \Locale::getRegion($locale);
                    if (!is_numeric($territoryId)) {
                        $this->countries[$key][strtolower($territoryId)] = $countryName;
                    }
                }
            }
        }
        return $this->countries[$key];
    }
    /**
     * Get contry code for the given [[code]]
     * @param string $code country code
     * @param string $inLocale format locale to use to display the regions names, default to current yii language     
     * @return array      
     */
    
    public function getCountry($code, $inLocale = null)
    {
        if (!$inLocale) {
            $inLocale = Yii::$app->language;
        }        
        $key = strtolower($inLocale);
        if (isset($this->countries[$key][$code])) {
            return $this->countries[$key][$code];
        }
    }

    /**
     * Get languages list relative to its locale
     * @param array $allowLanguages
     * @return array      
     */
    public function getRelativePrimaryLanguages($allowLanguages = [])
    {
        if ($allowLanguages) {
            $relativeLanguages = [];
            foreach ($allowLanguages as $language) {
                if (array_key_exists($language, self::$relativeLanguages)) {
                    $relativeLanguages[$language] = self::$relativeLanguages[$language];
                }
            }
            return $relativeLanguages;
        } else {
            return self::$relativeLanguages;
        }
    }

    /**
     * Get languages list
     * @param string $inLocale format locale to use to display the languages names, default to current yii language     
     * @return array      
     */
    public function getPrimaryLanguages($inLocale = null)
    {
        if (!$inLocale) {
            $inLocale = Yii::$app->language;
        }
        $key = strtolower($inLocale);
        if (!isset($this->languages[$key])) {
            foreach ($this->locales as $locale) {
                $this->languages[$key][\Locale::getPrimaryLanguage($locale)] = \Locale::getDisplayLanguage($locale, $inLocale);
            }
        }
        return $this->languages[$key];
    }

    /**
     * Get characters orientation, which is either 'ltr' (left-to-right) or 'rtl' (right-to-left)
     * @param string $inLocale format locale to use to gets the orientation, default to current yii language     
     * @return string
     */
    public function getOrientation($inLocale = null)
    {
        if (!$inLocale) {
            $inLocale = Yii::$app->language;
        }
        return in_array(\Locale::getPrimaryLanguage($inLocale), $this->rtlLanguages) ? 'rtl' : 'ltr';
    }

}
