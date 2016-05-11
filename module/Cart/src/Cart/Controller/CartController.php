<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/3/2016
 * Time: 9:46 AM
 */

namespace Cart\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CartController extends AbstractActionController
{
    public function indexAction()
    {
        $userSession = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $cart_id = $Container->offsetGet('cart_id');
        $CartItemTable = $sm->get('CartItemTable');
        $total = $CartItemTable->computeTotalAmount($cart_id);
        $items = $CartItemTable->displayItemsInCart($cart_id);
        $viewData = array(
            'items' => $items,
            'total_amount' => $total->total_amount
        );
        return new ViewModel($viewData, $userSession);
    }

    public function addToCartAction()
    {
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $CartItemTable = $sm->get('CartItemTable');
        $cart_id = $Container->offsetGet('cart_id');
        $Cart = $sm->get('Cart');

        if (!isset($cart_id)) {
            $CartTable = $sm->get('CartTable');
            $lastInsertID = $CartTable->insertItemInCartTable();
            $Container->offsetSet('cart_id', $lastInsertID);
        }
        $request = $this->getRequest();

        if ($request->isPost()) {
            //$checking = ;
            if ($CartItemTable->checkProductsIfExistingByID($request->getPost('hidProdID'), $cart_id)) {
                $Cart->weight = $request->getPost('hidWeight');
                $Cart->qty = $request->getPost('hidQty');
                $Cart->price = $request->getPost('hidPrice');
                $Cart->product_id = $request->getPost('hidProdID');
                $Cart->cart_id = $cart_id;
                $CartItemTable->updateProductsInCartItems($Cart);
            } else {
                $this->insertItemsInCart($Container->offsetGet('cart_id'));
            }
        }

        $this->redirect()->toRoute('cart', array(
            'controller' => 'CartController',
            'action' => 'index'
        ));
    }

    public function paymentAction()
    {
        $this->redirectPage();
        $userSession = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $cart_id = $Container->offsetGet('cart_id');
        $CartTable = $sm->get('CartTable');
        $CartItemTable = $sm->get('CartItemTable');
        $total = $CartTable->computeTotalPayment($cart_id);
        $items = $CartItemTable->displayItemsInCart($cart_id);
        $viewData = array(
            'total' => $total,
            'items' => $items
        );

        return new ViewModel($viewData);
    }

    protected function insertItemsInCart($cart_id)
    {
        $sm = $this->getServiceLocator();
        $Cart = $sm->get('Cart');
        $CartItemTable = $sm->get('CartItemTable');
        $request = $this->getRequest();
        $Cart->cart_id = $cart_id;
        $Cart->product_id = $request->getPost('hidProdID');
        $Cart->unit_price = $request->getPost('hidUnitPrice');
        $Cart->price = $request->getPost('hidPrice');
        $Cart->weight = $request->getPost('hidWeight');
        $Cart->qty = (Int)$request->getPost('hidQty');
        $CartItemTable->insertItemsInCartItems($Cart);
    }

    public function shippingAction()
    {
        $this->redirectPage();
        $userSession = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $ShippingForm = $sm->get('ShippingForm');
        $ShippingTable = $sm->get('ShippingTable');
        $CartItemTable = $sm->get('CartItemTable');
        $cart_id = $Container->cart_id;
        $totalWeight = $CartItemTable->getTotalWeightByCartID($cart_id);
        $maxWeight = $ShippingTable->getMaximumWeight();
        $result = $ShippingTable->getShippingByWeight($totalWeight->total_weight,$maxWeight->max_weight);
        $request = $this->getRequest();

        if ($request->isPost()) {
            //var_dump($request->getPost());
            $ShippingFilter = $sm->get('ShippingFilter');
            $ShippingForm->setInputFilter($ShippingFilter);
            $ShippingForm->setData($request->getPost());
            if ($ShippingForm->isValid()) {
                $this->addToShipping($ShippingForm->getData());
                $this->redirect()->toRoute('cart', array(
                    'controller' => 'CartController',
                    'action' => 'payment'
                ));
            }
        }

        $viewData = array(
            'shipping' => $ShippingForm,
            'result' => $result
        );

        return new ViewModel($viewData, $userSession);
        //return new ViewModel();
    }

    protected function redirectPage()
    {
        $Service = $this->getServiceLocator();
        $Container = $Service->get('Container');
        $first_name = $Container->offsetGet('first_name');
        $cart_id = $Container->offsetGet('cart_id');

        if (!isset($cart_id) || !isset($first_name)) {
            $this->redirect()->toRoute('home');
        }
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

    protected function addToShipping($data)
    {
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $CartTable = $sm->get('CartTable');
        $cart_id = $Container->offsetGet('cart_id');
        $Cart = $sm->get('Cart');
        $customer_id = $Container->customer_id;
        $CustomerTable = $sm->get('CustomerTable');
        $CartItemTable = $sm->get('CartItemTable');
        $total = $CartItemTable->computeTotalAmount($cart_id);
        $weight = $CartItemTable->computeTotalWeight($cart_id);
        $c = $CustomerTable->getCustomerByID($customer_id);
        $Cart->cart_id = $cart_id;
        $Cart->customer_id = $c->customer_id;
        $Cart->sub_total = $total->total_amount;
        $Cart->shipping_total = $data['shipping_rate'];
        $Cart->total_weight = $weight->total_weight;
        $Cart->company_name = $c->company_name;
        $Cart->email = $c->email;
        $Cart->first_name = $c->first_name;
        $Cart->last_name = $c->last_name;
        $Cart->phone = $c->phone;
        $Cart->shipping_mehod = $data['shipping_mehod'];
        $Cart->shipping_name = $data['txtName'];
        $Cart->shipping_address1 = $data['txtAdd1'];
        $Cart->shipping_address2 = $data['txtAdd2'];
        $Cart->shipping_address3 = $data['txtAdd3'];
        $Cart->shipping_city = $data['txtCity'];
        $Cart->shipping_state = $data['txtState'];
        $Cart->shipping_country = $data['txtCountry'];

        $CartTable->updateCartTable($Cart);
    }

    public function transferToJobsAction()
    {
        $userSession = $this->userIsLoggedIn();
        $sm = $this->getServiceLocator();
        $Container = $sm->get('Container');
        $cart_id = $Container->offsetGet('cart_id');
        $CartItemTable = $sm->get('CartItemTable');
        $JobItemsTable = $sm->get('JobItemsTable');
        $cartitems = $CartItemTable->displayItemsInCart(101);
        $JobItemsTable->insertToJobItems($cartitems);
        $CartItemTable->deleteCartItems($cart_id);
    }
}