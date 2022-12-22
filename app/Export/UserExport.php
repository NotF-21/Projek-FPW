<?php
    namespace App\Exports;

    use App\Invoice;
    use Maatwebsite\Excel\Concerns\FromCollection;

    class DummyExport implements FromCollection
    {
        public function __construct(){

        }
    }
