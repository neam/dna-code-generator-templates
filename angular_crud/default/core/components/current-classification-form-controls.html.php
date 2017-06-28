<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$model = $generator->getModel();

$modelClassSingular = $generator->modelClass;
$modelClassSingularWords = Inflector::camel2words($modelClassSingular);
$modelClassPluralWords = Inflector::pluralize($modelClassSingularWords);
$modelClassPlural = Inflector::camelize($modelClassPluralWords);

?>
<button
        type="submit"
        class="btn btn-primary"
        ng-disabled="!$ctrl.form.$valid || !<?= lcfirst($modelClassSingular) ?>.$resolved"
        >
    <span ng-if="$ctrl.form.$pristine">Refresh</span><span
        ng-if="!$ctrl.form.$pristine">Save</span>
</button>

<button
        type="button"
        class="btn btn-default"
        ng-disabled="$ctrl.form.$pristine || !<?= lcfirst($modelClassSingular) ?>.$resolved"
        ng-click="reset($ctrl.form)"
        >Reset Form
</button>

<button
        type="button"
        class="btn btn-default"
        ng-if="currentIndex(<?= lcfirst($modelClassSingular) ?>) > -1"
        ng-disabled="<?= lcfirst($modelClassPlural) ?>[0].id === <?= lcfirst($modelClassSingular) ?>.id"
        ng-click="previous()"
        >Previous
</button>

<button
        type="button"
        class="btn btn-default"
        ng-if="currentIndex(<?= lcfirst($modelClassSingular) ?>) > -1"
        ng-disabled="<?= lcfirst($modelClassPlural) ?>[<?= lcfirst($modelClassPlural) ?>.length-1].id === <?= lcfirst($modelClassSingular) ?>.id"
        ng-click="next()"
        >Next
</button>
