<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
*Cart Ajax Module
*
* @version $Id: mod_virtuemart_cart.php 6555 2012-10-17 15:49:43Z alatak $
* @package VirtueMart
* @subpackage modules
*
* 	@copyright (C) 2010 - Patrick Kohl
// W: demo.st42.fr
// E: cyber__fr|at|hotmail.com
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

$jsVars  = ' jQuery(document).ready(function(){
	jQuery(".vmCartModule").productUpdate();

});' ;

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');

VmConfig::loadConfig();
VmConfig::loadJLang('mod_virtuemartcart', true);

//This is strange we have the whole thing again in controllers/cart.php public function viewJS()
if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
$cart = VirtueMartCart::getCart(false);

$viewName = JRequest::getString('view',0);
if($viewName=='cart'){
	$checkAutomaticPS = true;
} else {
	$checkAutomaticPS = false;
}
$data = $cart->prepareAjaxData($checkAutomaticPS);
if (!class_exists('CurrencyDisplay')) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
$currencyDisplay = CurrencyDisplay::getInstance( );
$lang = JFactory::getLanguage();
$extension = 'com_virtuemart';
$lang->load($extension);//  when AJAX it needs to be loaded manually here >> in case you are outside virtuemart !!!
if ($data->totalProduct>1) $data->totalProductTxt = JText::sprintf('COM_VIRTUEMART_CART_X_PRODUCTS', $data->totalProduct);
else if ($data->totalProduct == 1) $data->totalProductTxt = JText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
else $data->totalProductTxt = JText::_('COM_VIRTUEMART_EMPTY_CART');
if (false && $data->dataValidated == true) {
	$taskRoute = '&task=confirm';
	$linkName = JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU');
	
	
} else {
	# Mostrar carro
	$taskRoute = '';
	$linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
}
/* Obtengo symbolo de moneda de vendedor */
$currencyModel = VmModel::getModel('currency');
// Pongo que vendedor es 0 pero pienso que si utilizamos multivendedor fllaría
$vendedor= 0;
$currency = $currencyModel->getCurrency($vendedor);
// La variable $moneda pasa directamente al vista tpml
$moneda =$currency->currency_symbol;




$useSSL = VmConfig::get('useSSL',0);
$useXHTML = true;
$data->cart_show = '<a href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';
$data->link = JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL);
$data->linkName = $linkName;
$data->billTotal = '<strong>'. $data->billTotal .'</strong>';
// Calculamos suma para mostrar
	$suma = 0;
	foreach ($data->products as $product) {
	$string = $product ['subtotal_with_tax'];
	$int = ereg_replace("[^0-9]", ".", $string); 
	
	$suma= $suma + $int;
	}
$suma = number_format($suma, 2, ',', ' ');
//$data->suma = $suma;
//$data->moneda = $moneda;
//vmJsApi::jPrice();
vmJsApi::cssSite();
$document = JFactory::getDocument();
//$document->addScriptDeclaration($jsVars);
$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$show_price = (bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_product_list = (bool)$params->get( 'show_product_list', 1 ); // Display the Product Price?
/* Laod tmpl default */

require(JModuleHelper::getLayoutPath('mod_virtuemartcart'));
 ?>
