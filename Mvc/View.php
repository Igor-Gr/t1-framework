<?php

namespace Orm;

class View
{
    
    protected $data = [];
    public $template_Path = 'protect/Templates/';
    
    public function __set ($k, $v) {
        $this->data[$k] = $v;
    }
    
    public function __get ($k) {
        return $this->data[$k];
    }

    /**
     * @param $template
     * @return string
     */
	public function render ($template) {
		ob_start();
		foreach ($this->data as $prop => $value) {
			$$prop = $value;
		}
		include $template;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
    
    public function display ($template) {
        echo $this->render($this->template_Path . $template);
    }
}