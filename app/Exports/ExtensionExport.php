<?php

namespace App\Exports;

use App\CountryExtension;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExtensionExport implements FromView {

    public function view(): View {
        return view('exports.SampleExtension');
    }

}
