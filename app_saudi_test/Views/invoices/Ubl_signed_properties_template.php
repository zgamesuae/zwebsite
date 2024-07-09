<xades:SignedProperties Id="xadesSignedProperties">
    <xades:SignedSignatureProperties>
        <xades:SigningTime><?php echo $sign_stamp ?></xades:SigningTime>
        <xades:SigningCertificate>
            <xades:Cert>
                <xades:CertDigest>
                    <ds:DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
                    <ds:DigestValue><?php echo $certificate_hash ?></ds:DigestValue>
                </xades:CertDigest>
                <xades:IssuerSerial>
                    <ds:X509IssuerName><?php echo $X509IssuerName ?></ds:X509IssuerName>
                    <ds:X509SerialNumber><?php echo $X509SerialNumber ?></ds:X509SerialNumber>
                </xades:IssuerSerial>
            </xades:Cert>
        </xades:SigningCertificate>
    </xades:SignedSignatureProperties>
</xades:SignedProperties>