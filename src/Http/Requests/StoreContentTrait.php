<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource\Http\Requests;

use HTMLPurifier;

/**
 * \Playground\Matrix\Resource\Http\Requests\StoreContentTrait
 */
trait StoreContentTrait
{
    protected ?HTMLPurifier $purifier = null;

    protected ?string $safeIframeRegexp = '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%';

    /**
     * Exorcise all html from the string.
     *
     * @uses \htmlspecialchars()
     * @uses \strip_tags()
     */
    public static function exorcise(mixed $content): string
    {
        return is_string($content) ? htmlspecialchars(
            strip_tags($content),
            ENT_HTML5
        ) : '';
    }

    /**
     * Purify a string with HTMLPurifier.
     */
    public function purify(mixed $content): string
    {
        return is_string($content) ? $this->getHtmlPurifier()->purify($content) : '';
    }

    /**
     * Get HTMLPurifier
     *
     * @param array<string, mixed> $config
     */
    public function getHtmlPurifier(array $config = []): HTMLPurifier
    {
        if ($this->purifier === null) {
            $hpc = \HTMLPurifier_Config::createDefault();

            $config = empty($config) ? config('playground-matrix-resource') : $config;

            $this->safeIframeRegexp =

            $safeIframeRegexp = ! empty($config['content'])
                && array_has_key(iframes, $config['content'])
                && is_string($config['content']['iframes'])
                ? $config['content']['iframes']
                : '%^(https?:)?(\/\/www\.youtube(?:-nocookie)?\.com\/embed\/|\/\/player\.vimeo\.com\/)%';

            $serializerPath = ! empty($config['cache'])
                && ! empty($config['cache']['purifier'])
                && is_string($config['cache']['purifier'])
                ? $config['cache']['purifier']
                : null;

            if ($serializerPath) {
                $hpc->set('Cache.SerializerPath', $serializerPath);
            }

            if ($safeIframeRegexp) {
                $hpc->set('HTML.SafeIframe', true);
                $hpc->set('URI.SafeIframeRegexp', $safeIframeRegexp);
            }

            $this->purifier = new HTMLPurifier($hpc);
        }

        return $this->purifier;
    }
}
