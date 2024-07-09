<?php 
$tax = bcdiv(($order["sub_total"]/1.15) * 0.15 , 1 , 2);
$TaxExclusiveAmount = bcdiv(($order["sub_total"]/1.15) , 1 , 2) - (float)$order["coupon_discount"];
$TaxInclusiveAmount = $TaxExclusiveAmount + $tax;

?>
<xml version="1.0" encoding="UTF-8">
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionURI>urn:oasis:names:specification:ubl:dsig:enveloped:xades</ext:ExtensionURI>
            <ext:ExtensionContent>
                <!-- Please note that the signature values are sample values only -->
                <sig:UBLDocumentSignatures xmlns:sig="urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2" xmlns:sac="urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2" xmlns:sbc="urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2">
                    <sac:SignatureInformation>
                        <cbc:ID>urn:oasis:names:specification:ubl:signature:1</cbc:ID>
                        <sbc:ReferencedSignatureID>urn:oasis:names:specification:ubl:signature:Invoice</sbc:ReferencedSignatureID>
                        <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#" Id="signature">
                            <ds:SignedInfo>
                                <ds:CanonicalizationMethod Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                <ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#ecdsa-sha256"/>
                                <ds:Reference Id="invoiceSignedData" URI="">
                                    <ds:Transforms>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::ext:UBLExtensions)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::cac:Signature)</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/TR/1999/REC-xpath-19991116">
                                            <ds:XPath>not(//ancestor-or-self::cac:AdditionalDocumentReference[cbc:ID='QR'])</ds:XPath>
                                        </ds:Transform>
                                        <ds:Transform Algorithm="http://www.w3.org/2006/12/xml-c14n11"/>
                                    </ds:Transforms>
                                    <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <!-- Step 1 -->
                                    <ds:DigestValue><?php echo $hash ?></ds:DigestValue>
                                </ds:Reference>
                                
                                <ds:Reference Type="http://www.w3.org/2000/09/xmldsig#SignatureProperties" URI="#xadesSignedProperties">
                                    <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                    <!-- Step 5 -->
                                    <ds:DigestValue></ds:DigestValue>
                                </ds:Reference>
                            </ds:SignedInfo>
                            <!-- Step 2 -->
                            <ds:SignatureValue><?php echo $digital_signature ?></ds:SignatureValue>

                            <ds:KeyInfo>
                                <ds:X509Data>
                                    <!-- Certificate -->
                                    <ds:X509Certificate><?php echo $certificate ?></ds:X509Certificate>
                                </ds:X509Data>
                            </ds:KeyInfo>

                            <ds:Object>
                                <xades:QualifyingProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" Target="signature">
                                    <xades:SignedProperties Id="xadesSignedProperties">
                                        <xades:SignedSignatureProperties>
                                            <!-- Signing Time -->
                                            <!-- <xades:SigningTime>2022-09-15T00:41:21Z</xades:SigningTime> -->
                                            <xades:SigningTime><?php echo $sign_stamp ?></xades:SigningTime>
                                            <xades:SigningCertificate>
                                                <xades:Cert>
                                                    <xades:CertDigest>
                                                        <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                                                        <!-- Step 3 -->
                                                        <ds:DigestValue><?php echo $certificate_hash ?></ds:DigestValue>
                                                    </xades:CertDigest>
                                                    <xades:IssuerSerial>
                                                        <!-- Certificate Issuer Name (Decoded) -->
                                                        <ds:X509IssuerName><?php echo $X509IssuerName ?></ds:X509IssuerName>
                                                        <!-- Certificate Serial Number (Decoded) -->
                                                        <ds:X509SerialNumber><?php echo $X509SerialNumber ?></ds:X509SerialNumber>
                                                    </xades:IssuerSerial>
                                                </xades:Cert>
                                            </xades:SigningCertificate>
                                        </xades:SignedSignatureProperties>
                                    </xades:SignedProperties>
                                </xades:QualifyingProperties>
                            </ds:Object>


                        </ds:Signature>
                    </sac:SignatureInformation>
                </sig:UBLDocumentSignatures>
            </ext:ExtensionContent>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    
    <cbc:ProfileID>reporting:1.0</cbc:ProfileID>
    <cbc:ID><?php echo $order["order_id"] ?></cbc:ID>
    <cbc:UUID>8e6000cf-1a98-4174-b3e7-b5d5954bc10d</cbc:UUID>
    <cbc:IssueDate><?php echo $date->format("Y-m-d")?></cbc:IssueDate>
    <cbc:IssueTime><?php echo $date->format("H:i:s")?></cbc:IssueTime>
    <cbc:InvoiceTypeCode name="0200000">388</cbc:InvoiceTypeCode>
    <cbc:Note languageID="ar">ABC</cbc:Note>
    <cbc:DocumentCurrencyCode>SAR</cbc:DocumentCurrencyCode>
    <cbc:TaxCurrencyCode>SAR</cbc:TaxCurrencyCode>
    <cac:AdditionalDocumentReference>
        <cbc:ID>ICV</cbc:ID>
        <cbc:UUID>10</cbc:UUID>
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
            <cbc:EmbeddedDocumentBinaryObject mimeCode="text/plain"><?php echo $QR ?></cbc:EmbeddedDocumentBinaryObject>
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
                <cbc:BuildingNumber>3242</cbc:BuildingNumber>
                <cbc:PlotIdentification>4323</cbc:PlotIdentification>
                <cbc:CitySubdivisionName>32423423</cbc:CitySubdivisionName>
                <cbc:CityName>Ryiad</cbc:CityName>
                <cbc:PostalZone>32432</cbc:PostalZone>
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

    <cac:AccountingCustomerParty>
        <cac:Party>
            <cac:PostalAddress>
                <cbc:StreetName/>
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
                <cbc:RegistrationName/>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingCustomerParty>

    <?php if(false): ?>
    <cac:Delivery>
        <cbc:ActualDeliveryDate><?php echo $date->format("Y-m-d")?></cbc:ActualDeliveryDate>
        <cbc:LatestDeliveryDate><?php echo $date->add(new \DateInterval("P2D"))->format("Y-m-d")?></cbc:LatestDeliveryDate>
    </cac:Delivery>
    <?php endif; ?>


    <cac:PaymentMeans>
        <cbc:PaymentMeansCode>10</cbc:PaymentMeansCode>
    </cac:PaymentMeans>

    <cac:AllowanceCharge>
        <cbc:ChargeIndicator>false</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReason>discount</cbc:AllowanceChargeReason>
        <cbc:Amount currencyID="SAR"><?php echo $order["coupon_discount"] ?></cbc:Amount>
        <cac:TaxCategory>
            <cbc:ID schemeID="UN/ECE 5305" schemeAgencyID="6">S</cbc:ID>
            <cbc:Percent>15</cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">VAT</cbc:ID>
            </cac:TaxScheme>
        </cac:TaxCategory>
    </cac:AllowanceCharge>

    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="SAR"><?php echo $tax ?></cbc:TaxAmount>
    </cac:TaxTotal>

    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="SAR"><?php $tax ;?></cbc:TaxAmount>
        <cac:TaxSubtotal>
            <cbc:TaxableAmount currencyID="SAR"><?php echo bcdiv(($order["sub_total"]/1.15) , 1 , 2) ?></cbc:TaxableAmount>
            <cbc:TaxAmount currencyID="SAR"><?php echo $tax ?></cbc:TaxAmount>
             <cac:TaxCategory>
                 <cbc:ID schemeID="UN/ECE 5305" schemeAgencyID="6">S</cbc:ID>
                 <cbc:Percent>15.00</cbc:Percent>
                <cac:TaxScheme>
                   <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">VAT</cbc:ID>
                </cac:TaxScheme>
             </cac:TaxCategory>
        </cac:TaxSubtotal>
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

</Invoice>