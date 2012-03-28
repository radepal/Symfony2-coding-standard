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
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
        'JS',
    );
         /**
	     * A list of forbidden functions with their alternatives.
	     *
	     * @var array(string => string|null)
	     */
	    protected $forbiddenFunctions = array(

	             # 2) Discourages the use of our own debugging helper methods
                 'Clansuite_Debug::printR' => 'null',
	             'clansuite_debug::printr' => 'null',
	             'Clansuite_Debug::firebug' => 'null',
	             'clansuite_debug::firebug' => 'null',
	
	             # 3) Discourages the use of PHP debugging functions
	             'console.log' 		=> 'null',
	             'print_r'          => 'null',
	             'var_export'       => 'null',
	             'var_dump'         => 'null'

		);
		/**
	     * Returns an array of tokens this test wants to listen for.
	     *
	     * @return array
	     */
	    public function register()
	    {
	        return array(
	                T_STRING,
	                T_PRINT  #,
	               );
	    }
		/**

     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool 
     */

    public $error = true;
}