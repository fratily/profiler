<?php
/**
 * FratilyPHP Profiler
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Kento Oka <kento-oka@kentoka.com>
 * @copyright   (c) Kento Oka
 * @license     MIT
 * @since       1.0.0
 */
namespace Fratily\Profiler\Panel\Block;

/**
 *
 */
class Template{

    const FILE  = "file";
    const TEXT  = "text";

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string|null
     */
    private $include;

    /**
     * Constructor
     *
     * @param   string  $template
     * @param   string  $type
     *
     * @throws  \InvalidArgumentException
     */
    public function __construct($type, string $template, string $include = null){
        if($type !== self::FILE && $type !== self::TEXT){
            throw new \InvalidArgumentException();
        }

        $this->type     = $type;
        $this->template = $template;
        $this->include  = $include;
    }

    /**
     * テンプレートのタイプを取得する
     *
     * getTemplateで取得できる文字列が
     * テンプレート文字列なのかファイル名なのかを判断する
     *
     * @return  mixed
     *  値がself::FILE定数と等しければtwigテンプレートファイル。
     *  self::TEXTならテンプレート文字列。
     */
    public function getType(){
        return $this->type;
    }

    /**
     * テンプレートを取得する
     *
     * @return  string
     */
    public function getTemplate(){
        return $this->template;
    }

    /**
     * Twigに追加するインクルードパスを取得する
     *
     * @return  string|null
     */
    public function getInclude(){
        return $this->include;
    }
}