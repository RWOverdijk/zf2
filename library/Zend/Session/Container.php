<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Session;

use Zend\Stdlib\ArrayObject;

/**
 * Session storage container
 *
 * Allows for interacting with session storage in isolated containers, which
 * may have their own expiries, or even expiries per key in the container.
 * Additionally, expiries may be absolute TTLs or measured in "hops", which
 * are based on how many times the key or container were accessed.
 */
class Container extends AbstractContainer
{
    /**
     * Exchange the current array with another array or object.
     *
     * @param  array|object $input
     * @return array        Returns the old array
     * @see ArrayObject::exchangeArray()
     */
    public function exchangeArray($input)
    {
        if (!is_array($input) && !$input instanceof ArrayObject) {
            throw new Exception\InvalidArgumentException(
                'Name passed to container is invalid; must consist of alphanumerics, backslashes and underscores only'
            );
        }

        return parent::exchangeArrayCompat($input);
    }

    /**
     * Retrieve a specific key in the container
     *
     * @param  string $key
     * @return mixed
     */
    public function &offsetGet($key)
    {
        $ret = null;

        if (!$this->offsetExists($key)) {
            return $ret;
        }

        $storage = $this->getStorage();
        $name    = $this->getName();
        $ret     =& $storage[$name][$key];

        return $ret;
    }
}
