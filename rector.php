<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Naming\Rector\Property\UnderscoreToCamelCasePropertyNameRector;
use Rector\Naming\Rector\Variable\UnderscoreToCamelCaseVariableNameRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, [
      SetList::CODE_QUALITY,
    ]);

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $parameters->set(Option::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::IMPORT_SHORT_CLASSES, true);
    $parameters->set(Option::IMPORT_DOC_BLOCKS, false);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);
    $parameters->set(Option::SKIP, [
        "src/Treasurer/SendDeductionNotification.php",
        "src/Extern/Http/FactSheetController.php",
        "src/Treasurer/Http/Controllers/DeductionsController.php",
        UnderscoreToCamelCasePropertyNameRector::class,
    ]);

    $rectorServices = [
        UnderscoreToCamelCaseVariableNameRector::class,
        \Rector\Php74\Rector\Property\TypedPropertyRector::class,
        \Rector\Laravel\Rector\StaticCall\RequestStaticValidateToInjectRector::class,
        \Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector::class,
        \Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector::class,
        \Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class,
        \Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector::class,
        \Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector::class,
        \Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector::class,
        \Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector::class,
        \Rector\CodingStyle\Rector\FuncCall\CallUserFuncCallToVariadicRector::class,
        \Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector::class,
        \Rector\Php74\Rector\Double\RealToFloatTypeCastRector::class,
        \Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class,
        \Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class,
    ];
    $services = $containerConfigurator->services();
    foreach ($rectorServices as $rector) {
        $services->set($rector);
    }
};
