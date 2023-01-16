<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use SimpleXMLElement;
use SimpleXMLIterator;

class XmlReaderController extends Controller
{
    //RETURN INDEX VIEW
    public function index(){

        $xmlData = null;

        return view('index', ['xmlData' => $xmlData]);

    }

    //FUNCTION TO CONVERT XML INTO ARRAY
    public function convertXml($xml){

        $iterator = new SimpleXMLIterator($xml);
        return $this->iteratorToArray($iterator);

    }
    
    //FUNCTION TO CONVERT AN ITERATOR XML INTO ARRAY
    public function iteratorToArray($iterator){
        
        $a = array();

        for( $iterator->rewind(); $iterator->valid(); $iterator->next() ) {
            if(!array_key_exists($iterator->key(), $a)){
                $a[$iterator->key()] = array();
            }
            if($iterator->hasChildren()){
                $a[$iterator->key()][] = $this->iteratorToArray($iterator->current());
            }
            else{
                $a[$iterator->key()][] = strval($iterator->current());
            }
        }

        return $a;

    }

    //FUNCTION TO READ AND HANDLE WITH THE XML AND RETURN TO FRONTEND
    public function readXml(Request $request){

        $file = $request->customFile;
        libxml_use_internal_errors(true);

        //VERIFY IF THE USER SENT A FILE
        if ($file == null) {
            return redirect('/')->with('message', 'É necessário anexar um arquivo XML');            
        }

        $xml = simplexml_load_string($file->get());

        //VERIFY IF THE FILE IS A VALID XML FILE
        if (!$xml) {
            return redirect('/')->with('message', 'É necessário que o arquivo enviado seja um XML');
        }


        //FUNCTION RESPONSIBLE FOR WALK THROUGH THE ARRAY AND CREATE THE PATH FROM CHILD ELEMENT TO PARENT ELEMENT
        function xmlMerge ( $base, SimpleXMLElement $node, &$output )  {
            $base[] = $node->getName();
            $nodeName = implode("/", $base);
            $childNodes = $node->children();
            if ( count($childNodes) == 0 )  {
                $output[ $nodeName ] = (string)$node;
            }
            else    {
                foreach ( $childNodes as $newNode ) {
                    xmlMerge($base, $newNode, $output);
                }
            }
        }

        $xmlMerged = [];
        xmlMerge([], $xml, $xmlMerged);        

        return view('index', ['xmlData' => $xmlMerged]);

    }


}
