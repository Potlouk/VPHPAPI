<?php
namespace src\interfaces;

use src\controllers\Controller;

interface FactoryControllerInterface{
    public static function build($response): Controller;
}