<?php

use Snowdog\DevTest\Controller\LoginFormAction;
use Snowdog\DevTest\Component\Migrations;
use Snowdog\DevTest\Controller\LogoutAction;
use Snowdog\DevTest\Menu\WebsitesMenu;
use Snowdog\DevTest\Controller\CreatePageAction;
use Snowdog\DevTest\Component\RouteRepository;
use Snowdog\DevTest\Command\WarmCommand;
use Snowdog\DevTest\Controller\CreateWebsiteAction;
use Snowdog\DevTest\Command\MigrateCommand;
use Snowdog\DevTest\Component\Menu;
use Snowdog\DevTest\Controller\RegisterFormAction;
use Snowdog\DevTest\Controller\IndexAction;
use Snowdog\DevTest\Menu\LoginMenu;
use Snowdog\DevTest\Menu\VarnishMenu;
use Snowdog\DevTest\Component\CommandRepository;
use Snowdog\DevTest\Controller\WebsiteAction;
use Snowdog\DevTest\Menu\RegisterMenu;
use Snowdog\DevTest\Controller\LoginAction;
use Snowdog\DevTest\Controller\RegisterAction;
use Snowdog\DevTest\Controller\VarnishesAction;
use Snowdog\DevTest\Controller\CreateVarnishAction;
use Snowdog\DevTest\Controller\CreateVarnishLinkAction;
use Snowdog\DevTest\Controller\DeleteVarnishLinkAction;

RouteRepository::registerRoute('GET', '/', IndexAction::class, 'execute');
RouteRepository::registerRoute('GET', '/login', LoginFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/login', LoginAction::class, 'execute');
RouteRepository::registerRoute('GET', '/logout', LogoutAction::class, 'execute');
RouteRepository::registerRoute('GET', '/register', RegisterFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/website', CreateWebsiteAction::class, 'execute');
RouteRepository::registerRoute('POST', '/register', RegisterAction::class, 'execute');
RouteRepository::registerRoute('POST', '/page', CreatePageAction::class, 'execute');
RouteRepository::registerRoute('GET', '/website/{id:\d+}', WebsiteAction::class, 'execute');
RouteRepository::registerRoute('GET', '/varnish', VarnishesAction::class, 'execute');
RouteRepository::registerRoute('POST', '/varnish', CreateVarnishAction::class, 'execute');
RouteRepository::registerRoute('POST', '/varnish/link', CreateVarnishLinkAction::class, 'execute');
RouteRepository::registerRoute('DELETE', '/varnish/link', DeleteVarnishLinkAction::class, 'execute');

CommandRepository::registerCommand('warm [id]', WarmCommand::class);
CommandRepository::registerCommand('migrate_db', MigrateCommand::class);

Menu::register(LoginMenu::class, 200);
Menu::register(RegisterMenu::class, 250);
Menu::register(WebsitesMenu::class, 10);
Menu::register(VarnishMenu::class, 20);

Migrations::registerComponentMigration('Snowdog\\DevTest', 4);
