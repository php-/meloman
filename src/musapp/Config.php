<?php

namespace Musapp;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;

use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;

use Zend\Diactoros\Response as Response;

/**
 * Description of Config
 *
 * @author User
 */
class Config extends ContainerConfig {
    
    public function modify(Container $di) {
        $adr = $di->get('radar/adr:adr');
        
        /**
        * Middleware
        */
       $adr->middle(new ResponseSender());
       $adr->middle(new ExceptionHandler(new Response()));
       $adr->middle('Radar\Adr\Handler\RoutingHandler');
       $adr->middle('Radar\Adr\Handler\ActionHandler');


        /**
         * Routes
         */
        $adr->get('Home/Front', '/', ['\Musapp\Repository\FrontRepository','welcome']);
        
        $adr->get('Album/Insert', '/album/insert', ['\Musapp\Repository\AlbumRepository','insertAlbum']);
        $adr->get('Album/Update', '/album/update/{id}', ['\Musapp\Repository\AlbumRepository','updateAlbum']);
        $adr->get('Album/Delete', '/album/delete/{id}', ['\Musapp\Repository\AlbumRepository','deleteAlbum']);
        $adr->get('Album/Find', '/album/{id}', ['\Musapp\Repository\AlbumRepository','findAlbum']);
        $adr->get('Album/List', '/album', ['\Musapp\Repository\AlbumRepository','listAlbums']);

        $adr->get('User/Insert', '/user/insert', ['\Musapp\Repository\UserRepository','insertUser']);
        $adr->get('User/Update', '/user/update/{id}', ['\Musapp\Repository\UserRepository','updateUser']);
        $adr->get('User/Delete', '/user/delete/{id}', ['\Musapp\Repository\UserRepository','deleteUser']);
        $adr->get('User/Find', '/user/{id}', ['\Musapp\Repository\UserRepository','findUser']);
        $adr->get('User/List', '/user/', ['\Musapp\Repository\UserRepository','listUsers']);


        $adr->get('Auth/Auth', '/auth', ['\Musapp\Repository\AuthRepository','authUser']);
       
    }
    
}
