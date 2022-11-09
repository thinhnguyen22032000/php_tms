<?php  
class Pagination{
    static function pagination($page, $total_item, $itemOfPage){     
        $countPage = ceil($total_item/$itemOfPage);
        if($page > $countPage || !is_numeric($page) || $page <= 0){
            $page = 1;
        }
        $idxStart = ($page - 1)*$itemOfPage; 
        return [
             'countPage' => $countPage,
             'idxStart' => $idxStart 
        ];
    }  
}
?>