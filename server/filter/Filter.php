<?

require_once(__DIR__ . "/GetCategories.php");


function Filter($filter_id, $grid_id)
{

    global $APPLICATION;

    $APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
        'FILTER_ID' => $filter_id,
        'GRID_ID' => $grid_id,
        'FILTER' => [
            [
                'id' => 'CATEGORY', 'name' => 'Направления сделок', 'type' => 'list', 'items' => GetCategories(),
                'default' => true, 'params' => ['multiple' => 'Y']
            ],
            [
                'id' => 'ASSIGNED_BY_ID', 'name' => 'Ответственный', 'type' => 'entity_selector', 'default' => true,
                'params' => [
                    'multiple' => 'Y',
                    'addEntityIdToResult' => 'Y',
                    'dialogOptions' => [
                        'height' => 200,
                        'context' => 'DATA_CONTROL_REPORT_ASSIGNED_BY_ID',
                        'dropdownMode' => false,
                        'showAvatars' => true,
                        'entities' => [
                            ['id' => 'user', 'options' => ['intranetUsersOnly' => true, 'inviteEmployeeLink' => false]],
                            ['id' => 'fired-user', 'options' => ['intranetUsersOnly' => true, 'inviteEmployeeLink' => false, 'fieldName' => 'ASSIGNED_BY_ID']],
                        ]
                    ]
                ],
            ],
        ],
        'ENABLE_LIVE_SEARCH' => true,
        'ENABLE_LABEL' => true
    ]);
}
