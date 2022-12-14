<?
require_once(__DIR__ . "/FilterByAssigned.php");

\Bitrix\Main\Loader::includeModule('crm');


function GetList($paramsFilter)
{

    $productID = [];

    $arSelect = ['ID'];
    $arFilter = [
        'IBLOCK_ID' => 27,
        'IBLOCK_TYPE' => 'CRM_PRODUCT_CATALOG',
        'SECTION_ID' => 260,
    ];

    // получаем товары из раздела "АРХИВ" 
    $Element = \CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
    while ($ob = $Element->GetNextElement()) {
        $arFields = $ob->GetFields();
        // $arProps = $ob->GetProperties();

        $productID[] = $arFields['ID'];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    $arFilter = [
        'OWNER_TYPE' => \CCrmOwnerTypeAbbr::Deal,
        'PRODUCT_ID' => $productID,
        'DEAL.STAGE_SEMANTIC_ID' => 'P',
    ];

    // фильтрация по направлениям сделок
    isset($paramsFilter['CATEGORY']) ? $arFilter['DEAL.CATEGORY_ID'] = $paramsFilter['CATEGORY'] : null;

    // дополняем фильтр по ответственным
    if ($paramsFilter['ASSIGNED_BY_ID']) FilterByAssigned($arFilter, $paramsFilter);

    // ?<--------------------------------------------------------------------------------------------------------------->

    $deal = [];

    $query = \Bitrix\Crm\ProductRowTable::GetList([
        'order' => ['OWNER_ID' => 'DESC'],
        'select' => ['OWNER_ID', 'DEAL_TITLE' => 'DEAL.TITLE', 'DEAL_ASSIGNED_BY_ID' => 'DEAL.ASSIGNED_BY_ID'],
        'filter' => $arFilter,
        'runtime' => [
            new \Bitrix\Main\Entity\ReferenceField(
                'DEAL',
                '\Bitrix\Crm\DealTable',
                ['=this.OWNER_ID' => 'ref.ID',]
            ),
        ]
    ]);

    // получаем сделки с у которых присутствуют товары из архива
    while ($arFields = $query->Fetch()) {
        $deal[$arFields['OWNER_ID']] = [
            'ID' => $arFields['OWNER_ID'],
            'TITLE' => $arFields['DEAL_TITLE'],
        ];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    $deal = array_values($deal);

    return $deal;
}
