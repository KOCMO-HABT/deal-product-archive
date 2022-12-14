<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Сделки с товарами из Архива");

require_once(__DIR__ . "/server/filter/Filter.php");
require_once(__DIR__ . "/server/grid/Grid.php");

// ?<--------------------------------------------------------------------------------------------------------------->

$grid_id = $filter_id = 'DealProductArchive';

?>

<div>
    <?
    // компонент фильтра
    Filter($filter_id, $grid_id);
    ?>
</div>

<div>
    <?
    // компонент таблицы
    Grid($grid_id, $filter_id);
    ?>
</div>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>