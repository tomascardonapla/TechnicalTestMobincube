<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Repositories\AppRepository;
use App\Classes\ToXml;

class AppController extends Controller
{
    protected $apps;

    public function __construct (AppRepository $apps)
    {
        $this->apps = $apps;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        return view('apps.index', ['apps' => $this->apps->getApps()]);
    }


    public function appToXml ($id)
    {
        $app = $this->apps->getApp($id);

        if (count($app) > 0) {
            $xml = new ToXml();

            $xml->addElement('app', 'root');
            $fields = ['name', 'mainScreen'];
            $data = $app->toArray();            
            $xml->addAttributes($fields, 'app', $data);
            unset($fields);
            unset($data);

            $screens = $app->screens;

            foreach ($screens as $screen) {
                $type = $this->apps->getScreen($screen->id)->type;

                $xml->addElement('screen', 'app');
                $fields = ['id', 'type'];
                $data = (array)$this->apps->getScreen($screen->id);            
                $xml->addAttributes($fields, 'screen', $data);
                unset($fields);
                unset($data);

                switch ($type) {
                    case 'contact':

                        $contact = $this->apps->getContact($screen->id);
                        $fields = ['contactName', 'contactAddress', 'contactState', 'contactCountry', 'contactPostalCode'];
                        $data = $contact->toArray();
                        $xml->addAttributes($fields, 'screen', $data);
                        unset($fields);
                        unset($data);

                        $info = $contact->info;
                        $xml->addElement('info', 'screen');
                        $fields = ['email', 'phone', 'twitter'];
                        $data = $info->toArray();
                        $xml->addAttributes($fields, 'info', $data);
                        unset($fields);
                        unset($data);


                        $map = $contact->map;
                        $xml->addElement('map', 'screen');
                        $fields = ['lng', 'lat'];
                        $data = $map->toArray();
                        $xml->addAttributes($fields, 'map', $data);
                        unset($fields);
                        unset($data);
                    break;

                    case 'detail':
                        $elements = $this->apps->getElements($screen->id);

                        $n_container = 0;
                        foreach ($elements as $element) {
                            switch ($element->element) {
                                case 'container':
                                    $n_container++;
                                    
                                    $n_container-1 == 0 ? $parent_container = 'screen' : $parent_container = $element->element . ($n_container-1);
                       
                                    $xml->addElement($element->element, $parent_container, '', $n_container);

                                    $parent = $element->element . $n_container;
                                break;
                                
                                case 'image':
                                    $xml->addElement($element->element, $parent);
                                    $fields = ['url', 'width', 'height'];
                                    $data = (array)$element;
                                    $xml->addAttributes($fields, $element->element, $data);
                                    unset($fields);
                                    unset($data);
                                break;

                                case 'text':
                                    $xml->addElement($element->element, $parent);
                                    $fields = ['font', 'color', 'weight', 'backgroundColor'];
                                    $data = (array)$element;
                                    $xml->addAttributes($fields, $element->element, $data);
                                    unset($fields);
                                    unset($data);
                                break;
                            }
                        }
                    break;
                }

            }

            $filename = 'xml/app' . time() . '.xml';

            return $xml->saveXml($filename);
        }
    }

}

?>