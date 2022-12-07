<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    /** getting the list of coache that are avaible */
    public function actionGetCoachesList()
    {
        $file = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Dataset.csv';

        if (($handle = fopen($file, 'r')) == false) {
            echo "Unable to open the file \n";
            die(__FILE__);
        }

        $i = 0;
        $items = [];
        while (($fileop = fgetcsv($handle, 1000, ',')) !== false) {
            if ($i == 0 || empty($fileop[1])) {
                $i++;
                continue;
            }
            if(!in_array($fileop[0], $items)){
                $items[] = $fileop[0];
            }

        }
        return json_encode($items);
        fclose($handle);

    }


    /**
     * get the particular coach data and respect time slot
     * @param $name  string  it can diff accroding
     * reurtn json
     */
    public function actionGetCoache($name = 'John Doe')
    {
        $file = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Dataset.csv';

        if (($handle = fopen($file, 'r')) == false) {
            echo "Unable to open the file \n";
            die(__FILE__);
        }

        $i = 0;
        $items = [];
        while (($fileop = fgetcsv($handle, 1000, ',')) !== false) {
            if ($i == 0 || empty($fileop[1])) {
                $i++;
                continue;
            }

            if($name == $fileop[0]) {
                $items[$fileop[2]] [] = [
                    'timeZone' => $fileop[1],
                    'available_at' => $fileop[3],
                    'available_until' => $fileop[4]
                ];
            }

        }
        return json_encode($items);
        fclose($handle);

    }


    /** time Slot can  be diff
     * Get the  coches which are availablity is more than 30mints
     * 
     */
    public function actionGetCoacheWithTimeSlot($timeslot = 30)
    {
        $file = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Dataset.csv';

        if (($handle = fopen($file, 'r')) == false) {
            echo "Unable to open the file \n";
            die(__FILE__);
        }

        $i = 0;
        $items = [];
        while (($fileop = fgetcsv($handle, 1000, ',')) !== false) {
            if ($i == 0 || empty($fileop[1])) {
                $i++;
                continue;
            }
            
            $timeDiff = round(abs(strtotime($fileop[3]) - strtotime($fileop[4]))/60, 2);
            if($timeDiff >= $timeslot) {
                $items[$fileop[0]][][$fileop[2]] = [
                    'timediff' => $timeDiff,
                    'available' => $fileop[3],
                    'available_untill' => $fileop[4]
                ];
            }

        }
        // print_r($items);
        return json_encode($items);
        fclose($handle);

    }
}
