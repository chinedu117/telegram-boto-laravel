<?php
namespace App\Exceptions;


class GenericExceptionHandler extends \Exception
{ 
    public $code;

    public function __construct($message = "An error occurred", $code=400)
    {   
        $this->code = $code;
        parent::__construct($message);
        
    }
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json(["message" => $this->getMessage()], $this->code);
    }
}