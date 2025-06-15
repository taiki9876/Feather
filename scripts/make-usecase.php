<?php

if ($argc < 2) {
    echo "Usage: php scripts/make-usecase.php <UseCaseName>\n";
    echo "Example: php scripts/make-usecase.php CreateUser\n";
    exit(1);
}

$useCaseName = $argv[1];
$useCaseDir = __DIR__ . "/../App/UseCase/{$useCaseName}";

// ディレクトリを作成
if (!is_dir($useCaseDir)) {
    mkdir($useCaseDir, 0755, true);
}

// Input クラスを作成
$inputContent = "<?php

namespace App\\UseCase\\{$useCaseName};

class {$useCaseName}Input
{
    public function __construct(
        // TODO: 必要なプロパティを追加
    ) {}
}";

file_put_contents("{$useCaseDir}/{$useCaseName}Input.php", $inputContent);

// Output クラスを作成
$outputContent = "<?php

namespace App\\UseCase\\{$useCaseName};

class {$useCaseName}Output
{
    public function __construct(
        // TODO: 必要なプロパティを追加
    ) {}
}";

file_put_contents("{$useCaseDir}/{$useCaseName}Output.php", $outputContent);

// UseCase クラスを作成
$useCaseContent = "<?php

namespace App\\UseCase\\{$useCaseName};

class {$useCaseName}UseCase
{
    public function execute({$useCaseName}Input \$input): {$useCaseName}Output
    {
        // TODO: ビジネスロジックを実装

        return new {$useCaseName}Output(
            // TODO: 結果を返す
        );
    }
}";

file_put_contents("{$useCaseDir}/{$useCaseName}UseCase.php", $useCaseContent);

echo "UseCase '{$useCaseName}' has been created successfully!\n";
echo "Files created:\n";
echo "- {$useCaseDir}/{$useCaseName}Input.php\n";
echo "- {$useCaseDir}/{$useCaseName}Output.php\n";
echo "- {$useCaseDir}/{$useCaseName}UseCase.php\n";
echo "\nThe UseCase will be automatically registered by AutoServiceProvider.\n"; 