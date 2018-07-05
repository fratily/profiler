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
namespace Fratily\Profiler;

/**
 *
 */
class Profile{

    /**
     * @var string
     */
    private $token;

    /**
     * @var Panel\PanelInterface[]
     */
    private $panels = [];

    /**
     * トークンを生成する
     *
     * @return  string
     *  一意性のある文字列。同一のトークンが既に使用されていた場合は、
     *  過去のデータが上書きされる可能性があることに注意。
     */
    protected static function generateToken(){
        return substr(md5(microtime() . random_int(0, 1000)), 0, 10);
    }

    /**
     * Constructor
     */
    public function __construct(){
        $this->token    = static::generateToken();
    }

    /**
     * トークンを取得する
     *
     * @return  string
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * パネルを取得する
     *
     * @param   string  $name
     *  パネルの名前
     *
     * @return  Panle\PanelInterface|null
     */
    public function getPanel(string $name){
        return $this->panels[$name] ?? null;
    }

    /**
     *
     *
     * @return  Panel\PanelInterface[]
     */
    public function getPanels(){
        return $this->panels;
    }

    /**
     * パネルを追加する
     *
     * @param   string  $name
     *  パネルの名前
     * @param   Panel\PanelInterface    $panel
     *  パネルインスタンス
     *
     * @return  $this
     *
     * @throws  \InvalidArgumentException
     */
    public function addPanel(string $name, Panel\PanelInterface $panel){
        $name   = trim($name);

        if($name === ""){
            throw new \InvalidArgumentException();
        }

        if(array_key_exists($name, $this->panels)){
            throw new \InvalidArgumentException();
        }

        $this->panels[$name]    = $panel;

        return $this;
    }
}
