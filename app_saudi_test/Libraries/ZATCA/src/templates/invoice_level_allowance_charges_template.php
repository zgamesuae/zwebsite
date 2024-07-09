<?php
$allowance_section = <<<XML
    <cac:AllowanceCharge>__Allowance_Detail
        <cac:TaxCategory>
            <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5305">S</cbc:ID>
            <cbc:Percent>15</cbc:Percent>
            <cac:TaxScheme>
                <cbc:ID schemeAgencyID="6" schemeID="UN/ECE 5153">VAT</cbc:ID>
            </cac:TaxScheme>
        </cac:TaxCategory>
    </cac:AllowanceCharge>
    
XML;

$allowance_details_charge = <<<XML

        <cbc:ID>__Allowance_Number</cbc:ID>
        <cbc:ChargeIndicator>__Allowance_indicator</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReasonCode>__Allowance_Reason_Code</cbc:AllowanceChargeReasonCode>
        <cbc:AllowanceChargeReason>___AllowanceChargeReason</cbc:AllowanceChargeReason>
        <cbc:Amount currencyID="SAR">__Charge_Amount</cbc:Amount>
XML;

$allowance_details_discount = <<<XML

        <cbc:ID>__Allowance_Number</cbc:ID>
        <cbc:ChargeIndicator>__Allowance_indicator</cbc:ChargeIndicator>
        <cbc:AllowanceChargeReason>___AllowanceChargeReason</cbc:AllowanceChargeReason>
        <cbc:Amount currencyID="SAR">__Charge_Amount</cbc:Amount>
XML;

return [
    'allowance_section' => $allowance_section,
    'allowance_details_charge' => $allowance_details_charge,
    'allowance_details_discount' => $allowance_details_discount
];