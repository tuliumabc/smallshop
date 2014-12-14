<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // HomeP
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'HomeP');
            }

            return array (  '_controller' => 'Small\\ShopBundle\\Controller\\contHPController::f1Action',  '_route' => 'HomeP',);
        }

        // MainP
        if (0 === strpos($pathinfo, '/MainP') && preg_match('#^/MainP/(?P<ParentID>[^/]++)(?:/(?P<numpage>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'MainP')), array (  '_controller' => 'Small\\ShopBundle\\Controller\\contMPController::f1Action',  'numpage' => 1,));
        }

        // ProdP
        if (0 === strpos($pathinfo, '/ProdP') && preg_match('#^/ProdP/(?P<ProductID>[^/]++)/(?P<ParentID>[^/]++)/(?P<numpage>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ProdP')), array (  '_controller' => 'Small\\ShopBundle\\Controller\\contPPController::f1Action',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
