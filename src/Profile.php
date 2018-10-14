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
     * プロファイルに登録されている名前をキーとしたパネルの連想配列を取得する
     *
     * @return  Panel\PanelInterface[]
     */
    public function getPanels(){
        return $this->panels;
    }

    /**
     * パネルを取得する
     *
     * @param   string  $name
     *  パネル名
     *
     * @return  Panle\PanelInterface
     *
     * @throws  Exception\PanelNotFoundException
     */
    public function getPanel(string $name){
        if(!$this->hasPanel($name)){
            throw new Exception\PanelNotFoundException(
                ""
            );
        }

        return $this->panels[$name];
    }

    /**
     * 指定した名前のパネルが存在するか確認する
     *
     * @param   string  $name
     *  パネル名
     *
     * @return  bool
     */
    public function hasPanel(string $name){
        return array_key_exists($name, $this->panels);
    }

    /**
     * パネルを追加する
     *
     * @param   Panel\PanelInterface    $panel
     *  パネルのインスタンス
     *
     * @return  $this
     */
    public function addPanel(Panel\PanelInterface $panel){
        $name   = $panel->getName();
        
        if($this->hasPanel($name)){
            throw new \InvalidArgumentException(
                ""
            );
        }

        $this->panels[$name]    = $panel;

        return $this;
    }

    /**
     * パネルを削除する
     *
     * @param   string  $name
     *  パネル名
     *
     * @return $this
     */
    public function removePanel(string $name){
        if($this->hasPanel($name)){
            unset($this->panels[$name]);
        }

        return $this;
    }
}
