<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 8:15 AM
 */

namespace Site\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $first_name = $Container->offsetGet('first_name');

        $this->layout()->setVariable('first_name', $first_name);
        
        $viewModel = array(
                'first_name' => $first_name
        );
        return new ViewModel($viewModel);
    }
}