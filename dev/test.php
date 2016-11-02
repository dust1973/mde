<?php

         require_once 'models/eanscanner.inc.php';
        $antrag = new Fingerscanner;
		$key = '48F61EEE-653B-E111-97E8-003048C4819C';
		$key= '7637DB75-C3E4-E311-87E7-003048C47FDC';
		$GutscheinaktionIdentifikation = 'D735B632-B38C-E311-AAF1-003048CEE820';
		$test = new Fingerscanner;
		$test->uid = 3;
		$email = $antrag->GetFilialen($test);
		print '<pre>';
		print_r ($email);
		print '</pre>';

?>