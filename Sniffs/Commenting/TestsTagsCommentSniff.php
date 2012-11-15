 <?php
/**
 * Symfony2_Sniffs_Commenting_TestsTagsCommentSniff sniff enforce @covers tag for unit tests
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Your Name <you@domain.net>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Symfony2_Sniffs_Commenting_TestsTagsCommentSniff sniff enforce @covers tag for unit tests
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Your Name <you@domain.net>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 */
class Symfony2_Sniffs_Commenting_TestsTagsCommentSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $find = array(
                 T_COMMENT,
                 T_DOC_COMMENT,
                );

        $commentEnd = $phpcsFile->findPrevious($find, ($stackPtr - 1));

        if ($commentEnd === false) {
            return;
        }
        
        // If there is any code between the function keyword and the doc block
        // then the doc block is not for us.
        $ignore    = PHP_CodeSniffer_Tokens::$scopeModifiers;
        $ignore[]  = T_STATIC;
        $ignore[]  = T_WHITESPACE;
        $ignore[]  = T_ABSTRACT;
        $ignore[]  = T_FINAL;
        $prevToken = $phpcsFile->findPrevious($ignore, ($stackPtr - 1), null, true);
        if ($prevToken !== $commentEnd) {
            return;
        }

        $this->currentFile = $phpcsFile;

        $commentStart = ($phpcsFile->findPrevious(array(T_COMMENT,T_DOC_COMMENT), ($commentEnd - 1), null, true) + 1);

        $comment           = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));

        try {
            $this->commentParser = new PHP_CodeSniffer_CommentParser_FunctionCommentParser($comment, $phpcsFile);
            $this->commentParser->parse();
        } catch (PHP_CodeSniffer_CommentParser_ParserException $e) {
            $line = ($e->getLineWithinComment() + $commentStart);
            $phpcsFile->addError($e->getMessage(), $line, 'FailedParse');
            return;
        }

        $funcPtr = $this->currentFile->findNext(T_FUNCTION, $commentStart);
        $methodName = $phpcsFile->getDeclarationName($funcPtr);

        if ( !strncmp($methodName, 'test', strlen('test'))) {
            $hasTag =false;
            $tags=$this->commentParser->getTags();
            foreach ($tags as $tag) {
                if ('covers' === $tag['tag']) {
                    $hasTag=true;
                    break;
                }
            }
            if (!$hasTag) {
                $this->currentFile->addWarning('Missing test @covers tag', $funcPtr);		
            }
        } 

    }//end process()

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(T_FUNCTION);

    }//end register()


}//end class

?> 

