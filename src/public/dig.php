<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// Load dependencies
require_once(__DIR__ . '/../../vendor/autoload.php');

// Valid name required to continue
if (empty($_GET['name']) || !is_string($_GET['name']) || !\Yggverse\Net\Dig::isHostName($_GET['name']))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => _('valid name required')
            ]
        )
    );
}

// Valid records required to continue
$records = [];

if (isset($_GET['record']) && is_string($_GET['record']) && \Yggverse\Net\Dig::isRecord($_GET['record']))
{
    $records[] = $_GET['record'];
}

if (isset($_GET['records']) && is_array($_GET['records']))
{
    foreach ($_GET['records'] as $record)
    {
        if (is_string($record) && \Yggverse\Net\Dig::isRecord($record))
        {
            $records[] = $record;
        }
    }
}

// At least one record required
if (empty($records))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => sprintf(
                    _('valid record(s) required: %s'),
                    implode(
                        ',',
                        array_unique(
                            $records
                        )
                    )
                )
            ]
        )
    );
}

// Resolve begin
if (!$result = \Yggverse\Net\Dig::records($_GET['name'], array_unique($records)))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => sprintf(
                    _('%s records for %s not found'),
                    implode(
                        ',',
                        array_unique(
                            $records
                        )
                    ),
                    $_GET['name']
                )
            ]
        )
    );
}

// Done
exit(
    json_encode(
        [
            'success' => true,
            'records' => $result
        ]
    )
);
