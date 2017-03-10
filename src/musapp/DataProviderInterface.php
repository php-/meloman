<?php


namespace Musapp;

/**
 *
 * @author User
 */
interface DataProviderInterface {
    function readData(string $key): array;
    function writeData(string $key, array $data);
}
