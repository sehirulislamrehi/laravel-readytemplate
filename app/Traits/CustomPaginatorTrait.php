<?php
namespace App\Traits;
trait CustomPaginatorTrait{
        /**
     * Generate Pagination number sequence
     *
     * @param integer $numberOfPages
     * @param integer $currentPage
     * @return array
     */
    public function customPaginator(int $numberOfPages, int $currentPage): array
    {
        $startpage = 1;
        $prev = 0;
        $next = 0;
        $lastpage = $numberOfPages;
        $pageNumbers = [];
        if ($numberOfPages==1) {
            array_push($pageNumbers, 1);
        } elseif ($numberOfPages >= $currentPage) {
            array_push($pageNumbers, $startpage);
            $prev = $currentPage - 1;
            if ($prev > $startpage) {
                array_push($pageNumbers, $prev);
            }
            if ($currentPage > $startpage && $currentPage < $lastpage) {
                array_push($pageNumbers, $currentPage);
            }
            $next = $currentPage + 1;
            if ($next < $numberOfPages) {
                array_push($pageNumbers, $next);
            }
            array_push($pageNumbers, $lastpage);
        }
        return $pageNumbers;
    }
}