<?php

namespace Elision\Mvc;

class View
{

    public $layout_path = 'protect/views/layouts/';
    public $layout_default = 'main.php';
    public $template_Path = 'protect/views/templates/';

    protected $data = [];
    
    public function __set ($k, $v) {
        $this->data[$k] = $v;
    }
    
    public function __get ($k) {
        return $this->data[$k];
    }

    /**
     * Принимает подключаемый шаблон, массив с данными для шаблона вида ['имя переменной' => переменная],
     * и необязательный параметр главный шаблон, если не передан то подключается шаблон
     * стоящий по умаолчанию 'main.php'
     *
     * @param string $template
     * @param array $data
     * @param null|string $layout
     * @return string
     */
	public function render ($template, $data = [], $layout = null) {
		ob_start();
        $this->content = $this->getLayout($template, $data);
		foreach ($this->data as $prop => $value) {
			$$prop = $value;
		}
        $layout_default = $this->layout_path . $this->layout_default;
        if (file_exists($layout_default) && $layout) {
            include $this->layout_path . $layout;
        } elseif (file_exists($layout_default) && $layout == null) {
            include $layout_default;
        } else {
            include $template;
        }
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

    /**
     * Рендер шаблона для вставки в основной лейаут
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function getLayout($template, $data = [])
    {
        ob_start();
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
        foreach ($this->data as $prop => $value) {
            $$prop = $value;
        }
        include $template;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    public function display ($template, $data = [], $layout = null) {
        echo $this->render($this->template_Path . $template, $data, $layout);
    }
}