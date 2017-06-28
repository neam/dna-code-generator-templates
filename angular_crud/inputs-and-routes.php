<?php

use yii\helpers\Inflector;
use yii\helpers\Html;

// Config

$recursionLevelLimit = 1;

// Angular UI Giiant `CallbackProvider` configuration
// -------------------------

// Hint helper
$hintMarkupGenerator = function ($attributeInfo) {
    $hint = htmlspecialchars($attributeInfo["hint"]);
    $hintMarkup = <<<HINT
<span class="badge badge-primary app-badge" tooltip-placement="right" data-tooltip-html-unsafe="$hint">?</span>
HINT;
    $hintMarkup = !empty($hint) ? $hintMarkup : "";
    return $hintMarkup;
};

// Default value halper
$defaultValueMarkupGenerator = function ($lcfirstModelClass, $attribute, $label) {

    // Only for campaign crud currently
    if ($lcfirstModelClass !== "campaign") {
        return "";
    }

    // Only for campaignFlowCopy, campaignThemeConfiguration and registration label defaults currently
    if (strpos($attribute, "campaignFlowCopy") !== false
        || strpos($attribute, "campaignThemeConfiguration") !== false
        || (strpos($attribute, "registration_") !== false && strpos($attribute, "_label") !== false)
    ) {

        return <<<MARKUP

        <div class="row m-b" ng-if="$lcfirstModelClass.defaults.attributes.$attribute">
            <small>The following will be used if the field above is left empty: "<span>{{ $lcfirstModelClass.defaults.attributes.$attribute }}"</span></small><br/>
            <a href="javascript:void(0)" ng-click="$lcfirstModelClass.attributes.$attribute = $lcfirstModelClass.defaults.attributes.$attribute" class="btn btn-sm btn-primary"><i class="fa fa-copy pull-left"></i> Override</a></li>
            <a href="javascript:void(0)" ng-click="$lcfirstModelClass.attributes.$attribute = null" class="btn btn-sm btn-primary"><i class="fa fa-chain-broken pull-left"></i> Clear field so that the default value is used</a></li>
        </div>
MARKUP;

    }

    return "";
};


// Input wrapper
// TODO

// Text input

$textInput = function ($attribute, $model, $params) use ($hintMarkupGenerator, $defaultValueMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    // Include default value markup
    $defaultValueMarkup = $defaultValueMarkupGenerator($lcfirstModelClass, $attribute, $label);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <input type="text" ng-model="$lcfirstModelClass.attributes.$attribute" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute" class="form-control m-b" />$defaultValueMarkup
    </div>
</div>

INPUT;

};

// Text input with colorpicker

$textInputWithColorpicker = function ($attribute, $model, $params) use ($hintMarkupGenerator, $defaultValueMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    // Include default value markup
    $defaultValueMarkup = $defaultValueMarkupGenerator($lcfirstModelClass, $attribute, $label);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <input type="text" colorpicker placeholder="Click for color picker" ng-model="$lcfirstModelClass.attributes.$attribute" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute" class="form-control m-b" />$defaultValueMarkup
    </div>
</div>

INPUT;

};

// Textarea input

$textAreaInput = function ($attribute, $model, $params) use ($hintMarkupGenerator, $defaultValueMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    // Include default value markup
    $defaultValueMarkup = $defaultValueMarkupGenerator($lcfirstModelClass, $attribute, $label);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <textarea ng-model="$lcfirstModelClass.attributes.$attribute" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute" class="form-control m-b"></textarea>$defaultValueMarkup
    </div>
</div>

INPUT;

};

// File selection widget

$fileSelectionWidget = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div class="well">
            <small>
        <dna-file-selection-widget preview-height-pixels="dnaFileSelectionWidgetPreviewHeightPixels" file="$lcfirstModelClass.attributes.$attribute" ng-model="$lcfirstModelClass.attributes.$attribute.id" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute"></dna-file-selection-widget>
            </small>
        </div>
    </div>
</div>

INPUT;

};

// Image selection widget

$imageSelectionWidget = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div class="well">
            <small>
        <dna-file-selection-widget type="image" preview-height-pixels="dnaFileSelectionWidgetPreviewHeightPixels" file="$lcfirstModelClass.attributes.$attribute" ng-model="$lcfirstModelClass.attributes.$attribute.id" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute"></dna-file-selection-widget>
            </small>
        </div>
    </div>
</div>

INPUT;

};

// Video selection widget

$videoSelectionWidget = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div class="well">
            <small>
        <dna-file-selection-widget type="video" preview-height-pixels="dnaFileSelectionWidgetPreviewHeightPixels" file="$lcfirstModelClass.attributes.$attribute" ng-model="$lcfirstModelClass.attributes.$attribute.id" name="$lcfirstModelClass.attributes.$attribute" id="$lcfirstModelClass.attributes.$attribute"></dna-file-selection-widget>
            </small>
        </div>
    </div>
</div>

INPUT;

};

// "Boolean" tri-state (0,1,NULL) radio inputs

$tristateRadioInput = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label class="label-left control-label">{$attributeInfo["label"]}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div class="radio">
            <label>
                <input icheck type="radio" ng-model="$lcfirstModelClass.attributes.$attribute"
                       ng-value="'1'"
                       name="$attribute"/> Yes
            </label>
        </div>
        <div class="radio">
            <label>
                <input icheck type="radio" ng-model="$lcfirstModelClass.attributes.$attribute"
                       ng-value="'0'"
                       name="$attribute"/> No
            </label>
        </div>
        <div class="radio">
            <label>
                <input icheck type="radio" ng-model="$lcfirstModelClass.attributes.$attribute"
                       ng-value="null"
                       name="$attribute"/> Don't know
            </label>
        </div>
    </div>
</div>

INPUT;

};

// Boolean switch input

$switchInput = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Sanitize
    $label = Html::encode($attributeInfo["label"]);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label class="label-left control-label">{$label}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <label class="switch m-b">
            <input ng-model="$lcfirstModelClass.attributes.$attribute"
                 name="$lcfirstModelClass.attributes.$attribute"
                 id="$lcfirstModelClass.attributes.$attribute" type="checkbox" checked
                 name="activate" class="form-control m-b"><i></i>
        </label>
    </div>
</div>

INPUT;

};


/*

// $relationCompositionWidget

$relationCompositionWidget = function ($attribute, $model) {

    return <<<INPUT
<?php
\$input = \$this->widget('CompositionWidget',
    array(
        'model' => \$model,
        'attribute' => 'sir_trevor_ui_{$attribute}',
        'blocksProfile' => CompositionWidget::ITEM_BLOCKS_ONLY,
    ),
    true
);
?>
<?php echo \$form->customControlGroup(\$model, '{$attribute}', \$input); ?>
INPUT;
};

// composition CompositionWidget

$compositionCompositionWidget = function ($attribute, $model) {

    return <<<INPUT
    <?php
    \$input = \$this->widget('CompositionWidget',
        array(
            'model' => \$model,
            'attribute' => '{$attribute}',
        ),
        true
    );
    ?>
    <?php echo \$form->customControlGroup(\$model, '{$attribute}', \$input); ?>
INPUT;

};

// Upload select + FilepickerIoWidget

$uploadCode = function ($relationName, $model) {

    // Find relation name

    $relations = $model->relations();
    $multilingualRelations = $model->getMultilingualRelations();

    if (!isset($relations[$relationName]) && !isset($multilingualRelations[$relationName])) {
        throw new CException("No relation $relationName in model " . get_class($model));
    }

    $modelClass = get_class($model);

    $attributeCode = "";
    $disabledCode = "";
    switch ($model->scenario) {

        case "edit-step":

            if (!isset($multilingualRelations[$relationName])) {
                $attribute = $relations[$relationName][2];
                $attributeCode = <<<INPUT
'{$attribute}'
INPUT;
            } else {
                $attributeCode = <<<INPUT
\$model->getAttributeBySourceRelationName("{$relationName}", \$model->source_language)
INPUT;
            }

            $disabledCode = <<<INPUT
'disabled' => !\$this->canEditSourceLanguage(),
INPUT;

            break;
        case
        "translate-step":

            $attributeCode = <<<INPUT
\$model->getAttributeBySourceRelationName("{$relationName}", \$this->workflowData['translateInto'])
INPUT;

            break;
        default:
            throw new CException("model->scenario was neither edit-step nor translate-step");
    }

    return <<<INPUT
<div class="file-field-2cols">
    <div class="field-column">
        <?php echo \$form->select2ControlGroup(
            \$model,
            {$attributeCode},
            File::listData(File::model()->forItemRelationSelect(get_class(\$model), "{$relationName}")->findAll()),
            array(
                {$disabledCode}
                'empty' => Yii::t('app', 'None'),
                'thumbnails' => true,
            )
        ); ?>
    </div>
    <div class="field-column">
        <div class="form-group">
            <label class="control-label"><?php echo Yii::t('account', 'Upload new file'); ?></label>

            <?php
            \$this->widget('FilepickerIoWidget',
                array(
                    'inputSelector' => "#{$modelClass}_" . {$attributeCode},
                    'mimeTypes' => \$model->getFileConstraints()["{$relationName}"]["mimeTypes"],
                )
            );
            ?>

        </div>
    </div>
</div>
INPUT;

};

*/

// Has-one-relation select2 input

$hasOneRelationSelect2Input = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute.id" class="label-left control-label">{$attributeInfo["label"]}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div class="select2 m-b">
            <select2 empty-to-null ng-model="$lcfirstModelClass.attributes.$attribute.id" name="$lcfirstModelClass.attributes.$attribute.id" id="$lcfirstModelClass.attributes.$attribute.id"
            options="{$lcfirstModelClass}Crud.relations.$attribute.select2Options">
                <option value="{{{$lcfirstModelClass}.attributes.$attribute.id}}">{{{$lcfirstModelClass}.attributes.$attribute.item_label}}</option>
            </select2>
        </div>
    </div>
</div>

INPUT;

};

/*
$routesWidget = function ($attribute, $model) {

    return <<<INPUT
<?php
\$input = \$this->widget('RoutesWidget',
    array(
        'model' => \$model,
        'relation' => '{$attribute}',
    ),
    true
);
?>

<?php echo \$form->customControlGroup(\$model, '{$attribute}', \$input); ?>
INPUT;

};

$sirtrevorMarkupWidget = function ($attribute, $model) {

    return <<<INPUT
<div class="alert alert-info" role="alert">
    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
    <span class="sr-only">Info:</span>
    Remember - Only Sir-trevor-allowed formatting is allowed in the {$attribute}-field. Please press the "Save changes" above
    to see how this field will look like after html has been removed, then fix the formatting and save again.
</div>

<?php
\$input = \$this->widget('\kato\sirtrevorjs\yii1compat\ESirTrevor',
    [
        'debug' => true,
        'model' => \$model,
        'attribute' => 'sir_trevor_ui_{$attribute}',
        'imageUploadUrl' => \yii\helpers\Url::to('internal/p3media/import/sirTrevorUpload', true),
        'el' => 'sir-trevor-sir_trevor_ui_{$attribute}', // will add to the textarea,
        'blockOptions' => \yii\helpers\Json::encode(
                [
                    'el' => new \yii\web\JsExpression("$('.sir-trevor-sir_trevor_ui_{$attribute}')"),
                    'blockTypes' => [
                        "Text", "Heading"
                    ],
                    'defaultType' => "Text",
                    'blockLimit' => 1,
                ]
            )
    ],
    true
);
?>

<?php echo \$form->customControlGroup(\$model, '{$attribute}', \$input); ?>

INPUT;

};

$selectLanguage = function ($attribute, $model) {

    return <<<INPUT
<div class="profile-col-4">
    <?php echo \$form->select2ControlGroup(
        \$model,
        '{$attribute}',
        LanguageHelper::getTranslatedLanguageList(),
        array(
            'empty' => Yii::t('app', 'None'),
        )
    ); ?>
</div>
INPUT;

};

$handsontableRelationInput = function ($attribute, $model) {

    $relations = $model->relations();
    $relationModel = new $relations["$attribute"][1];

    $input = "
<?php

\$input = \$this->widget('\\neam\\yii_relations_ui\\widgets\\HasManyHandsontableInput', [
        'model' => \$model,
        'relation' => '$attribute',
        'registerSelect2Editor' => true,
        // Uncomment to reference files in the dev git repos - useful while developing
        //'appBowerAlias' => 'root.ui.yii-dna-cms.bower_components-git-repos',
        'settings' => [
            'columns' => [
                (object) ['special' => 'delete_checkbox'],
                (object) ['data' => 'id'],
                //(object) ['data' => 'ordinal'],";
    foreach ($relationModel->getSafeAttributeNames() as $attributeName) {
        $input .= "
                (object) ['data' => '$attributeName'],";
    }
    $input .= "
                (object) ['data' => 'ordinal'],
            ]
        ]
    ],
    true
);

?>

<?php echo \$form->customControlGroup(\$model, '$attribute', \$input); ?>

<?php //echo \$model->handsontable_input_$attribute; ?>
";

    return $input;

};

*/

// Has-one-relation dna item selection widget

$hasOneRelationDnaItemSelectionWidget = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $modelClassSingular = $modelClass;
    $lcfirstModelClass = lcfirst($modelClassSingular);
    $modelClassSingularId = Inflector::camel2id($modelClassSingular);
    $lcfirstModelClassSingularId = lcfirst($modelClassSingularId);

    if (!isset($attributeInfo["relatedModelClass"])) {
        $class = $modelClass;
        return <<<INPUT
<!-- "$attribute" - Model $class does not have a relation '$attribute' -->

INPUT;
        //throw new Exception("Model " . $modelClass . " does not have a relation '$attribute'");
    }
    $relatedModelClass = $attributeInfo["relatedModelClass"];
    $relatedModelClassSingular = $relatedModelClass;
    $relatedModelClassSingularId = Inflector::camel2id($relatedModelClassSingular);
    $relatedModelClassSingularWords = Inflector::camel2words($relatedModelClassSingular);
    $relatedModelClassPluralWords = Inflector::pluralize($relatedModelClassSingularWords);
    $relatedModelClassPlural = Inflector::camelize($relatedModelClassPluralWords);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label for="$lcfirstModelClass.attributes.$attribute" class="label-left control-label">{$attributeInfo["label"]}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <crud-$relatedModelClassSingularId-elements-item-selection-widget selected-item="$lcfirstModelClass.attributes.$attribute" ng-model="$lcfirstModelClass.attributes.$attribute.id" attribute-ref="$lcfirstModelClass.attributes.$attribute"></crud-$relatedModelClassSingularId-elements-item-selection-widget>
    </div>
</div>

INPUT;

};

// Has-many-relation dna item selection widget

$hasManyRelationDnaItemSelectionWidget = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    if (!isset($attributeInfo["relatedModelClass"])) {
        $class = $modelClass;
        return <<<INPUT
<!-- "$attribute" - Model $class does not have a relation '$attribute' -->

INPUT;
        //throw new Exception("Model " . $modelClass . " does not have a relation '$attribute'");
    }
    $relatedModelClass = $attributeInfo["relatedModelClass"];
    $relatedModelClassSingular = $relatedModelClass;
    $relatedModelClassSingularId = Inflector::camel2id($relatedModelClassSingular);
    $relatedModelClassSingularWords = Inflector::camel2words($relatedModelClassSingular);
    $relatedModelClassPluralWords = Inflector::pluralize($relatedModelClassSingularWords);
    $relatedModelClassPlural = Inflector::camelize($relatedModelClassPluralWords);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label class="label-left control-label">{$attributeInfo["label"]}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <crud-$relatedModelClassSingularId-elements-item-selection-widget multiple items="$lcfirstModelClass.attributes.$attribute" ng-model="$lcfirstModelClass.attributes.{$attribute}_ids" attribute-ref="$lcfirstModelClass.attributes.$attribute"></crud-$relatedModelClassSingularId-elements-item-selection-widget>
    </div>
</div>

INPUT;

};

// Has-many-relation listing

$hasManyRelationListing = function ($attribute, $model, $params) use ($hintMarkupGenerator) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    $attribute = str_replace("/", ".attributes.", $attribute);

    if (!isset($attributeInfo["relatedModelClass"])) {
        $class = $modelClass;
        return <<<INPUT
<!-- "$attribute" - Model $class does not have a relation '$attribute' -->

INPUT;
        //throw new Exception("Model " . $modelClass . " does not have a relation '$attribute'");
    }
    $relatedModelClass = $attributeInfo["relatedModelClass"];
    $relatedModelClassSingular = $relatedModelClass;
    $relatedModelClassSingularId = Inflector::camel2id($relatedModelClassSingular);
    $relatedModelClassSingularWords = Inflector::camel2words($relatedModelClassSingular);
    $relatedModelClassPluralWords = Inflector::pluralize($relatedModelClassSingularWords);
    $relatedModelClassPlural = Inflector::camelize($relatedModelClassPluralWords);

    // Include hint markup if hint is not empty
    $hintMarkup = $hintMarkupGenerator($attributeInfo);

    return <<<INPUT
<div class="row">
    <div class="col-sm-2">
        <label class="label-left control-label">{$attributeInfo["label"]}</label>$hintMarkup
    </div>
    <div class="col-sm-10">
        <div ng-include="'crud/$relatedModelClassSingularId/compact-list.html'"></div>
    </div>
</div>

INPUT;

};

// Default input

$defaultInput = function ($attribute, $model, $params) use (
    $textInput,
    $hasOneRelationDnaItemSelectionWidget,
    $hasManyRelationDnaItemSelectionWidget
) {

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];

    // Handle attributes that have no item type attribute information (ie for pure crud columns)
    if (!array_key_exists($attribute, $itemTypeAttributes)) {
        return <<<INPUT
<!-- "$attribute" NO MATCHING ITEM TYPE ATTRIBUTE -->

INPUT;
    }

    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);

    switch ($attributeInfo["type"]) {
        default:
            return <<<INPUT
<!-- "$attribute" TYPE {$attributeInfo["type"]} TODO -->

INPUT;
        case "primary-key":
            return <<<INPUT
<!-- "$attribute" TYPE {$attributeInfo["type"]} TODO -->

INPUT;
        case "ordinary":
            return $textInput($attribute, $model, $params);
            break;
        case "has-one-relation":
            return $hasOneRelationDnaItemSelectionWidget($attribute, $model, $params);
            break;
        case "has-many-relation":
            return $hasManyRelationDnaItemSelectionWidget($attribute, $model, $params);
            break;
    }

};

// Handsontable column settings

$handsontableOrdinaryColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    if (strpos($attribute, '/') !== false) {
        return '';
    } // TODO: Add support for handsontable columns for deep/aliased attributes
    $attributeInfo["label"] = json_encode($attributeInfo["label"]);
    return <<<INPUT
            {
                data: 'attributes.$attribute',
                title: {$attributeInfo["label"]},
            },
INPUT;
};

$handsontableCheckboxColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    if (strpos($attribute, '/') !== false) {
        return '';
    } // TODO: Add support for handsontable columns for deep/aliased attributes
    $attributeInfo["label"] = json_encode($attributeInfo["label"]);
    return <<<INPUT
            {
                data: 'attributes.$attribute',
                title: {$attributeInfo["label"]},
                type: 'checkbox',
                checkedTemplate: true,
                uncheckedTemplate: false,
            },
INPUT;
};

$handsontablePrimaryKeyColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    if (strpos($attribute, '/') !== false) {
        return '';
    } // TODO: Add support for handsontable columns for deep/aliased attributes
    $attributeInfo["label"] = json_encode($attributeInfo["label"]);
    return <<<INPUT
            {
                data: 'attributes.$attribute',
                title: 'Delete',
                renderer: handsontable.deleteButtonRenderer,
                readOnly: true,
            },{
                data: 'attributes.$attribute',
                title: {$attributeInfo["label"]},
                readOnly: true,
            },{
                data: 'item_label',
                title: 'Summary',
                readOnly: true,
            },
INPUT;
};

$handsontableHasOneRelationColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);
    if (strpos($attribute, '/') !== false) {
        return '';
    } // TODO: Add support for handsontable columns for deep/aliased attributes
    $attributeInfo["label"] = json_encode($attributeInfo["label"]);
    return <<<INPUT
            {
                data: 'attributes.$attribute.id',
                title: {$attributeInfo["label"]},
                renderer: handsontable.columnLogic.$attribute.cellRenderer,
                editor: 'select2',
                select2Options: handsontable.columnLogic.$attribute.select2Options,
            },
INPUT;
};

$handsontableAutoDetectColumn = function ($attribute, $model, $params) use (
    $handsontableOrdinaryColumn,
    $handsontableCheckboxColumn,
    $handsontablePrimaryKeyColumn,
    $handsontableHasOneRelationColumn
) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];

    // Handle attributes that have no item type attribute information (ie for pure crud columns)
    if (!array_key_exists($attribute, $itemTypeAttributes)) {
        return <<<INPUT
            {
                data: 'attributes.$attribute',
                title: '$attribute',
            },
INPUT;
    }

    $attributeInfo = $itemTypeAttributes[$attribute];

    switch ($attributeInfo["type"]) {
        default:
            return <<<INPUT
            // "$attribute" TYPE {$attributeInfo["type"]} TODO
INPUT;
        case "internal":
            return <<<INPUT
            // "$attribute" TYPE {$attributeInfo["type"]}
INPUT;
            break;
        case "ordinary":
            return $handsontableOrdinaryColumn($attribute, $model, $params);
        case "boolean":
            return $handsontableCheckboxColumn($attribute, $model, $params);
        case "primary-key":
            return $handsontablePrimaryKeyColumn($attribute, $model, $params);
        case "has-one-relation":
            return $handsontableHasOneRelationColumn($attribute, $model, $params);
    }

};

// Handsontable inputs

/*
$handsontableOrdinaryColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];

    // Handle attributes that have no item type attribute information (ie for pure crud columns)
    if (!array_key_exists($attribute, $itemTypeAttributes)) {
            return <<<INPUT
    <hot-column data="attributes.$attribute" title="'$attribute'" attribute-type="'crud'"></hot-column>
INPUT;
    }

    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $lcfirstModelClass = lcfirst($modelClass);

    switch ($attributeInfo["type"]) {
        default:
            return <<<INPUT
        <!-- "$attribute" TYPE {$attributeInfo["type"]} TODO -->
INPUT;
        case "primary-key":
            return <<<INPUT
        <hot-column data="attributes.$attribute" title="'Delete'" attribute-type="'delete-button'" renderer="{$lcfirstModelClass}Crud.handsontable.deleteButtonRenderer" read-only></hot-column>
        <hot-column data="attributes.$attribute" title="'$attribute'" attribute-type="'{$attributeInfo["type"]}'" read-only></hot-column>
        <hot-column data="item_label" title="'Label'" attribute-type="'{$attributeInfo["type"]}'" read-only></hot-column>
INPUT;
        case "ordinary":
            return <<<INPUT
        <hot-column data="attributes.$attribute" title="'$attribute'" attribute-type="'{$attributeInfo["type"]}'"></hot-column>
INPUT;
            break;
        case "has-one-relation":
            return <<<INPUT
        <hot-column data="attributes.$attribute.id" title="'$attribute'" attribute-type="'has-one-relation'" renderer="{$lcfirstModelClass}Crud.handsontable.columnLogic.$attribute.cellRenderer" editor="'select2'" select2-options="{$lcfirstModelClass}Crud.handsontable.columnLogic.$attribute.select2Options"></hot-column>
INPUT;
            break;
    }

};

$handsontableCheckboxColumn = function ($attribute, $model, $params) {
    $attribute = str_replace("handsontable-column-settings.", "", $attribute);
    return <<<INPUT
        <hot-column data="attributes.$attribute" title="'$attribute'" type="'checkbox'"
                checked-template="true" unchecked-template="false"></hot-column>
INPUT;
};
*/

// $uiRouterItemTypeStates

$uiRouterItemTypeStates = [];

$uiRouterItemTypeStates['item-type-template'] = function ($attribute, $model, $params) use ($recursionLevelLimit) {

    $step = $params["step"];
    $stepReference = $params["stepReference"];
    $parentState = $params["parentState"];
    $rootCrudState = $params["rootCrudState"];
    $recursionLevel = $params["recursionLevel"];
    $generator = $params["generator"];

    if ($recursionLevel >= $recursionLevelLimit) {

        // Prevent infinite loops and giant state trees
        return '        // Recursion limit reached';

    }

    $modelClass = $params["modelClass"];

    $modelClassSingular = $modelClass;
    $modelClassLcfirstSingular = lcfirst($modelClassSingular);
    $modelClassSingularId = Inflector::camel2id($modelClassSingular);
    $modelClassSingularWords = Inflector::camel2words($modelClassSingular);
    $modelClassPluralWords = Inflector::pluralize($modelClassSingularWords);
    $modelClassPlural = Inflector::camelize($modelClassPluralWords);
    $modelClassLcfirstPlural = lcfirst($modelClassPlural);
    $modelClassPluralId = Inflector::camel2id($modelClassPlural);
    $labelSingular = ItemTypes::label($modelClassSingular, 1);
    $labelPlural = ItemTypes::label($modelClassSingular, 2);
    $labelNone = ItemTypes::label($modelClassSingular, 2);

    // TODO: handle prefixes through config
    $unprefixedModelClassSingular = str_replace(["Clerk", "Neamtime"], "", $modelClassSingular);
    $unprefixedModelClassLcfirstSingular = lcfirst($unprefixedModelClassSingular);
    $unprefixedModelClassSingularId = Inflector::camel2id($unprefixedModelClassSingular);
    $unprefixedModelClassSingularWords = Inflector::camel2words($unprefixedModelClassSingular);
    $unprefixedModelClassPluralWords = Inflector::pluralize($unprefixedModelClassSingularWords);
    $unprefixedModelClassPlural = Inflector::camelize($unprefixedModelClassPluralWords);
    $unprefixedModelClassPluralId = Inflector::camel2id($unprefixedModelClassPlural);

    // TODO: fix choiceformat interpretation in yii2 and use item type choiceformat label for labels instead of inflector-created labels
    $labelSingular = $unprefixedModelClassSingularWords;
    $labelPlural = $unprefixedModelClassPluralWords;

    // The state where the views for list, view and edit etc are defined the first state - necessary to keep track of in order to be able to reference their ui-views
    if (!$rootCrudState) {
        $rootCrudState = "$parentState.$modelClassPluralId";
    }

    // Route-based filter recursive resolve hack
    if ($recursionLevel === 0) {
        $setRouteBasedContentFiltersLevelResolveLine = "setRouteBasedContentFiltersLevel{$recursionLevel}: /*@ngInject*/ function (routeBasedContentFilters, \$stateParams) {";
    } else {
        $parentRecursionLevel = $recursionLevel - 1;
        $setRouteBasedContentFiltersLevelResolveLine = "setRouteBasedContentFiltersLevel{$recursionLevel}: /*@ngInject*/ function (setRouteBasedContentFiltersLevel{$parentRecursionLevel}, routeBasedContentFilters, \$stateParams) {";
    }
    if ($recursionLevel === 0) {
        $setRouteBasedVisibilitySettingsLevelResolveLine = "setRouteBasedVisibilitySettingsLevel{$recursionLevel}: /*@ngInject*/ function (routeBasedVisibilitySettings, \$stateParams) {";
    } else {
        $parentRecursionLevel = $recursionLevel - 1;
        $setRouteBasedVisibilitySettingsLevelResolveLine = "setRouteBasedVisibilitySettingsLevel{$recursionLevel}: /*@ngInject*/ function (setRouteBasedVisibilitySettingsLevel{$parentRecursionLevel}, routeBasedVisibilitySettings, \$stateParams) {";
    }

    /*
     * Overview of states:
     *  - item type root state
     *  - list
     *  - curate
     *  - curate step states
     *  - single item root state
     *  - edit
     *  - edit step and attribute states
     */

    $states = "";

    $states .= <<<STATES
            .state('{$parentState}.{$modelClassPluralId}', {
                abstract: true,
                url: "/{$unprefixedModelClassPluralId}",
                template: "<ui-view/>"
            })

            ;

        var views = {};
        views['@{$rootCrudState}'] = {
            template: require("crud/{$modelClassSingularId}/list.html"),
            controller: "list{$modelClassPlural}Controller",
        };

        \$stateProvider

            .state('{$parentState}.{$modelClassPluralId}.list', {
                url: "/list",
                views: views,
                data: {pageTitle: 'List {$labelPlural}'}
            })


STATES;

    $curateStepStates = <<<CURATESTEPSSTATESSTART
            ;

        var views = {};
        views['@{$rootCrudState}'] = {
            template: "<ui-view/>",
            controller: "list{$modelClassPlural}Controller",
        };

        \$stateProvider

            .state('{$parentState}.{$modelClassPluralId}.curate', {
                abstract: true,
                url: "/curate",
                views: views,
                data: {pageTitle: 'Curate {$labelPlural}'}
            })


CURATESTEPSSTATESSTART;

    if (in_array($modelClassSingular, array_keys(\ItemTypes::where('is_workflow_item')))):
        $stepCaptions = $model->flowStepCaptions();

        $flowSteps = $model->flowSteps();
        $flowStepReferences = array_keys($flowSteps);
        $firstStepReference = reset($flowStepReferences);

        // Determine level of step
        $stepReference = $firstStepReference;
        $stepHierarchy = explode(".", $stepReference);
        $step = end($stepHierarchy);
        $stepCaption = !empty($stepCaptions[$step]) ? $stepCaptions[$step] : ucfirst($step);

        // Summarize metadata
        $stepMetadata = compact("stepReference", "step" /*, "stepAttributes" Not including since it seems to affect performance having to large metadata blobs in step definitions */);

        // Json encode
        $jsonEncodedStepCaption = json_encode($stepCaption);
        $jsonEncodedStepMetadata = json_encode((object) $stepMetadata);

        $curateStepStates .= <<<STEPSTATESSTART
            // Add initial alias for "first-step" TODO: Refactor to have dynamic step logic in angular logic instead of repeated code
            .state('{$parentState}.{$modelClassPluralId}.curate.continue-editing', {
                url: "/continue-editing",
                data: {
                    pageTitle: 'Curate {$labelSingular} - Step \'{$stepReference}\'',
                    stepCaption: $jsonEncodedStepCaption,
                    stepMetadata: $jsonEncodedStepMetadata,
                },
                template: require("crud/{$modelClassSingularId}/curate-steps/{$stepReference}.html"),
                controller: "list{$modelClassPlural}Controller",
                resolve: {
                    {$setRouteBasedVisibilitySettingsLevelResolveLine}
                        routeBasedVisibilitySettings.{$modelClassSingular}_columns_by_step = '{$stepReference}';
                    },
                }
            })


STEPSTATESSTART;

        // Keep track of which states are already defined
        $defined = [];

        foreach ($flowSteps as $stepReference => $stepAttributes):

            // Determine level of step
            $stepHierarchy = explode(".", $stepReference);
            $step = end($stepHierarchy);
            $stepCaption = !empty($stepCaptions[$step]) ? $stepCaptions[$step] : ucfirst($step);

            // Summarize metadata
            $stepMetadata = compact("stepReference", "step" /*, "stepAttributes" Not including since it seems to affect performance having to large metadata blobs in step definitions */);

            // Json encode
            $jsonEncodedStepCaption = json_encode($stepCaption);
            $jsonEncodedStepMetadata = json_encode((object) $stepMetadata);

            // Add necessary abstract states if the current step is a seb-step
            if (count($stepHierarchy) > 1) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.curate.{$stepHierarchy[0]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $curateStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[0]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            if (count($stepHierarchy) > 2) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.curate.{$stepHierarchy[0]}.{$stepHierarchy[1]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $curateStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[1]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            if (count($stepHierarchy) > 3) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.curate.{$stepHierarchy[0]}.{$stepHierarchy[1]}.{$stepHierarchy[2]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $curateStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[2]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            $curateStepStates .= <<<STEPSTATES
            // {$jsonEncodedStepCaption}
            .state('{$parentState}.{$modelClassPluralId}.curate.{$stepReference}', {
                url: "/{$step}",
                data: {
                    pageTitle: 'Curate {$labelSingular} - Step \'{$stepReference}\'',
                    stepCaption: $jsonEncodedStepCaption,
                    stepMetadata: $jsonEncodedStepMetadata,
                },
                template: require("crud/{$modelClassSingularId}/curate-steps/{$stepReference}.html"),
                controller: "list{$modelClassPlural}Controller",
                resolve: {
                    {$setRouteBasedVisibilitySettingsLevelResolveLine}
                        routeBasedVisibilitySettings.{$modelClassSingular}_columns_by_step = '{$stepReference}';
                    },
                }
            })


STEPSTATES;

        endforeach;

    else:

        // [not a workflow-item]

    endif;

    $states .= $curateStepStates;

    $states .= <<<STATES

            .state('{$parentState}.{$modelClassPluralId}.create', {
                url: "/new",
                onEnter: /*@ngInject*/ function (\$state, {$modelClassLcfirstSingular}, {$modelClassLcfirstPlural}) {
                    let itemAttributes = {
                        'attributes': {
                        }
                    };
                    {$modelClassLcfirstPlural}.add(itemAttributes, function (createdItem) {
                        let goToStateParams = angular.merge(\$state.params, {active{$modelClassSingular}Id: createdItem.id});
                        \$state.transitionTo(
                            '' + baseState + '.{$modelClassPluralId}.existing.edit.continue-editing',
                            goToStateParams,
                            {location: 'replace', inherit: true, relative: \$state.\$current, notify: true}
                        );
                    });
                },
                data: {pageTitle: 'New {$labelSingular}'}
            })

            .state('{$parentState}.{$modelClassPluralId}.existing', {
                abstract: true,
                url: "/:active{$modelClassSingular}Id",
                resolve: {
                    {$setRouteBasedContentFiltersLevelResolveLine}
                        // TODO: Generate the following dynamically based on data model
                        routeBasedContentFilters.Bar_order = 'Foo.id DESC';
                        routeBasedContentFilters.Bar_foo_id = \$stateParams.fooId;
                    },
                    {$setRouteBasedVisibilitySettingsLevelResolveLine}
                        // TODO: Adjust the below so that columns that are all the same value due to a route-based filter are hidden
                        routeBasedVisibilitySettings.{$modelClassSingular}_hide_source_relation = '{$modelClassSingular}';
                    },
                    current$modelClassSingular: /*@ngInject*/ function (\$stateParams, {$modelClassLcfirstSingular}) {
                        let active{$modelClassSingular}Id = \$stateParams.active{$modelClassSingular}Id;
                        {$modelClassLcfirstSingular}.\$activate();
                        return {$modelClassLcfirstSingular}.load(active{$modelClassSingular}Id);
                    },
                },
                template: "<ui-view/>"
            })

            /*
             .state('{$parentState}.{$modelClassPluralId}', {
             url: "/dashboard",
             template: require("crud/{$modelClassSingularId}/dashboard.html"),
             data: {pageTitle: '{$labelPlural} Dashboard'}
             })
             */

            ;

        var views = {};
        views['@{$rootCrudState}'] = {
            controller: "edit{$modelClassSingular}Controller",
            template: require("crud/$modelClassSingularId/view.html"),
        };

        \$stateProvider

            .state('{$parentState}.{$modelClassPluralId}.existing.view', {
                url: "/view",
                views: views,
                data: {pageTitle: 'View {$labelSingular}'}
            })


STATES;

    $editStepStates = <<<EDITSTEPSSTATESSTART

            ;

        var views = {};
        views['@{$rootCrudState}'] = {
            controller: "edit{$modelClassSingular}Controller",
            template: require("crud/{$modelClassSingularId}/components/form.html")
        };
        /*
        views['sidebar@root'] = {
            template: require("crud/{$modelClassSingularId}/navigation.html")
        };
        */

        \$stateProvider

            .state('{$parentState}.{$modelClassPluralId}.existing.edit', {
                abstract: true,
                url: "/edit",
                views: views,
                data: {
                    showSideMenu: true,
                    pageTitle: 'Edit {$labelSingular}'
                }
            })


EDITSTEPSSTATESSTART;

    if (in_array($modelClassSingular, array_keys(\ItemTypes::where('is_workflow_item')))):
        $stepCaptions = $model->flowStepCaptions();

        $flowSteps = $model->flowSteps();
        $flowStepReferences = array_keys($flowSteps);
        $firstStepReference = reset($flowStepReferences);

        $editStepStates .= <<<STEPSTATESSTART
            // Add initial alias for "first-step" TODO: Refactor to have dynamic step logic in angular logic
            .state('{$parentState}.{$modelClassPluralId}.existing.edit.continue-editing', {
                url: "/continue-editing",
                template: require("crud/{$modelClassSingularId}/steps/{$firstStepReference}.html"),
                data: {pageTitle: 'Edit {$labelSingular}'}
            })


STEPSTATESSTART;

        // Keep track of which states are already defined
        $defined = [];

        foreach ($flowSteps as $stepReference => $stepAttributes):

            // Determine level of step
            $stepHierarchy = explode(".", $stepReference);
            $step = end($stepHierarchy);
            $stepCaption = !empty($stepCaptions[$step]) ? $stepCaptions[$step] : ucfirst($step);

            // Summarize metadata
            $stepMetadata = compact("stepReference", "step" /*, "stepAttributes" Not including since it seems to affect performance having to large metadata blobs in step definitions */);

            // Json encode
            $jsonEncodedStepCaption = json_encode($stepCaption);
            $jsonEncodedStepMetadata = json_encode((object) $stepMetadata);

            // Add necessary abstract states if the current step is a seb-step
            if (count($stepHierarchy) > 1) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.existing.edit.{$stepHierarchy[0]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $editStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[0]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            if (count($stepHierarchy) > 2) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.existing.edit.{$stepHierarchy[0]}.{$stepHierarchy[1]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $editStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[1]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            if (count($stepHierarchy) > 3) {
                $fullStepReference = "{$parentState}.{$modelClassPluralId}.existing.edit.{$stepHierarchy[0]}.{$stepHierarchy[1]}.{$stepHierarchy[2]}";
                if (!in_array($fullStepReference, $defined)) {
                    $defined[] = $fullStepReference;
                    $editStepStates .= <<<STEPSTATES
            .state('{$fullStepReference}', {
                abstract: true,
                url: "/{$stepHierarchy[2]}",
                template: "<ui-view/>"
            })


STEPSTATES;
                }
            }

            $editStepStates .= <<<STEPSTATES
            // {$jsonEncodedStepCaption}
            .state('{$parentState}.{$modelClassPluralId}.existing.edit.{$stepReference}', {
                url: "/{$step}",
                template: require("crud/{$modelClassSingularId}/steps/{$stepReference}.html"),
                data: {
                    pageTitle: 'Edit {$labelSingular} - Step \'{$stepReference}\'',
                    stepCaption: $jsonEncodedStepCaption,
                    stepMetadata: $jsonEncodedStepMetadata,
                }
            })

            .state('{$parentState}.{$modelClassPluralId}.existing.edit.$stepReference.attributes', {
                abstract: true,
                template: "<ui-view/>"
            })


STEPSTATES;


            foreach ($stepAttributes as $attribute):

                $params = [
                    "step" => $step,
                    "stepReference" => $stepReference,
                    "parentState" => "$parentState.$modelClassPluralId.existing.edit.$stepReference.attributes",
                    "rootCrudState" => $rootCrudState,
                    "recursionLevel" => $recursionLevel + 1,
                    "generator" => $generator,
                    "itemTypeAttributesWithAdditionalMetadata" => $params["itemTypeAttributesWithAdditionalMetadata"],
                    "modelClass" => $params["modelClass"],
                ];
                $editStepStates .= $generator->prependActiveFieldForAttribute(
                    "ui-router-attribute-states." . $attribute,
                    $model,
                    $params
                );
                $editStepStates .= $generator->activeFieldForAttribute(
                    "ui-router-attribute-states." . $attribute,
                    $model,
                    $params
                );
                $editStepStates .= $generator->appendActiveFieldForAttribute(
                    "ui-router-attribute-states." . $attribute,
                    $model,
                    $params
                );

            endforeach;

            /*
                .state('{$parentState}.edit-modal', {
                    url: "/edit",
                    onEnter: function (\$modal) {

                        var open = function (template, size, params) {

                            var modalInstance = \$modal.open({
                                animation: true,
                                templateUrl: template,
                                controller: 'GeneralModalInstanceController',
                                size: size,
                                resolve: {
                                    modalParams: function () {
                                        return {};
                                    }
                                }
                            });

                            modalInstance.result.then(function (/*selectedItem* /) {
                                //\$scope.selected = selectedItem;
                            }, function () {
                                \$log.info('Modal dismissed at: ' + new Date());
                            });
                        };

                        open('crud/$relatedModelClassSingularId/modal.html', 'lg');

                    },
                })
             */

        endforeach;

    else:

        // [not a workflow-item]

    endif;

    $states .= $editStepStates;

    return $states;

};

// $uiRouterStepAttributeStates

$uiRouterStepAttributeStates = [];

$uiRouterStepAttributeStates['has-many-relation'] = function ($attribute, $model, $params) use ($uiRouterItemTypeStates
) {

    $attribute = str_replace("ui-router-attribute-states.", "", $attribute);

    $step = $params["step"];
    $stepReference = $params["stepReference"];
    $parentState = $params["parentState"];
    $recursionLevel = $params["recursionLevel"];
    $generator = $params["generator"];

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];
    $attributeInfo = $itemTypeAttributes[$attribute];
    $modelClass = $params["modelClass"];
    $modelClassSingular = $modelClass;
    $modelClassLcfirstSingular = lcfirst($modelClassSingular);

    if (!isset($attributeInfo["relatedModelClass"])) {
        $class = $modelClass;
        return <<<INPUT
<!-- "$attribute" - Model $class does not have a relation '$attribute' -->

INPUT;
        //throw new Exception("Model " . $modelClass . " does not have a relation '$attribute'");
    }
    $relatedModelClass = $attributeInfo["relatedModelClass"];

    $relatedModelClassWithNamespace = "\\propel\\models\\$relatedModelClass";
    $relatedModel = new $relatedModelClassWithNamespace();

    $relatedModelClassSingular = str_replace(["Clerk", "Neamtime"], "", $relatedModelClass);
    $relatedModelClassLcfirstSingular = lcfirst($relatedModelClassSingular);
    $relatedModelClassSingularId = Inflector::camel2id($relatedModelClassSingular);
    $relatedModelClassSingularWords = Inflector::camel2words($relatedModelClassSingular);
    $relatedModelClassPluralWords = Inflector::pluralize($relatedModelClassSingularWords);
    $relatedModelClassPlural = Inflector::camelize($relatedModelClassPluralWords);
    $relatedModelClassPluralId = Inflector::camel2id($relatedModelClassPlural);
    $relatedModelClassLcfirstPlural = lcfirst($relatedModelClassPlural);

    $stateStart = <<<STATESTART
        /**
         * START $modelClassSingular has-many-relation {$attributeInfo["label"]} editing functionality in step $parentState.$stepReference
         */

STATESTART;

    /*
    $relatedItemTypeStates = <<<RELATEDITEMTYPESTATES

        \$injector($relatedModelClassSingularId-routes, function(relatedItemTypeRoutes) {
            relatedItemTypeRoutes(\$stateProvider, $parentState.$stepReference);
        });

RELATEDITEMTYPESTATES;
   */

    $relatedItemTypeAttributesWithAdditionalMetadata = $params["generator"]->getItemTypeAttributesWithAdditionalMetadata($relatedModel);
    $relatedItemTypeStates = $uiRouterItemTypeStates['item-type-template'](
        $attribute,
        $relatedModel,
        array_merge($params, ["modelClass" => $relatedModelClass, "itemTypeAttributesWithAdditionalMetadata" => $relatedItemTypeAttributesWithAdditionalMetadata])
    );

    $stateEnd = <<<STATEEND

        /**
         * END $modelClassSingular has-many-relation {$attributeInfo["label"]} editing functionality in step $parentState.$stepReference
         */


STATEEND;

    return $stateStart . $relatedItemTypeStates . $stateEnd;

};

// Default input

$uiRouterStepAttributeStates['default-ui-router-attribute-states'] = function ($attribute, $model, $params) use (
    $uiRouterStepAttributeStates
) {

    $attribute = str_replace("ui-router-attribute-states.", "", $attribute);

    $step = $params["step"];
    $stepReference = $params["stepReference"];
    $parentState = $params["parentState"];
    $recursionLevel = $params["recursionLevel"];
    $generator = $params["generator"];

    $itemTypeAttributes = $params["itemTypeAttributesWithAdditionalMetadata"];

    // Handle attributes that have no item type attribute information (ie for pure crud columns)
    if (!array_key_exists($attribute, $itemTypeAttributes)) {
        return <<<STATE
            // "$attribute" NO MATCHING ITEM TYPE ATTRIBUTE

STATE;
    }

    $attributeInfo = $itemTypeAttributes[$attribute];

    switch ($attributeInfo["type"]) {
        default:
        case "primary-key":
        case "ordinary":
        case "has-one-relation":
            return <<<STATE
            // "$attribute" TYPE {$attributeInfo["type"]} TODO scrollto/mark -->


STATE;
        /*
                    .state('{$parentState}.$attribute', {
                        abstract: true,
                        url: "/$attribute",
                        template: "<ui-view/>"
                    })
        */
        case "has-many-relation":
            return $uiRouterStepAttributeStates['has-many-relation']($attribute, $model, $params);
            break;
    }

};

$todo = function ($attribute, $model, $params) {
    return "<!-- \"$attribute\" TODO -->";
};
