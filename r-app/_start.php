<?php
// Здесь ваш код перед началом работы вашего приложения
var_app(array('url' => URL));

#print_var(get_declared_classes(), 'Classes');
$constants = get_defined_constants(TRUE);
print_var($constants['user'], 'User Constants');