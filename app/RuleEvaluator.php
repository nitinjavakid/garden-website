<?php

namespace App;

class RuleEvaluator
{
    private $variables;
    private $rule;
    
    public function __construct($rule)
    {
        $this->rule = $rule;
        $this->variables = array();
    }

    public function set($name, $value)
    {
        array_push($this->variables, $name . "=" . $value);
    }

    public function clear()
    {
        $this->variables = array();
    }

    public function evaluate()
    {
        $cmd = "echo \"" . $this->rule . "\" | " . base_path("rule_evaluator");
        foreach($this->variables as $var)
        {
            $cmd .= " \"" . $var . "\"";
        }

        exec($cmd, $op);
        return end($op);
    }
}