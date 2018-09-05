<?php

namespace Tilume\PDF;

use Tilume\PDF\Concerns\FromView;

use Dompdf\Dompdf;

class Writer
{
    public function __construct()
    {
    }
    /**
     * @param object $export
     */

    public function export($export)
    {

        if ($export instanceof FromView) {
            return $this->fromView($export);
        } else {
            if ($export instanceof FromQuery) {
                return $this->fromQuery($export);
            }

            if ($export instanceof FromCollection) {
                return $this->fromCollection($export);
            }
        }
    }

    /**
     * @param FromQuery $export
     */
    // public function fromQuery(FromQuery $export)
    // {
    // }

    /**
     * @param FromCollection $export
     */
    // public function fromCollection(FromCollection $export)
    // {
    // }

    /**
     * @param FromView $export
     */
    public function fromView(FromView $export)
    {
        $pdf = new Dompdf();

        $pdf->loadHtml($export->view()->render());

        return $pdf;
    }
}
