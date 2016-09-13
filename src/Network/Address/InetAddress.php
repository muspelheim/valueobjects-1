<?php

namespace RHorv\ValueObjects\Network\Address;


/**
 * Class InetAddress
 * @package RHorv\ValueObjects\Network\Address
 * @info    Taken from java.net.InetAddress
 */
abstract class InetAddress
{
    /**
     * @var array
     */
    protected $segments = array();

    /**
     * @var string|null
     */
    protected $hostName;

    /**
     * @param array $segments
     * @param null $hostName
     */
    protected function __construct(Array $segments, $hostName = null)
    {
        $this->segments = $segments;
        $this->hostName = $hostName;
    }

    /**
     * Converts address to segments
     *
     * @param $address
     *
     * @return array
     */
    public static function addressToSegments($address)
    {
        return static::addressToSegments($address);
    }

    /**
     * Converts segments to address
     *
     * @param $segments
     *
     * @return string
     */
    public static function segmentsToAddress(Array $segments)
    {
        return static::segmentsToAddress($segments);
    }

    /**
     * Returns the raw IP address of this InetAddress object.
     *
     * @return array
     */
    public function getAddress()
    {
        return $this->segments;
    }

    /**
     * Given the name of a host, returns an array of its IP addresses, based on the configured name service on the system.
     *
     * @param $host
     *
     * @return array
     */
    public static function getAllByName($host)
    {
        $addrList = gethostbynamel($host) ?: array();
        $inetAddrs = array();
        foreach ($addrList as $addr) {
            $inetAddrs[] = new static(static::addressToSegments($addr), $host);
        }

        return $inetAddrs;
    }

    /**
     * Returns an InetAddress object given the raw IP address .
     *
     * @param array $addr
     *
     * @return InetAddress
     */
    public static function getByAddress(array $addr)
    {
        return new static($addr);
    }

    /**
     * Returns an InetAddress object given the IP address in textual format.
     *
     * @param string $address
     *
     * @return InetAddress
     */
    public static function getByAddressString($address)
    {
        return new static(static::addressToSegments($address));
    }

    /**
     * Determines the IP address of a host, given the host's name.
     *
     * @param $host
     *
     * @return InetAddress
     */
    public static function getByName($host)
    {
        return new static(static::addressToSegments(gethostbyname($host)));
    }

    /**
     * Returns the IP address string in textual presentation.
     *
     * @return string
     */
    abstract public function getHostAddress();

    /**
     * Gets the host name for this IP address.
     *
     * @return string
     */
    public function getHostName()
    {
        if (!$this->hostName) {
            $this->hostName = gethostbyaddr($this->getHostAddress());
        }

        return $this->hostName;
    }

    /**
     * Converts this IP address to a String. The string returned is of the form: hostname / literal IP address.
     * If the host name is unresolved, no reverse name service lookup is performed. The hostname part will be represented by an empty string.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s / %s", $this->getHostName(), $this->getHostAddress());
    }

    /**
     * @param $other
     *
     * @return bool
     */
    public function equals(InetAddress $other)
    {
        return get_class($this) === get_class($other) && $this->getAddress() == $other->getAddress();
    }
}

?>