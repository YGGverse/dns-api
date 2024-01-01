<?php

// Init config
$config = json_decode(
    file_get_contents(
        __DIR__ . '/../../../config.json'
    )
);

// Init helpers
function isRegex(array $regex, string $value): bool
{
    foreach ($regex as $regex)
    {
        if (preg_match($regex, $value))
        {
            return true;
        }
    }

    return false;
}

// Set headers
foreach ($config->net->dig->response->headers as $key => $value)
{
    header(
        sprintf(
            '%s: %s',
            $key,
            $value
        )
    );
}

header('Content-Type: application/json; charset=utf-8');

// Load dependencies
require_once(__DIR__ . '/../../../vendor/autoload.php');

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

if (!isRegex($config->net->dig->request->name->regex, $_GET['name']))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => _('name not supported')
            ]
        )
    );
}

// Valid records required to continue
$records = [];

if (isset($_GET['record']) && is_string($_GET['record']) && \Yggverse\Net\Dig::isRecord($_GET['record']))
{
    if (!isRegex($config->net->dig->request->record->regex, $_GET['record']))
    {
        exit(
            json_encode(
                [
                    'success' => false,
                    'message' => sprintf(
                        _('record "%s" not supported'),
                        $_GET['record']
                    )
                ]
            )
        );
    }

    $records[] = $_GET['record'];
}

if (isset($_GET['records']) && is_array($_GET['records']))
{
    foreach ($_GET['records'] as $record)
    {
        if (is_string($record) && \Yggverse\Net\Dig::isRecord($record))
        {
            if (!isRegex($config->net->dig->request->records->regex, $record))
            {
                exit(
                    json_encode(
                        [
                            'success' => false,
                            'message' => sprintf(
                                _('record "%s" not supported'),
                                $record
                            )
                        ]
                    )
                );
            }

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
