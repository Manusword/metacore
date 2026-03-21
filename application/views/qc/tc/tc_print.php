<link href="<?php echo base_url();?>dist-assets/css/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
   if(isset($res2[0]['invoice_date'])){$invoice_date=$this->Base->change_date_dmy($res2[0]['invoice_date']);}else{$invoice_date='';}
   
?>  
<div class="col-md-12" style="height:300px; width:100%"> </div>

   
<div class="col-md-12" style="margin-left:10%">       
       
                    
            <table cellspacing="0" border="0">
                <colgroup width="88"></colgroup>
                <colgroup span="7" width="77"></colgroup>
                <colgroup width="92"></colgroup>
                <colgroup width="77"></colgroup>
                <tr>
                    <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=10 height="76" align="center" valign=middle><b><font face="Times New Roman" size=4 color="#000000">MATERIAL TEST CERTIFICATE</font></b></td>
                    </tr>
                <tr>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 height="21" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Governing Specification - As per JIS G-3506/  IS 4454 (Part -1):2001</font></b></td>
                    </tr>
                <tr>
                    <td style="border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=10 height="18" align="center" valign=middle><b><font face="Times New Roman" size=4 color="#000000"><br></font></b></td>
                </tr>
                <tr>
                <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Party Name</font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td colspan='3' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['cname']))echo $res2[0]['cname'];?></font></b></td>
                    <td colspan='2' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Date- </font></b></td>
                    <td colspan='2' align="left" valign=middle sdnum="1033;1033;M/D/YYYY"><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($entry_date))echo $entry_date;?></font></b></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>

                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Invoice no.</font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td colspan='3' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['invoice_no']))echo $res2[0]['invoice_no'];?></font></b></td>
                    <td colspan='2' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Certificate No.- </font></b></td>
                    <td colspan='2' align="left" valign=middle sdnum="1033;1033;M/D/YYYY"><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['certificate_no']))echo $res2[0]['certificate_no'];?></font></b></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>

                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">No. of Coils/spools-</font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td colspan='3' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['no_coil']))echo $res2[0]['no_coil'];?></font></b></td>
                    <td colspan='2' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Product- </font></b></td>
                    <td colspan='2' align="left" valign=middle sdnum="1033;1033;M/D/YYYY"><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['product_name']))echo $res2[0]['product_name'];?></font></b></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>

                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Invoice Dt-</font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td colspan='3' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($invoice_date))echo $invoice_date;?></font></b></td>
                    <td colspan='2' align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Size(mm)- </font></b></td>
                    <td colspan='2' align="left" valign=middle sdnum="1033;1033;M/D/YYYY"><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['size']))echo $res2[0]['size'];?></font></b></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>



              
                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Weight(kg) - </font></b></td>
                    <td align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td align="left" valign=middle sdval="5006" sdnum="1033;"><b><font face="Times New Roman" size=3 color="#000000"><?php if(isset($res2[0]['weight']))echo $res2[0]['weight'];?></font></b></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=10 height="21" align="center" valign=middle><b><u><font face="Times New Roman" size=3 color="#000000">CHEMICAL COMPOSITION</font></u></b></td>
                    </tr>
                <tr>
                    <td style="border-left: 2px solid #000000" height="22" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                </tr>
                <tr height="40">
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 height="22" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Elements</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><br></font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">C%</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0%"><b><font face="Times New Roman" size=3 color="#000000">Mn%</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0%"><b><font face="Times New Roman" size=3 color="#000000">Si%</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0%"><b><font face="Times New Roman" size=3 color="#000000">P%</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdnum="1033;0;0%"><b><font face="Times New Roman" size=3 color="#000000">S%</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=middle sdnum="1033;0;0%"><font face="Times New Roman" size=3 color="#000000">Heat. No.</font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>


                                                                                                                                                                         

                <tr height="40">
                    <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 height="20" align="center" valign=middle><b><font face="Times New Roman" color="#000000">Grade-</font></b></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign=middle><font face="Times New Roman" color="#000000">Min</font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.45" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['c_min']) and $res2[0]['c_min'] != 0.000 )echo $res2[0]['c_min'];?></font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.3" sdnum="1033;0;0.00"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['mn_min']) and $res2[0]['mn_min'] != 0.000)echo $res2[0]['mn_min'];?></font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.15" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['si_min']) and $res2[0]['c_min'] != 0.000)echo $res2[0]['si_min'];?></font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['p_min']) and $res2[0]['p_min'] != 0.000)echo $res2[0]['p_min'];?></font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['s_min']) and $res2[0]['s_min'] != 0.000)echo $res2[0]['s_min'];?></font></td>
                    <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom sdnum="1033;0;0.00"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['heatno_1']))echo $res2[0]['heatno_1'];?></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr height="40">
                    <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 height="21" align="center" valign=middle><b><font face="Times New Roman" color="#000000"><br></font></b></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign=middle><font face="Times New Roman" color="#000000">Max</font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="1" sdnum="1033;0;0.00"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['c_max']) and $res2[0]['c_max'] != 0.000)echo $res2[0]['c_max'];?></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="1.5" sdnum="1033;0;0.00"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['mn_max']) and $res2[0]['mn_max'] != 0.000)echo $res2[0]['mn_max'];?></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.35" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['si_max']) and $res2[0]['si_max'] != 0.000)echo $res2[0]['si_max'];?></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.03" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['p_max']) and $res2[0]['p_max'] != 0.000)echo $res2[0]['p_max'];?></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.03" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['s_max']) and $res2[0]['s_max'] != 0.000)echo $res2[0]['s_max'];?></font></td>
                    <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['heatno_2']))echo $res2[0]['heatno_2'];?></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr height="40">
                    <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=2 height="21" align="center" valign=middle><b><font face="Times New Roman" color="#000000">Observed value &gt;&gt;&gt;</font></b></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000" align="center" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.72" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['c_obs']))echo $res2[0]['c_obs'];?></font></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.65" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['mn_obs']))echo $res2[0]['mn_obs'];?></font></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.2" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['si_obs']))echo $res2[0]['si_obs'];?></font></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.014" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['p_obs']))echo $res2[0]['p_obs'];?></font></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="0.01" sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['s_obs']))echo $res2[0]['s_obs'];?></font></td>
                    <td style="border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=bottom sdnum="1033;0;0.000"><font face="Times New Roman" color="#000000"><?php if(isset($res2[0]['heatno_3']))echo $res2[0]['heatno_3'];?></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>

















                <tr>
                    <td style="border-left: 2px solid #000000" height="19" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-left: 2px solid #000000; border-right: 2px solid #000000" colspan=10 height="25" align="center" valign=middle><b><u><font face="Times New Roman" size=4 color="#000000">PHYSICAL &amp; MECHANICAL PROPERTIES</font></u></b></td>
                    </tr>
                <tr>
                    <td style="border-bottom: 2px solid #000000; border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="center" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-bottom: 2px solid #000000; border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" height="68" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Specs.</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Coil No.</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Diameter     (mm)</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">U.T.S (KG/mm2)</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Torsion (Turns)</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">%R.A.</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000"> Zinc Coating  (gm/m2 )  </font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Bend Test</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Surface</font></b></td>
                    <td style="border-top: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Remarks</font></b></td>
                </tr>

                <?php
                    if(!empty($res3))
                    {
                        $j=1;
                        foreach($res3 as $s)
                        {
                        ?>
                            <tr height="30"> 
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><?php if($j == 3){echo "Result";}?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Times New Roman" size=3 color="#000000"><?php echo $s['coilno'];?></font></b></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="4.73" sdnum="1033;0;0.000"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['diameter'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="148" sdnum="1033;0;0.00"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['uts'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;0.0"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['torsiontest'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdval="35" sdnum="1033;0;0.0"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['raper'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;0.0"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['zinc'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=bottom sdnum="1033;0;0.0"><font face="Times New Roman" size=3 color="#000000"><?php echo $s['bend'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><?php echo $s['surface'];?></font></td>
                                <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><?php echo $s['remarks'];?></font></td>
                            </tr>
                            
                            <?php
                            $j++;
                        }//foreach
                    }//if
                ?>
                
                


                
                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                </tr>
                






                <tr>
                    <td colspan='7' style="border-left: 2px solid #000000" height="21" align="left" valign=middle><b><font face="Times New Roman" size=3 color="#000000">Certified that the material conforms to order</font></b></td>
                   <td style="border-right: 2px solid #000000" colspan=3 align="left" valign=middle><b><font face="Times New Roman" color="#000000">For RKS Steel Industries Pvt. Ltd.</font></b></td>
                </tr>
                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-left: 2px solid #000000" height="21" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="center" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                    <td colspan=2 align="center" valign=middle><font face="Times New Roman" size=3 color="#000000">Authorised Signatory</font></td>
                    <td style="border-right: 2px solid #000000" align="left" valign=middle><font face="Times New Roman" color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=10 height="21" align="left" valign=middle><font face="Times New Roman" size=3 color="#000000">F12(BP/QA/02), REV. NO. / DATE : 00 / 01.01.2020</font></td>
                    </tr>
            </table>





</div>
