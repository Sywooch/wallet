<?php

namespace app\widgets\grid;

class TransactionDescriptionColumn extends \yii\grid\Column {

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
        $out = "<div>";
        $out .= "<small><i>" . $model->getAllContractorNames() . "</i></small><br/>";
        $out .= "<small>";

        $sums = [];
        foreach ($model->transactionOutgoings as $outgoing) {
            $sums[] = $outgoing->account->title . ": <span class='outSum'>" . $outgoing->account->renderFinance(-$outgoing->sum) . "</span>";
        }

        foreach ($model->transactionIncomings as $incoming) {
            $sums[] = $incoming->account->title . ": <span class='inSum'>+" . $incoming->account->renderFinance($incoming->sum) . "</span>";
        }
        $out .= join('<br/>', $sums);
        $out .= "</small>";
        $out .= "<br/>";
        $out .= "<small><i>" . $model->comment . "</i></small>";
        $out .= "</div>";
        return $out;
    }

}
