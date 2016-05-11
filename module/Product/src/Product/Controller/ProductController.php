<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/30/2016
 * Time: 12:12 PM
 */

namespace Product\Controller;

use Product\Model\Product;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class ProductController extends AbstractActionController
{
    public function indexAction()
    {
        $userSession = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $ProductTable = $sm->get('ProductTable');
        $products = $ProductTable->getAllProducts();
        $viewData = array(
            'products' => $products
        );
        return new ViewModel($viewData, $userSession);
    }

    public function viewAction()
    {
        $userSession = $this->userIsLoggedIn();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id || $id==0) {
            $this->redirect()->toRoute('home');
        }

        $sm = $this->getServiceLocator();
        $ProductTable = $sm->get('ProductTable');
        $product = $ProductTable->getProductsByID($id);

        $viewData = array(
            'product' => $product,
            'userSession' => $userSession,

        );
        return new ViewModel($viewData);
    }
    
    protected function userIsLoggedIn()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $first_name = $Container->offsetGet('first_name');

        $this->layout()->setVariable('first_name', $first_name);

        $viewModel = array(
            'first_name' => $first_name
        );
        return $viewModel;
    }
}