<?php

namespace Inflector;

class Inflector
{
    protected static $uncountableWords = [
        'equipment',
        'information',
        'rice',
        'money',
        'species',
        'series',
        'fish',
        'sheep',
        'moose',
        'deer',
        'news',
    ];

    protected static $pluralRules = [
        ['/(m)an$/i', '$1en'],
        ['/(pe)rson$/i', '$1ople'],
        ['/(child)$/i', '$1ren'],
        ['/^(ox)$/i', '$1en'],
        ['/(ax|test)is$/i', '$1es'],
        ['/(octop|vir)us$/i', '$1i'],
        ['/(alias|status)$/i', '$1es'],
        ['/(bu)s$/i', '$1ses'],
        ['/(buffal|tomat|potat)o$/i', '$1oes'],
        ['/(ti)um$/i', '$1a'],
        ['/sis$/i', 'ses'],
        ['/(?:([^f])fe|([lr])f)$/i', '$1$2ves'],
        ['/(hive)$/i', '$1s'],
        ['/([^aeiouy]|qu)y$/i', '$1ies'],
        ['/(x|ch|ss|sh)$/i', '$1es'],
        ['/(matr|vert|ind)(?:ix|ex)$/i', '$1ices'],
        ['/([m|l])ouse$/i', '$1ice'],
        ['/(quiz)$/i', '$1zes'],
        ['/s$/i', 's'],
        ['/$/', 's'],
    ];

    protected static $singularRules = [
        ['/(m)en$/i', '$1an'],
        ['/(pe)ople$/i', '$1rson'],
        ['/(child)ren$/i', '$1'],
        ['/([ti])a$/i', '$1um'],
        ['/(hive)s$/i', '$1'],
        ['/(tive)s$/i', '$1'],
        ['/(curve)s$/i', '$1'],
        ['/([lr])ves$/i', '$1f'],
        ['/([^fo])ves$/i', '$1fe'],
        ['/([^aeiouy]|qu)ies$/i', '$1y'],
        ['/(s)eries$/i', '$1eries'],
        ['/(m)ovies$/i', '$1ovie'],
        ['/(x|ch|ss|sh)es$/i', '$1'],
        ['/([m|l])ice$/i', '$1ouse'],
        ['/(bus)es$/i', '$1'],
        ['/(o)es$/i', '$1'],
        ['/(shoe)s$/i', '$1'],
        ['/(cris|ax|test)es$/i', '$1is'],
        ['/(octop|vir)i$/i', '$1us'],
        ['/(alias|status)es$/i', '$1'],
        ['/^(ox)en/i', '$1'],
        ['/(vert|ind)ices$/i', '$1ex'],
        ['/(matr)ices$/i', '$1ix'],
        ['/(quiz)zes$/i', '$1'],
        ['/s$/i', ''],
    ];

    protected static $nonTitlecasedWords = [
        'and',
        'or',
        'nor',
        'a',
        'an',
        'the',
        'so',
        'but',
        'to',
        'of',
        'at',
        'by',
        'from',
        'into',
        'on',
        'onto',
        'off',
        'out',
        'in',
        'over',
        'with',
        'for'
    ];

    protected static $idSuffix = '/(_ids|_id)$/';
    protected static $underbar = '/_/';
    protected static $spaceOrUnderbar = '/[ _]/';

    protected static function applyRules(string $str, array $rules, array $skip, ?string $override = null): string
    {
        if ($override !== null) {
            return $override;
        }

        if (in_array(strtolower($str), $skip)) {
            return $str;
        }

        foreach ($rules as $rule) {
            if (preg_match($rule[0], $str)) {
                return preg_replace($rule[0], $rule[1], $str);
            }
        }

        return $str;
    }

    /**
     * Pluralizes a given word.
     *
     * If the word already ends with the plural form, it is returned as is.
     * Otherwise, the plural form is determined by applying the plural rules to the word.
     *
     * Example
     * ```php
     * Inflector::pluralize('person'); // people
     * Inflector::pluralize('person', 'persons'); // persons
     * Inflector::pluralize('octopus'); // octopi
     * Inflector::pluralize('Hat'); // Hats
     * Inflector::pluralize('person', 'guy'); // guys
     * ```
     * 
     * @param string $word The word to pluralize.
     * @param string|null $plural The plural form of the word, if it has a non-standard plural form.
     * @return string The pluralized word.
     */
    public static function pluralize(string $word, ?string $plural = null): string
    {
        return self::applyRules($word, self::$pluralRules, self::$uncountableWords, $plural);
    }

    /**
     * Singularizes a given word.
     *
     * If the word already ends with the singular form, it is returned as is.
     * Otherwise, the singular form is determined by applying the singular rules to the word.
     *
     * Example
     * ```php
     * Inflector::singularize('people'); // person
     * Inflector::singularize('octopi'); // octopus
     * Inflector::singularize('Hats'); // Hat
     * Inflector::singularize('guys', 'person'); // person
     * ```
     * 
     * @param string $word The word to singularize.
     * @param string|null $singular The singular form of the word, if it has a non-standard singular form.
     * @return string The singularized word.
     */
    public static function singularize(string $word, ?string $singular = null): string
    {
        return self::applyRules($word, self::$singularRules, self::$uncountableWords, $singular);
    }

    /**
     * Camelizes a given string.
     *
     * Replaces spaces with underscores, splits the string into parts separated by slashes,
     * and then camelizes each part. If $lowFirstLetter is true, the first letter of each
     * part will be lowercase. Finally, the camelized parts are joined back together with
     * double colons.
     * 
     * Example
     * ```php
     * Inflector::camelize('message_properties'); // 'MessageProperties'
     * Inflector::camelize('message_properties', true); // 'messageProperties'
     * ```
     *
     * @param string $str The string to camelCase.
     * @param bool $lowFirstLetter Whether to lowercase the first letter of each part.
     * @return string The camelized string.
     */
    public static function camelize(string $str, bool $lowFirstLetter = false): string
    {
        $str = str_replace(' ', '_', $str);
        $parts = explode('/', $str);
        foreach ($parts as &$part) {
            $sub = explode('_', $part);
            $start = $lowFirstLetter ? 1 : 0;
            foreach ($sub as $k => $v) {
                if ($k >= $start) {
                    $sub[$k] = ucfirst($v);
                }
            }
            $part = implode('', $sub);
        }
        $str = implode('::', $parts);
        if ($lowFirstLetter) {
            $str = lcfirst($str);
        }
        return $str;
    }

    /**
     * Converts camelCase to snake_case.
     *
     * Replaces sequences of camelCase by underscores, removes all non-alphanumeric characters,
     * and then trims and lowercases the result.
     *
     * Example
     * ```php
     * Inflector::underscore('MessageProperties'); // 'message_properties'
     * Inflector::underscore('messageProperties'); // 'message_properties'
     * ```
     * @param string $str The camelCase string to convert.
     * @return string The snake_case string.
     */
    public static function underscore(string $str): string
    {
        $str = preg_replace('/([a-z])([A-Z])/', '$1_$2', $str);
        $str = preg_replace('/[^0-9a-zA-Z]/', ' ', $str);
        return strtolower(trim(preg_replace('/\s+/', '_', $str)));
    }

    /**
     * Humanizes a given string.
     *
     * Replaces sequences of camelCase and underscores by spaces, removes any trailing "Id" or "id" suffix,
     * and then trims and lowercases the result. If $lowFirstLetter is false, the first letter of the result will be uppercased.
     *
     * Example
     * ```php
     * Inflector::humanize('message_properties'); // 'Message Properties'
     * Inflector::humanize('message_properties', true); // 'message properties'
     * ```
     *
     * @param string $str The string to humanize.
     * @param bool $lowFirstLetter Whether to lowercase the first letter of the result.
     * @return string The humanized string.
     */
    public static function humanize(string $str, bool $lowFirstLetter = false): string
    {
        // Pisahkan camelCase jadi spasi
        $str = preg_replace('/([a-z])([A-Z])/', '$1 $2', $str);

        // Hilangkan suffix ID kalau ada (misalnya _id)
        $str = preg_replace(self::$idSuffix, '', $str);

        // Ganti underscore jadi spasi
        $str = str_replace('_', ' ', $str);

        // Jadiin lowercase semua dulu
        $str = strtolower($str);

        // Kalau tidak pakai lowFirstLetter, kapital huruf pertama tiap kata
        if (!$lowFirstLetter) {
            $str = self::capitalize($str);
        }

        return $str;
    }


    /**
     * Capitalizes a given string.
     *
     * Trims and lowercases the string, then uppercases the first letter.
     *
     * Example
     * ```php
     * Inflector::capitalize('message_properties'); // 'Message Properties'
     * Inflector::capitalize('message properties'); // 'Message Properties'
     * ```
     *
     * @param string $str The string to capitalize.
     * @return string The capitalized string.
     */
    public static function capitalize(string $str): string
    {
        return ucfirst(strtolower($str));
    }

    /**
     * Replaces spaces and underscores with dashes in a given string.
     *
     * Example
     * ```php
     * Inflector::dasherize('message_properties'); // 'message-properties'
     * Inflector::dasherize('message properties'); // 'message-properties'
     * ```
     *
     * @param string $str The string to dasherize.
     * @return string The dasherized string.
     */
    public static function dasherize(string $str): string
    {
        return preg_replace(self::$spaceOrUnderbar, '-', $str);
    }

    /**
     * Converts a camelCase or snake_case string to a space-separated string
     * with optional title-case words.
     *
     * Example:
     * ```php
     * Inflector::camel2words('message_properties'); // 'Message Properties'
     * Inflector::camel2words('message properties'); // 'Message Properties'
     * Inflector::camel2words('Message_propertyId', true); // 'Message Properties Id'
     * ```
     *
     * @param string $word The input string to convert.
     * @param bool $allFirstUpper If true, ensures all words are capitalized.
     * @return string The transformed, human-readable string.
     */
    public static function camel2words(string $word, bool $allFirstUpper = false): string
    {
        if ($allFirstUpper) {
            $word = self::camelize($word);
            $word = self::underscore($word);
        } else {
            $word = strtolower($word);
        }

        $word = str_replace('_', ' ', $word);
        $words = explode(' ', $word);

        foreach ($words as $key => $w) {
            $parts = explode('-', $w);
            foreach ($parts as $i => $p) {
                if (!in_array(strtolower($p), self::$nonTitlecasedWords, true)) {
                    $parts[$i] = self::capitalize($p);
                }
            }
            $words[$key] = implode('-', $parts);
        }

        $result = implode(' ', $words);
        $result = ucfirst($result);

        return $result;
    }

    /**
     * Removes module namespace from a string.
     *
     * Splits the string by "::" and returns the last part.
     *
     * Example
     * ```php
     * Inflector::demodulize('MyApp::Models::User'); // 'User'
     * Inflector::demodulize('User'); // 'User'
     * ```
     * @param string $str The string to demodulize.
     * @return string The demodulized string.
     */
    public static function demodulize(string $str): string
    {
        $parts = explode('::', $str);
        return end($parts);
    }

    /**
     * Converts a class name string to its corresponding table name (snake_case and pluralized).
     *
     * Example
     * ```php
     * Inflector::tableize('MessageBusProperty'); // 'message_bus_properties'
     * ```
     * @param string $str The class name to convert.
     * @return string The corresponding table name.
     */
    public static function tableize(string $str): string
    {
        return self::pluralize(self::underscore($str));
    }

    /**
     * Converts a string to its corresponding class name (camelCase and singular).
     *
     * Example
     * ```php
     * Inflector::classify('message_bus_properties'); // 'MessageBusProperty'
     * ```
     * @param string $str The string to convert.
     * @return string The corresponding class name.
     */
    public static function classify(string $str): string
    {
        return self::singularize(self::camelize($str));
    }

    /**
     * Generates a foreign key based on the given class name.
     *
     * Replaces the class name with its corresponding underscored name, then appends the string with '_id'.
     * If $dropIdUbar is true, the '_id' suffix is not appended.
     *
     * Example
     * ```php
     * Inflector::foreignKey('MessageBusProperty'); // 'message_bus_property_id'
     * Inflector::foreignKey('MessageBusProperty', true); // 'message_bus_propertyid'
     * ```
     * @param string $str The class name to convert.
     * @param bool $dropIdUbar Whether to drop the '_id' suffix.
     * @return string The generated foreign key.
     */
    public static function foreignKey(string $str, bool $dropIdUbar = false): string
    {
        return self::underscore(self::demodulize($str)) . ($dropIdUbar ? '' : '_') . 'id';
    }

    /**
     * Ordinalizes a string containing numbers.
     *
     * Replaces each numeric word with its ordinal form (e.g. '1' becomes '1st', '2' becomes '2nd', etc.).
     *
     * Example
     * ```php
     * Inflector::ordinalize('the 1 pitch'); // 'the 1st pitch'
     * Inflector::ordinalize('The 1 dog and 2 cats'); // 'The 1st dog and 2nd cats'
     * Inflector::ordinalize('1'); // '1st'
     * Inflector::ordinalize('2'); // '2nd'
     * Inflector::ordinalize('3'); // '3rd'
     * Inflector::ordinalize('4'); // '4th'
     * Inflector::ordinalize('11'); // '11th'
     * ```
     * @param string $str The string to ordinalize.
     * @return string The ordinalized string.   
     */
    public static function ordinalize(string $str): string
    {
        $words = explode(' ', $str);
        foreach ($words as &$word) {
            if (is_numeric($word)) {
                $lastTwo = substr($word, -2);
                $last = substr($word, -1);
                $suf = 'th';
                if (!in_array($lastTwo, ['11', '12', '13'])) {
                    if ($last === '1') $suf = 'st';
                    elseif ($last === '2') $suf = 'nd';
                    elseif ($last === '3') $suf = 'rd';
                }
                $word .= $suf;
            }
        }
        return implode(' ', $words);
    }
}