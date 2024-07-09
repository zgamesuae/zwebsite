<?php ?>
<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
    <?php if(isset($ubl_extensions)): ?>
    <ext:UBLExtensions>
        <?php  echo $ubl_extensions; ?>
    </ext:UBLExtensions>
    <?php endif; ?>
    <?php if(isset($simplified_invoice)): echo $simplified_invoice; endif; ?>
</Invoice>