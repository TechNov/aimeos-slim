<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 * @package Slim
 * @subpackage Controller
 */

namespace Aimeos\Slim\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Aimeos controller for account related functionality.
 *
 * @package Slim
 * @subpackage Controller
 */
class Account
{
	/**
	 * Returns the html for the "My account" page.
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function indexAction( ContainerInterface $container, ServerRequestInterface $request,
		ResponseInterface $response, array $args ) : ResponseInterface
	{
		$contents = $container->get( 'shop' )->get( 'account-index', $request, $response, $args );
		return $container->get( 'view' )->render( $response, 'Account/index.html.twig', $contents );
	}


	/**
	 * Returns the html for the "My account" download page.
	 *
	 * @param ContainerInterface $container Dependency injection container
	 * @param ServerRequestInterface $request Request object
	 * @param ResponseInterface $response Response object
	 * @param array $args Associative list of route parameters
	 * @return ResponseInterface $response Modified response object with generated output
	 */
	public static function downloadAction( ContainerInterface $container, ServerRequestInterface $request,
		ResponseInterface $response, array $args ) : ResponseInterface
	{
		$context = $container->get( 'aimeos.context' )->get( true, $args );
		$langid = $context->getLocale()->getLanguageId();

		$view = $container->get( 'aimeos.view' )->create( $context, $request, $response, $args, array(), $langid );
		$context->setView( $view );

		$client = \Aimeos\Client\Html::create( $context, 'account/download' );
		$client->setView( $view );
		$client->process();

		return $view->response();
	}
}
