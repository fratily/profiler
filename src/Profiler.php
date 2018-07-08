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
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var \Twig\Environment
     */
    private $twig;

    private static function generateTwig(Panel\PanelInterface $panel){
        $include    = [__DIR__ . "/../template"];

        foreach($panel->getBlocks() as $block){

        }

        $this->twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader($include),
            [
                "cache" => $cache,
                "debug" => true,
            ]
        );
    }

    public function __construct(CacheInterface $cache){
        $this->cache    = $cache;
    }

    public function getProfile(string $token){
        $key    = self::CACHE_PREFIX . "." . $token;

        if(!$this->cache->has($key)){
            return new Profile($panels);
        }

        $profile    = $this->cache->get($key);

        if(!$profile instanceof Profile){
            throw new \LogicException;
        }

        return $profile;
    }

    public function addProfile(Profile $profile){
        $this->cache->set(
            self::CACHE_PREFIX  . "." . $profile->getToken(),
            $profile
        );

        return $this;
    }

    public function getResponse(string $token, string $name, string $cache = false){
        $profile    = $this->getProfile($token);
        $panel      = $profile->getPanel($name);
        $twig       = self::generateTwig($panel);
    }
}
