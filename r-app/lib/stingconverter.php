<?php
class StingConverter {
    public function Rus2Translite($st){
        $st2=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_","abvgdeeziyklmnoprstufh'iei");
        $st3=strtr($st2,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_","ABVGDEEZIYKLMNOPRSTUFH'IEI");
        $st4=strtr($st3, 
                    array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", 
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
                        )
             );
        return $st4;
    }
}
?>