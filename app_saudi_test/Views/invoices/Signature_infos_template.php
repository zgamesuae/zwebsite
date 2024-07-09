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
        <ds:DigestValue><?php echo $hash ?></ds:DigestValue>
    </ds:Reference>
    <ds:Reference Type="http://www.w3.org/2000/09/xmldsig#SignatureProperties" URI="#xadesSignedProperties">
        <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
        <ds:DigestValue>ZWMyZGJmYjhiMDM5Yzg1NjFjMTY4OGFjMGZiOWRjZGQwZDU4ZDc2NGYzMTFiMjdhNzY1ODYzM2YwOWE1NWFjNA==</ds:DigestValue>
    </ds:Reference>
</ds:SignedInfo>
<ds:SignatureValue><?php echo $digital_signature ?></ds:SignatureValue>
<ds:KeyInfo>
    <ds:X509Data>
        <ds:X509Certificate><?php echo $certificate ?></ds:X509Certificate>
    </ds:X509Data>
</ds:KeyInfo>
<ds:Object>
     <xades:QualifyingProperties xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" Target="signature">
        <?php if(isset($signed_properties)):  echo $signed_properties; endif; ?>
    </xades:QualifyingProperties>
</ds:Object>