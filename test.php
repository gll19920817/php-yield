<?php
require_once 'Yield.class.php';

function childTask() {
    $tid = (yield getTaskId());
    while (true) {
        echo "Child task $tid still alive!\n";
        yield;
    }
}
function task() {
    $tid = (yield getTaskId());
    $childTid = (yield newTask(childTask()));
    for ($i = 1; $i <= 6; ++$i) {
        echo "Parent task $tid iteration $i.\n";
        yield;
        if ($i == 3) yield killTask($childTid);
    }
}
$scheduler = new Scheduler;
$scheduler->newTask(task());
$scheduler->run();
