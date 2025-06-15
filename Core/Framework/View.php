<?php

namespace Core\Framework;

class View
{
    private string $viewPath;
    private array $data = [];
    private ?BaseViewData $viewData = null;

    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
    }

    public function with(array|BaseViewData $data): self
    {
        if ($data instanceof BaseViewData) {
            $this->viewData = $data;
        } else {
            $this->data = array_merge($this->data, $data);
        }
        return $this;
    }

    public function render(): string
    {
        $viewFile = Config::get('view.path') . '/' . $this->viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$viewFile}");
        }

        // ViewDataオブジェクトがある場合はそれを使用、なければ配列データを展開
        if ($this->viewData !== null) {
            $viewData = $this->viewData;
        } else {
            extract($this->data);
        }
        
        ob_start();
        include $viewFile;
        return ob_get_clean();
    }

    public static function make(string $view): self
    {
        return new self($view);
    }
} 