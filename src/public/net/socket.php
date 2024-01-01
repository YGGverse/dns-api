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
foreach ($config->net->socket->response->headers as $key => $value)
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

// Valid port required to continue
if (empty($_GET['port']) || !\Yggverse\Net\Socket::isPort($_GET['port']))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => _('valid port required')
            ]
        )
    );
}

if (!isRegex($config->net->socket->request->port->regex, $_GET['port']))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => _('port not supported')
            ]
        )
    );
}

// Set client address if optional host not provided
if (empty($_GET['host']))
{
    // Valid REMOTE_ADDR required to continue
    if (empty($_SERVER['REMOTE_ADDR']) || !\Yggverse\Net\Socket::isHost($_SERVER['REMOTE_ADDR']))
    {
        exit(
            json_encode(
                [
                    'success' => false,
                    'message' => _('could not detect valid REMOTE_ADDR')
                ]
            )
        );
    }

    else
    {
        $host = $_SERVER['REMOTE_ADDR'];
    }
}

else
{
    // Valid host required to continue
    if (isset($_GET['host']) && !\Yggverse\Net\Socket::isHost($_GET['host']))
    {
        exit(
            json_encode(
                [
                    'success' => false,
                    'message' => _('valid host required')
                ]
            )
        );
    }

    else
    {
        $host = $_GET['host'];
    }
}

if (!isRegex($config->net->socket->request->host->regex, $host))
{
    exit(
        json_encode(
            [
                'success' => false,
                'message' => _('host not supported')
            ]
        )
    );
}

// Connection test
exit(
    json_encode(
        [
            'success' => \Yggverse\Net\Socket::isOpen($host, $_GET['port'], 3)
        ]
    )
);
