<style type="text/css">
  table td{
    border:1px solid #000;
    padding:8px;
  }
</style>
<table border="0" cellpadding="0" cellspacing="0" width="829" style="border:1px solid #000; border-collapse: collapse; width: 621pt;">
  <tbody>
    <tr height="28" style="height: 21pt;">
      <td colspan="4" height="96" class="gmail-xl76" width="79" style="height: 71.55pt; border-top: none; width: 59pt;">
      <img width="200" src="<?=base_url('assets/img/invoice/CD_LOGO1.png');?>"></td>
      <td colspan="9" class="gmail-xl72" width="666" style="border-left: none; width: 498pt;">Chetan
      Dalal Investigation and Management Services Pvt. Ltd.<br />
      308-309, Bombay Market Apartments, Tardeo Road<br />
      Near A.C Market Tardeo, Mumbai, Maharashtra 400034<br />
      <strong>Website :</strong> www.chetandalal.com<br />
      <strong>Tel :</strong> +91 22 2352 6940 / +91 22 2352 2943<br />
      <strong>GSTIN :</strong> 27AACCC0589M1ZB

      </td>
    </tr>

    <tr height="19" style="height: 14.4pt;">
      <td colspan="13"  height="39" class="gmail-xl82" style="height: 29.4pt; text-align: center;font-weight: bold;font-size: 20px;">Receipt
      Voucher</td>
    </tr>
   
     
     <tr height="20" style="height: 15pt;">
      <td colspan="6" height="20" class="gmail-xl67" style="height: 15pt;"><strong>Voucher Number : </strong> <?=@$transaction_id;?></td>
      <td colspan="7" class="gmail-xl84" style="border-left: none;"><strong>Details Of Receiver</strong></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="6" height="19" class="gmail-xl67" style="height: 14.4pt;"><strong>Voucher Date : </strong> <?=@$response['addedon'];?></td>
      <td colspan="7" class="gmail-xl67" style="border-left: none;"><strong>Name : </strong><?=@$billing_name;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="6" height="19" class="gmail-xl68" style="height: 14.4pt;"><strong>Place of Supply : </strong>www.chetandalal.com</td>
      <td colspan="7" rowspan="2" class="gmail-xl68"><strong>Address : </strong><?=$address;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="5" height="19" class="gmail-xl68" style="height: 14.4pt;"><strong>Reverse Charge
      (Y/N) : </strong></td>
      <td class="gmail-xl85" style="border-top: none; border-left: none;"><?php if($reverse_charge==1){echo 'Y';}else{ echo 'N';}?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="6" height="19" class="gmail-xl69" style="height: 14.4pt;">&nbsp;</td>
      <td colspan="7" class="gmail-xl67" style="border-left: none;"><strong>GSTIN : </strong><?=$gstin_no?$gstin_no:'-------' ;?> </td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="4" height="19" class="gmail-xl68" style="height: 14.4pt;"><strong>State : </strong> Maharashtra</td>
      <td class="gmail-xl86" style="border-top: none; border-left: none;"><strong>Code</strong></td>
      <td class="gmail-xl86" style="border-top: none; border-left: none;">&nbsp;</td>
      <td colspan="4" class="gmail-xl68" style="border-left: none;"><strong>State : </strong><?=@$state_name;?></td>
      <td colspan="3" class="gmail-xl84" style="border-left: none;"><strong>Code</strong></td>
     </tr>
     <tr height="14" style="height: 11.1pt;">
      <td colspan="13" height="14" class="gmail-xl83" style="height: 11.1pt;">&nbsp;</td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="3" rowspan="2" height="38" class="gmail-xl87" width="163" style="height: 28.8pt; width: 123pt;">Description of Product/Service</td>
      <td rowspan="2" class="gmail-xl87" width="68" style="border-top: none; width: 51pt;">HSN/SAC
      Codes</td>
      <td rowspan="2" class="gmail-xl87" width="64" style="border-top: none; width: 48pt;">Taxable
      Value</td>
      <td colspan="2" class="gmail-xl88" style="border-left: none;">CGST</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">SGST</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">&nbsp;</td>
      <td colspan="2" class="gmail-xl88" style="border-left: none;">IGST</td>
      <td colspan="2" rowspan="2" class="gmail-xl87" width="128" style="width: 96pt;">Total Advance
      Received</td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td height="19" class="gmail-xl89" style="height: 14.4pt; border-top: none; border-left: none;">Rate</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">Amount</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">Rate</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">Amount</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">Rate</td>
      <td class="gmail-xl89" style="border-top: none; border-left: none;">Amount</td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="3" height="19" class="gmail-xl83" style="height: 14.4pt;"><?=$response['productinfo'];?></td>
      <td class="gmail-xl66" style="border-top: none; border-left: none;">999293/999294</td>
      <td class="gmail-xl65" style="border-top: none; border-left: none;"><?=@$base_value;?></td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;">0.09</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><?=@$cgst;?></td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;">0.09</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><?=@$sgst;?></td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;">0.18</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><?=@$igst;?></td>
      <td colspan="2" class="gmail-xl83" style="border-left: none;"><?=@$total;?></td>
     </tr>     
     <tr height="19" style="height: 14.4pt;">
      <td colspan="4" height="19" class="gmail-xl90" style="height: 14.4pt;"><strong>Total</strong></td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><strong><?=@$base_value;?></strong></td>
      <td class="gmail-xl65" style="border-top: none; border-left: none;">&nbsp;</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><strong><?=@$cgst;?></strong></td>
      <td class="gmail-xl65" style="border-top: none; border-left: none;">&nbsp;</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><strong><?=@$sgst;?></strong></td>
      <td class="gmail-xl65" style="border-top: none; border-left: none;">&nbsp;</td>
      <td class="gmail-xl65" align="right" style="border-top: none; border-left: none;"><strong><?=@$igst;?></strong></td>
      <td colspan="2" class="gmail-xl83" style="border-left: none;"><strong><?=@$total;?></strong></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="13" rowspan="3" height="57" class="gmail-xl91" style="height: 43.2pt;">Total
      Advance Received (In words) : <strong><?=@$in_words;?></strong></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
     </tr>
     <tr height="19" style="height: 14.4pt;">
     </tr>
     <tr height="14" style="height: 11.1pt;">
      <td colspan="13" height="14" class="gmail-xl83" style="height: 11.1pt;">&nbsp;</td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="6" height="19" class="gmail-xl92" style="height: 14.4pt;">Ceritified that the
      particuler given above are ture and correct</td>
      
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Total Amount before tax</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$base_value;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="6" height="19" class="gmail-xl94" style="height: 14.4pt;text-align: center;">For CDIMS Pvt. Ltd.</td>      
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Add: CGST</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$cgst;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td rowspan="4" colspan="4" height="96" class="gmail-xl76" width="79" style="height: 71.55pt; border-top: none; width: 59pt;">  <img height="96" src="<?=base_url('assets/img/invoice/signatureCD.jpg');?>"></td>
      <td rowspan="4" colspan="2" height="96" class="gmail-xl76" width="79" style="height: 71.55pt; border-top: none; width: 59pt;">  <img height="96" src="<?=base_url('assets/img/invoice/seal.jpg');?>"></td>
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Add: SGST</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$sgst;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">      
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Add: IGST</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$igst;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Total Tax Amount (GST)</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$igst;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      
      <td colspan="6" class="gmail-xl94" style="border-left: none;">Total Amount After Tax</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;"><?=@$total;?></td>
     </tr>
     <tr height="19" style="height: 14.4pt;">
      <td colspan="4" height="19" class="gmail-xl94" style="height: 14.4pt;">Authorised Signatory</td>
      <td colspan="2" class="gmail-xl94" style="border-left: none;">Common Seal</td>
      <td colspan="6" class="gmail-xl88" style="border-left: none;">GST on Reverse Charge</td>
      <td class="gmail-xl83" style="border-top: none; border-left: none;">0</td>
     </tr>
  </tbody>
</table>