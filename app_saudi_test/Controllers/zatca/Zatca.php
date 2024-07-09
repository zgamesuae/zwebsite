<?php

namespace App\Controllers\zatca;
use \App\Controllers\BaseController;
use XmlDsig;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\InvoiceHashXml;
use Salla\ZATCA\Tags\InvoiceHash;
use Salla\ZATCA\Tags\DigitalSignature;
use Salla\ZATCA\Tags\Signature;
use Salla\ZATCA\Tags\PublicKey;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

use App\Libraries\ZATCA\src\EGS;
use App\Libraries\Zatca\src\API;
use App\Libraries\Zatca\src\ZATCASimplifiedTaxInvoice;

class Zatca extends \App\Controllers\BaseController{


    public function __construct(){

    }

    
    public function index($order_id="16988131789"){
        // echo implode("," , ["hel" => "lo" , "neig" =>"hbors"]);die();
        $order =  (array)$this->orderModel->get_order_details($order_id);
        // var_dump($order);die();
        $products =  $this->orderModel->get_order_products($order_id);
        $business = $this->systemModel->get_website_settings();
        $date = new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
        // file_put_contents("test_xml_invoice.xml" , base64_decode($c));

        $uuid = $this->uuid();

        // Create the xml file
        $simplified_invoice = view("invoices/Simplified_tax_invoice" , [
            "order" => $order ,
            "products" => $products ,
            "date" => $date ,
            "business" => $business,
            "uuid" => $uuid,
            "customer_party" => true
        ]);

        $xml_invoice = view("invoices/XML_invoice" , [
            "simplified_invoice" => $simplified_invoice
        ]);

        // ########## PREPARE THE CANONICAL XML INVOICE #######################

            $document_name = "zatca/invoices/".$order_id."_canc_xml_invoice.xml";
            $document = new \DOMDocument();

            $document->loadXML($xml_invoice);
            $domxpath = new \DOMXPath($document);

            // Register namespaces 
            $domxpath->registerNamespace("ext" , "urn:oasis:names:specification:ubl:dsig:enveloped:xades");
            $domxpath->registerNamespace("sig" , "urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2");
            $domxpath->registerNamespace("sac" , "urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2");
            $domxpath->registerNamespace("ds" , "http://www.w3.org/2000/09/xmldsig#");
            $domxpath->registerNamespace("xades" , "http://uri.etsi.org/01903/v1.3.2#");


            //############## Remove unecessery DOMS 
                // $UBLExt_node = $domxpath->query("//*[local-name()='UBLExtensions']");
                // foreach ($UBLExt_node as $entry) {
                //     # code...
                //     $entry->parentNode->removeChild($entry);
                // }
                    
                // $tt = $domxpath->query("//ext:UBLExtensions/ext:UBLExtension/ext:ExtensionContent/sig:UBLDocumentSignatures/sac:SignatureInformation/ds:Signature/ds:Object/xades:QualifyingProperties/xades:SignedProperties");
                $adr_node = $domxpath->query("//*[local-name()='AdditionalDocumentReference'][cbc:ID[normalize-space(text()) = 'QR']]");
                foreach ($adr_node as $entry) {
                    # code...
                    $entry->parentNode->removeChild($entry);
                }
                    
                $signature_node = $domxpath->query("//*[local-name()='Signature']");
                foreach ($signature_node as $entry) {
                    # code...
                    $entry->parentNode->removeChild($entry);
                }

            //############## Remove unecessery DOMS 

            // Save Xml content
            // $document->saveXml($document->documentElement);
            $document->saveXml();
            // Canonicalize the XML content
            file_put_contents($document_name , preg_replace("/\s\n/" , "" , $document->saveXml()));
            // file_put_contents($document_name , $document->C14N());


            // $document->save($document_name);

        // ########## PREPARE THE CANONICAL XML INVOICE #######################
        

        // ########## HASH THE CANONICAL XML INVOICE #######################
            $_xml = file_get_contents($document_name);
            $invoice_hash = base64_encode(hash("sha256", trim($_xml)));
            file_put_contents("zatca/invoices/".$order_id."_invoice_hash.txt" , $invoice_hash);
            // "invoiceHash": "t1vEblOtMk4E3+YFofL4rYw8ARqvuvA5aQYVw6wS3BA=",
        // ########## HASH THE CANONICAL XML INVOICE #######################
        

        if(true):
        // ######################## Create Private and Public keys ########################
            // $result = shell_exec('openssl ecparam -name secp256k1 -genkey');
            exec("openssl ecparam -name secp256k1 -genkey -noout -out zatca/privatekey.pem");
            // exec("openssl ec -in zatca/privatekey.pem -pubout -conv_form compressed -out zatca/publickey.pem");
            // exec("openssl base64 -d -in zatca/publickey.pem -out zatca/publickey.bin");
        // ######################## Create Private and Public keys ########################
        endif;

        // Validate the signature for the standard invoice
        // exec("openssl dgst -verify zatca/publickey.pem -signature zatca/publickey.bin ".$document_name , $out);

        // ######################## Create Certificate Signing request (CSR) ########################
            // exec("openssl req -new -sha256 -key zatca/privatekey.pem -extensions v3_req -config zatca/config.cnf -out zatca/taxpayer.csr");
            exec("openssl req -new -sha256 -key zatca/privatekey.pem -config zatca/config1.cnf -out zatca/taxpayer.csr");
            $csr= file_get_contents("zatca/taxpayer.csr");
            // $csr_base64 = base64_encode(hash("sha256" , $csr));
            $csr_base64 = base64_encode($csr);
            // $csr_base64 = str_replace("\n" , "" , $csr_base64);
            // $csr_base64 = str_replace("\r" , "" , $csr_base64);
        // ######################## Create Certificate Signing request (CSR) ########################


        // ######################## Sign hashed 256 canonical invoice xml ######################

            // exec("openssl pkeyutl -sign -inkey zatca/privatekey.pem -in zatca/invoices/".$order_id."_invoice_hash.txt > zatca/invoices/".$order_id."signature.bin");
            // exec("openssl pkeyutl -in zatca/invoices/".$order_id."_invoice_hash.txt -inkey zatca/publickey.pem -pubin -verify -sigfile zatca/invoices/".$order_id."signature.bin" , $out);
            openssl_sign(file_get_contents("zatca/invoices/".$order_id."_invoice_hash.txt"), $digital_signature, file_get_contents("zatca/privatekey.pem"), 'sha256');
            // var_dump($digital_signature);die();
            if($digital_signature){
                // $digital_signature = file_get_contents("zatca/invoices/".$order_id."signature.bin");
                // echo "Digital Signature: ".base64_decode("MEQCIGAQj78/dlFj31AZBDK79GKTvZJh5sD9fMEYeeE8azwcAiBYL+n143jKkL0fjV0D0S/HQxxUtT/NM/K5r92pZ24VwA==");
                $sign_stamp = $date->format('Y-m-d\TH:i:s\Z');
            }

        // ######################## Sign hashed 256 canonical invoice xml ########################


        // ######################## Get the certificate from Zatca ########################
            $CSID = $this->CSID($csr_base64);
            $R_CSID = base64_decode($CSID->binarySecurityToken);
            $_CSID = "-----BEGIN CERTIFICATE-----\n".$R_CSID."\n-----END CERTIFICATE-----";
            // save the certificate
            file_put_contents("zatca/Certificat.pem" , $_CSID);
            // save the secret
            file_put_contents("zatca/secret.txt" , $CSID->secret);
            
            // exec("openssl x509 -in zatca/Certificat.pem -text -noout" , $out);
            $decoded_CSID = openssl_x509_parse(openssl_x509_read($_CSID));
            if(sizeof($decoded_CSID) > 0){
                $CertificatePublicKey = $this->cleanUpPublicKey(openssl_pkey_get_details(openssl_get_publickey($_CSID))["key"]);
                $X509SerialNumber = $decoded_CSID["serialNumber"];
                $X509IssuerName = "";
                $co = 0;
                foreach ($decoded_CSID["issuer"] as $key => $value) {
                    # code...
                    $X509IssuerName .= $key."=".$value;
                    if($co !== sizeof($decoded_CSID["issuer"]) - 1)
                    $X509IssuerName .= ", ";
                    $co++;
                }
            }
            else{
                echo "here"; die();
            }
            $cert_hash_base64 = base64_encode(hash("sha256" , $R_CSID));
        // ######################## Get the certificate from Zatca ########################
        
        // ##################### Create The QR code ########################
            $seller_info = [
                new Seller('ZGames'), // seller name        
                new TaxNumber('301315172700003'), // seller tax number
                new InvoiceDate($date->format('Y-m-d\TH:i:s\Z')), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                new InvoiceTotalAmount(bcdiv(($order["sub_total"]/1.15) , 1 , 2) - (float)$order["coupon_discount"] + bcdiv(($order["sub_total"]/1.15) * 0.15 , 1 , 2)), // invoice total amount
                new InvoiceTaxAmount(bcdiv(($order["sub_total"]/1.15) * 0.15 , 1 , 2)), // invoice tax amount
                new InvoiceHash($invoice_hash),
                new DigitalSignature(base64_encode($digital_signature)),
                new PublicKey(base64_encode($CertificatePublicKey)),
                new Signature(base64_encode($this->getCertificateSignature($_CSID))),
            ];
            var_dump(GenerateQrCode::fromArray($seller_info));die();
            $qr_base64 = GenerateQrCode::fromArray($seller_info)->toBase64();
            $QRcode = GenerateQrCode::fromArray($seller_info)->render();
            // echo("<img src='$QRcode' height='250px'></img>");
        // ##################### Create The QR code ########################

        
        $signed_properties_xml = view("invoices/Ubl_signed_properties_template" , [
            "sign_stamp" => $sign_stamp,
            "certificate_hash" => $cert_hash_base64, // Step 3
            "X509IssuerName" => $X509IssuerName,
            "X509SerialNumber" => $X509SerialNumber,
        ]);

        $signature_infos = view("invoices/Signature_infos_template" , [
            "hash" => $invoice_hash, // Step 1
            "digital_signature" => base64_encode($digital_signature), // Step 2
            "certificate" => $R_CSID,
            "signed_properties" =>  $signed_properties_xml
        ]);

        $ubl_signature = view("invoices/Ubl_signature" , [
            "signature_infos" => $signature_infos 
        ]);

        $simplified_invoice = view("invoices/Simplified_tax_invoice" , [
            "order" => $order ,
            "products" => $products ,
            "date" => $date ,
            "business" => $business,
            "uuid" => $uuid,
            "QR" => $qr_base64,
            "customer_party" => true
        ]);
        
        $xml_invoice = view("invoices/XML_invoice" , [
            "simplified_invoice" => $simplified_invoice,
            "ubl_extensions" => $ubl_signature
        ]);

        $document->loadXML($xml_invoice);
        $file = "zatca/invoices/".$order_id."_xml_invoice.xml";
        $document->save($file);
        $xml_invoice = $this->signed_properties_hash($file);
        $invoice_encode = base64_encode($xml_invoice);

        if(true){
            $certificate_striped = base64_encode($this->cleanUpCertificateString(file_get_contents("zatca/Certificat.pem")));
            $secret = file_get_contents("zatca/secret.txt");
            $basic = base64_encode($certificate_striped . ':' . $secret);
            // var_dump($this->clearance($basic , $uuid ,  $invoice_hash , $invoice_encode));die();
            $compliance = $this->compliance_check($basic , $invoice_hash , $invoice_encode , $uuid);
            var_dump($compliance->validationResults);
            // var_dump($compliance);
        }

    }

    public function zatca($url , $request , $header){

        $curl = curl_init();
        curl_setopt_array( $curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_TIMEOUT => 300,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$request,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HEADER=>true,
            CURLOPT_HTTPHEADER=> 
            array_merge(
                array(
                    'accept: application/json',
                    'Content-Type: application/json',
                ) , $header
            ),
        
        CURLOPT_SSL_VERIFYPEER => false,
        // CURLOPT_VERBOSE => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response);
        // var_dump($response->secret , $response->requestID);
        // print_r(($response));die();

        if($response->error){
            var_dump($response->error);
            return false;
        }

        else 
        return $response;
    }

    public function CSID($csr){
        $request = 
        '
        {
            "csr": "'.$csr.'"
          }
        ';

        $header = 
        [
            'OTP: 123345',
            'Accept-Version: V2'
        ];

        $csid_url = "https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal/compliance";
        $CSID = $this->zatca($csid_url , $request , $header);
        return $CSID;
    }

    public function clearance($authorization , $uuid ,  $invoice_hash , $invoice_encoded){
        $invoice =  base64_encode($xml);
        $hash = md5(base64_decode($invoice));
        // "invoiceHash": "t1vEblOtMk4E3+YFofL4rYw8ARqvuvA5aQYVw6wS3BA=",
        $request = 
        '
            {
              "invoiceHash": "'.$invoice_hash.'",
              "uuid": "'.$uuid.'",
              "invoice": "'.$invoice_encoded.'"
            }
        ';

        $header = 
        [
            'Clearance-Status: 1',
            'Accept-Version: V2',
            'accept-language: en',
            'Authorization: Basic '.$authorization,
        ];

        $clearance_url = "https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal/invoices/clearance/single";
        $clearance = $this->zatca($clearance_url , $request , $header);

        return $clearance;
    }

    public function compliance_check($basic , $invoice_hash , $invoice_encode , $uuid){
        $compliance = false;
        $request = 
        '
            {
              "invoiceHash": "'.$invoice_hash.'",
              "uuid": "'.$uuid.'",
              "invoice": "'.$invoice_encode.'"
            }
        ';

        $header = 
        [
            'Accept-Version: V2',
            'accept-language: en',
            'Authorization: Basic '.$basic,
        ];

        $compliance_url = "https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal/compliance/invoices";
        $compliance = $this->zatca($compliance_url , $request , $header);

        return $compliance;
    }

    public function reporting($authorization , $xml){
        $invoice =  base64_encode($xml);
        $hash = hash( "sha1", base64_decode($invoice));
        $request = 
        '
            {
              "invoiceHash": "'.$hash.'",
              "uuid": "16e78469-64af-406d-9cfd-895e724198f0",
              "invoice": "'.$invoice.'"
            }
        ';

        $header = 
        [
            'Accept-Version: V2',
            'accept-language: en',
            'Authorization: Basic '.$authorization,
        ];

        $compliance_url = "https://gw-apic-gov.gazt.gov.sa/e-invoicing/developer-portal/invoices/reporting/single";
        $compliance = $this->zatca($compliance_url , $request , $header);

        return $compliance;
    }

    public function signed_properties_hash($file){
        $document = new \DOMDocument("1.0");
        $document->load($file);
        $domxpath = new \DOMXPath($document);

        $domxpath->registerNamespace("ext" , "urn:oasis:names:specification:ubl:dsig:enveloped:xades");
        $domxpath->registerNamespace("sig" , "urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2");
        $domxpath->registerNamespace("sac" , "urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2");
        $domxpath->registerNamespace("ds" , "http://www.w3.org/2000/09/xmldsig#");
        $domxpath->registerNamespace("xades" , "http://uri.etsi.org/01903/v1.3.2#");

        $SignedProperties = $domxpath->query("//ext:UBLExtensions/ext:UBLExtension/ext:ExtensionContent/sig:UBLDocumentSignatures/sac:SignatureInformation/ds:Signature/ds:Object/xades:QualifyingProperties/xades:SignedProperties");
        $SignedProperties_value = $domxpath->query("//ext:UBLExtensions/ext:UBLExtension/ext:ExtensionContent/sig:UBLDocumentSignatures/sac:SignatureInformation/ds:Signature/ds:SignedInfo/ds:Reference[@URI='#xadesSignedProperties']/ds:DigestValue");
        $block = "";

        foreach ($SignedProperties as $node) {
            # code...
            $block = preg_replace("/\n+/" , "" , $node->C14N());
            $block = preg_replace("/\s+/" , "" , $block);
            file_put_contents("zatca/test.xml" , $block);

        }

        foreach ($SignedProperties_value as $node) {
            # code...
            $hash = base64_encode(hash("sha256" , $block));
            $node->nodeValue = $hash;
        }
        $document->save($file);
        return ($document->saveXML());
        
    }

    public static function cleanUpCertificateString(string $certificate): string {
        $certificate = str_replace('-----BEGIN CERTIFICATE-----', '', $certificate);
        $certificate = str_replace('-----END CERTIFICATE-----', '', $certificate);

        return trim($certificate);
    }
    
    public static function cleanUpPublicKey(string $PublicKey): string {
        $PublicKey = str_replace('-----BEGIN PUBLIC KEY-----', '', $PublicKey);
        $PublicKey = str_replace('-----END PUBLIC KEY-----', '', $PublicKey);

        return trim($PublicKey);
    }

    public static function uuid(): string {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function getCertificateSignature(string $cer): string{
        $res = openssl_x509_read($cer);
        openssl_x509_export($res, $out, FALSE);
        $out = explode('Signature Algorithm:', $out);
        $out = explode('-----BEGIN CERTIFICATE-----', $out[2]);
        $out = explode("\n", $out[0]);
        $out = $out[1] . $out[2] . $out[3] . $out[4];
        $out = str_replace([':', ' '], '', $out);

        return pack('H*', $out);
    }

    public function test($order_id = "17012520245"){
        $order =  (array)$this->orderModel->get_order_details($order_id);
        $products =  $this->orderModel->get_order_products($order_id);
        $order_charges = $this->orderModel->order_total_charges($order_id);
        // var_dump($order);die();
        // SET CANCELATION INVOICE REFERENCE
        $egs_unit = [
            'cancelation' => [
                'cancelation_type' => 'INVOICE',
                'canceled_invoice_number' => '',
            ],
        ];

        $egs = new EGS();

        // SET ZATCA LIVE MODE
        // $egs->production = true;

        $line_items = $charges = $discounts = [];

        // MAP invoice Product list to the ZATCA System Data Structure
        array_map(function($product) use(&$line_items){
            $line_items[] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'quantity' => $product->quantity,
                'tax_exclusive_price' => round(bcdiv($product->product_original_price / 1.15 , 1 , 3) , 2),
                'VAT_percent' => 0.15,
                // 'other_taxes' => [
                //     ['percent_amount' => 1]
                // ],
                'discounts' => ($product->discount_percentage > 0) ? [['amount' => round(bcdiv($product->product_original_price / 1.15 , 1 , 2 ) , 2) - round(bcdiv($product->product_price / 1.15 , 1 ,2) , 2), 'reason' => 'Discount']] : [],
            ];

        } , $products);

        // MAP Charges information to the ZATCA System Data Structure
        array_map(function($charge) use(&$charges){
            if(sizeof($charge) > 0){
                preg_match_all("/\b\w/" , $charge["title"] , $matches);
                $charges[] = [
                    'type' => $charge["type"],
                    'value'=> $charge["value"],
                    'amount' => round(bcdiv($charge["price"] / 1.15 , 1 , 2) , 2),
                    'reason' => $charge["title"],
                    'code' => $charge["code"],
                ];
            }
        } , $order_charges["charges"]);

        // MAP Discount information to the ZATCA System Data Structure
        $discounts = (!is_null($order["coupon_code"]) && trim($order["coupon_code"]) !== "") ? 
        [
            [
                'type' => $order["coupon_type"],
                'value'=> $order["coupon_value"],
                'amount' => round(bcdiv($order["coupon_discount"] / 1.15 , 1 , 2) , 2),
                'reason' => "Coupon Discount",
                'VAT_percent' => 0.15
            ]
        ] : $discounts;

        // MAP invoice information to the ZATCA System Data Structure
        $invoice = [
            'invoice_counter_number' => 1,
            // 'invoice_serial_number' => 'EGS1-886431145-1',
            'invoice_serial_number' => $order["order_id"],
            'issue_date' => date("Y-m-d" , strtotime($order["created_at"])),
            'issue_time' => date("H:i:s" , strtotime($order["created_at"])),
            'previous_invoice_hash' => ($egs->production) ? file_get_content(APPPATH."/Libraries/ZATCA/tmp/LIH.txt") : 'NWZlY2ViNjZmZmM4NmYzOGQ5NTI3ODZjNmQ2OTZjNzljMmRiYzIzOWRkNGU5MWI0NjcyOWQ3M2EyN2ZiNTdlOQ==', // AdditionalDocumentReference/PIH
            'line_items' => $line_items,
            'charges' => $charges,
            'discounts' => $discounts,
        ];
        // var_dump($invoice["discounts"]);die();
        // New Keys & CSR for the EGS
        list($private_key, $csr) = $egs->generateNewKeysAndCSR('solution_name');

        // Issue a new compliance cert for the EGS
        list($request_id, $binary_security_token, $secret) = $egs->issueComplianceCertificate('123345', $csr);

        // Sign invoice
        list($signed_invoice_string, $invoice_hash, $qr) = $egs->signInvoice($invoice, $binary_security_token, $private_key);

        // Check invoice compliance
        var_dump(json_decode($egs->checkInvoiceCompliance($signed_invoice_string, $invoice_hash, $binary_security_token, $secret))->validationResults);
        echo PHP_EOL;
    }

}

?>