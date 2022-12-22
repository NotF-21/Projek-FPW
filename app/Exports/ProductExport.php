<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromCollection, ShouldAutoSize, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $collection;
    private $numAll = 5;
    private $numNot = 0;

    public function __construct($arrays)
    {
        $output = [];
        $i = 0;

        foreach($arrays as $arr) {
            $output[] = ["Product Name", "Product Description", "Product Price", "Product Stock"];
            foreach($arr as $row) {
                $output[] = [
                    $row->product_name,
                    $row->product_desc,
                    $row->product_price,
                    $row->product_stock,
                ];
                if ($i==0) {
                    $this->numAll++;
                }
                if ($i==1) {
                    $this->numNot++;
                }
            }
            $output[]= [''];
            if ($i==0) {
                $output[] = ['Products in danger of running out :'];
                $i++;
            }
        }
        $this->numNot+=$this->numAll;
        $this->numNot--;
        $this->collection = collect($output);
    }

    public function collection()
    {
        //
        return $this->collection;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $x = $this->numAll-4;
                $event->sheet->getDelegate()->getStyle('A'.$this->numAll.':D'.$this->numNot)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                $event->sheet->getDelegate()->getStyle('A'.$this->numAll.':D'.$this->numNot)->getFont()->getColor()->setRGB('FFFFFF');
                $event->sheet->getStyle('A1'.':D'.$x)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A'.($this->numAll-1).':D'.$this->numNot)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
