$a = new foo(); 
foo::staticmethod();
func();


$a = new subnamespace\foo();
subnamespace\foo::staticmethod();
subnamespace\func();



$a = new \currentnamespace\foo();
\currentnamespace\foo::staticmethod();
\currentnamespace\func();
