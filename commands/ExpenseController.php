<?php

namespace app\commands;

use yii\console\Controller;

class ExpenseController extends Controller
{
    public function actionIndex()
    {
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
                $expenses[] = [
                    'date' => $arr[0],
                    'contractor' => $arr[1],
                    'bonus' => $arr[7],
                    'account' => $arr[8],
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
        var_dump($expenses);
    }
}
