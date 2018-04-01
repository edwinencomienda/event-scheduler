<?php 

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    private $collecion;
    
    public function __construct($collecion) {
        $this->collection = $collecion;
    }

    public function collection()
    {
        return $this->collection;
    }
}