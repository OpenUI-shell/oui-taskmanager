<?php
namespace app\forms;

use bundle\windows\result\taskItem;
use bundle\windows\Task;
use php\gui\framework\AbstractForm;
use php\gui\event\UXWindowEvent; 


class _taskWindow extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        waitAsync(100, function () use ($e, $event) {
        
            //
            $a = Task::getList();
            
            foreach($a as $task){
                if ($task->sessionName == "Console"){
                    if ($task->title != null){
                        $process = $task->title;
                    } else {
                        $process = $task->name;
                    }
                    echo "[DEBUG] sigma\n";
                    // f
                    if ($task->memory > 1073741824){
                        $memory = round($task->memory / 1024 / 1024 / 1024)." ГБ";
                    } else {
                        $memory = round($task->memory / 1024 / 1024)." МБ";
                    }
                    
                        $arr = [
                            'process'     => $process,
                            'pid'         => $task->pid,
                            'memory'      => $memory,
                            'cpuTime'     => $task->cpuTime."%"
                        ];
                        $this->table->items->add($arr);
                    
                }
            }
        
        });
    }

}
