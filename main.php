<?php
foreach ([...glob('../../lib/*.php'), ...glob('../../lib/**/*.php')] as $filename) {
    require_once $filename;
}
