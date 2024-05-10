<?php
namespace app\forms;

use bundle\windows\Task;
use bundle\windows\Windows;
use php\gui\framework\AbstractForm;
use php\gui\event\UXMouseEvent;
use php\lib\Str;
use php\gui\event\UXWindowEvent;

use php\gui\UXTableView;
use php\gui\UXTableColumn;
use php\gui\UXTableCell;
use php\util\Regex;
use php\gui\event\UXEvent; 

class MainForm extends AbstractForm
{
    function getTasks(){
        $filepath = realpath('./').'/tasks.temp';
        if(file_exists($filepath))unlink($filepath);
        execute('cmd.exe /c "tasklist /FO CSV /NH>>'.$filepath.'"', true);
        $tasks = explode("\r\n", Str::Decode(file_get_contents($filepath), 'cp866'));
        $return = [];
        
        foreach($tasks as $k=>$v){
            $task = explode('","',$v);
            $return[] = $task;
        }
        
        //var_dump($return);
        return $return;
    }

    /**
     * @event show 
     **/
    function doShow(UXWindowEvent $event)
    {    
        $tasks = $this->getTasks();
        
        $table = new UXTableView;
        $this->panel->add($table);

        
        $table->anchorFlags['left'] = true;
        $table->anchorFlags['right'] = true;
        $table->anchorFlags['top'] = true;
        $table->anchorFlags['bottom'] = true;
        
        $table->anchors['left'] = 10;
        $table->anchors['right'] = 10;
        $table->anchors['top'] = 10;
        $table->anchors['bottom'] = 10;
        
        $table->leftAnchor = 10;
        $table->rightAnchor = 10;
        $table->topAnchor = 10;
        $table->bottomAnchor = 10;
        
        
        $tr1 = new UXTableColumn;
        $tr2 = new UXTableColumn;
        $tr3 = new UXTableColumn;

        $tr1->text = 'Process';
        $tr2->text = 'ID';
        $tr3->text = 'Memory';
        
        
        $table->columns->add($tr1);
        $table->columns->add($tr2);
        $table->columns->add($tr3);

        for($i = 0; $i<sizeof($tasks); ++$i){
            $table->items->add($i);
        }

        $i = 0;
        $table->columns[0]->setCellFactory(function(UXTableColumn $column) use ($tasks){
            global $i;
            $td = new UXTableCell;
            $td->text = $tasks[$i][0];
            
            $i++;    
            return $td;
        });
        
        $i = 0;
        $table->columns[1]->setCellFactory(function(UXTableColumn $column) use ($tasks){
            global $i;
            $td = new UXTableCell;
            $td->text = $tasks[$i][1];
            
            $i++;    
            return $td;
        });
        
        $i = 0;
        $table->columns[2]->setCellFactory(function(UXTableColumn $column) use ($tasks){
            global $i;
            $td = new UXTableCell;
            $td->text = $tasks[$i][4];
            
            $i++;    
            return $td;
        });
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
        print_r(Task::getList());
    }

}
