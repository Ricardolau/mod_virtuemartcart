<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Entro Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
<div class="ModuloVmCart">
</div>

<?php
if ($show_product_list) {
	?>
	<div id="hiddencontainer" style=" display: none; ">
		<div class="vmcontainer">
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>

			<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				<div class="subtotal_with_tax" style="float: right;"></div>
			<?php } ?>
			<div class="customProductData"></div><br>
			</div>
		</div>
	</div>
	<div class="vm_cart_products">
		<div class="vmcontainer">

		<?php
			foreach ($data->products as $product){
				?><div class="product_row">
					<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
				<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				  <div class="subtotal_with_tax" style="float: right;"><?php echo $product['subtotal_with_tax'] ?></div>
				<?php } ?>
				<?php if ( !empty($product['customProductData']) ) { ?>
					<div class="customProductData"><?php echo $product['customProductData'] ?></div><br>

				<?php } ?>

			</div>
		<?php }
		?>
		</div>
	</div>
<?php } ?>
<div class="total_products">
	<?php  //Mostramos imagend de carro de la plantilla
	?>	
</div>

	<div class="total" style="text-align: center;">
		<?php  /* Muestra total si realmente hay datos .. */
		if ($data->totalProduct and $show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
		<?php 
			
			if ($suma > 0){
			echo JText::_('COM_VIRTUEMART_CART_TITLE').'('.$data->totalProduct.')</span><br/>';
			echo '<div class="Precio" style="font-size: 1.2em;padding: 5px;display: table;margin: 0px auto;">'.$suma.'<span class="euro">'.$moneda.'</span></div>';
			
			}
			 ?>
			
		<?php
		} else {
			echo '<a href="./">'.JText::_('COM_VIRTUEMART_CHECKOUT_TITLE').'</a>';
		}
		
		?>
	</div>

<div class="show_cart" style="text-align: center;">
	<?php if ($data->totalProduct) {
	 
	 echo  $data->cart_show;
	 } ?>
</div>
<div style="clear:both;"></div>
	<div class="payments_signin_button" ></div>
<noscript>
<?php 
echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT'); ?>
</noscript>
</div>

