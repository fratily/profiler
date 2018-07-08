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
interface BlockInterface{

    /**
     * タイトルを取得する
     *
     * @return  string|null
     */
    public function getTitle();

    /**
     * テンプレート情報を取得する
     *
     * @return  Template
     */
    public function getTemplate();

    /**
     * テンプレートエンジンに追加するインクルードディレクトリのリストを取得する
     *
     * @return  string[]
     */
    public function getIncludes();
}
