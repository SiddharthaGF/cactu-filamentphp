<?php

namespace App\Http\Controllers;

use App\Models\Answer;
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
            'Content-Disposition' => "inline; filename=$child->dni.pdf",
        ]);

        return $pdf->stream('sheet.pdf');
    }

    public function letter1(Answer $answer)
    {
        $today = date('d/m');
        if (($today > '22/12') && ($today < '07/01')) {
            $pdf = Pdf::loadView('pdf.letter_1', compact('answer'))
                ->setOption(['isRemoteEnabled' => true]);
        } else {
            $pdf = Pdf::loadView('pdf.letter_2', compact('answer'))
                ->setOption(['isRemoteEnabled' => true]);
        }
        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename='.$answer->mail->mailbox->child->dni.'-'.$answer->id.'.pdf',
        ]);

        return $pdf->stream('leter1.pdf');
    }
}
