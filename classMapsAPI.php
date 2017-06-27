<?php class MapsAPI {

 

    private $mapsHost = 'maps.googleapis.com';

 

    private function loadUrl($url) {

        if (function_exists('curl_init')) {

            $cURL = curl_init($url);

            curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);

            $resultado = curl_exec($cURL);

            curl_close($cURL);

        } else {

            $resultado = file_get_contents($url);

        }

 

        if (!$resultado) {

            return false;

        } else {

            return $resultado;

        }

    }

 

    public function getLatLon($endereco) {

        $url = 'http://'. $this->mapsHost .'/maps/api/geocode/json?address='. urlencode($endereco).'&sensor=true&region=pt-BR&language=pt-BR';

                /*retorna um objeto json*/

        $dados = $this->loadUrl($url);

                /*retorna uma std class*/

        $geo = json_decode($dados);

                $tmp = $geo->results;

                unset($geo,$dados,$endereco);

        return array('lat' => $tmp[0]->geometry->location->lat, 'lon' => $tmp[0]->geometry->location->lng,'endereco'=>$tmp[0]->formatted_address);

    }

 

    public function getEndereco($latitude,$longitude) {

        $url = 'http://'. $this->mapsHost .'/maps/api/geocode/json?latlng='. urlencode($latitude.','.$longitude).'&sensor=true&region=pt-BR&language=pt-BR';

                /*retorna um objeto json*/

        $dados = $this->loadUrl($url);

                /*retorna uma std class*/

                $decode=json_decode($dados);

                $geo = $decode->results;

                $endereco =  $geo[0]->formatted_address;/*remove aspas duplas da estring*/

                unset($geo,$decode,$latitude,$longitude);

        return $endereco;

    }

} ?>