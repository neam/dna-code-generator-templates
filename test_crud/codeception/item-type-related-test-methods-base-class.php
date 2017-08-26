<?php

/**
 * @var $itemTypePhpName
 * @var $dbTable
 */

$modelClassSingular = $itemTypePhpName;
$modelClassSingularId = PhInflector::camel2id($modelClassSingular);
$modelClassSingularWords = PhInflector::camel2words($modelClassSingular);
$modelClassPluralWords = PhInflector::pluralize($modelClassSingularWords);
$modelClassPlural = PhInflector::camelize($modelClassPluralWords);
$modelClassPluralId = PhInflector::camel2id($modelClassPlural);
$labelSingular = ItemTypes::label($modelClassSingular, 1);
$labelPlural = ItemTypes::label($modelClassSingular, 2);
$labelNone = ItemTypes::label($modelClassSingular, 2);

// TODO: handle prefixes through config
$prefixesToRemoveFromClassNamesWhenCreatingLabels = ["Clerk", "Neamtime"];
$unprefixedLabelSingular = trim(str_ireplace($prefixesToRemoveFromClassNamesWhenCreatingLabels, "", $labelSingular));
$unprefixedLabelPlural = trim(str_ireplace($prefixesToRemoveFromClassNamesWhenCreatingLabels, "", $labelPlural));
$unprefixedLabelNone = trim(str_ireplace($prefixesToRemoveFromClassNamesWhenCreatingLabels, "", $labelNone));

$unprefixedModelClassSingular = str_replace($prefixesToRemoveFromClassNamesWhenCreatingLabels, "", $modelClassSingular);
$unprefixedModelClassSingularId = PhInflector::camel2id($unprefixedModelClassSingular);
$unprefixedModelClassSingularWords = PhInflector::camel2words($unprefixedModelClassSingular);
$unprefixedModelClassPluralWords = PhInflector::pluralize($unprefixedModelClassSingularWords);
$unprefixedModelClassPlural = PhInflector::camelize($unprefixedModelClassPluralWords);
$unprefixedModelClassPluralId = PhInflector::camel2id($unprefixedModelClassPlural);

// @formatter:off
echo "<?php\n";
?>

namespace Step\Unit_db_dependent\crud\base;

use function Functional\pluck;
use Propel\Runtime\Map\TableMap;
use \propel\models;

class <?= $modelClassSingular ?>RelatedTestMethods extends \DbDependentCodeGuy
{

    use \DnaTestRelatedMethodsTrait;

    public $defaultPerspective = "basics";

    /**
     * @Given I have the following <?= strtolower($unprefixedLabelPlural) ?>:
     */
    public function iHaveTheFollowing<?= $modelClassPlural ?>(
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $expected = $this->tableNodeToArray($expected<?= $modelClassPlural ?>);

        foreach ($expected as $itemEntry) {
            $item = new models\<?= $modelClassSingular ?>();
            $expectedId = $itemEntry["id"];
            unset($itemEntry["id"]);
            foreach ($itemEntry as $attribute => $value) {
                if ($value === "") {
                    $value = null;
                }
                $item->setByName($attribute, $value, TableMap::TYPE_FIELDNAME);
            }
            $item->save();
            $this->assertEquals($expectedId, $item->getId());
        }

    }

    /**
     * @Then I should have :count <?= strtolower($unprefixedLabelPlural) . "\n" ?>
     */
    public function iShouldHaveCount<?= $modelClassPlural ?>(
        $count
    ) {
        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $this->assertEquals($count, $<?= lcfirst($modelClassSingular) ?>Query->count());
    }

    /**
     * @Then I should have the following <?= strtolower($unprefixedLabelPlural) ?>:
     */
    public function iShouldHaveTheFollowing<?= $modelClassPlural ?>(
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $this->iShouldHaveTheFollowing<?= $modelClassPlural ?>ByPerspective($this->defaultPerspective, $expected<?= $modelClassPlural ?>);
    }

    /**
     * @Then I should have the following <?= strtolower($unprefixedLabelPlural) ?> (perspective: :perspective):
     */
    public function iShouldHaveTheFollowing<?= $modelClassPlural ?>ByPerspective(
        $perspective,
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $expected = $this->tableNodeToArray($expected<?= $modelClassPlural ?>);

        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $actual = $this-><?= lcfirst($modelClassSingular) ?>QueryToArray($<?= lcfirst($modelClassSingular) ?>Query, $perspective);

        $this->outputExpectedAndActual($expected, $actual);

        $this->assertEquals(
            count($expected),
            count($actual), //$<?= lcfirst($modelClassSingular) ?>Query->count(),
            "Amount of <?= strtolower($unprefixedLabelPlural) ?> match expected"
        );
        $this->assertEquals($expected, $actual, "<?= ucfirst(strtolower($unprefixedLabelPlural)) ?> match expected");

    }

    /**
     * @When I :filterMethod, I should have :count <?= strtolower($unprefixedLabelPlural) . "\n" ?>
     */
    public function iFilterMethodIShouldHaveCount<?= $modelClassPlural ?>(
        $filterMethod,
        $count
    ) {
        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $<?= lcfirst($modelClassSingular) ?>Query->$filterMethod();
        $this->assertEquals($count, $<?= lcfirst($modelClassSingular) ?>Query->count());
    }

    /**
     * @When I :filterMethod, I should see the following <?= strtolower($unprefixedLabelPlural) ?>:
     */
    public function iIFilterMethodIShouldSeeTheFollowing<?= $modelClassPlural ?>(
        $filterMethod,
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $this->iIFilterMethodIShouldSeeTheFollowing<?= $modelClassPlural ?>ByPerspective($filterMethod, $this->defaultPerspective, $expected<?= $modelClassPlural ?>);
    }

    /**
     * @When I :filterMethod, I should see the following <?= strtolower($unprefixedLabelPlural) ?> (perspective: :perspective):
     */
    public function iIFilterMethodIShouldSeeTheFollowing<?= $modelClassPlural ?>ByPerspective(
        $filterMethod,
        $perspective,
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $expected = $this->tableNodeToArray($expected<?= $modelClassPlural ?>);

        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $<?= lcfirst($modelClassSingular) ?>Query->$filterMethod();
        $actual = $this-><?= lcfirst($modelClassSingular) ?>QueryToArray($<?= lcfirst($modelClassSingular) ?>Query, $perspective);

        $this->outputExpectedAndActual($expected, $actual);

        $this->assertEquals(
            count($expected),
            count($actual), //$<?= lcfirst($modelClassSingular) ?>Query->count(),
            "Amount of <?= strtolower($unprefixedLabelPlural) ?> match expected"
        );
        $this->assertEquals($expected, $actual, "<?= ucfirst(strtolower($unprefixedLabelPlural)) ?> match expected");

    }

    /**
     * @When I :filterMethod with id :id, I should have :count <?= strtolower($unprefixedLabelPlural) . "\n" ?>
     */
    public function iFilterMethodWithIdIShouldHaveCount<?= $modelClassPlural ?>(
        $filterMethod,
        $id,
        $count
    ) {
        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $<?= lcfirst($modelClassSingular) ?>Query->$filterMethod($id);
        $this->assertEquals($count, $<?= lcfirst($modelClassSingular) ?>Query->count());
    }

    /**
     * @When I :filterMethod with id :id, I should see the following <?= strtolower($unprefixedLabelPlural) ?>:
     */
    public function iFilterMethodWithIdIShouldSeeTheFollowing<?= $modelClassPlural ?>(
        $filterMethod,
        $id,
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $this->iFilterMethodWithIdIShouldSeeTheFollowing<?= $modelClassPlural ?>ByPerspective($filterMethod, $id, $this->defaultPerspective, $expected<?= $modelClassPlural ?>);
    }

    /**
     * @When I :filterMethod with id :id, I should see the following <?= strtolower($unprefixedLabelPlural) ?> (perspective: :perspective):
     */
    public function iFilterMethodWithIdIShouldSeeTheFollowing<?= $modelClassPlural ?>ByPerspective(
        $filterMethod,
        $id,
        $perspective,
        \Behat\Gherkin\Node\TableNode $expected<?= $modelClassPlural . "\n" ?>
    ) {
        $expected = $this->tableNodeToArray($expected<?= $modelClassPlural ?>);

        $<?= lcfirst($modelClassSingular) ?>Query = models\<?= $modelClassSingular ?>Query::create();
        $<?= lcfirst($modelClassSingular) ?>Query->$filterMethod($id);
        $actual = $this-><?= lcfirst($modelClassSingular) ?>QueryToArray($<?= lcfirst($modelClassSingular) ?>Query, $perspective);

        $this->outputExpectedAndActual($expected, $actual);

        $this->assertEquals(
            count($expected),
            count($actual), //$<?= lcfirst($modelClassSingular) ?>Query->count(),
            "Amount of <?= strtolower($unprefixedLabelPlural) ?> match expected"
        );
        $this->assertEquals($expected, $actual, "<?= ucfirst(strtolower($unprefixedLabelPlural)) ?> match expected");

    }

    public function <?= lcfirst($modelClassSingular) ?>QueryToArray(models\<?= $modelClassSingular ?>Query $<?= lcfirst($modelClassSingular) ?>Query, $perspective)
    {

        $actual = [];
        switch ($perspective) {
            case "basics":
                $actual = $this-><?= lcfirst($modelClassSingular) ?>QueryToBasicsPerspectiveArray($<?= lcfirst($modelClassSingular) ?>Query);
                break;
            default:
                throw new \Exception("Unknown perspective: " . $perspective);
        }
        return $actual;

    }

    protected function <?= lcfirst($modelClassSingular) ?>QueryToBasicsPerspectiveArray(models\<?= $modelClassSingular ?>Query $<?= lcfirst($modelClassSingular) ?>Query)
    {
        $actual = [];
        foreach ($<?= lcfirst($modelClassSingular) ?>Query->find() as $<?= lcfirst($modelClassSingular) ?>) {
            $entry = [];
            $entry["id"] = $<?= lcfirst($modelClassSingular) ?>->getId();
            $entry["item_label"] = $<?= lcfirst($modelClassSingular) ?>->getItemLabel();
            $actual[] = $entry;
        }
        return $actual;
    }

}
