<?php

namespace app\widgets\grid;

class TransactionExpensesColumn extends \yii\grid\Column {

    private function getExpensesByGroups(\app\models\transaction\Transaction $model) {
        $groups = [];
        foreach ($model->transactionExpenses as $expense) {
            if (!isset($groups[$expense->contractor_id])) {
                $groups[$expense->contractor_id] = [
                    'contractor' => $expense->contractor,
                    'expenses' => []
                ];
            }
            $groups[$expense->contractor_id]['expenses'][] = $expense;
        }
        return $groups;
    }

    /**
     * Renders the header cell content.
     * The default implementation simply renders [[header]].
     * This method may be overridden to customize the rendering of the header cell.
     * @return string the rendering result
     */
    protected function renderHeaderCellContent() {
        return "Details";
    }

    /**
     * Renders the data cell content.
     * @param \app\models\transaction\Transaction $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    protected function renderDataCellContent($model, $key, $index) {
        $out = "<div><small>";

        $exps = [];
        foreach ($this->getExpensesByGroups($model) as $group) {
            $groupText = "<div>"
                    . "<b>{$group['contractor']->name}</b><br/>";
            $groupExps = [];
            foreach ($group['expenses'] as $expense) {
                $t = "$expense->name $expense->price * $expense->qty ";
                if (floatval($expense->discount)) {
                    $t .= "- $expense->discount%";
                }
                $t .= "= $expense->sum";
                $groupExps[] = $t;
            }
            $groupText .= join("<br/>", $groupExps);
            $groupText .= "</div>";
            $exps[] = $groupText;
        }

        $out .= join("\n", $exps);
        $out .= "</small>";
        $out .= "</div>";
        return $out;
    }

}
