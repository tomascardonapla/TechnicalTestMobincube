<?php

namespace App\Repositories;

use App\App;
use App\Screen;
use App\Contact;
use App\Detail;
use DB;

class AppRepository
{

    public function getApps ()
    {
       return App::get();
    }

    public function getApp ($idApp)
    {
       return App::find($idApp);
    }

    public function getScreen ($idScreen)
    {
        $screen = DB::table('screens')
                    ->leftJoin('contact', 'screens.id', '=', 'contact.idScreen')
                    ->leftJoin('detail', 'screens.id', '=', 'detail.idScreen')
                    ->select('screens.id', 'screens.backgroundColor', DB::raw('case when contact.id IS NOT NULL then "contact" when detail.id IS NOT NULL then "detail" end as type'))
                    ->where('screens.id', $idScreen)
                    ->first();                  

        return $screen;
    }

    public function getContact ($idScreen)
    {
        $contact = Contact::where('idscreen', $idScreen)->first();

        return $contact;
    }

    public function getElements ($idScreen)
    {
        $elements = DB::table('detail')
                ->leftJoin('elements', 'detail.id', '=', 'elements.idDetail')
                ->leftJoin('image', 'elements.id', '=', 'image.idElement')
                ->leftJoin('text', 'elements.id', '=', 'text.idElement')
                ->leftJoin('container', 'elements.id', '=', 'container.idElement')
                ->select('detail.*', DB::raw('"detail" as type'), 'elements.idContainer', 'elements.border', DB::raw('case when image.id IS NOT NULL then "image" when text.id IS NOT NULL then "text" when container.id IS NOT NULL then "container" end as element'), 'image.url', 'image.width', 'image.height', 'text.font', 'text.color', 'text.weight', 'text.backgroundColor', 'container.idElement')
                ->where('detail.idScreen', $idScreen)
                ->orderBy('elements.idContainer')
                ->orderBy('container.idElement')
                ->get();

        return $elements;
    }
}

?>
