<?php
if(!function_exists('get_formatted_nrc_suits')) {
    //  [
    //      "id"=>"64",
    //      "name_en"=>"KhaOuTa",
    //      "name_mm"=>"(ခဥတ) ခင်ဦး",
    //      "nrc_code"=>"5",
    //      "created_at"=>"2019-01-31 20=>03=>05",
    //      "updated_at"=>"2019-01-31 20=>03=>24"
    //   ]
    function get_formatted_nrc_suits($nrc_formats) {
        $formatted_suits = [
            "districts" => [],
        ];
        foreach ($nrc_formats as $format) {
            $formatted_suits['districts'][] = [
                'id' => $format['id'],
                'name_en' => $format['name_en'],
                'name_mm' => $format['name_mm'],
                'nrc_code' => $format['nrc_code'],
            ];
        }
        return $formatted_suits;
    }
}