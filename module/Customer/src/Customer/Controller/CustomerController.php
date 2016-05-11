<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 4/29/2016
 * Time: 11:16 AM
 */

namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractActionController
{
    private $errorRegMessage;
    
    public function indexAction()
    {
        $viewModel = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $LoginForm = $sm->get('LoginForm');
        $RegistrationForm = $sm->get('RegistrationForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($request->getPost('login') != null) {
                if (!$this->login($request)) {
                    return new ViewModel(array(
                        'login' => $LoginForm,
                        'errorMessage' => 'ACCOUNT DOES NOT EXIST',
                        'regErrorMessage' => '',
                        'registration' => $RegistrationForm
                    ), $viewModel);
                } else {
                    return new ViewModel(array(
                        'login' => $LoginForm,
                        'errorMessage' => '',
                        'regErrorMessage' => '',
                        'registration' => $RegistrationForm
                    ), $viewModel);
                }
            } else {
                if (!$this->registration($request)) {
                    return new ViewModel(array(
                        'login' => $LoginForm,
                        'errorMessage' => '',
                        'regErrorMessage' => $this->errorRegMessage,
                        'registration' => $RegistrationForm
                    ), $viewModel);
                } else {
                    return new ViewModel(array(
                        'login' => $LoginForm,
                        'errorMessage' => '',
                        'regErrorMessage' => '',
                        'registration' => $RegistrationForm
                    ), $viewModel);
                }
            }
        }
        return new ViewModel(array(
            'login' => $LoginForm,
            'errorMessage' => '',
            'regErrorMessage' => '',
            'registration' => $RegistrationForm
        ), $viewModel);
    }
    
    public function logoutAction()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $cart_id = $Container->cart_id;
        $CartItemTable = $Service->get('CartItemTable');
        $CartTable = $Service->get('CartTable');
        $CartItemTable->deleteCartItems($cart_id);
        $CartTable->deleteCart($cart_id);
        $Container->offsetUnset('first_name');
        $Container->offsetUnset('customer_id');
        $Container->offsetUnset('cart_id');

        $this->redirect()->toRoute('home');
    }

    protected function login($r)
    {
        $sm = $this->getServiceLocator();
        $LoginForm = $sm->get('LoginForm');
        $LoginFilter = $sm->get('LoginFilter');
        $LoginForm->setInputFilter($LoginFilter);
        $LoginForm->setData($r->getPost());

        if ($LoginForm->isValid()) {
            $CustomerTable = $sm->get('CustomerTable');
            $c = $CustomerTable->getCustomerByEmail($LoginForm->getInputFilter()->getValue('txtEmail'));
            if ($c != null) {
                if ($LoginForm->getInputFilter()->getValue('txtPass') == $c->password) {
                    $this->setUserSession($c->customer_id, $c->first_name);
                    $this->redirectPage();
                    //$this->redirect()->toRoute('home');
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    protected function registration($r)
    {
        $sm = $this->getServiceLocator();
        $RegistrationForm = $sm->get('RegistrationForm');
        $RegistrationFilter = $sm->get('RegistrationFilter');
        $RegistrationForm->setInputFilter($RegistrationFilter);
        $RegistrationForm->setData($r->getPost());

        if ($RegistrationForm->isValid()) {
            $CustomerTable = $sm->get('CustomerTable');
            $Customer = $sm->get('Customer');
            $c = $CustomerTable->getCustomerByEmail($RegistrationForm->getInputFilter()->getValue('txtRegEmail'));
            if ($c->email == $RegistrationForm->getInputFilter()->getValue('txtRegEmail')) {
                $this->errorRegMessage = 'Email already exists.';
                return false;
            } else {
                //$Customer->exchangeArray($RegistrationForm->getData());
                $Customer->email = $RegistrationForm->getInputFilter()->getValue('txtRegEmail');
                $Customer->password = $RegistrationForm->getInputFilter()->getValue('txtConfirm');
                $Customer->company_name = $RegistrationForm->getInputFilter()->getValue('txtCompanyName');
                $Customer->first_name = $RegistrationForm->getInputFilter()->getValue('txtFName');
                $Customer->last_name = $RegistrationForm->getInputFilter()->getValue('txtLName');
                $last_id = $CustomerTable->registerNewUser($Customer);
                $this->setUserSession($last_id, $Customer->first_name);
                $this->redirectPage();
                //$this->redirect()->toRoute('home');
            }
        } else {
            return true;
        }
    }

    protected function userIsLoggedIn()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $first_name = $Container->offsetGet('first_name');
        $cart_id = $Container->offsetGet('cart_id');

        if (isset($cart_id) && isset($first_name)) {
            $this->redirect()->toRoute('cart',
                array(
                    'controller' => 'CartController',
                    'action' => 'shipping'
                )
            );
        } else if (isset($first_name)) {
            $this->redirect()->toRoute('home');
        } else {

        }
        $this->layout()->setVariable('first_name', $first_name);

        $viewModel = array(
            'first_name' => $first_name
        );
        return $viewModel;
    }

    protected function redirectPage()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $cart_id = $Container->offsetGet('cart_id');

        if (!isset($cart_id)) {
            $this->redirect()->toRoute('home');
        } else {
            $this->redirect()->toRoute('cart', array(
                'controller' => 'CartController',
                'action' => 'shipping'
            ));
        }
    }

    protected function setUserSession($id, $first_name)
    {
        $sm = $this->getServiceLocator();
        $user = $sm->get('Container');
        $user->customer_id = $id;
        $user->first_name = $first_name;
    }
}