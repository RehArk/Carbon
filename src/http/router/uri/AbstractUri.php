<?php

namespace Rehark\Carbon\http\router\uri;

use Rehark\Carbon\http\router\exception\InvalidUriException;

/**
 * Abstract class representing a URI.
 */
abstract class AbstractUri {

    /**
     * The string representation of the URI.
     * @var string
     */
    public string $string;

    /**
     * Constructor for AbstractUri.
     * @param string $string The string representation of the URI.
     * @throws InvalidUriException If the URI is not valid.
     */
    public function __construct(string $string) {

        $string = strtolower($string);

        if (!$this->isValid($string)) {
            throw new InvalidUriException();
        }

        $this->string = $string;

    }

    /**
     * Gets the string representation of the URI.
     * @return string The string representation of the URI.
     */
    public function getString() : string {
        return $this->string;
    }

    /**
     * Checks if the provided URI is valid.
     * This method should be implemented by subclasses.
     * @param string $uri The URI to validate.
     * @return bool True if the URI is valid, false otherwise.
     */
    abstract public function isValid(string $uri) : bool;

}