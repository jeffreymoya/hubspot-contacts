<?php
namespace App;

class DBStat {
    public function __construct(
        public $maxDate = null,
        public $minDate = null,
        public array $years = [],
        public $pageSize = 10,
    ) {}
}
