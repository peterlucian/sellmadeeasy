<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "vendor/autoload.php";
use Omnipay\Omnipay;

class paypal extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    

    public function gateway(){
        
        $gateway = Omnipay::create('PayPal_Rest');

        $gateway->setClientId('YOUR CLIENT ID');
        $gateway->setSecret('YOUR CLIENT SECRET');
        $gateway->setTestMode(true);

        return $gateway;

    }

  

    public function sendPurchase(){

        $return_url = base_url().'paypal/completePurchase';
        $cancel_url = base_url().'paypal/cancelPurchase';    
       
        $id = $this->session->userdata('id');

        $this->load->model('cart/cart_model');
		$query=$this->cart_model->_get_cart_by_user($id);
        
        $items = array();
        $amount = 0;
        
        foreach($query->result() as $row){

            array_push($items, array('name' => $row->title,
            'quantity' => $row->qty,
            'price' => $row ->price));

            $amount += $row->price * $row->qty;
			
        }
        
        try {

            $response = $this->gateway()->purchase(array(
                'amount' => $amount,
                'currency' => 'EUR',
                'returnUrl' => $return_url,
                'cancelUrl' => $cancel_url,
            ))->setItems($items)->send();
     
            if ($response->isRedirect()) {
                $response->redirect(); // this will automatically forward the customer
            } else {
                // not successful
                echo $response->getMessage();
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function completePurchase(){


        // Once the transaction has been approved, we need to complete it.
        if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
            $transaction = $this->gateway()->completePurchase(array(
                'payer_id'             => $_GET['PayerID'],
                'transactionReference' => $_GET['paymentId'],
            ));
            $response = $transaction->send();

        
        if ($response->isSuccessful()) {
            
                $user_id = $this->session->userdata('id');
                
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $payment_id = $arr_body['id'];
                

                $this->load->model('cart/cart_model');
                $query=$this->cart_model->_get_cart_by_user($user_id);
                
                $this->load->model('items/items_model');
                

                foreach($query->result() as $row){
        
                    $qty = $row->qty;
                    $item_id = $row->item_id;
                    
                    $this->items_model->_update_qty($item_id, $qty);

                }
                    
                $this->cart_model->_delete_by_user($user_id); 
                
                $data['module']='paypal';
                $data['view_file']='paypal_success';
        
                $this->load->module('home');
				$this->home->index($data);

                
                
                
            } else {
                echo $response->getMessage();
            }
        } else {
            echo 'Transaction is declined';
        }
 
    }


    public function cancelPurchase(){

        echo "Canceled purchase";

    }


}