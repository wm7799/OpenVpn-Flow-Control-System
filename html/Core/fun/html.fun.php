<?php
function create_page_html($numrows = 0, $offsetPage = 1, $pageSize = 30, $link = "")
{
    $pages = intval($numrows / $pageSize);
    if ($numrows % $pageSize) {
        $pages++;
    }

    $page_limit = 15;
    $page = intval($offsetPage) == "" ? 1 : $offsetPage;


    $rem = $page % $page_limit;
    $page_len = $rem;
    $page_start = $page - $rem + 1;
    if ($page >= 15) {
        $page_start--;
    }
    $for_len = $pages - $page_start > 15 ? 15 : $pages - $page_start + 1;

    $html .= '<div class="d-flex justify-content-end pt-30">
                                    <nav class="atbd-page ">
                                        <ul class="atbd-pagination d-flex"><li class="atbd-pagination__item">';
    $first = 1;
    $prev = $page - 1;
    $next = $page + 1;
    $last = $pages;
    if ($page > 1) {
        $html .= '<a href="?page=' . $first . $link . '" class="atbd-pagination__link"><span
                                                            class="page-number">首页</span></a>';
        $html .= '<a href="?page=' . $prev . $link . '" class="atbd-pagination__link pagination-control"><span
                                                            class="la la-angle-left"></span></a>';
    } else {
        $html .= '<a href="#" class="atbd-pagination__link pagination-control"><span
                                                            class="la la-angle-left"></span></a>';
    }
    for ($i = $page_start; $i < $page_start + $for_len; $i++) {
        if ($page != $i) {
            $html .= '<a href="?page=' . $i . $link . '" class="atbd-pagination__link"><span
                                                            class="page-number">' . $i . '</span></a>';
        } else {
            $html .= '<a href="#" class="atbd-pagination__link active"><span
                                                            class="page-number">' . $page . '</span></a>';
        }
    }

    if ($page < $pages) {
        $html .= '<a href="?page=' . $next . $link . '" class="atbd-pagination__link pagination-control"><span
                                                            class="la la-angle-right"></span></a>';
        $html .= '<a href="?page=' . $last . $link . '" class="atbd-pagination__link"><span
                                                            class="page-number">尾页</span></a>';
    } else {
        $html .= '<a href="#" class="atbd-pagination__link pagination-control"><span
                                                            class="la la-angle-right"></span></a>';
    }
    //<li class="atbd-pagination__item">
    //                                                <div class="paging-option">
    //                                                    <select name="page-number" class="page-selection">
    //                                                        <option value="20">20/page</option>
    //                                                        <option value="40">40/page</option>
    //                                                        <option value="60">60/page</option>
    //                                                    </select>
    //                                                </div>
    //                                            </li>
    $html .= '</li></ul>';

    return $html;
}