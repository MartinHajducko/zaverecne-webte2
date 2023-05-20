<?php
$command = '/usr/bin/python3 simplify.py ' . escapeshellarg($userAnswer) . ' ' . escapeshellarg($correctAnswer);

//$command = 'python3 -c "import sympy; print(sympy.__version__)"';
$output = [];
exec($command, $output);
var_dump($output);

?>