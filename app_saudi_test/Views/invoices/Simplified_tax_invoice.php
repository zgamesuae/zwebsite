<?php 
$orderModel = model("App\Models\OrderModel");
$tax = bcdiv(($order["sub_total"]/1.15) * 0.15 , 1 , 2);
$TaxExclusiveAmount = bcdiv(($order["sub_total"]/1.15) , 1 , 2) - (float)$order["coupon_discount"];
$TaxInclusiveAmount = $TaxExclusiveAmount + $tax;
?>
        <cbc:ProfileID>reporting:1.0</cbc:ProfileID>
        <cbc:ID><?php echo $order["order_id"] ?></cbc:ID>
        <cbc:UUID><?php echo $uuid ?></cbc:UUID>
        <cbc:IssueDate><?php $date = new \DateTime("now"); echo $date->format("Y-m-d")?></cbc:IssueDate>
        <cbc:IssueTime><?php echo $date->format("H:i:s")?></cbc:IssueTime>
        <cbc:InvoiceTypeCode name="0200000">388</cbc:InvoiceTypeCode>
        <cbc:DocumentCurrencyCode>SAR</cbc:DocumentCurrencyCode>
        <cbc:TaxCurrencyCode>SAR</cbc:TaxCurrencyCode>
        <cac:AdditionalDocumentReference>
            <cbc:ID>ICV</cbc:ID>
            <cbc:UUID>62</cbc:UUID>
        </cac:AdditionalDocumentReference>
        <cac:AdditionalDocumentReference>
            <cbc:ID>PIH</cbc:ID>
            <cac:Attachment>
                <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain">NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==</cbc:EmbeddedDocumentBinaryObject>
            </cac:Attachment>
        </cac:AdditionalDocumentReference>
        <cac:AdditionalDocumentReference>
            <cbc:ID>QR</cbc:ID>
            <cac:Attachment>
                <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain"><?php if(isset($QR)): echo $QR; endif; ?></cbc:EmbeddedDocumentBinaryObject>
            </cac:Attachment>
        </cac:AdditionalDocumentReference>
        <cac:Signature>
          <cbc:ID>urn:oasis:names:specification:ubl:signature:Invoice</cbc:ID>
          <cbc:SignatureMethod>urn:oasis:names:specification:ubl:dsig:enveloped:xades</cbc:SignatureMethod>
        </cac:Signature>
        <cac:AccountingSupplierParty>
            <cac:Party>
                <cac:PartyIdentification>
                    <cbc:ID schemeID="CRN">1010824122</cbc:ID>
                </cac:PartyIdentification>
                <cac:PostalAddress>
                    <cbc:StreetName>Al Zahra Street, Ahmad al Attas</cbc:StreetName>
                    <cbc:BuildingNumber>3454</cbc:BuildingNumber>
                    <cbc:PlotIdentification>1234</cbc:PlotIdentification>
                    <cbc:CitySubdivisionName>Ryiad</cbc:CitySubdivisionName>
                    <cbc:CityName>Riyadh</cbc:CityName>
                    <cbc:PostalZone>12345</cbc:PostalZone>
                    <cbc:CountrySubentity>test</cbc:CountrySubentity>
                    <cac:Country>
                        <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                    </cac:Country>
                </cac:PostalAddress>
                <cac:PartyTaxScheme>
                    <cbc:CompanyID>301315172700003</cbc:CompanyID>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:PartyTaxScheme>
                <cac:PartyLegalEntity>
                    <cbc:RegistrationName>ZGames</cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:AccountingSupplierParty>
        <?php if($customer_party): ?>
        <cac:AccountingCustomerParty>
            <cac:Party>
                <cac:PostalAddress>
                    <cbc:StreetName> <?php echo $order["street"] ?> </cbc:StreetName>
                    <cbc:BuildingNumber> <?php echo $order["apartment_house"] ?> </cbc:BuildingNumber>
                    <cbc:CitySubdivisionName>32423423</cbc:CitySubdivisionName>
                    <cac:Country>
                        <cbc:IdentificationCode>SA</cbc:IdentificationCode>
                    </cac:Country>
                </cac:PostalAddress>
                <cac:PartyTaxScheme>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:PartyTaxScheme>
                <cac:PartyLegalEntity>
                    <cbc:RegistrationName>
                        <?php echo $order["name"] ?>
                    </cbc:RegistrationName>
                </cac:PartyLegalEntity>
            </cac:Party>
        </cac:AccountingCustomerParty>
        <?php else: ?>
        <cac:AccountingCustomerParty/>
        <?php endif; ?>

        <cac:Delivery>
            <cbc:ActualDeliveryDate><?php echo $date->format("Y-m-d")?></cbc:ActualDeliveryDate>
            <cbc:LatestDeliveryDate><?php echo $date->add(new \DateInterval("P2D"))->format("Y-m-d")?></cbc:LatestDeliveryDate>
        </cac:Delivery>

        <cac:PaymentMeans>
            <cbc:PaymentMeansCode>10</cbc:PaymentMeansCode>
        </cac:PaymentMeans>

        <cac:AllowanceCharge>
            <cbc:ID>1</cbc:ID>
            <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
            <cbc:AllowanceChargeReason>discount</cbc:AllowanceChargeReason>
            <cbc:Amount currencyID="SAR"><?php echo $order["coupon_discount"] ?></cbc:Amount>
            <cac:TaxCategory>
                <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5305">S</cbc:ID>
                <cbc:Percent>15</cbc:Percent>
                <cac:TaxScheme>
                    <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5153">VAT</cbc:ID>
                </cac:TaxScheme>
            </cac:TaxCategory>
        </cac:AllowanceCharge>
        
        <!-- cacTaxSubtotal -->
        <cac:TaxTotal>
            <cbc:TaxAmount currencyID="SAR"><?php echo $tax ?></cbc:TaxAmount>
            <cac:TaxSubtotal>
                <cbc:TaxableAmount currencyID="SAR"><?php echo bcdiv(($order["sub_total"]/1.15) , 1 , 2) ?></cbc:TaxableAmount>
                <cbc:TaxAmount currencyID="SAR"><?php echo $tax ?></cbc:TaxAmount>
                <cac:TaxCategory>
                    <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5305">S</cbc:ID>
                    <cbc:Percent>15.00</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5153">VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:TaxCategory>
            </cac:TaxSubtotal>
        </cac:TaxTotal>
        <!-- cacTaxSubtotal -->


        <cac:TaxTotal>
            <cbc:TaxAmount currencyID="SAR"><?php echo $tax ?></cbc:TaxAmount>
        </cac:TaxTotal>

        <cac:LegalMonetaryTotal>
            <cbc:LineExtensionAmount currencyID="SAR"><?php echo bcdiv(($order["sub_total"]/1.15) , 1 , 2) ?></cbc:LineExtensionAmount>
            <cbc:TaxExclusiveAmount currencyID="SAR"><?php  echo $TaxExclusiveAmount?></cbc:TaxExclusiveAmount>
            <cbc:TaxInclusiveAmount currencyID="SAR"><?php echo $TaxInclusiveAmount ?></cbc:TaxInclusiveAmount>
            <cbc:AllowanceTotalAmount currencyID="SAR"><?php echo (float)$order["coupon_discount"] ?></cbc:AllowanceTotalAmount>
            <cbc:PrepaidAmount currencyID="SAR">0.00</cbc:PrepaidAmount>
            <cbc:PayableAmount currencyID="SAR"><?php echo $TaxInclusiveAmount ?></cbc:PayableAmount>
        </cac:LegalMonetaryTotal>

        <?php 
        foreach($products as $product):
            $i=1;
            $discount = round(bcdiv($product->product_original_price / 1.15 , 1 , 2 ) , 2) - round(bcdiv($product->product_price / 1.15 , 1 ,2) , 2);
            $gross_price = round(bcdiv($product->product_original_price / 1.15 , 1 , 3) , 2);
            $net_price = $gross_price - $discount;
            $total_net_amount = $net_price * $product->quantity;
            $taxamount = round(bcdiv($total_net_amount * 0.15 , 1 , 3) , 2);
            $quantity = $product->quantity;
        ?>
        <cac:InvoiceLine>
            <cbc:ID>1</cbc:ID>
            <cbc:InvoicedQuantity unitCode="PCE"><?php echo $quantity ?></cbc:InvoicedQuantity>
            <cbc:LineExtensionAmount currencyID="SAR"><?php echo $total_net_amount ?></cbc:LineExtensionAmount>
            <cac:TaxTotal>
                <cbc:TaxAmount currencyID="SAR"><?php echo $taxamount ?></cbc:TaxAmount>
                <cbc:RoundingAmount currencyID="SAR"><?php echo $total_net_amount + $taxamount ?></cbc:RoundingAmount>
            </cac:TaxTotal>
            <cac:Item>
                <cbc:Name><?php echo $product->product_name ?></cbc:Name>
                <cac:ClassifiedTaxCategory>
                    <cbc:ID>S</cbc:ID>
                    <cbc:Percent>15.00</cbc:Percent>
                    <cac:TaxScheme>
                        <cbc:ID>VAT</cbc:ID>
                    </cac:TaxScheme>
                </cac:ClassifiedTaxCategory>
            </cac:Item>
            <cac:Price>
                <cbc:PriceAmount currencyID="SAR"><?php echo $net_price ?></cbc:PriceAmount>
                <cac:AllowanceCharge>
                    <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
                    <cbc:AllowanceChargeReason>discount</cbc:AllowanceChargeReason>
                    <cbc:Amount currencyID="SAR"><?php echo $discount ?></cbc:Amount>
                </cac:AllowanceCharge>
            </cac:Price>
        </cac:InvoiceLine>
        <?php endforeach; ?>