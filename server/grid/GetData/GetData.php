<?

require_once(__DIR__ . "/../GetNavigation.php");
require_once(__DIR__ . "/GetList/GetList.php");

use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\Ui\Filter\Options as FilterOptions;



/*
 * получаем список лидов для вывода  таблицу 
 */

function GetData($grid_id, $filter_id)
{

    $list = [];

    // получаем настройки фильтра
    $filter_options = new FilterOptions($filter_id);
    $paramsFilter = $filter_options->getFilter();

    // ?<--------------------------------------------------------------------------------------------------------------->

    // задаём количество выводимых элементов для грида по умолчанию 20
    $nPageSize = 20;
    // создаём объект с настройками для грида
    $grid_options = new GridOptions($grid_id);
    // получаем количество выводимых элементов для грида
    $nPageSize = $grid_options->GetNavParams()['nPageSize'];

    // ?<--------------------------------------------------------------------------------------------------------------->

    // получаем номер страницы
    $iNumPage = isset($_GET[$grid_id]) ? explode('-', $_GET[$grid_id])[1] : 1;

    $data = GetList($paramsFilter);

    $total = count($data);

    $data = array_chunk($data, $nPageSize);

    foreach ($data[$iNumPage - 1] as $key => $value) {
        $list[] = [
            'id' => $value['ID'],
            'data' => $value,
            'columns' => [
                'TITLE' => '<a href="/crm/deal/details/' . $value['ID'] . '/">' . $value['TITLE'] . '</a>',
            ]
        ];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    $nav = GetNavigation($grid_id, $total, $nPageSize, $iNumPage);

    return [$list, $total, $nav];
}
