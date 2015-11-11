<?php

namespace app\commands;

use yii\console\Controller;

class ExpenseController extends Controller {

    public function actionIndex() {
        $fname = __DIR__ . "/../expense.csv";

        $lines = file($fname);

        $expenses = [];
        $current = null;
        foreach ($lines as $line) {
            $arr = explode(',', $line);
            if (trim($line) == ',,,,,,,,,') {
                continue;
            }
            if ($arr[0]) {
                var_dump($arr[1], $arr[8]);
                $expenses[] = [
                    'date' => $arr[0],
                    'contractor' => $arr[1],
                    'contractor_id' => \app\models\contractor\Contractor::getByName($arr[1], 2)->id,
                    'bonus' => $arr[7],
                    'account' => $arr[8],
                    'account_id' => \app\models\account\Account::getByName($arr[8], 2)->id,
                    'expenses' => [[
                    'title' => $arr[2],
                    'price' => $arr[3],
                    'count' => $arr[4],
                    'discount' => $arr[5],
                    'sum' => $arr[6],
                    'comment' => trim($arr[9]),
                        ]],
                ];
            } else {
                $expenses[count($expenses) - 1]['expenses'][] = [
                    'title' => $arr[2],
                    'price' => $arr[3],
                    'count' => $arr[4],
                    'discount' => $arr[5],
                    'sum' => $arr[6],
                    'comment' => trim($arr[9]),
                ];
            }
        }

        foreach ($expenses as $expense) {
            $transfer = new \app\models\transaction\Transaction();
            $transfer->comment = "";
            preg_match('!^(\d{1,2})[\.\-](\d{1,2}) (\d{1,2})-(\d{2})$!', $expense['date'], $m);
            $transfer->date = date('Y-m-d H:i:s', strtotime("$m[1].$m[2].2015 $m[3]:$m[4]:00"));
            var_dump($transfer->date);
            $transfer->user_id = 2;
            $transfer->comment = $expense['expenses'][0]['comment'];
            $transfer->type = 'expense';
            $transfer->save(false);

            $exps = [];
            $total = 0;
            foreach ($expense['expenses'] as $e) {
                $exp = new \app\models\transaction\TransactionExpense();
                $exp->name = $e['title'];
                $exp->price = $e['price'];
                $exp->qty = $e['count'];
                $exp->discount = floatval($e['discount']);
                $exp->sum = $exp->price * $exp->qty * (1 - $exp->discount);
                $exp->comment = $e['comment'];
                $exp->contractor_id = $expense['contractor_id'];
                $exp->user_id = 2;
                $total+= $exp->sum;
                
                $exp->transaction_id = $transfer->id;
                $exp->save(false);
            }

            $out = new \app\models\transaction\TransactionOutgoing();
            $out->account_id = $expense['account_id'];
            $out->sum = $total;
            $out->user_id = 2;
            $out->transaction_id = $transfer->id;
            $out->save(false);

            if ($expense['bonus']) {
                var_dump($expense['bonus']);
                $in = new \app\models\transaction\TransactionIncoming();
                $in->account_id = \app\models\account\Account::getByName('Okeycity', 2)->id;
                $in->sum = $expense['bonus'];
                $in->user_id = 3;
                $in->transaction_id = $transfer->id;
                $in->contractor_id = \app\models\contractor\Contractor::getByName('Okeycity', 2)->id;
                $in->save(false);
            }
        }
    }

}
