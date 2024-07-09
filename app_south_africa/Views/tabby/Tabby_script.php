<script src="https://checkout.tabby.ai/tabby-card.js"></script>
<script src="https://checkout.tabby.ai/tabby-promo.js"></script>

<script>
// Tabby Card
<?php if(isset($total)): ?>
  new TabbyCard({
    selector: '#tabbyCard', // empty div for TabbyCard.
    currency: '<?php echo CURRENCY ?>', // required, currency of your product. AED|SAR|KWD|BHD|QAR only supported, with no spaces or lowercase.
    lang: <?php if(get_cookie("language") == "AR") echo "'ar'"; else echo "'en'" ?>, // Optional, language of snippet and popups.
    price: <?php echo $total ?>, // required, total price or the cart. 2 decimals max for AED|SAR|QAR and 3 decimals max for KWD|BHD.
    size: 'narrow', // required, can be also 'wide', depending on the width.
    theme: 'black', // required, can be also 'default'.
    header: false // if a Payment method name present already. 
  });

  TabbyPromo({
    lang : <?php if(get_cookie("language") == "AR") echo "'ar'"; else echo "'en'" ?>
  })
<?php endif; ?>

// Tabby pormo
<?php if(isset($tabby_promo) && $tabby_promo): ?>
  var tabby_cart = {
      selector: '#ws-tabby-promo',
      currency: '<?php echo CURRENCY ?>',
      price: <?php echo $price ?>, 
      installmentsCount: 4, 
      lang: <?php if(get_cookie("language") == "AR") echo "'ar'"; else echo "'en'" ?>, 
      source: 'product',
      publicKey: '<?php echo TABBY_PUBLIC_KEY ?>',
      merchantCode: '<?php echo TABBY_MERCHANT_CODE ?>'
  }
  new TabbyPromo(tabby_cart);
<?php endif; ?>

</script>