<?php
/**
 * This file is used to include the procedural interface files, it does not include class files.
 * You must also include the vendor autoload file before including this.
 */

//Helpers
require_once 'helpers/file.php';
require_once 'helpers/pluggable.php';
require_once 'helpers/config.php';
require_once 'helpers/render.php';
require_once 'helpers/cache.php';
require_once 'helpers/string.php';

//Constants
require_once 'constants.php';

//Init arte
\Artemis\Arte::Init();