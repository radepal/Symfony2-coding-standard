<?php

/**
 * Symfony2_Sniffs_Formatting_BlankLineBeforeReturnSniff.
 *
 * Throws errors if there's no blank line before return statements. Symfony
 * coding standard specifies: "Add a blank line before return statements,
 * unless the return is alone inside a statement-group (like an if statement);"
 *
 * @author Radosłąw Palczyński <radepal@gmail.com>
 */

class Symfony2_Sniffs_Functions_ForbidenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{
  /**
	     * A list of forbidden functions with their alternatives.
	     *
	     * @var array(string => string|null)
	     */
	    protected $forbiddenFunctions = array(


	
	             # 3) Discourages the use of PHP debugging functions
	             'print' 		    => null,
	             'echo'             => null,
	             'print_r'          => null,
	             'vprintf'          => null,
	             'printf'           => null,
	             'debug_print_backtrace'          => null,
	             'var_export'       => null,
	             'var_dump'         => null
	             

		);


     /* If true, an error will be thrown; otherwise a warning.
     *
     * @var bool 
     */

    public $error = true;
}