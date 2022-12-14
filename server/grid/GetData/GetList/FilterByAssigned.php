<?

function FilterByAssigned(&$arFilter, $paramsFilter)
{

    $arrUser = [];

    // распределяем id пользователей и отделов по массивам
    foreach ($paramsFilter['ASSIGNED_BY_ID'] as $key => $value) {
        $value = json_decode($value, true);

        if ($value[0] === 'user') $arrUser[] = $value[1];
        if ($value[0] === 'fired-user') $arrUser[] = $value[1];
    }

    // ?<--------------------------------------------------------------------------------------------------------------->

    $arFilter['DEAL.ASSIGNED_BY_ID'] = $arrUser;
}
