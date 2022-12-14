<?

/*
 * получаем категории сделок
 */
function GetCategories()
{
    $res = [
        '0' => 'Общее'
    ];

    $query = \Bitrix\Crm\Category\Entity\DealCategoryTable::GetList([
        'select' => ['ID', 'NAME'],
    ]);

    while ($arFields = $query->Fetch()) {
        $res[$arFields['ID']]  = $arFields['NAME'];
    }

    return $res;
}
