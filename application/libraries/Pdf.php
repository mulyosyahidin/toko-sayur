<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Pdf
{
	function createPDF($html, $filename = '', $download = TRUE, $paper = 'A4', $orientation = 'portrait')
	{
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation);
		$dompdf->render();
		if ($download)
			$dompdf->stream($filename . '.pdf', array('Attachment' => 1));
		else
			$dompdf->stream($filename . '.pdf', array('Attachment' => 0));
	}
}
