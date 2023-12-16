<?php

// Set headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

// Load dependencies
require_once(__DIR__ . '/../../vendor/autoload.php');

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

// Connection test
exit(
    json_encode(
        [
            'success' => \Yggverse\Net\Socket::isOpen($host, $_GET['port'], 3)
        ]
    )
);
