<?php
$command = '/usr/bin/python3 simplify.py ' . "y(t)=dfrac{3}{2}e^{-t}+dfrac{1}{4}e^{-4t}=0.0833-1.5e^{-t}+0.1666e^{-3t}+0.25e^{-4t}" . ' ' . "\frac56";

//$command = 'python3 -c "import sympy; print(sympy.__version__)"';
$output = [];
exec($command, $output);
var_dump($output);

?>