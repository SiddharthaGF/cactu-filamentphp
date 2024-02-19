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
            'Content-Disposition' =>  "inline; filename=$child->dni.pdf",
        ]);
        return $pdf->stream('sheet.pdf');
    }
}
