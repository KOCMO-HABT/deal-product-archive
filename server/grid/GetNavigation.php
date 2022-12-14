<?

use Bitrix\Main\UI\PageNavigation;

/*
 * задаём параметры навигации для таблицы 
 */

function GetNavigation($grid_id, $total, $nPageSize, $iNumPage)
{

    // создаем объект навигации
    $nav = new PageNavigation($grid_id);
    // отключаем кнопку все записи
    $nav->allowAllRecords(false);
    // устанавливаем размер страницы
    $nav->setPageSize($nPageSize);
    // ->initFromUri();
    // указываем гриду сколько всего записей у него есть
    $nav->setRecordCount($total);
    // передаём номер страницы
    $nav->setCurrentPage($iNumPage);

    return $nav;
}
