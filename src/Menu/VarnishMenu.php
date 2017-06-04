<?php
/**
 * Created by PhpStorm.
 * User: bazej
 * Date: 04.06.17
 * Time: 17:55
 */

namespace Snowdog\DevTest\Menu;


class VarnishMenu extends AbstractMenu
{
    public function isActive()
    {
        return $_SERVER['REQUEST_URI'] == '/';
    }

    public function getHref()
    {
        if(isset($_SESSION['login'])) {
            return '/varnish';
        }
        return '/login';
    }

    public function getLabel()
    {
        return 'Varnishes';
    }
}