<?php

$className = "app\\models\\{$model->object}";
$objectClass = class_exists($className) ? $className : null;

/// Just temporary as a Proof-of-Concept
if ($objectClass) {
    $object = $model->{$model->object};
    $serviceName = 'app\\services\\' . ucfirst("{$model->object}Service");

    if (!class_exists($serviceName)) {
        $serviceName = 'app\\services\\' . ucfirst("BaseService");
    }
    echo $this->render($serviceName::getWidgetView(), $serviceName::getViewData($model));
} else {
    echo "[$className DOES NOT EXIST YET]";
}
