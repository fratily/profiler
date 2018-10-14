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

use Psr\SimpleCache\CacheInterface;

/**
 *
 */
class Profiler{

    const CACHE_PREFIX  = "fratily.profiler.profile";

    /**
     * @var CacheInterface|null
     */
    private $cache;

    /**
     * プロファイルトークンを生成する
     *
     * @return  string
     */
    public static function generateToken(){
        return substr(
            md5((string)time() . bin2hex(random_bytes(4))),
            0,
            8
        );
    }

    /**
     * トークンに対応したキャッシュキーを取得する
     *
     * @param   string  $token
     *  プロファイルトークン
     *
     * @return  string
     */
    protected static function getCacheKey(string $token){
        return static::CACHE_PREFIX. "." . $token;
    }

    /**
     * Constructor
     *
     * @param   CacheInterface  $cache
     *  プロファイルをキャッシュするためのキャッシュマネージャ
     */
    public function __construct(CacheInterface $cache = null){
        $this->cache    = $cache;
    }

    /**
     * 指定したトークンのプロファイルをキャッシュから取得する
     *
     * @param   string  $token
     *
     * @return  Profile
     */
    public function getProfile(string $token){
        if(!$this->hasProfile($token)){
            throw new Exception\CacheNotFoundException(
                "Cache corresponding to token '{$token}' was not found."
            );
        }

        $profile    = $this->cache->get(static::getCacheKey($token));

        if(!$profile instanceof Profile){
            $key    = static::getCacheKey($token);
            $class  = Profile::class;

            throw new Exception\InvalidCacheValueException(
                "The value of the cache key '{$key}' (token:{$token}) was not a"
                . " {$class}."
            );
        }

        return $profile;
    }

    /**
     * 指定したトークンのプロファイルをキャッシュに保持しているか確認する
     *
     * @param   string  $token
     *  プロファイルトークン
     *
     * @return  bool
     */
    public function hasProfile(string $token){
        return $this->cache->has(static::getCacheKey($token));
    }

    /**
     * プロファイルをキャッシュに追加する
     *
     * @param   Profile $profile
     *  プロファイル
     *
     * @return  $this
     */
    public function addProfile(Profile $profile){
        $this->cache->set(
            static::getCacheKey($profile->getToken()),
            $profile
        );

        return $this;
    }

    /**
     * 指定したトークンのプロファイルをキャッシュから削除する
     *
     * @param   string  $token
     *  プロファイルトークン
     *
     * @return  $this
     */
    public function removeProfile(string $token){
        if($this->hasProfile($token)){
            $this->cache->delete(static::getCacheKey($token));
        }

        return $this;
    }
}
