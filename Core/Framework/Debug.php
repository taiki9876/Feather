<?php

namespace Core\Framework;

class Debug
{
    /**
     * Dump and die - 変数の内容を出力して処理を停止
     */
    public static function dd(...$vars): void
    {
        foreach ($vars as $var) {
            self::dump($var);
        }
        die();
    }

    /**
     * Dump - 変数の内容を出力（処理は継続）
     */
    public static function dump(...$vars): void
    {
        foreach ($vars as $var) {
            echo self::formatOutput($var);
        }
    }

    /**
     * 変数の内容を整形して出力
     */
    private static function formatOutput($var): string
    {
        $type = gettype($var);
        $output = "<div style='background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; padding: 15px; margin: 10px 0; font-family: monospace; font-size: 14px;'>";
        $output .= "<div style='color: #6c757d; font-weight: bold; margin-bottom: 10px;'>Type: {$type}</div>";
        
        switch ($type) {
            case 'NULL':
                $output .= "<div style='color: #dc3545;'>null</div>";
                break;
            case 'boolean':
                $output .= "<div style='color: #007bff;'>" . ($var ? 'true' : 'false') . "</div>";
                break;
            case 'integer':
            case 'double':
                $output .= "<div style='color: #28a745;'>{$var}</div>";
                break;
            case 'string':
                $length = strlen($var);
                $output .= "<div style='color: #6f42c1;'>\"" . htmlspecialchars($var) . "\" (length: {$length})</div>";
                break;
            case 'array':
                $count = count($var);
                $output .= "<div style='color: #fd7e14;'>Array ({$count} items)</div>";
                $output .= "<pre style='margin: 10px 0; padding: 10px; background: #ffffff; border: 1px solid #e9ecef; border-radius: 3px;'>";
                $output .= htmlspecialchars(print_r($var, true));
                $output .= "</pre>";
                break;
            case 'object':
                $className = get_class($var);
                $output .= "<div style='color: #e83e8c;'>Object ({$className})</div>";
                $output .= "<pre style='margin: 10px 0; padding: 10px; background: #ffffff; border: 1px solid #e9ecef; border-radius: 3px;'>";
                $output .= htmlspecialchars(print_r($var, true));
                $output .= "</pre>";
                break;
            default:
                $output .= "<pre style='margin: 10px 0; padding: 10px; background: #ffffff; border: 1px solid #e9ecef; border-radius: 3px;'>";
                $output .= htmlspecialchars(var_export($var, true));
                $output .= "</pre>";
        }
        
        // スタックトレースを追加
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        if (isset($trace[2])) {
            $file = $trace[2]['file'] ?? 'unknown';
            $line = $trace[2]['line'] ?? 'unknown';
            $output .= "<div style='color: #6c757d; font-size: 12px; margin-top: 10px;'>Called from: {$file}:{$line}</div>";
        }
        
        $output .= "</div>";
        
        return $output;
    }
} 