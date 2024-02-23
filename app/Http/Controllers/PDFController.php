<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Response;
use Pdf;

class PDFController extends Controller
{


    public function sheet(Child $child)
    {
        $pdf = Pdf::loadView('pdf.sheet', compact('child'))->setOption(['isRemoteEnabled' => true]);
        $output = $pdf->output();
        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
<<<<<<< HEAD
            'Content-Disposition' => "inline; filename=$child->dni.pdf",
=======
            'Content-Disposition' =>  "inline; filename=$child->dni.pdf",
>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
        ]);
        return $pdf->stream('sheet.pdf');
    }
}
