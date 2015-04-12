<?= "Raw: " . $helpers->date('2015-01-01') ?>

<?= "Raw Time: " . $helpers->date('2015-01-01 12:00:00') ?>

<?= "Raw Time 2: " . $helpers->date->time() ?>

<?= "Stentence Now: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 12:00:05') ?>

<?= "Stentence Now: " . $helpers->date('2015-01-01 12:00:00')->sentence(true, '2015-01-01 12:00:05') ?>

<?= "Stentence Second: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 12:00:11') ?>

<?= "Stentence Minutes: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 12:10:11') ?>

<?= "Stentence Minutes: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 12:1:00') ?>

<?= "Stentence Hours: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 13:10:11') ?>

<?= "Stentence Hours: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-01 14:10:11') ?>

<?= "Stentence Tomorrow: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2015-01-02 14:10:11') ?>

<?= "Stentence Tomorrow: " . $helpers->date('2015-01-01 12:00:00')->sentence(false, '2014-12-31 12:00:00') ?>

