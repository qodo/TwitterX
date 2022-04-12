<?php
/** @var modX $modx */
$modx =& $transport->xpdo;
$success = true;

switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

        $modx->log(xPDO::LOG_LEVEL_INFO, ' - Checking if the minimum requirements are met...');

        $modx->log(xPDO::LOG_LEVEL_INFO, ' - Checking PHP version is 7.3+ up to 8.0');
        if (version_compare(PHP_VERSION, '7.3.0') < 0 && version_compare('8.1', PHP_VERSION) > 0) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, ' × Your server or MODX installation does not meet the minimum requirements for this extra. Installation cannot continue.');
            $success = false;
        } else {
            $modx->log(xPDO::LOG_LEVEL_INFO,  ' ✔ PHP version is supported: ' . PHP_VERSION);
        }

        if ($success) {
            $modx->log(xPDO::LOG_LEVEL_INFO, ' ✔ Minimum requirements look good!');
        }
        else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, ' × Your server or MODX installation does not meet the minimum requirements for this extra. Installation cannot continue.');
        }

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        return true;
        break;
}
return $success;